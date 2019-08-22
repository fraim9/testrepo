<?php

namespace App;


class ItemStock extends AppModel 
{
	protected $table = 'item_stock';
	
	protected $fillable = [
			'warehouse_id', 'item_id', 'serial_id', 
	        'physical_qty', 'available_qty', 'reserved_qty', 'transfer_qty', 'delivery_qty'
	];
	
	
	
	
}