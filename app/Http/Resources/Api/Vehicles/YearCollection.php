<?php

namespace App\Http\Resources\Api\Vehicles;

use Illuminate\Http\Resources\Json\ResourceCollection;

class YearCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray(YearResource::class);
    }
}
