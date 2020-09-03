<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CamposFormularios extends JsonResource
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
            'Id_formulario'     => $this->ID_FORMULARIO,
            'id_campoForm'      => $this->ID_CAMPOS_FORMS,
            'created_at'        => $this->CREATED_AT,
            'updated_at'        => $this->UPDATED_AT,
        ];
    }
}
