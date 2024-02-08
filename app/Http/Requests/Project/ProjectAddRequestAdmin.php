<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class ProjectAddRequestAdmin extends FormRequest
{


    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [

            /*   User Name   */
            'user_name' => 'required|integer|exists:users,id',

            /*   NAME   */
            'name' => 'required|max:255',

            /*   Description   */
            'description' => 'required',

            /*   Country   */
            'country_id' => 'required|integer',



            /*   DOCUMENT   */
//            'document' => 'mimes:jpg,jpeg,png,gif,doc,docx,xls,pdf'

        ];
    }


    public function messages()
    {
        return [
            /*   user_name   */
            'user_name.required' => 'User name required',
            'user_name.exits' => 'User name required',

            /*   NAME   */
            'name.required' => 'Name required',
            'name.max' => 'Name must be a maximum of 255 characters',


            /*   Description   */
            'description.required' => 'Description required',




        ];
    }




}
