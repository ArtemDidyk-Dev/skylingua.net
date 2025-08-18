<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{



    public function authorize()
    {
        return true;
    }



    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email|min:3|max:255',
            'roles' => 'required|exists:roles,id',
            'name' => 'required',
            'password' => 'required|min:8|max:50',
            'password_confirmation' => 'required|same:password',
            'agree' => 'required',
        ];
    }


    public function messages()
    {
        return [

            /*   ROLES   */
            'roles.required' => language('frontend.register.error_roles_required'),
            'roles.exists' => language('frontend.register.error_roles_exists'),


            /*   name   */
            'name.required' => language('frontend.register.error_name_required'),

            /*   e-mail   */
            'email.required' => language('frontend.register.error_email_required'),
            'email.unique' => language('frontend.register.error_email_unique'),
            'email.email' => language('frontend.register.error_email_correct'),
            'email.min' => language('frontend.register.error_email_min'),
            'email.max' => language('frontend.register.error_email_max'),

            /*  password   */
            'password.required' => language('frontend.register.error_password_required'),
            'password.min' => language('frontend.register.error_password_min'),
            'password.max' => language('frontend.register.error_password_max'),

            /*  password_confirmation   */
            'password_confirmation.required' => language('frontend.register.error_password_confirmation_required'),
            'password_confirmation.same' => language('frontend.register.error_password_confirmation_same'),

            /*   agree   */
            'agree.required' => language('frontend.register.error_agree_required'),
        ];
    }





}
