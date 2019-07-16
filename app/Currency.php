<?php

namespace App;

class Currency extends AppModel
{
	protected $table = 'currency';
	
	protected $primaryKey = 'code';
	
	protected $keyType = 'char';
	
	public $incrementing = false;
	
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'code', 'name', 'symbol'
	];
	
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];
	
}


