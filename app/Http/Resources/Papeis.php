<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Papeis extends JsonResource
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
            'papel'             => $this->PAPEL,
            'descricao'         => $this->DESCRICAO,
            'permissoes'        => $this->permissoes,
            'created_at'        => $this->CREATED_AT
        ];
    }
}
