<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ticket extends JsonResource
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
            'id'                    => $this->ID,
            'usuario_abertura'      => $this->USUARIO,
            'papel_usuario'         => $this->PAPEL_USUARIO,
            'setor'                 => $this->SETOR,
            'categoria'             => $this->CATEGORIA,
            'assunto'               => $this->ASSUNTO,
            'mensagem'              => $this->MENSAGEM,
            'anexo'                 => $this->ANEXO,
            'usuario_fechamento'    => $this->USUARIO_FECHAMENTO,
            'dt_fechamento'         => $this->DT_FECHAMENTO,
            'status'                => $this->STATUS,
            'created_at'            => $this->CREATED_AT
        ];

    }
}
