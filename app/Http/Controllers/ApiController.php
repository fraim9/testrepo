<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use App\Exceptions\ApiException;
use Exception;
use App\Exceptions\ApiExceptionFactory as AEF;


class ApiController extends Controller
{
    const TEMP_TOKEN = '1cecc8fb-fb47-4c8a-af3d-d34c1ead8c4f';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //public function __construct()
    //{
        //$this->middleware('auth');
    //}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $ver, $method)
    {
        $result = new \stdClass();
        $result->apiVer = $ver;
        $result->apiMethod = $method;
        $result->errorCode = 0;
        $result->errorMessage = 0;
        try {
            // проверка токена
            $this->_checkToken($request);
            
            // версия API
            switch ($ver) {
                case 'v0':
                    $this->api0($request, $method, $result);
                    break;
                default:
                    throw AEF::create(AEF::API_VERSION_UNKNOWN);
            }
            
        } catch (Exception $e) {
            $result->errorCode = $e->getCode();
            $result->errorMessage = $e->getMessage();
        }
        
        $result->callId = 0;
        echo json_encode($result);
    }
    
    public function api0(Request $request, $method, $result)
    {
        switch ($method) {
            case 'authentication':
                $this->_authentication($request, $result);
                break;
            default:
                throw AEF::create(AEF::API_METHOD_UNKNOWN);
        }
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
        if (Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])) {
            
            $user = Auth::user();
            $result->userId = $user->id;
            $result->username = $user->email;
            $result->displayName = $user->display_name;
            $result->employeeId = $user->display_name;
            
            Auth::logout();
            
        } else {
            throw AEF::create(AEF::USER_CREDENTIALS_INVALID);
        }
    }
    
    protected function _checkToken(Request $request)
    {
        $token = $request->bearerToken();
        
        if (!strlen($token)) {
            throw AEF::create(AEF::API_TOKEN_EMPTY);
        }
        
        if (!$this->_tokenValid($token)) {
            throw AEF::create(AEF::API_TOKEN_INVALID);
        }
        
        if (!$this->_tokenExpirationDateValid($token)) {
            throw AEF::create(AEF::API_TOKEN_EXPIRED);
        }
    }
    
    protected function _tokenValid($token) 
    {
        return $token == self::TEMP_TOKEN;
    }
    
    protected function _tokenExpirationDateValid($token) 
    {
        return true;
    }
    
    
}
