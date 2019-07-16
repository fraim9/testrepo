<?php

namespace App;

class Settings extends AppModel
{
	protected $table = 'settings';
	
	protected $primaryKey = '_id';
	
	protected $keyType = 'char';
	
	public $incrementing = false;
	
	public $timestamps = false;
	
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'doc'
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
	    
	    $this->casts['doc'] = 'json';
	    
	}
	
	
}


