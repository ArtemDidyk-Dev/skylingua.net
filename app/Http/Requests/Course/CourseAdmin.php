<?php

namespace App\Http\Requests\Course;

use App\Models\Access;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Validator;
use Illuminate\Contracts\Validation\Validator as ValidatorSecond;

class CourseAdmin extends FormRequest
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
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required',
            'user' => 'required|exists:users,id',
            'access_select' => Rule::in(
                [
                    Access::OPEN_TO_EVERYONE,
                    Access::SUBSCRIBERS_ONLY,
                    Access::SUBSCRIBERS_OR_ONE_TIME_PAYMENT,
                    Access::ONE_TIME_PAYMENT_ONLY,
                ]
            ),
        ];
        if ($this->input('access_select') !== Access::OPEN_TO_EVERYONE && $this->input('access_select') !== Access::SUBSCRIBERS_ONLY ) {
           $rules['price'] = 'required|numeric|min:0.01';
        }
        return $rules;

    }

    public function failedValidation(Validator|ValidatorSecond $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422));
    }

}
