<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class ProjectAcceptCancelRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'project_id' => 'required|integer'
        ];
    }


    public function messages()
    {
        return [

            /*   Project_id   */
            'project_id.required' => language('Project required'),
            'project_id.integer' => language('Project integer'),
        ];
    }




}
