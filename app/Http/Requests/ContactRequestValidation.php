<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ContactRequestValidation extends FormRequest
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
            'fullname'  => 'required|min:3',
            'email'     => 'required|email',
            'location'  => 'required|min:3',
            'phone'     => 'nullable',
            'result'    => 'required|integer|size:'.($this->get('fig1') + $this->get('fig2')),
        ];
    }

    public function messages()
    {
        return [
            'fullname.required'     => 'Kindly provide your fullname',
            'email.required'        => 'Kindly provide your email address',
            'email.email'           => 'Kindly provide a valid email address',
            'location.required' => 'Kindly provide your current location (City, State)',
            'result.required'       => 'Please provide an answer to prove you are human',
            'result.size'           => 'That is an incorrect value',
        ];
    }
}
