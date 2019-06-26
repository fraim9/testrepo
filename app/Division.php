<?php

namespace App;


class Division extends AppModel 
{
	protected $table = 'division';
	
	protected $fillable = [
			'code', 'name', 'sort', 'active'
	];
	
}