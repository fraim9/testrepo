<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
                'code' => 'required|max:32',
                'name' => 'required|max:150',
                'description' => 'nullable',
                'phone' => 'nullable|max:255',
                'country_id' => 'nullable|integer',
                'city_id' => 'nullable|integer',
                'address' => 'nullable|max:255',
                'geolocation' => 'nullable|max:255',
                'time_zone' => 'nullable|max:6',
                'price_id' => 'nullable|integer',
                'currency' => 'nullable|string|max:3',
                'group_id' => 'nullable|integer',
        ];
    }
}
