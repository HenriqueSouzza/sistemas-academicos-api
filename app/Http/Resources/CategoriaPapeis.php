<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriaPapeis extends JsonResource
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
            'papeis'         => $this->FK_PAPEIS,
            'categoria'         => $this->FK_CATEGORIA,
            'created_at'        => $this->CREATED_AT
        ];
    }
}
