<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }



    public function rules()
    {
        return [
            'email' => 'required|min:3|max:255',
            'password' => 'required|min:8|max:30',
        ];
    }


    public function messages()
    {
        return [
            'email.required' => 'E-mail required.',
            'email.min' => 'E-mail must be at least 3 characters long.',
            'email.max' => 'E-mail must be a maximum of 255 characters.',
            'password.required' => 'Password required.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.max' => 'The password must be a maximum of 30 characters.'
        ];
    }
}
