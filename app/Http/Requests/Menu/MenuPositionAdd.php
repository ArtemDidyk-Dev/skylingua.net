<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class MenuPositionAdd extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
           'menu_position_id' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Name required',
            'menu_position_id.required' => 'Position ID cannot be left blank.',

        ];
    }
}
