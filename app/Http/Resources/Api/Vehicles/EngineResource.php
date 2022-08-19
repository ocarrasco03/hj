<?php

namespace App\Http\Resources\Api\Vehicles;

use Illuminate\Http\Resources\Json\JsonResource;

class EngineResource extends JsonResource
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
            'engine' => $this->display_name,
        ];
    }
}
