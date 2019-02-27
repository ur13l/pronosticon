<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuinielaResource extends JsonResource
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
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion, 
            'imagen' => $this->imagen, 
            'permitir_marcador' => $this->permitir_marcador,
            'cantidad_reponches' => $this->cantidad_reponches,
            'liga' => $this->liga,
            'tipo_quiniela' => $this->tipoQuiniela,
            'bolsas' => $this->bolsas,
        ];    
    }
}
