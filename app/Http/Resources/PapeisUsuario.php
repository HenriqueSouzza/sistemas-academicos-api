<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PapeisUsuario extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->ID,
            'usuario'           => $this->FK_USER,
            'papeis'            => $this->FK_PAPEIS,
            'created_at'        => $this->CREATED_AT
        ];
    }
}
