<?php

namespace App\Http\Requests\Subscriber;

use Illuminate\Foundation\Http\FormRequest;

class SubscriberAdmin extends FormRequest
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
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ];
    }
    public function messages()
    {
        return [

            /*   NAME   */
            'title.*.required' => 'Title <span>[[@:attribute@]]</span> required',
            'title.*.max' => 'Title <span>[[@:attribute@]]</span> must be a maximum of 255 characters',
            'content.*.required' => 'Content <span>[[@:attribute@]]</span> required',
            'user_id.required' => 'User <span>[[@:attribute@]]</span> required',
            'price.required' => 'Price <span>[[@:attribute@]]</span> required',
            'price.numeric' => 'Price <span>[[@:attribute@]]</span> must be a number',
        ];
    }

}
