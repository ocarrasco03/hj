<?php

namespace App\Http\Resources\Main\Home;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchResource extends JsonResource
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
            'brand' => $this->brand->name,
            'categories' => $this->categories,
            'slug' => $this->slug,
            'price' => $this->price,
            'rate' => $this->averageRating ? $this->averageRating : 0,
            'thumb' => $this->getFirstMediaUrl('products', 'thumb'),
            'stock' => $this->stock,
        ];
    }
}
