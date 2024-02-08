<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AdminAddUserRequest extends FormRequest
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
            'profile_photo' => 'mimes:jpg,png',
        ];
    }


    public function messages()
    {
        return [

            /*   ROLES   */
            'roles.required' => 'Roles required.',
            'roles.exists' => 'Roles not exists.',


            /*   name   */
            'name.required' => 'Name required.',

            /*   e-mail   */
            'email.required' => 'E-mail required.',
            'email.unique' => 'This email address is in the system, please check...',
            'email.email' => 'Use the correct email format.',
            'email.min' => 'Email must be at least 3 characters long.',
            'email.max' => 'Email must be a maximum of 255 characters.',

            /*  password   */
            'password.required' => 'Password required.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.max' => '	The password must be a maximum of 50 characters.',

            /*  password_confirmation   */
            'password_confirmation.required' => 'Confirm Password required.',
            'password_confirmation.same' => 'Repeat password is incorrect.',

            /*   profile_photo   */
            'profile_photo.mimes' => 'Wrong photo format. Allowed formats (jpg, jpeg and png)',
        ];
    }





}
