<?php

namespace App\Http\Resources\Main\Home;

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
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
            'brand' => $this->brand->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'price_wo_tax' => $this->price_wo_tax,
            'price' => $this->price,
            'stock' => $this->stock,
            'attributes' => $this->attributes,
            'notes' => $this->notes,
            'rate' => $this->averageRating ? $this->averageRating : 0,
            'reviwes' => $this->ratings,
            'image' => $this->getFirstMediaUrl('products'),
            'media' => $this->getMedia('products'),
            'related' => MostSelledResource::collection($this->related),
            'application' => ApplicationResource::collection($this->vehicles)
        ];
    }
}
