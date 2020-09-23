<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissoesPapeis extends JsonResource
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
            'permissao'         => $this->FK_PERMISSOES,
            'papeis'            => $this->FK_PAPEIS,
            'created_at'        => $this->CREATED_AT
        ];
    }
}
