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
            'papeis'         => $this->papeis,
            'created_at'     => $this->created_at,
        ];
    }
}