<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Categoria extends JsonResource
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
            'setor'             => $this->ID_SETOR,
            'descricao'         => $this->DESCRICAO,
            'ativo'             => $this->ATIVO,
            'permite_abertura'  => $this->PERMITE_ABERTURA,
            'permite_interacao' => $this->PERMITE_INTERACAO,
            'permite_n_tickets' => $this->PERMITE_N_TICKETS,
            'usuario'           => $this->USUARIO,
            'created_at'        => $this->CREATED_AT,
            'updated_at'        => $this->UPDATED_AT,
            'deleted_at'        => $this->DELETED_AT
        ];
    }
}
