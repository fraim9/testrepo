<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AmlReport extends FormRequest
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
                'first_name' => 'required|string|max:50',
                'middle_name' => 'required|string|max:50',
                'last_name' => 'required|string|max:50',
               
                'birth_date' => 'required|date',

                'citizenship_id' => 'nullable|int',
                
                'passport_series' => 'nullable|string|max:20',
                'passport_number' => 'nullable|string|max:20',
                'passport_issued_date' => 'nullable|string',
                'passport_issued_by' => 'nullable|string|max:150',
                'passport_subdivision_code' => 'nullable|string|max:10',
                
                'migration_series' => 'nullable|string|max:20',
                'migration_number' => 'nullable|string|max:20',
                'migration_stay_from' => 'nullable|date',
                'migration_stay_to' => 'nullable|date',
                
                'permission_series' => 'nullable|string|max:20',
                'permission_number' => 'nullable|string|max:20',
                'permission_stay_from' => 'nullable|date',
                'permission_stay_to' => 'nullable|date',
                
                'registration_address' => 'nullable|string|max:255',
                
                'inn' => 'nullable|string|max:12',
                
                'status' => 'required|int',
                
        ];
    }
}
