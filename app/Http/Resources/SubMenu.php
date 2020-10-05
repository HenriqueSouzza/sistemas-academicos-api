<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubMenu extends JsonResource
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
            'id'            => $this->ID,
            'menu'          => $this->menu,
            'nome'          => $this->NOME,
            'link'          => $this->LINK,
            'icon'          => $this->ICON,
            'ativo'         => $this->ATIVO,
            'created_at'    => $this->CREATED_AT,
        ];
    }
}
