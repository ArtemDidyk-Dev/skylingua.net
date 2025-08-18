<?php

namespace App\Http\Requests\UserCategory;

use Illuminate\Foundation\Http\FormRequest;

class UserCategoryEditRequest extends FormRequest
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
            'role_id' => 'required|integer',

            /*   IMAGE   */
//            'image' => 'required',
        ];
    }


    public function messages()
    {
        return [

            /*   NAME   */
            'name.*.required' => 'Name <span>[[@:attribute@]]</span> required',
            'name.*.max' => 'Name <span>[[@:attribute@]]</span> must be a maximum of 255 characters',

            /*   role_id   */
            'role_id.required' => language('backend.user_category.error_role_id_required'),
            'role_id.integer' => language('backend.user_category.error_role_id_integer'),


            /*   IMAGE   */
//            'image.required' => 'Image required',
        ];
    }




}
