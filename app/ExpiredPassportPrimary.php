<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpiredPassportPrimary extends Model
{
	protected $table = 'expired_passport_primary';
	
	protected $fillable = [];
	
	protected $connection = 'omnipos_auth';
	
	public $timestamps = false;
	
	
	
}
