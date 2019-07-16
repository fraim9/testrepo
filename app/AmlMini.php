<?php

namespace App;


class AmlMini extends AppModel 
{
	protected $table = 'aml_mini_quest';
	
	protected $fillable = [
	        'store_id', 'initiator_id', 'client_id', 'first_name', 'middle_name', 'last_name', 'birth_date',
	        'birth_place', 'citizenship_id', 'passport_series', 'passport_number', 'passport_issued_date',
	        'passport_issued_by', 'passport_subdivision_code', 'inn', 'registration_address', 'residence_address',
	        'phone', 'migration_series', 'migration_number', 'migration_stay_from', 'migration_stay_to',
	        'permission_series', 'permission_number', 'permission_stay_from', 'permission_stay_to',
	        'questionnaire', 'questionnaire_file'
	];
	
	public function __construct(array $attributes = [])
	{
	    parent::__construct($attributes);
	    $this->casts['questionnaire'] = 'json';
	}
	
	
	public function store()
	{
	    return $this->belongsTo('App\Store');
	}
	
	public function initiator()
	{
	    return $this->belongsTo('App\Employee');
	}
	
	public function client()
	{
	    return $this->belongsTo('App\Client');
	}
	
	public function citizenship()
	{
	    return $this->belongsTo('App\Country');
	}
	
}
