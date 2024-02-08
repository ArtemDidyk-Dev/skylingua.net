<?php

namespace App\Http\Requests\Portfolio;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioAddRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            /*   NAME   */
            'title' => 'required|max:255',


            /*   IMAGE   */
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }


    public function messages()
    {
        return [

            /*   NAME   */
            'title.required' => 'Name required',
            'title.max' => 'Name must be a maximum of 255 characters',

        ];
    }


}
