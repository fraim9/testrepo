<?php

namespace App;


class Company extends AppModel 
{
    const DEFAULT_ID = 1;
    
	protected $table = 'company_info';
	
	protected $fillable = [
			'name', 'logo', 'description', 'phone', 'country_id',
	        'city_id', 'address', 'time_zone', 'legal_mentions', 'currency', 
	];
	
	
	public static function getInfo()
	{
	    return static::query()->find(self::DEFAULT_ID);
	}
	
	public function country()
	{
	    return $this->belongsTo('App\Country');
	}
	
	public function city()
	{
	    return $this->belongsTo('App\City');
	}
	
	public function timeZone()
	{
	    return $this->belongsTo('App\TimeZone', 'time_zone_id');
	}
	
	public function currencyObj()
	{
	    return $this->belongsTo('App\Currency', 'currency');
	}
	
}
