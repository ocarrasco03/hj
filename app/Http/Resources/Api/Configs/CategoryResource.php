<?php

namespace App\Http\Resources\Api\Configs;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $array = [];

        $array['category'] = $this->name;

        if (count($this->children) > 0) {
            $array['subcategory'] = CategoryResource::collection($this->children);
        }

        return $array;
    }
}
