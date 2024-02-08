<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{



    public function authorize()
    {
        return true;
    }



    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email,status,1|min:3|max:255',
        ];
    }


    public function messages()
    {
        return [

            /*   e-mail   */
            'email.required' => language('frontend.register.error_email_required'),
            'email.email' => language('frontend.register.error_email_correct'),
            'email.exists' => language('frontend.register.error_email_exists'),
            'email.min' => language('frontend.register.error_email_min'),
            'email.max' => language('frontend.register.error_email_max'),

        ];
    }





}
