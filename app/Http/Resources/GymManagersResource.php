<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Column;

class GymManagersResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'national_id' => $this->national_id,
            'email' => $this->email,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'avatar' => $this->avatar,
            'is_banned' => $this->is_banned,
            'gym' => $this->gym->name,
        ];
        if (Auth::user()->can('show_city_data')) {
            $dataArray['city'] = $this->gym->city->name;
        };
        return $dataArray;

    }
}
