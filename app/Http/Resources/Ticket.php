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
        $arquivo = array();

        //Anexos da interacao
        foreach($this->AnexoTicket as $key => $val):
            //Para buscar somente o anexos do ticket, sem as interações
            if($this->AnexoTicket[$key]->ID_INTERACAO_TICKET == 0):
                $arquivo[$key] = $this->AnexoTicket[$key]->ARQUIVO;
            endif;
        endforeach;

        $dt_interacao = null;
        //Dados para pegar a ultima data de interacao
        foreach($this->InteracaoTicket as $key => $val):
            $dt_interacao = $this->InteracaoTicket[$key]->CREATED_AT;
        endforeach;



        return [
            'id'                    => $this->ID,
            'usuario_abertura'      => $this->USUARIO,
            'papel_usuario'         => $this->ID_PAPEL_USUARIO,
            'setor'                 => $this->SETOR->DESCRICAO,
            'categoria'             => $this->CATEGORIA->DESCRICAO,
            'assunto'               => $this->ASSUNTO,
            'mensagem'              => $this->MENSAGEM,
            'arquivo'               => $arquivo,
            'usuario_atendente'     => $this->USUARIO_ATENDENTE,
            'usuario_fechamento'    => $this->USUARIO_FECHAMENTO,
            'dt_fechamento'         => $this->DT_FECHAMENTO,
            'dt_interacao'          => $dt_interacao,
            'status'                => $this->status->NOME,
            'dt_criacao'            => $this->CREATED_AT
        ];

    }
}
