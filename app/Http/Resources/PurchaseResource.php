<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Column;

class PurchaseResource extends JsonResource
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
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'package_name' => $this->trainingPackage->name,
            'amount_paid' => $this->amount_paid / 100,
        ];
        if (Auth::user()->can('show_gym_data')) {
            $dataArray['gym'] = $this->gym->name;
        }
        if (Auth::user()->can('show_city_data')) {
            $dataArray['city'] = $this->gym->city->name;
        };
        return $dataArray;
    }
}
