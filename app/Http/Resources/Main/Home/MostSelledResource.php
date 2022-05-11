<?php

namespace App\Http\Resources\Main\Home;

use Illuminate\Http\Resources\Json\JsonResource;

class MostSelledResource extends JsonResource
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
            'description' => $this->description,
            'slug' => $this->slug,
            'price' => $this->price,
            'rating' => $this->averageRating ? $this->averageRating : 0,
            'image' => $this->getFirstMediaUrl('products')
        ];
    }
}
