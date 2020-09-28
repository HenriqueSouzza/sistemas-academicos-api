<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Sistemas extends JsonResource
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
            'nome_sistema'      => $this->NOME_SISTEMA,
            'ativo'             => $this->ATIVO,
            'created_at'        => $this->CREATED_AT
        ];
    }
}
