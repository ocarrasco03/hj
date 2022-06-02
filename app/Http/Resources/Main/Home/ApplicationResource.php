<?php

namespace App\Http\Resources\Main\Home;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
            'engine' => $this->engine,
            'attributes' => json_decode($this->attributes),
            'notes' => $this->notes,
        ];
    }
}
