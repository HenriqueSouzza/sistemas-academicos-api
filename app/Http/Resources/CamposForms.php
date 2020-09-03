<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CamposForms extends JsonResource
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
            'descricao'     => $this->DESCRICAO,
            'label'         => $this->LABEL,
            'name'          => $this->NAME,
            'campo_id'      => $this->CAMPO_ID,
            'value'         => $this->VALUE,
            'obrigatorio'   => (int) $this->OBRIGATORIO,
            'visivel'       => (int) $this->VISIVEL,
            'editavel'      => (int) $this->EDITAVEL,
            'created_at'    => $this->CREATED_AT,
            'updated_at'    => $this->UPDATED_AT,
        ];
    }
}
