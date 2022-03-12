<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'name' => ['required','min:3'],
            'email' => ['required','email',Rule::unique('users')],
            'gender' =>['required','in:male,female'],
            'birth_date' =>['date_format:Y-m-d','before:today','after:1920-01-01'],
            'avatar' =>['nullable','image'],
            'password' => ['required', 'confirmed',Password::min(8)
                            ->letters()         // Require at least one letter...
                            ->mixedCase()       // Require at least one uppercase and one lowercase letter...
                            ->numbers()         // Require at least one number...
                            ->symbols()         // Require at least one symbol...
                            ->uncompromised()   //ensure that a password has not been compromised in a public password data breach leak
                           ],
        ];
    }
}
