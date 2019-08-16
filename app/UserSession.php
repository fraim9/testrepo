<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    
    protected $table = 'user_session';
	
	public $timestamps = false;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['date', 'user_id', 'type', 'app_name', 'app_version', 'device_name'];
	
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];
	
	
	public static function add($userId, $typeId, $appName = null, $appVer = null, $deviceName = null)
	{
	    $session = new static([
	            'date' => date('Y-m-d H:i:s'),
	            'user_id' => $userId,
	            'type' => $typeId,
	            'app_name' => str_limit($appName, 137),
	            'app_version' => str_limit($appVer, 17),
	            'device_name' => str_limit($deviceName, 137),
	    ]);
	    $session->save();
	    return $session;
	}
	
	
	public function user()
	{
	    return $this->belongsTo('App\User');
	}
	
}


