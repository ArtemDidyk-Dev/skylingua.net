<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class ProjectEditRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            /*   NAME   */
            'name' => 'required|max:255',

            /*   Description   */
            'description' => 'required',

//            /*   DOCUMENT   */
//            'document' => 'mimes:jpg,jpeg,png,gif,doc,docx,xls,pdf'
        ];
    }


    public function messages()
    {
        return [

            /*   NAME   */
            'name.required' => 'Name required',
            'name.max' => 'Name must be a maximum of 255 characters',

            /*   Description   */
            'description.required' => 'Description required',


        ];
    }




}
