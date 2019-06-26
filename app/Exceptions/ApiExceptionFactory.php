<?php

namespace App\Exceptions;

//use ApiException;

class ApiExceptionFactory
{
    // 100000 - Ошибки общего уровня
    const API_VERSION_UNKNOWN = 100010;
    const API_METHOD_UNKNOWN = 100020;
    const API_TOKEN_EMPTY = 101010;
    const API_TOKEN_INVALID = 101020;
    const API_TOKEN_EXPIRED = 101030;
    
    // 200000 - Ошибки авторизации приложений
    
    
    
    // 300000 - Ошибки авторизации пользователей
    const USER_LOGIN_EMPTY = 300010;
    const USER_PASSWORD_EMPTY = 300020;
    const USER_CREDENTIALS_INVALID = 300030;
    
    
    
    public static function create($code)
    {
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
            case self::API_TOKEN_EMPTY: return 'API Token is empty';
            case self::API_TOKEN_INVALID: return 'API Token is invalid';
            case self::API_TOKEN_EXPIRED: return 'API Token expired';

            case self::USER_LOGIN_EMPTY: return 'User login is empty';
            case self::USER_PASSWORD_EMPTY: return 'User password is empty';
            case self::USER_CREDENTIALS_INVALID: return 'Invalid user credentials';
                
        }
    }
    
}
