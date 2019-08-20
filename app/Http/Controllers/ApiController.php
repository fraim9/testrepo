<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Exceptions\ApiExceptionFactory as AEF;
use App\Exceptions\ApiException;
use App\Services\DataExport;
use App\Services\DataImport;
use App\Services\AuthAPI;
use App\AuthParameters;

use App\Services\Files as FileService;

use ReallySimpleJWT\Token;
use App\UserSession;
use App\UserSessionTypes;


class ApiController extends Controller
{
    protected $_exportService = null;
    protected $_importService = null;
    
    protected $_currentUserId = null;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //public function __construct()
    //{
        //$this->middleware('auth');
    //}
    
    

    public function index(Request $request, $ver, $method)
    {
        $result = new \stdClass();
        $result->apiVer = $ver;
        $result->apiMethod = $method;
        $result->errorCode = 0;
        $result->errorMessage = 0;
        $result->errorDetails = '';
        try {
            // версия API
            switch ($ver) {
                case 'v0':
                    $this->api0($request, $method, $result);
                    break;
                default:
                    throw AEF::create(AEF::API_VERSION_UNKNOWN);
            }
            $status = 200;
        } catch (Exception $e) {
            $result->errorCode = $e->getCode() ?: AEF::SYSTEM_ERROR;
            $result->errorMessage = $e->getMessage();
            $result->errorDetails = AEF::getDetails();
            
            if ($e instanceof ApiException) {
                switch ($e->getCode()) {
                    case AEF::USER_LOGIN_EMPTY:
                    case AEF::USER_PASSWORD_EMPTY:
                    case AEF::USER_CREDENTIALS_INVALID:
                        
                    case AEF::AUTH_AUTH_FAILED:
                    case AEF::AUTH_NO_LICENSE:
                    case AEF::AUTH_TOKEN_INVALID:
                        
                    case AEF::ACCESS_TOKEN_EMPTY:
                    case AEF::ACCESS_TOKEN_INVALID:
                        
                        $status = 401;
                        break;
                    case AEF::AUTH_GENERAL:
                        $status = 500;
                        break;
                    default:
                        $status = 400;
                }
            } else {
                $status = 500;
            }
        }

        $result->callId = 0;
        
        return response(json_encode($result), $status)
              ->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function files(Request $request, $ver, $fileId)
    {
        // версия API
        switch ($ver) {
            case 'v0':
                return $this->files0($request, $fileId);
            default:
                return response('Unknown API version', 404);
        }
    }
    
    public function files0(Request $request, $fileId)
    {
        try {
            // проверка Access токена
            $this->_checkAccessToken($request);
        } catch (ApiException $e) {
            return response($e->getMessage(), 401);
        }
        
        $fullFilename = FileService::getFullName($fileId);
        
        if (!$fullFilename || !is_readable($fullFilename)) {
            return response('File not found!', 404);
        }
        
        return response()->download($fullFilename, pathinfo($fullFilename, PATHINFO_BASENAME));
    }
    
    public function api0(Request $request, $method, $result)
    {
        if ($method == 'test') {
            
            $this->_test($request, $result, 0);
            
        } else if ($method == 'authentication') {
            
            $this->_authentication($request, $result);
            
        } else {
            // проверка Access токена
            $this->_checkAccessToken($request);
            
            if ($request->isMethod('GET')) {
                switch ($method) {
                    case 'clients':
                        $this->_pullClients($request, $result);
                        break;
                    case 'amlminis':
                        $this->_pullAmlminis($request, $result);
                        break;
                }
            } else if ($request->isMethod('POST')) {
                switch ($method) {
                    case 'productSections':
                        $this->_pushProductSections($request, $result);
                        break;
                        
                    case 'warehouses':
                        $this->_pushWarehouses($request, $result);
                        break;
                    case 'stock':
                        $this->_pushStock($request, $result);
                        break;
                        
                    case 'clients':
                        $this->_pushClients($request, $result);
                        break;
                        
                    default:
                        throw AEF::create(AEF::API_METHOD_UNKNOWN);
                }
            } else {
                throw AEF::create(AEF::HTTP_METHOD_UNKNOWN, $request->method());
            }
        }
    }
    
    
    
    protected function _test(Request $request, $result, $version)
    {
        $result->name = 'OmniPOS API';
        $result->version = $version;
    }
    
    
    protected function _authentication(Request $request, $result)
    {
        $email = $request->input('login');
        if (!$email) {
            throw AEF::create(AEF::USER_LOGIN_EMPTY);
        }
        $password = $request->input('password');
        if (!$password) {
            throw AEF::create(AEF::USER_PASSWORD_EMPTY);
        }
        $authToken = $request->input('authToken');
        if (!$authToken) {
            throw AEF::create(AEF::AUTH_TOKEN_EMPTY);
        }
        
        if (Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])) {
            
            $authKey = AuthParameters::authKey();
            $user = Auth::user();
            
            $authAPI = new AuthAPI();
            $authAPI->validateUserLicense($authToken, $authKey, $user->id);
            
            $result->userId = $user->id;
            $result->username = $user->email;
            $result->displayName = $user->display_name;
            $result->employeeId = $user->employee_id;
            $result->accessToken = $this->_createAccessToken($user->id);
            $result->appName = $request->input('appName');
            
            UserSession::add(
                    $user->id, 
                    UserSessionTypes::API, 
                    $request->input('appName'),
                    $request->input('appVersion'),
                    $request->input('deviceName'));
            
            Auth::logout();
            
        } else {
            throw AEF::create(AEF::USER_CREDENTIALS_INVALID);
        }
    }
    
    protected function _pullClients(Request $request, $result)
    {
        $validator = Validator::make($request->all(), [
                'page' => 'nullable|integer',
                'pageSize' => 'nullable|integer',
                'modifiedFrom' => 'nullable|date_format:Y-m-d\TH:i:s',
                'id' => 'nullable|integer',
                'onlyCount' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = $errors->first();
            throw AEF::create(AEF::INVALID_REQUEST_PARAMETERS, $message);
        }
        
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 1000);
        $modifiedFrom = $request->input('modifiedFrom');
        $id = $request->input('id');
        $onlyCount = $request->input('onlyCount');
        
        $result->clients = [];
        
        if ($id) {
            $client = $this->_getExportService()->getClient($id);
            if ($client) {
                $result->clients[] = $client;
                $result->count = 1;
            } else {
                throw AEF::create(AEF::ITEM_NOT_FOUND);
            }
        } else if ($onlyCount) {
            $result->clients = null;
            $result->count = $this->_getExportService()->getClients($modifiedFrom, $onlyCount, $page, $pageSize);
        } else {
            $result->clients = $this->_getExportService()->getClients($modifiedFrom, $onlyCount, $page, $pageSize);
            $result->count = count($result->clients);
        }
        
    }
    
    protected function _pullAmlminis(Request $request, $result)
    {
        $validator = Validator::make($request->all(), [
                'page' => 'nullable|integer',
                'pageSize' => 'nullable|integer',
                'modifiedFrom' => 'nullable|date_format:Y-m-d\TH:i:s',
                'clientId' => 'nullable|integer',
                'id' => 'nullable|integer',
                'onlyCount' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = $errors->first();
            throw AEF::create(AEF::INVALID_REQUEST_PARAMETERS, $message);
        }
        
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 1000);
        $modifiedFrom = $request->input('modifiedFrom');
        $clientId = $request->input('clientId');
        $id = $request->input('id');
        $onlyCount = $request->input('onlyCount');
        
        $result->clients = [];
        
        if ($id) {
            $amlmini = $this->_getExportService()->getAmlmini($id);
            if ($amlmini) {
                $result->amlminis[] = $amlmini;
                $result->count = 1;
            } else {
                throw AEF::create(AEF::ITEM_NOT_FOUND);
            }
        } else if ($onlyCount) {
            $result->amlminis = null;
            $result->count = $this->_getExportService()->getAmlminis($modifiedFrom, $clientId, $onlyCount, $page, $pageSize);
        } else {
            $result->amlminis = $this->_getExportService()->getAmlminis($modifiedFrom, $clientId, $onlyCount, $page, $pageSize);
            $result->count = count($result->amlminis);
        }
        
    }
    
    
    protected function _pushProductSections(Request $request, $result)
    {
        $result->ids = $this->_getImportService()->productSections($request->all());
    }
    
    protected function _pushClients(Request $request, $result)
    {
        $result->ids = $this->_getImportService()->clients($request->all());
    }
    
    protected function _pushWarehouses(Request $request, $result)
    {
        $result->ids = $this->_getImportService()->warehouses($request->all());
    }
    
    protected function _pushStock(Request $request, $result)
    {
        $result->ids = $this->_getImportService()->stock($request->all());
    }
    
    
    
    protected function _createAccessToken($userId)
    {
        $secret = AuthParameters::omniposSecretKey();
        $expiration = time() + 36 * 3600;
        $issuer = 'OmniPOS';
        $token = Token::create($userId, $secret, $expiration, $issuer);
        return $token;
    }
    
    protected function _checkAccessToken(Request $request)
    {
        $token = $request->bearerToken();
        
        if (!strlen($token)) {
            throw AEF::create(AEF::ACCESS_TOKEN_EMPTY);
        }
        
        
        $secret = AuthParameters::omniposSecretKey();
        if (!Token::validate($token, $secret)) {
            throw AEF::create(AEF::ACCESS_TOKEN_INVALID);
        }
        
        $payload = Token::getPayload($token, $secret);
        $this->_currentUserId = $payload['user_id'];
        
        /*
        if (!$this->_tokenExpirationDateValid($token)) {
            throw AEF::create(AEF::API_TOKEN_EXPIRED);
        }
        */
    }
    
    protected function _tokenValid($token) 
    {
        $secret = AuthParameters::omniposSecretKey();
        return Token::validate($token, $secret);
        //return $token == self::TEMP_TOKEN;
    }
    
    /*
    protected function _tokenExpirationDateValid($token) 
    {
        return true;
    }
    */
    
    /**
     * @return DataExport
     */
    protected function _getExportService()
    {
        if ($this->_exportService === null) {
            $this->_exportService = new DataExport();
        }
        return $this->_exportService;
    }
    
    /**
     * @return DataImport
     */
    protected function _getImportService()
    {
        if ($this->_importService === null) {
            $this->_importService = new DataImport($this->_currentUserId);
        }
        return $this->_importService;
    }
    
}
