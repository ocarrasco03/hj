<?php

namespace App\Http\Resources\Cms\Customers;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->firstname . ' ' . $this->lastname,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'phone' => $this->phone,
            'ave_purchases' => is_null($this->averagePurchases()) ? 0 : $this->averagePurchases(),
            'suscribed' => $this->suscribed,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
