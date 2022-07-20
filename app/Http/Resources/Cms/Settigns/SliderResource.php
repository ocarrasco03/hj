<?php

namespace App\Http\Resources\Cms\Settigns;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $media = [];
        $items = $this->getMedia('slider');

        for ($i=0; $i < count($items); $i++) {
            $media[$i] = [
                'uuid' => $items[$i]['uuid'],
                'name' => $items[$i]['name'],
                'extension' => $items[$i]['extension'],
                'size' => $items[$i]->human_readable_size,
                'original_url' => $items[$i]->getFullUrl(),
                'preview_url' => $items[$i]->getFullUrl(),
                'order' => $items[$i]['order_column'],
            ];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'media' => $media,
        ];
    }
}
