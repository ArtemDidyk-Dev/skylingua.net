<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class ProjectAddRequest extends FormRequest
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

            /*   Country   */
            'country_id' => 'required|integer',

            /*   DOCUMENT   */
//            'document' => 'mimes:jpg,jpeg,png,gif,doc,docx,xls,pdf'

        ];
    }


    public function messages()
    {
        return [

            /*   NAME   */
            'name.required' => language('Name required'),
            'name.max' => language('Name must be a maximum of 255 characters'),


            /*   Description   */
            'description.required' => language('Description required'),


            /*   Country   */
            'country_id.required' => language('Country required'),
            'country_id.integer' => language('Country integer'),


        ];
    }




}
