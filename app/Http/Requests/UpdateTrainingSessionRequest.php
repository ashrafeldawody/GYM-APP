<?php

namespace App\Http\Requests;

use App\Models\TrainingSession;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateTrainingSessionRequest extends FormRequest
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
        $sessionID = $this->route('session');

        return [
            'name' => [
                'required',
                Rule::unique('training_sessions')->ignore($sessionID),
            ],
            'day' => 'required|date',
            'starts_at' => 'required',
            'finishes_at' => 'required|after:starts_at',
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
            'name.required' => 'The session name is required',
            'day.required' => 'Day Field is required',
            'starts_at.required' => 'Start Time is required',
            'finishes_at.required' => 'Finish Time is required',
            'finishes_at.after' => 'Finish Time must be after start time !',
        ];
    }
}
