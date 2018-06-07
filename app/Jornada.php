<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

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
    use SoftDeletes;
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
        
        foreach($participacionesJornada as $pj) {
            $puntos = 0;
            foreach($pj->pronosticos as $pronostico) {
                $resultado = $pronostico->partido->resultado;
                if($resultado) {  
                    if($pronostico->id_equipo_ganador == $resultado->id_equipo_ganador) {
                        $puntos += 1;

                        if($pronostico->resultado_local == $resultado->resultado_local && 
                            $pronostico->resultado_visita == $resultado->resultado_visita) {
                                $puntos += 2;
                        }
                    }
                    else if($resultado->id_equipo_ganador != null && $pj->participacion->quiniela->tipoQuiniela->nombre == "Survivor") {
                        $reponche = Reponche::where('id_jornada', $pj->id_jornada)->where('id_participacion', $pj->id_participacion)->first();
                        if(!$reponche) {
                            $pj->participacion->activo = false;
                            $pj->participacion->save();
                        }
                    }
                }
            }

            $pj->puntuacion = $puntos;
            $pj->save();
            $pj->participacion->calcularPuntuacion();
            
            //Eliminar a los de survivor que no enviaron respuesta.

            foreach($this->liga->quinielasSurvivor as $q ) {
                foreach ($q->participacions as $p) {
                    $pj = $p->participacionJornada($this->id);
                    if (!$pj) {
                        $p->activo = false;
                        $p->save();
                    }
                }
            }
        }

 
    }


    public function partidosPendientes() {
        $p = $this->partidos()->where('fecha_hora', '>=', Carbon::now('America/Mexico_City'))->get();
        return $p->count();
    }

    public function actualizarFechas() {
        $this->fecha_inicio = $this->partidos()->min('fecha_hora');
        $this->fecha_fin = $this->partidos()->max('fecha_hora');
        $this->save();
    }
}
