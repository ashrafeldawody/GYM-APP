<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'session_name' => $this->trainingSession->name,
            'attendance_time'=> date('h:i:s a', strtotime($this->attendance_datetime)),
            'attendance_date'=> date('d/m/Y', strtotime($this->attendance_datetime)),
            'gym' => $this->trainingSession->gym->name,
            'city' => $this->trainingSession->gym->city->name,
        ];
    }
}
