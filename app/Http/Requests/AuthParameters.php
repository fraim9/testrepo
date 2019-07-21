<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthParameters extends FormRequest
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
                'auth_key' => 'nullable|string|max:32',
                'auth_code' => 'nullable|string|max:36',
                'api_auth_url' => 'nullable|string|max:50',
                'omnipos_secret_key' => 'nullable|string|max:36',
                'ipos_secret_key' => 'nullable|string|max:36',
        ];
        
        
    }
}
