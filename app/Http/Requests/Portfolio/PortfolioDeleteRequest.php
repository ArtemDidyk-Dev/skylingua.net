<?php

namespace App\Http\Requests\Portfolio;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioDeleteRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'id' => 'required',
        ];
    }


    public function messages()
    {
        return [

        ];
    }


}
