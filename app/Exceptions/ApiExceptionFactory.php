<?php

namespace App\Exceptions;

//use ApiException;

class ApiExceptionFactory
{
    // 100000 - Ошибки общего уровня
    const API_VERSION_UNKNOWN       = 100010;
    const API_METHOD_UNKNOWN        = 100020;
    
    const ACCESS_TOKEN_EMPTY        = 101010;
    const ACCESS_TOKEN_INVALID      = 101020;
    
    // 200000 - Ошибки авторизации приложений
    
    
    
    // 300000 - Ошибки авторизации пользователей
    const USER_LOGIN_EMPTY          = 300010;
    const USER_PASSWORD_EMPTY       = 300020;
    const USER_CREDENTIALS_INVALID  = 300030;
    
    const AUTH_TOKEN_EMPTY          = 301010;
    
    const AUTH_GENERAL              = 302010;
    const AUTH_AUTH_FAILED          = 302020;
    const AUTH_NO_LICENSE           = 302030;
    const AUTH_TOKEN_INVALID        = 302040;
    
    // 400000 - Ошибки при получении данных
    const ITEM_NOT_FOUND            = 400010;

    // 500000 - Ошибки при передаче данных
    //const ITEM_NOT_FOUND = 500010;

    // 600000 - Ошибки формата данных
    const INVALID_REQUEST_PARAMETERS = 600010;
    
    
    static protected $_details = '';
    
    public static function create($code, $details = '')
    {
        self::$_details = $details;
        return new ApiException(self::getMessage($code), $code);
    }
    
    public static function apiVersionUnknown()
    {
        return self::create(self::API_VERSION_UNKNOWN);
    }
    
    
    public static function getMessage($code)
    {
        switch ($code) {
            case self::API_VERSION_UNKNOWN: return 'Unknown version of API';
            case self::API_METHOD_UNKNOWN: return 'Unknown method of API';
            case self::ACCESS_TOKEN_EMPTY: return 'ACCESS Token is empty';
            case self::ACCESS_TOKEN_INVALID: return 'ACCESS Token is invalid';

            case self::USER_LOGIN_EMPTY: return 'User login is empty';
            case self::USER_PASSWORD_EMPTY: return 'User password is empty';
            case self::USER_CREDENTIALS_INVALID: return 'Invalid user credentials';
            case self::AUTH_TOKEN_EMPTY: return 'AUTH Token is empty';

            case self::AUTH_GENERAL: return 'AUTH general error';
            case self::AUTH_AUTH_FAILED: return 'AUTH failed';
            case self::AUTH_NO_LICENSE: return 'AUTH no license';
            case self::AUTH_TOKEN_INVALID: return 'AUTH invalid token';

            
            
            case self::INVALID_REQUEST_PARAMETERS: return 'Invalid parameters in request';
            
            
            default: return 'Unknown error';
        }
    }
    
    public static function getDetails()
    {
        return self::$_details;
    }
    
}
