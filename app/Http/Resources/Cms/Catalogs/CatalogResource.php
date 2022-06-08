<?php

namespace App\Http\Resources\Cms\Catalogs;

use Illuminate\Http\Resources\Json\JsonResource;

class CatalogResource extends JsonResource
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
            'year' => $this->year->year,
            'make' => $this->make->name,
            'model' => $this->model->name,
            'engine' => null,
            'notes' => $this->notes,
            'attributes' => $this->attributes,
        ];
    }
}
