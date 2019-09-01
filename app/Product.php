<?php

namespace App;


class Product extends AppModel 
{
	protected $table = 'product';
	
	protected $fillable = [
			'id', 'code', 'name', 'description'
	];
	
	
	public function sections()
	{
	    return $this->belongsToMany('App\ProductSection', 'product_to_section', 'product_id', 'section_id');
	}
	
	
}