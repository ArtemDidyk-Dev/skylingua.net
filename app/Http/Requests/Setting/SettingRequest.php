<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }



    public function rules()
    {
        return [
            'logo' => 'mimes:jpg,png,svg',
            'logo_dark' => 'mimes:jpg,png,svg',
            'favicon' => 'mimes:jpg,png,svg',
        ];
    }


    public function messages()
    {
        return [
            'logo.mimes' => 'You have selected the wrong image format for the logo. Allowed formats (jpg, jpeg, png)',
            'logo_dark.mimes' => 'You have selected the wrong image format for the dark logo. Allowed formats (jpg, jpeg, png)',
            'favicon.mimes' => 'You have selected the wrong image format for the favicon. Allowed formats (jpg, jpeg, png)',
        ];
    }


}
