<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Country extends FormRequest
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
                'iso2' => 'required|alpha|size:2',
                'iso3' => 'required|alpha|size:3',
                'name' => 'required|max:60',
                'calling_code' => 'required|digits_between:1,5',
        ];
    }
}
