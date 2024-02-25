<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class EmployerRegisterRequest extends FormRequest
{



    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email|min:3|max:255',
            'name' => 'required',
            'agree' => 'required',
        ];
    }


    public function messages()
    {
        return [

            /*   ROLES   */

            /*   e-mail   */
            'email.required' => language('frontend.register.error_email_required'),
            'email.unique' => language('frontend.register.error_email_unique'),
            'email.email' => language('frontend.register.error_email_correct'),
            'email.min' => language('frontend.register.error_email_min'),
            'email.max' => language('frontend.register.error_email_max'),


            /*   agree   */
            'agree.required' => language('frontend.register.error_agree_required'),
        ];
    }





}
