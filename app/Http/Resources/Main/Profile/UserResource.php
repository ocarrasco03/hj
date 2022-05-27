<?php

namespace App\Http\Resources\Main\Profile;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $shipping = null;
        $billing = null;

        foreach ($this->addresses as $address) {
            switch ($address->type) {
                case 'shipping':
                    $shipping = $address;
                    break;
                case 'billing':
                    $billing = $address;
                    break;
                case 'both':
                    $shipping = $address;
                    $billing = $address;
                    break;
            }
        }

        return [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'addresses' => [
                'shipping' => !is_null($shipping) ? new AddressResource($shipping): null,
                'billing' => !is_null($billing) ? new AddressResource($billing) : null,
            ],
            'orders' => OrderResource::collection($this->orders)
        ];
    }
}
