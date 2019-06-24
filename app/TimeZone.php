<?php

namespace App;

class TimeZone extends AppModel
{
	protected $table = 'time_zone';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'code', 'name', 'offset'
	];
	
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];

	
	public function asOptions($keyField = 'id', $nameField = 'name')
	{
	    $options = [];
	    $items = $this->orderBy('offset')->get();
	    if ($items) {
	        foreach ($items as $item) {
	            $options[$item->id] = $item->offset . ' ' . $item->name;
	        }
	    }
	    return $options;
	}
	
}
