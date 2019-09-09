<?php

namespace App;



class ProductImage extends AppModel 
{
    use HasCompositePrimaryKey;
    
	protected $table = 'product_image';
	
	protected $primaryKey = ['product_id', 'image_id'];
	
	public $incrementing = false;
	
	protected $fillable = [];
	
	

	
}