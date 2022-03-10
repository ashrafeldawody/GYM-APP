<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTrainingSessionRequest extends FormRequest
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
            'name' => 'required|unique:training_sessions',
            'day' => 'required|date|after:yesterday',
            'starts_at' => 'required',
            'finishes_at' => 'required|after:starts_at',
            'coach_id' => 'required',
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
            'day.after' => 'The Entered day is expired',
            'starts_at.required' => 'Start Time is required',
            'finishes_at.required' => 'Finish Time is required',
            'finishes_at.after' => 'Finish Time must be after start time !',
            'coach_id.required' => 'You have to select at least one coach',
        ];
    }
}
