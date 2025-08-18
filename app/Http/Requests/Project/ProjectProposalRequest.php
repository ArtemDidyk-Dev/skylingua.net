<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class ProjectProposalRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            /*   Your Price   */
            'price' => 'required|numeric',

            /*   Estimated Hours   */
            'hours' => 'required|integer',

            /*   Agree   */
            'agree' => 'required',

        ];
    }


    public function messages()
    {
        return [
            /*   Price   */
            'price.required' => language('Price required'),
            'price.numeric' => language('Price numeric'),

            /*   Hours   */
            'hours.required' => language('Hours required'),
            'hours.integer' => language('Hours integer'),

            /*   Agree   */
            'agree.required' => language('Agree required'),

        ];
    }


}
