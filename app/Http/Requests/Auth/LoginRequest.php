<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'u_email'    => 'required',
            'u_password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'u_email.required'    => 'Email is required',
            'u_password.required' => 'Password is required',
        ];
    }
}
