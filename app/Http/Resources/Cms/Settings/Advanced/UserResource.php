<?php

namespace App\Http\Resources\Cms\Settings\Advanced;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'roles' => $this->getRoleNames(),
            'permissions' => $this->getAllPermissions()->pluck('name'),
            'avatar' => $this->getFirstMediaUrl('avatar'),
            'deleted_at' => $this->deleted_at,
        ];
    }
}
