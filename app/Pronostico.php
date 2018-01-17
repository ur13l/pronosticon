<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_participacion
 * @property int $id_partido
 * @property int $id_equipo_ganador
 * @property int $id_participacion_jornada
 * @property int $puntos
 * @property int $resultado_local
 * @property int $resultado_visita
 * @property boolean $victoria
 * @property string $fecha
 * @property string $created_at
 * @property string $updated_at
 * @property Equipo $equipo
 * @property Participacion $participacion
 * @property Partido $partido
 */
class Pronostico extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'pronostico';

    /**
     * @var array
     */
    protected $fillable = ['id_participacion', 'id_partido', 'id_equipo_ganador', 'id_participacion_jornada', 'puntos', 'resultado_local', 'resultado_visita', 'victoria', 'fecha', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipo()
    {
        return $this->belongsTo('App\Equipo', 'id_equipo_ganador');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function participacion()
    {
        return $this->belongsTo('App\Participacion', 'id_participacion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partido()
    {
        return $this->belongsTo('App\Partido', 'id_partido');
    }

    public function participacionJornada() 
    {
        return $this->belongsTo('App\ParticipacionJornada', 'id_participacion_jornada');
    }

    public function equipoGanador() {
        return $this->belongsTo('App\Equipo', 'id_equipo_ganador');
    }
}
