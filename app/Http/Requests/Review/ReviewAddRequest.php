<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class ReviewAddRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:200',
            'rating' => 'required|numeric|between:0,5',
            'project_id' => 'required|integer',
            'message' => "string|max:1000",
            'status' => 'required|integer',
        ];
    }


    public function messages()
    {
        return [

        ];
    }




}
