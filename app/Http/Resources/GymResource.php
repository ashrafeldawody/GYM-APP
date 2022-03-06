<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Column;

class GymResource extends JsonResource
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
           'created_at' => date('d-m-Y', strtotime($this->created_at)),
           'cover_image' => $this->cover_image,
       ];
        if (Auth::user()->can('show_city_data')) {
            $dataArray['city_manager_name'] = $this->city->manager->name;
        };
        return $dataArray;
    }
}
