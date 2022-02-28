<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'user_name' => $this->client->name,
            'user_email' => $this->client->email,
            'package_name' => $this->trainingPackage->name ?? '',
            'amount_paid' => $this->trainingPackage->price / 100 ?? '',
            'gym' => $this->manager->gym->name ?? '',
            'city' => $this->manager->gym->city->name ?? '',
        ];
    }
}
