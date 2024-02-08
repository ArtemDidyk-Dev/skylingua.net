<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetsRequest extends FormRequest
{



    public function authorize()
    {
        return true;
    }



    public function rules()
    {
        return [
            'password' => 'required|min:8|max:50',
            'password_confirmation' => 'required|same:password',
            'email' => 'required|email|exists:users,email,status,1|min:3|max:255',
            'token' => 'required',
        ];
    }


    public function messages()
    {
        return [

            /*   e-mail   */
            'email.required' => language('frontend.register.error_email_required'),
            'email.unique' => language('frontend.register.error_email_unique'),
            'email.email' => language('frontend.register.error_email_correct'),
            'email.exists' => language('frontend.register.error_email_exists'),
            'email.min' => language('frontend.register.error_email_min'),
            'email.max' => language('frontend.register.error_email_max'),

            /*  password   */
            'password.required' => language('frontend.register.error_password_required'),
            'password.min' => language('frontend.register.error_password_min'),
            'password.max' => language('frontend.register.error_password_max'),

            /*  password_confirmation   */
            'password_confirmation.required' => language('frontend.register.error_password_confirmation_required'),
            'password_confirmation.same' => language('frontend.register.error_password_confirmation_same'),

            /*   token   */
            'token.required' => language('frontend.register.error_token_required'),
        ];
    }





}
