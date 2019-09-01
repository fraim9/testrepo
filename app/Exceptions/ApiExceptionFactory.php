<?php

namespace App\Exceptions;

//use ApiException;

class ApiExceptionFactory
{
    // 100000 - Ошибки общего уровня
    const API_VERSION_UNKNOWN       = 100010;
    const API_METHOD_UNKNOWN        = 100020;
    const HTTP_METHOD_UNKNOWN       = 100030;
    
    const ACCESS_TOKEN_EMPTY        = 101010;
    const ACCESS_TOKEN_INVALID      = 101020;

    const SYSTEM_ERROR              = 109999;
    
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
    const CLIENT_NOT_FOUND          = 501010;
    const EMPLOYEE_NOT_FOUND        = 501020;
    const STORE_NOT_FOUND           = 501030;
    const WAREHOUSE_NOT_FOUND       = 501040;
    const BARCODE_NOT_FOUND         = 501050;
    const INVALID_DATE              = 501060;
    const PRODUCT_NOT_FOUND         = 501070;
    const PRODUCT_COLOR_NOT_FOUND   = 501080;
    const PRODUCT_SIZE_NOT_FOUND    = 501090;
    const PRODUCT_CONFIG_NOT_FOUND  = 501100;
    const PRODUCT_SEASON_NOT_FOUND  = 501110;

    // 600000 - Ошибки формата данных
    const INVALID_REQUEST_PARAMETERS = 600010;
    const DATA_NOT_FOUND = 600020;
    const DATA_TOO_MUCH = 600030;
    const DATA_VALIDATION_ERROR = 600040;
    
    
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

            case self::CLIENT_NOT_FOUND: return 'Client not found';
            case self::EMPLOYEE_NOT_FOUND: return 'Employee not found';
            case self::STORE_NOT_FOUND: return 'Store not found';
            case self::WAREHOUSE_NOT_FOUND: return 'Warehouse not found';
            case self::BARCODE_NOT_FOUND: return 'Barcode not found';
            case self::INVALID_DATE: return 'Invalid date';
            case self::PRODUCT_NOT_FOUND: return 'Product not found';
            case self::PRODUCT_COLOR_NOT_FOUND: return 'Product color not found';
            case self::PRODUCT_SIZE_NOT_FOUND: return 'Product size not found';
            case self::PRODUCT_CONFIG_NOT_FOUND: return 'Product config not found';
            case self::PRODUCT_SEASON_NOT_FOUND: return 'Product season not found';
            
            
            case self::INVALID_REQUEST_PARAMETERS: return 'Invalid parameters in the request';
            case self::DATA_NOT_FOUND: return 'Data not found in the request';
            case self::DATA_TOO_MUCH: return 'Too much data in the request';
            case self::DATA_VALIDATION_ERROR: return 'Data validation error';
            
            
            default: return 'Unknown error';
        }
    }
    
    public static function getDetails()
    {
        return self::$_details;
    }
    
}
