<?php

namespace App\Http\Resources\Cms\Catalogs;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $categories = [];
        foreach ($this->categories as $category) {
            $categories[] = [
                'name' => $category->name,
                'parent_id' => $category->parent_id,
            ];
        }
        return [
            'id' => $this->id,
            'brand' => $this->brand->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'name' => $this->name,
            'description' => $this->description,
            'notes' => $this->notes,
            'cost' => $this->cost,
            'unit' => $this->unit,
            'weight' => $this->weight,
            'price_wo_tax' => $this->price_wo_tax,
            'price' => $this->price,
            'stock' => $this->stock,
            'attributes' => $this->attributes,
            'categories' => $categories,
            'media' => $this->getMedia('products'),
            'status' => $this->status->name,
            'condition' => $this->condition,
            'catalogs' => CatalogResource::collection($this->vehicles),
            'related' => RelatedResource::collection($this->related),
            'tags' => $this->tags,
        ];
    }
}
