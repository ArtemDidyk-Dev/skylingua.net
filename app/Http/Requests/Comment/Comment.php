<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class Comment extends FormRequest
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
            'descrip' => 'nullable|max:100',
            'content' => 'required|max:255',
            'image' => 'nullable|mimes:jpg,png',
        ];
    }
    public function messages()
    {
        return [

            /*   NAME   */
            'name.*.required' => 'Title <span>[[@:attribute@]]</span> required',
            'name.*.max' => 'Title <span>[[@:attribute@]]</span> must be a maximum of 255 characters',
            'descrip.*.max' => 'Descrip <span>[[@:attribute@]]</span> must be a maximum of 100 characters',
            'content.*.required' => 'Content <span>[[@:attribute@]]</span> required',
            'image.mimes' => 'Wrong photo format. Allowed formats (jpg, jpeg and png)'

        ];
    }
}
