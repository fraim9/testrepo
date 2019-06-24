<?php

namespace App;


class City extends AppModel 
{
	protected $table = 'city';
	
	protected $fillable = [
			'code', 'name', 'country_id'
	];
	
	protected $hidden = [];

	
	
	public function country()
	{
	    return $this->belongsTo('App\Country');
	}
	
}
