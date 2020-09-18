<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Formularios extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $data = array();
        foreach($this->camposForm->toArray() as $key => $value):
            // if($this->ID == $value['pivot']['ID_FORMULARIOS']):
                $data[] = [
                    'id'            => $value['ID'],
                    'descricao'     => $value['DESCRICAO'],
                    'label'         => $value['LABEL'],
                    'type'          => $value['TYPE'],
                    'icon'          => $value['ICON'],
                    'name'          => $value['NAME'],
                    'campo_id'      => $value['CAMPO_ID'],
                    'value'         => $value['VALUE'],
                    'obrigatorio'   => (int) $value['OBRIGATORIO'],
                    'visivel'       => (int) $value['VISIVEL'],
                    'editavel'      => (int) $value['EDITAVEL'],
                ]; 
            // endif;
        endforeach;

        return [
            'id'                => $this->ID,
            'nome'              => $this->NOME,
            'descricao'         => $this->DESCRICAO,
            'campos'            => $data,
            'created_at'        => $this->CREATED_AT,
            'updated_at'        => $this->UPDATED_AT,
        ];
    }
}
