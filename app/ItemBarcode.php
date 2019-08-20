<?php

namespace App;


class ItemBarcode extends AppModel 
{
	protected $table = 'item_barcode';
	
	protected $primaryKey = 'barcode';
	
	protected $keyType = 'char';
	
	public $incrementing = false;
	
	protected $fillable = [];
	
	
}