<?php

namespace App;


class Employee extends AppModel 
{
	protected $table = 'employee';
	
	protected $fillable = [
			'code', 'name', 'personnel_number', 'department', 'position', 'birth_month', 'birth_day',
	        'image', 'email', 'phone', 'phone_mobile', 'phone_personal', 
	        'region_id', 'manager_id', 'division_id',
	        'publish_on_site', 'publish_on_fast_contacts', 'publish_phone', 'publish_email',
	        'active'
	];
	
	public function division()
	{
	    return $this->belongsTo('App\Division')->withDefault();
	}
	
	
}
