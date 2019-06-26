<?php

namespace App;


class Client extends AppModel 
{
	protected $table = 'client';
	
	protected $fillable = [
			'code', 'name', 'personnel_number', 'department', 'position', 'birth_month', 'birth_day',
	        'image', 'email', 'phone', 'phone_mobile', 'phone_personal', 
	        'region_id', 'manager_id', 'division_id',
	        'publish_on_site', 'publish_on_fast_contacts', 'publish_phone', 'publish_email',
	        'active'
	];
	
	// id, code, type, name, original_name, first_name, middle_name, last_name, first_name_lat, 
	// last_name_lat, gender, comment, phone, email, bd_day, bd_month, bd_year, birth_place, 
	// time_zone_id, country_id, postcode, city, address, citizenship_id, passport_series, 
	// passport_number, passport_issued_date, passport_issued_by, passport_subdivision_code, inn, 
	// registration_address, discount, discount_auto_calc, subscribe, postal_opt_in, voice_opt_in, 
	// email_opt_in, msg_opt_in, consent_file, agreement_signed, sent_welcome, sent_welcome_date, 
	// employee_id, responsible_id, created_employee_id, created_store_id, attached_store_id,
	
	public function country()
	{
	    return $this->belongsTo('App\Country');
	}
	
	
}
