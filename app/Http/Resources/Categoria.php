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
            'id'                        => $this->ID,
            'setor'                     => $this->setor,
            'descricao'                 => $this->DESCRICAO,
            'ativo'                     => $this->ATIVO,
            'permite_abertura_ticket'   => $this->PERMITE_ABERTURA_TICKET,
            'permite_interacao'         => $this->PERMITE_INTERACAO,
            'permite_n_tickets_abertos' => $this->PERMITE_N_TICKETS_ABERTOS,
            'created_at'                => $this->CREATED_AT,
            'updated_at'                => $this->UPDATED_AT,
        ];
    }
}
