<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Menu extends JsonResource
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
            'nome'          => $this->NOME,
            'link'          => $this->LINK,
            'icon'          => $this->ICON,
            'submenu'       => $this->submenu,
            'created_at'    => $this->CREATED_AT
        ];
    }
}
