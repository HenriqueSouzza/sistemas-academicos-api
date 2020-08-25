<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnexoTicket extends JsonResource
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
            'ticket'            => $this->ID_TICKET,
            'interacao_ticket'  => $this->ID_INTERACAO_TICKET,
            'arquivo'           => $this->ARQUIVO,
            'created_at'        => $this->CREATED_AT,
            'updated_at'        => $this->UPDATED_AT,
            'deleted_at'        => $this->DELETED_AT
        ];
    }
}
