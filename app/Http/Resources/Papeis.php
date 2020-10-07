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
        $arraySetorCategoria = [];
        
        foreach($this->categoria as $key => $value):
            $arraySetorCategoria[$value['id_setor']]['id_setor'] = $value['id_setor'];
            $arraySetorCategoria[$value['id_setor']]['setor'] = $value['setor'];
            $arraySetorCategoria[$value['id_setor']]['categoria'][] = [
                'id'                        => $value['id'],
                'descricao'                 => $value['descricao'],
                'permite_abertura_ticket'   => $value['permite_abertura_ticket'],
                'permite_interacao'         => $value['permite_interacao'],
                'permite_n_tickets_abertos' => $value['permite_n_tickets_abertos']
            ];
        endforeach;

        $arrayMenus = [];

        foreach($this->menus as $key => $value):
            $arrayMenus[$value['id']]['id'] = $value['id'];
            $arrayMenus[$value['id']]['nome'] = $value['nome'];
            $arrayMenus[$value['id']]['icon'] = $value['icon'];
            $arrayMenus[$value['id']]['link'] = $value['link'];
            $arrayMenus[$value['id']]['ordem'] = $value['ordem'];
            $arrayMenus[$value['id']]['submenus'][] = [
                'id'                => $value['id_submenu'],
                'nome'              => $value['nome_submenu'],
                'link_submenu'      => $value['link_submenu'],
                'icon'              => $value['icon_submenu'],
                'ativo'             => $value['ativo_submenu'],
                'ordem'             => $value['ordem_submenu']
            ];
        endforeach;

        return [
            'id'                => $this->ID,
            'papel'             => $this->PAPEL,
            'descricao'         => $this->DESCRICAO,
            'permissoes'        => $this->permissoes,
            'sistemas'          => $this->sistemas,
            'formulario'        => $this->formulario,
            'setorCategoria'    => $arraySetorCategoria,
            'menus'             => $arrayMenus,
            'created_at'        => $this->CREATED_AT
        ];
    }
}
