<?php

namespace App\Http\Requests\Pay;

use Illuminate\Foundation\Http\FormRequest;

class PayoutBankstepOneRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'currency' => 'required',
//            'senderAccount' => 'required',
            'amount' => 'required|numeric',
            'receiverCountry' => 'required',
        ];
    }


    public function messages()
    {
        return [

        ];
    }




}
