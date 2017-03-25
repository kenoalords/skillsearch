<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialUserProfileRequest extends FormRequest
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
            'first_name'=> 'required|min:3|max:32',
            'last_name' => 'required|min:3|max:32',
            'gender'    => 'required|in:male,female',
            'location'  => 'required|min:3|max:32',
            'bio'       => 'required|min:120|max:2500',
            'account_type' => 'required|in:1,0'
        ];
    }
}
