<?php

namespace App;


class Warehouse extends AppModel 
{
	protected $table = 'warehouse';
	
	protected $fillable = [
			'id', 'code', 'name', 'store_id'
	];
	
	
	
}