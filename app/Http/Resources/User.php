<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  [
            'id'             => $this->id,
            'name'           => $this->name,
            'email'          => $this->email,
            'provider'       => $this->provider,
            'provider_id'    => $this->provider_id,
            'email_verified' => $this->email_verified_at,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
            'deleted_at'     => $this->deleted_at,
            // 'user'           => new UserResource($this->user)
        ];
    }
}