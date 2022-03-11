<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreGeneralManagerRequest extends FormRequest
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
        return [
            'name' => 'required|min:3|unique:managers|string',
            'email' => 'required|email|unique:managers',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date|before:-20 years',
            'password' => 'min:8',
            'password_confirmation'=> 'required_with:password|same:password|min:8',
            'avatar' => 'image',
            'national_id' => 'digits:14|unique:managers',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password_confirmation.*' => 'The password dosn\'t match',
            'birth_date.before' => 'The Age of managers must be at least 20 years old',
        ];
    }
}
