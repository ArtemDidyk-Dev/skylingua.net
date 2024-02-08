<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class ReviewAddRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'rating' => 'required',
            'from' => 'required|integer|exists:users,id',
            'to' => 'required|integer|exists:users,id',
            'review' => 'required',
        ];
    }


    public function messages()
    {
        return [

        ];
    }




}
