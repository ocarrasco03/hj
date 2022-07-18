<?php

namespace App\Http\Resources\Cms\Exports\Catalogs;

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
        $category = count($this->categories()->whereNull('parent_id')->pluck('name')) > 0 ? $this->categories()->whereNull('parent_id')->pluck('name')[0] : null;
        $subcategory = count($this->categories()->whereNotNull('parent_id')->pluck('name')) > 0 ? $this->categories()->whereNotNull('parent_id')->pluck('name')[0] : null;
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'description' => $this->description,
            'stock' => $this->stock,
            'cost' => $this->cost,
            'price' => $this->price,
            'brand' => $this->brand->name,
            'category' => $category,
            'subcategory' => $subcategory,
        ];
    }
}
