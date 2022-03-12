<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //AttendanceApiResource::collection(User::where('id', $userID)->first()->attendances)
        return [
            'session_name' => $this->trainingSession->name,
            'gym_name' => $this->trainingSession->gym->name,
            'attendance_date'=> date('d-m-Y', strtotime($this->attendance_datetime)),
            'attendance_time'=> date('h:i:s a', strtotime($this->attendance_datetime)),
        ];
    }
}
