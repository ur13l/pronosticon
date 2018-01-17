<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_liga
 * @property string $nombre
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property boolean $registrada
 * @property string $created_at
 * @property string $updated_at
 * @property Liga $liga
 * @property Partido[] $partidos
 */
class Jornada extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'jornada';

    protected $dates=['fecha_inicio', 'fecha_fin'];

    /**
     * @var array
     */
    protected $fillable = ['id_liga', 'nombre', 'fecha_inicio', 'fecha_fin', 'registrada', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function liga()
    {
        return $this->belongsTo('App\Liga', 'id_liga');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partidos()
    {
        return $this->hasMany('App\Partido', 'id_jornada')->orderBy('fecha_hora');
    }


    public function participacionesJornada() {
        return $this->hasMany('App\ParticipacionJornada', 'id_jornada');
    }


    public function calcularPuntuaciones() {
        $participacionesJornada = ParticipacionJornada::where('id_jornada', $this->id)->get();
        dd($participacionesJornada);
        foreach($participacionesJornada as $pj) {
            foreach($pj->pronosticos as $pronostico) {
                $resultado = $pronostico->partido->resultado;
                $puntos = 0;
                if($resultado) {
                    if($pronostico->id_equipo_ganador == $resultado->id_equipo_ganador) {
                        $puntos += 3;
                        if($pronostico->resultado_local == $resultado->resultado_local && 
                            $pronostico->resultado_visita && $resultado->resultado_visita) {
                                $puntos += 2;
                        }
                    }
                }
                $pj->puntuacion = $puntos;
                $pj->save();
            }
        }

        $quinielas = $this->liga->quinielas;

        foreach($quinielas as $quiniela) {
            foreach ($quiniela->participacions as $participacion) {
                $participacion->calcularPuntuacion();
            }
        }
    }
}
