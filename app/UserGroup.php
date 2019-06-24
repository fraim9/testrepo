<?php

namespace App;

class UserGroup extends AppModel 
{
	protected $table = 'user_group';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'name', 'ipos_rights'
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
	    
	    $this->casts['ipos_rights'] = 'json';
	    
	}
	
}
