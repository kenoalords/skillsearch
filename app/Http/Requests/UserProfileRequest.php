<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileRequest extends FormRequest
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
            'bio'           => 'required|min:200|max:3200',
            'user_location' => 'required|min:3|max:32',
            'gender'        => 'in:male,female',
        ];
    }

    // Custom error messages
    public function messages()
    {
        return [
            'bio.required'          => 'Please tell us a little about yourself',
            'bio.min'               => 'Hmmm! That cannot be all about you, please enter a minimum on 200 characters',
            'gender.required'       => 'Please select your gender',
        ];
    }
}
