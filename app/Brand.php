<?php

namespace App;


class Brand extends AppModel 
{
	protected $table = 'brand';
	
	protected $fillable = [
			'id', 'code', 'name', 'logo'
	];
	
	
	
}