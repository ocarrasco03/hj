<?php

namespace App\Http\Resources\Cms\Sales;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user' => $this->user->name,
            'status' => [
                'name' => $this->status->name,
                'prefix' => $this->status->prefix,
                'level' => $this->status->level
            ],
            'items' => ProductResource::collection($this->products),
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'shipping' => 0,
            'tax' => $this->tax,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
