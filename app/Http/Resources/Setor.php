<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Setor extends JsonResource
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
            'id'            => $this->ID,
            'descricao'     => $this->DESCRICAO,
            'ativo'         => $this->ATIVO,
            'created_at'    => $this->CREATED_AT,
            'updated_at'    => $this->UPDATED_AT,
        ];
    }
}
