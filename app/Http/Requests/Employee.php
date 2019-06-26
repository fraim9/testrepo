<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Employee extends FormRequest
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
                'name' => 'required|string|max:150',
                'personnel_number' => 'nullable|string|max:32',
                'department' => 'nullable|string|max:150',
                'position' => 'nullable|string|max:150',
                'birth_month' => 'nullable|int|between:1,12',
                'birth_day' => 'nullable|int|between:1,31',
                'email' => 'nullable|email|max:100',
                'phone' => 'nullable|string|max:26',
                'phone_mobile' => 'nullable|string|max:26',
                'phone_personal' => 'nullable|string|max:26',
                //'region_id' => 'nullable|int',
                'division_id' => 'nullable|int',
                
                'publish_on_site' => 'boolean',
                'publish_on_fast_contacts' => 'boolean',
                'publish_phone' => 'boolean',
                'publish_email' => 'boolean',
                'active' => 'boolean',
        ];
        
        
    }
}
