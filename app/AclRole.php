<?php

namespace App;


class AclRole extends AppModel 
{
	protected $table = 'acl_role';
	
	protected $fillable = [
			'name', 'rights'
	];
	
	protected $hidden = [];

	
	
	public function __construct(array $attributes = [])
	{
	    parent::__construct($attributes);
	    
	    $this->casts['rights'] = 'json';
	    
	}
	
	
}
