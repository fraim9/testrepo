<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAction extends Model
{
    const PERSON_MASS_DESTRUCTION_LOADED = 'PersonMassDestructionLoaded';
    const PERSON_BLOCKED_LOADED = 'PersonBlokedLoaded';
    const TERRORIST_LOADED = 'TerroristLoaded';
    
    protected $table = 'user_action';
	
	protected $primaryKey = 'code';
	
	protected $keyType = 'char';
	
	public $incrementing = false;
	
	public $timestamps = false;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];
	
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];
	
	
	public function setDate($code, $date, $userId)
	{
	    $row = $this->find($code);
	    if (!$row) {
	        $row = new UserAction();
	        $row->code = $code;
	    }
	    $row->date = $date;
	    $row->user_id = $userId;
	    $row->save();
	}
	
	
	public function user()
	{
	    return $this->belongsTo('App\User')->withDefault(['display_name' => '---']);
	}
	
}


