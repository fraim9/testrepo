<?php

namespace App;

class StoreGroup extends AppModel 
{
	protected $table = 'store_group';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'name', 'ipos_settings'
	];
	
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];
	
	
	public function __construct(array $attributes = [])
	{
	    parent::__construct($attributes);
	    
	    $this->casts['ipos_settings'] = 'json';
	    
	}
	
}
