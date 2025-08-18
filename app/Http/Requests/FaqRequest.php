<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'content' => 'required'
        ];
    }
    public function messages()
    {
        return [

            /*   NAME   */
            'title.*.required' => 'Title <span>[[@:attribute@]]</span> required',
            'title.*.max' => 'Title <span>[[@:attribute@]]</span> must be a maximum of 255 characters',
            'content.*.required' => 'Content <span>[[@:attribute@]]</span> required',

        ];
    }
}
