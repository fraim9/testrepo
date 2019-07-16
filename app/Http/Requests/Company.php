<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Company extends FormRequest
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
                'name' => 'required|string|max:150',
                'logo' => 'nullable|string|max:50',
                'description' => 'nullable',
                'phone' => 'nullable|string|max:255',
                'country_id' => 'required|int',
                'city_id' => 'required|int',
                'time_zone_id' => 'required|int',
                'legal_mentions' => 'nullable',
                'currency' => 'required|alpha|size:3',
        ];
        
    }
}
