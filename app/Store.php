<?php

namespace App;


class Store extends AppModel 
{
	protected $table = 'store';
	
	protected $fillable = [
			'code', 'name', 'description', 'phone', 'country_id', 'city_id', 'address',
	        'geolocation', 'time_zone_id', 'price_id', 'currency', 'group_id', 'geolocation'
	];
	
	protected $hidden = [];

	
	
	public function group()
	{
	    return $this->belongsTo('App\StoreGroup');
	}
	
	public function country()
	{
	    return $this->belongsTo('App\Country');
	}
	
	public function city()
	{
	    return $this->belongsTo('App\City');
	}
	
	public function price()
	{
	    return $this->belongsTo('App\Price');
	}
	
	public function time_zone()
	{
	    return $this->belongsTo('App\TimeZone');
	}
	
}
