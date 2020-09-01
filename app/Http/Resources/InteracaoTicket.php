<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InteracaoTicket extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $arquivo = array();

        //Anexos da interacao
        foreach($this->AnexoTicket as $key => $val):
            $arquivo[$key] = $this->AnexoTicket[$key]->ARQUIVO;
        endforeach;

        return [
            'id'                => $this->ID,
            'id_ticket'         => $this->ID_TICKET,
            'papel_usuario'     => $this->ID_PAPEL_USUARIO,
            'usuario_interacao' => $this->USUARIO_INTERACAO,
            'mensagem'          => $this->MENSAGEM,
            'arquivo'           => $arquivo,
            'dt_criacao'        => $this->CREATED_AT
        ];
    }
}
