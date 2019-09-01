<?php

namespace App;


class Item extends AppModel 
{
	protected $table = 'item';
	
	protected $fillable = [];
	
	protected $hidden = [];

	public function color()
	{
	    return $this->belongsTo('App\ProductColor')->withDefault(['code' => 'none']);
	}
	
	public function config()
	{
	    return $this->belongsTo('App\ProductConfig')->withDefault(['code' => 'none']);
	}
	
	public function size()
	{
	    return $this->belongsTo('App\ProductSize')->withDefault(['code' => 'none']);
	}
	
	public function season()
	{
	    return $this->belongsTo('App\ProductSeason')->withDefault(['code' => 'none']);
	}
	
	
}
