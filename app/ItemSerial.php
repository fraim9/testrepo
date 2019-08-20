<?php

namespace App;


class ItemSerial extends AppModel 
{
	protected $table = 'item_serial';
	
	protected $fillable = ['item_id', 'serial'];
	
}