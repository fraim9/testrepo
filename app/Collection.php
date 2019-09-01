<?php

namespace App;


class Collection extends AppModel 
{
	protected $table = 'collection';
	
	protected $fillable = [
			'id', 'code', 'name', 'description', 'year', 'brandCode'
	];
	
	
	
}