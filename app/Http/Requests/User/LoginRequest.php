<?php

namespace App\Http\Requests\User;

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
            'email' => 'required|email|exists:users,email,status,1|min:3|max:255',
            'password' => 'required|min:8|max:50',
            'remember' => 'integer|size:1',
        ];
    }


    public function messages()
    {
        return [


            /*   e-mail   */
            'email.required' => language('frontend.login.error_email_required'),
            'email.exits' => language('frontend.login.error_email_exits'),
            'email.email' => language('frontend.login.error_email_correct'),
            'email.min' => language('frontend.login.error_email_min'),
            'email.max' => language('frontend.login.error_email_max'),

            /*  password   */
            'password.required' => language('frontend.login.error_password_required'),
            'password.min' => language('frontend.login.error_password_min'),
            'password.max' => language('frontend.login.error_password_max'),

            /*  password_confirmation   */
            'password_confirmation.required' => language('frontend.login.error_password_confirmation_required'),
            'password_confirmation.same' => language('frontend.login.error_password_confirmation_same'),

            /*   remember   */
            'remember.integer' => language('frontend.login.error_remember_integer'),
        ];
    }





}
