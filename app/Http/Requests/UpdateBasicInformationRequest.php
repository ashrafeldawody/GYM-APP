<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateBasicInformationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userId = Auth::user()->id;
        return [
            'name' => 'required|min:3|max:100',
            'email' => 'required|unique:managers|email:rfc,dns|max:100',
            'email' => [
                'required',
                Rule::unique('managers')->ignore($userId),
                'email:rfc,dns',
                'max:100'
            ],
            'gender' => 'required|in:male,female',
            'birth_date' => 'date_format:Y-m-d|before:today',
            'avatar' => 'mimes:jpg,jpeg,bmp,png'
        ];
    }
}
