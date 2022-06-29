<?php

namespace App\Http\Resources\Cms\Sales;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Main\Profile\AddressResource;

class OrderResource extends JsonResource
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

        foreach ($this->user->addresses as $address) {
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
            'id' => $this->id,
            'user' => $this->user->firstname . ' ' . $this->user->lastname,
            'addresses' => [
                'shipping' => !is_null($shipping) ? new AddressResource($shipping): null,
                'billing' => !is_null($billing) ? new AddressResource($billing) : null,
            ],
            'status' => [
                'name' => $this->status->name,
                'prefix' => $this->status->prefix,
                'level' => $this->status->level
            ],
            'items' => ProductResource::collection($this->products),
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'shipping' => 0,
            'tax' => $this->tax,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
