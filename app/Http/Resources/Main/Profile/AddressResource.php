<?php

namespace App\Http\Resources\Main\Profile;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'street' => $this->street,
            'exterior_no' => $this->ext_no,
            'interior_no' => $this->int_no,
            'zip_code' => $this->zip_code,
            'neighborhood' => $this->neighborhood,
            'country' => $this->country->name,
            'state' => $this->state->name,
            'city' => $this->city,
            'type' => $this->type,
            'indications' => $this->notes,
        ];
    }
}
