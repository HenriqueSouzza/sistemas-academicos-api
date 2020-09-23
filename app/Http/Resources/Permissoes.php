<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Permissoes extends JsonResource
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
            'permissao'         => $this->PERMISSAO,
            'descricao'         => $this->DESCRICAO,
            'prefix'            => $this->PREFIX,
            'created_at'        => $this->CREATED_AT
        ];
    }
}
