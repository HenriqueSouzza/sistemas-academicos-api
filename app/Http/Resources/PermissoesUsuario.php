<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissoesUsuario extends JsonResource
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
            'usuario'           => $this->FK_USER,
            'permissoes'        => $this->FK_PERMISSOES,
            'created_at'        => $this->CREATED_AT
        ];
    }
}
