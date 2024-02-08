<?php

namespace App\Http\Requests\Slide;

use Illuminate\Foundation\Http\FormRequest;

class SlideAddRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            /*   TITLE   */
            'title.*' => 'max:255',

            /*  SUB TITLE   */
            'sub_title.*' => 'max:255',

            /*   IMAGE   */
            'image.*' => 'required',
        ];
    }


    public function messages()
    {
        return [

            /*   TITLE   */
            'title.*.max' => 'Title <span>[[@:attribute@]]</span> must be a maximum of 255 characters',

            /*  SUB TITLE   */
            'sub_title.*.max' => 'Sub Title <span>[[@:attribute@]]</span> must be a maximum of 255 characters',

            /*   IMAGE   */
            'image.*.required' => 'Image <span>[[@:attribute@]]</span> required',
        ];
    }




}
