<?php

namespace App\Http\Resources\Cms\Catalogs;

use Illuminate\Http\Resources\Json\JsonResource;

class RelatedResource extends JsonResource
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
            'brand' => $this->brand->name,
        ];
    }
}
