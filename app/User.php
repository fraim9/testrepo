<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
	use Notifiable;
	
	const CREATED_AT = 'created_date';
	const UPDATED_AT = 'modified_date';
	
	protected $table = 'user';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'username', 'email', 'group_id', 
	        'display_name', 'email_subscribe', 'active'
	];
	
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
			'password', 'remember_token',
	];
	
	
	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
			'created_date' => 'datetime',
			'modified_date' => 'datetime',
	];
	
	
	public function group()
	{
	    return $this->belongsTo('App\UserGroup');
	}
	
}
