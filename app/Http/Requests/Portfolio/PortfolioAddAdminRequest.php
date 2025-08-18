<?php

namespace App\Http\Requests\Portfolio;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class PortfolioAddAdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            /*   NAME   */
            'title' => 'required|max:255',
            'user' => 'required|exists:App\Models\User,id',
        ];
    }


    public function messages()
    {
        return [

            /*   NAME   */
            'title.required' => 'Name required',
            'title.max' => 'Name must be a maximum of 255 characters',
            'user.required' => 'User required',
        ];
    }
}
