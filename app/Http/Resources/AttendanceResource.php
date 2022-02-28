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
            'user_name' => $this->client->name,
            'user_email' => $this->client->email,
            'session_name' => $this->trainingSession->name,
            'attendance_time'=> date('H:i:s', strtotime($this->datetime)),
            'attendance_date'=> date('d/M/Y', strtotime($this->datetime)),
            'gym' => $this->trainingSession->gym->name,
            'city' => $this->trainingSession->gym->city->name,
        ];
    }
}
