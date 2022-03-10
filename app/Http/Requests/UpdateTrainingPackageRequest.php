<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateTrainingPackageRequest extends FormRequest
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
        $packageId = $this->route('package');
        return [
            'name' => [
                'required',
                Rule::unique('training_packages')->ignore($packageId),
            ],
            'price' => 'required|numeric',
            'sessions_number' => 'required|integer',
        ];
    }




}
