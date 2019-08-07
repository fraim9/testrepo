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
use App\Services\AuthAPI;
use App\AuthParameters;

use App\Services\Files as FileService;

use ReallySimpleJWT\Token;


class ApiController extends Controller
{
    protected $_dataService = null;
    
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
            $result->errorCode = $e->getCode();
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
            
            switch ($method) {
                case 'clients':
                    $this->_clients($request, $result);
                    break;
                case 'amlminis':
                    $this->_amlminis($request, $result);
                    break;
                default:
                    throw AEF::create(AEF::API_METHOD_UNKNOWN);
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
            
            Auth::logout();
            
        } else {
            throw AEF::create(AEF::USER_CREDENTIALS_INVALID);
        }
    }
    
    protected function _clients(Request $request, $result)
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
            $client = $this->_getDataService()->getClient($id);
            if ($client) {
                $result->clients[] = $client;
                $result->count = 1;
            } else {
                throw AEF::create(AEF::ITEM_NOT_FOUND);
            }
        } else if ($onlyCount) {
            $result->clients = null;
            $result->count = $this->_getDataService()->getClients($modifiedFrom, $onlyCount, $page, $pageSize);
        } else {
            $result->clients = $this->_getDataService()->getClients($modifiedFrom, $onlyCount, $page, $pageSize);
            $result->count = count($result->clients);
        }
        
    }
    
    protected function _amlminis(Request $request, $result)
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
            $amlmini = $this->_getDataService()->getAmlmini($id);
            if ($amlmini) {
                $result->amlminis[] = $amlmini;
                $result->count = 1;
            } else {
                throw AEF::create(AEF::ITEM_NOT_FOUND);
            }
        } else if ($onlyCount) {
            $result->amlminis = null;
            $result->count = $this->_getDataService()->getAmlminis($modifiedFrom, $clientId, $onlyCount, $page, $pageSize);
        } else {
            $result->amlminis = $this->_getDataService()->getAmlminis($modifiedFrom, $clientId, $onlyCount, $page, $pageSize);
            $result->count = count($result->amlminis);
        }
        
    }
    
    protected function _createAccessToken($userId)
    {
        $secret = AuthParameters::omniposSecretKey();
        $expiration = time() + 36 * 3600;
        $issuer = 'OmniPOS';
        $token = Token::create($userId, $secret, $expiration, $issuer);
        return $token;
        
        /*
        $prt = explode('.', $authToken);
        //$authData = json_decode(base64_decode($prt[1]));
        
        $headerData = new \stdClass();
        $headerData->alg = "HS256";
        $headerData->typ = "JWT";
        
        $header = json_encode($headerData);
        
        $payloadData = new \stdClass();
        $payloadData->userId = $userId;
        $payloadData->exp = $authData->exp;
        $payload = json_encode($payloadData);
           
        $unsignedToken = base64_encode($header) . '.' . base64_encode($payload);
        
        $secret = AuthParameters::omniposSecretKey();
        $signature = HMAC-SHA256(unsignedToken, SECRET_KEY)
        */
    }
    
    protected function _checkAccessToken(Request $request)
    {
        $token = $request->bearerToken();
        
        if (!strlen($token)) {
            throw AEF::create(AEF::ACCESS_TOKEN_EMPTY);
        }
        
        if (!$this->_tokenValid($token)) {
            throw AEF::create(AEF::ACCESS_TOKEN_INVALID);
        }
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
    protected function _getDataService()
    {
        if ($this->_dataService === null) {
            $this->_dataService = new DataExport();
        }
        return $this->_dataService;
    }
    
}
