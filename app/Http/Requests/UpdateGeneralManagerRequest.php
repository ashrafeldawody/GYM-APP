<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateGeneralManagerRequest extends FormRequest
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

        $managerId = $this->route('general_manager');
        return [
            'name' => [
                'required',
                'min:3',
                Rule::unique('managers')->ignore($managerId),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('managers')->ignore($managerId),
            ],
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date|before:-20 years',
            'avatar' => 'image',
            'national_id' => 'digits:14',

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
