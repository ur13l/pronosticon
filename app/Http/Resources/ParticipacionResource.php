<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParticipacionResource extends JsonResource
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
            'puntuacion' => $this->puntuacion,
            'activo' => $this->activo, 
            'no_reponches' => $this->no_reponches, 
            'registrada' => $this->registrada,
            'quiniela' => $this->quiniela
        ];    
    }
}
