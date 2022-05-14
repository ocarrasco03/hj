<?php

namespace App\Http\Resources\Cms\Sales;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => $this->pivot->subtotal,
            'quantity' => $this->pivot->quantity,
            'tax' => $this->pivot->tax,
            'discount' => $this->pivot->discount,
            'amount' => $this->pivot->total,
        ];
    }
}
