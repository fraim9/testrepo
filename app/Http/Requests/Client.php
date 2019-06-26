<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Client extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'code' => 'required|string|max:32',
                
                'first_name' => 'required|string|max:50',
                'middle_name' => 'required|string|max:50',
                'last_name' => 'required|string|max:50',
                'gender' => 'required|string|size:1',
                
                'comment' => 'nullable|string|max:500',
                
                'phone' => 'nullable|string|max:26',
                'email' => 'nullable|email|max:100',
               
                'bd_day' => 'nullable|int|between:1,31',
                'bd_month' => 'nullable|int|between:1,12',
                'bd_year' => 'nullable|int|between:1900,' . date('Y'),
                'birth_place' => 'nullable|string|max:150',
                
                'time_zone_id' => 'nullable|int',
                'country_id' => 'nullable|int',
                'postcode' => 'nullable|string|max:30',
                'city' => 'nullable|string|max:40',
                'address' => 'nullable|string|max:255',
                'citizenship_id' => 'nullable|int',
                
                'passport_series' => 'nullable|string|max:20',
                'passport_number' => 'nullable|string|max:20',
                'passport_issued_date' => 'nullable|string',
                'passport_issued_by' => 'nullable|string|max:150',
                'passport_subdivision_code' => 'nullable|string|max:10',
                
                'registration_address' => 'nullable|string|max:255',
                
                'inn' => 'nullable|string|max:12',
                
                'discount' => 'nullable|int',
                'discount_auto_calc' => 'boolean',

                'subscribe' => 'boolean',
                'postal_opt_in' => 'boolean',
                'voice_opt_in' => 'boolean',
                'email_opt_in' => 'boolean',
                'msg_opt_in' => 'boolean',
                
                //'consent_file' => '',
                'agreement_signed' => 'boolean',
                
                'employee_id' => 'nullable|int',
                
                'responsible_id' => 'nullable|int',
                'created_employee_id' => 'nullable|int',
                
                'created_store_id' => 'nullable|int',
                'attached_store_id' => 'nullable|int',
                
        ];
        
        /*
	        'gender', 'comment', 'phone', 'email', 'bd_day', 'bd_month', 'bd_year', 'birth_place',
	        'time_zone_id', 'country_id', 'postcode', 'city', 'address', 'citizenship_id', 'passport_series',
	        'passport_number', 'passport_issued_date', 'passport_issued_by', 'passport_subdivision_code', 'inn',
	        'registration_address', 'discount', 'discount_auto_calc', 'subscribe', 'postal_opt_in', 'voice_opt_in',
	        'email_opt_in', 'msg_opt_in', 'consent_file', 'agreement_signed',
	        'employee_id', 'responsible_id', 'created_employee_id', 'created_store_id', 'attached_store_id'
         */
        
    }
}
