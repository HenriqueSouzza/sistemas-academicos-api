<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CamposForms extends JsonResource
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
            'formulario'        => $this->ID,
            'nome'              => $this->NOME,
            'descricao'         => $this->DESCRICAO,
            'created_at'        => $this->CREATED_AT,
            'updated_at'        => $this->UPDATED_AT,
        ];
    }
}
