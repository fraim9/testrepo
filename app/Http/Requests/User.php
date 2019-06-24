<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class User extends FormRequest
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
                'username' => 'required|max:50',
                'password' => 'nullable|min:8|max:20',
                'display_name' => 'required|max:150',
                'email' => 'required|email|max:100',
                'email_subscribe' => 'boolean',
                'active' => 'boolean',
                'password' => 'nullable|string|min:8'
        ];
    }
}
