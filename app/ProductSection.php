<?php

namespace App;


class ProductSection extends AppModel 
{
	protected $table = 'product_section';
	
	protected $fillable = [
			'id', 'code', 'parent_id', 'name'
	];
	
	
	
}