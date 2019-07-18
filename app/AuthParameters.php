<?php

namespace App;


class AuthParameters extends AppModel 
{
    const DEFAULT_ID = 1;
    
	protected $table = 'auth_parameters';
	
	protected $fillable = [];
	
	//protected $connection = 'omnipos_auth';
	
	static protected $_params = null;
	
	public static function getParameters()
	{
	    if (self::$_params === null) {
	        self::$_params = static::query()->find(self::DEFAULT_ID);
	    }
	    return self::$_params;
	}

	public static function authKey()
	{
	    return static::getParameters()->auth_key;
	}
	
	public static function authCode()
	{
	    return static::getParameters()->auth_code;
	}
	
	public static function apiAuthUrl()
	{
	    return static::getParameters()->api_auth_url;
	}
	
	public static function omniposSecretKey()
	{
	    return static::getParameters()->omnipos_secret_key;
	}
	
	public static function iposSecretKey()
	{
	    return static::getParameters()->ipos_secret_key;
	}
	
	
	
	
	
	
}