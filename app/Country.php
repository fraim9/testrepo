<?php

namespace App;

class Country extends AppModel
{
	protected $table = 'country';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'iso2', 'iso3', 'name', 'calling_code', 'aml_risk'
	];
	
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];
	
}
