<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $dataArray = [
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'session_name' => $this->trainingSession->name,
            'attendance_time'=> date('h:i:s a', strtotime($this->attendance_datetime)),
            'attendance_date'=> date('d-m-Y', strtotime($this->attendance_datetime)),
        ];
        if (Auth::user()->can('show_gym_data')) {
            $dataArray['gym'] = $this->trainingSession->gym->name;
        }
        if (Auth::user()->can('show_city_data')) {
            $dataArray['city'] = $this->trainingSession->gym->city->name;
        };
        return $dataArray;
    }
}
