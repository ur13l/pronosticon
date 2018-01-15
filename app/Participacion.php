<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ParticipacionJornada;

/**
 * @property int $id
 * @property int $id_usuario
 * @property int $id_quiniela
 * @property int $puntuacion
 * @property boolean $activo
 * @property boolean $registrada
 * @property int $no_reponches
 * @property string $created_at
 * @property string $updated_at
 * @property Quiniela $quiniela
 * @property Usuario $usuario
 * @property Pronostico[] $pronosticos
 */
class Participacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'participacion';

    /**
     * @var array
     */
    protected $fillable = ['id_usuario', 'id_quiniela', 'puntuacion', 'activo', 'no_reponches', 'registrada', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quiniela()
    {
        return $this->belongsTo('App\Quiniela', 'id_quiniela');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo('App\Usuario', 'id_usuario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pronosticos()
    {
        return $this->hasMany('App\Pronostico', 'id_participacion');
    }

    public function participacionJornadas() {
        return $this->hasMany('App\ParticipacionJornada', 'id_participacion');
    }

    public function participacionProximaJornada() {
        $id = $this->quiniela->liga->proximaJornada ? $this->quiniela->liga->proximaJornada->id : null;
        return $this->hasOne('App\ParticipacionJornada', 'id_participacion')->where('id_jornada', $id);
    }

    public function participacionUltimaJornada() {
        $id = $this->quiniela->liga->ultimaJornada ?  $this->quiniela->liga->ultimaJornada->id : null;
        return $this->hasOne('App\ParticipacionJornada', 'id_participacion')->where('id_jornada', $id);
    }

    public function participacionJornada($id_jornada) {
        return $this->hasOne('App\ParticipacionJornada', 'id_participacion')->where('id_jornada', $id_jornada);
    }

    public function ultimoPronostico() {
        $id = $this->participacionUltimaJornada ? $this->participacionUltimaJornada->id : null;
        return $this->hasOne('App\Pronostico', 'id_participacion')->where('id_participacion_jornada', $id);
        
    }

    public function calcularPosicion() {
        $quiniela = $this->quiniela;
        $pos = 1;
        foreach ($quiniela->participacions as $participacion) {
            if($participacion->id == $this->id) {
                return $pos;
            }
            $pos += 1;
        }
    }
    
}
