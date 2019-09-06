<?php

namespace App;

class Settings extends AppModel
{
	protected $table = 'settings';
	
	protected $primaryKey = '_id';
	
	protected $keyType = 'char';
	
	public $incrementing = false;
	
	public $timestamps = false;
	
	public static $availableKeys = ['General', 'iPOS', 'Storage', 'OmniPOS'];
	
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'doc'
	];
	
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];
	
	public function __construct(array $attributes = [])
	{
	    parent::__construct($attributes);
	    
	    $this->casts['doc'] = 'json';
	    
	}
	
	public static function findOrFail($id)
	{
	    if (!in_array($id, static::$availableKeys)) {
	       abort(404);
	    }
	    $settings = static::find($id);
	    if (!$settings) {
	        $settings = new static();
	        $doc = new \stdClass();
	        $doc->_id = $id;
	        $settings->doc = $doc;
	        $settings->save();
	        $settings->_id = $id;
	    }
	    return $settings;
	}
	
	public static function General()
	{
	    return static::find('General')->doc;
	}
	
	public static function iPos()
	{
	    return static::find('iPOS')->doc;
	}
	
	public static function Storage()
	{
	    return static::find('Storage')->doc;
	}
	
	
}


