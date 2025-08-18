<?php

namespace App\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;

class CountryAddRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            /*   NAME   */
            'name.*' => 'required|max:255',


            /*   IMAGE   */
            'image' => 'required',
        ];
    }


    public function messages()
    {
        return [

            /*   NAME   */
            'name.*.required' => 'Name <span>[[@:attribute@]]</span> required',
            'name.*.max' => 'Name <span>[[@:attribute@]]</span> must be a maximum of 255 characters',

        ];
    }




}
