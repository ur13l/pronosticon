<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LigaResource extends JsonResource
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
            'logo' => $this->logo, 
            'imagen' => $this->imagen, 
            'deporte' => $this->deporte
        ]; 
    }
}
