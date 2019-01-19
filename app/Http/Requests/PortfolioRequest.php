<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioRequest extends FormRequest
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
        $rules =  [
            'title'     => 'required|max:120',
            'skills'    => 'required',
            'thumbnail' => 'required|mimes:jpg,jpeg,png,gif',
        ];
        $files = count($this->input('files'));
        foreach ( range(0, $files) as $index ){
            $rules['file-'.$index] = 'mimetypes:video/mp4,audio/mp3,audio/mpeg,image/jpeg,image/jpg,image/png,image/gif';
        }
        return $rules;
    }
}
