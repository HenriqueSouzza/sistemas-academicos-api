<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Papeis extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array = [];

        foreach($this->categoria as $key => $value):
            $array[$value['id_setor']]['id_setor'] = $value['id_setor'];
            $array[$value['id_setor']]['setor'] = $value['setor'];
            $array[$value['id_setor']]['categoria'][] = [
                'id'                        => $value['id'],
                'descricao'                 => $value['descricao'],
                'permite_abertura_ticket'   => $value['permite_abertura_ticket'],
                'permite_interacao'         => $value['permite_interacao'],
                'permite_n_tickets_abertos' => $value['permite_n_tickets_abertos']
            ];
        endforeach;

        return [
            'id'                => $this->ID,
            'papel'             => $this->PAPEL,
            'descricao'         => $this->DESCRICAO,
            'permissoes'        => $this->permissoes,
            'sistemas'          => $this->sistemas,
            'formulario'        => $this->formulario ? $this->formulario : [],
            'setorCategoria'    => $array,
            'created_at'        => $this->CREATED_AT
        ];
    }
}
