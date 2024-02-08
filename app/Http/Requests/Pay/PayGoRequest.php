<?php

namespace App\Http\Requests\Pay;

use Illuminate\Foundation\Http\FormRequest;

class PayGoRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'freelancer_id' => 'required|integer',
            'project_id' => 'required|integer'
        ];
    }


    public function messages()
    {
        return [

        ];
    }




}
