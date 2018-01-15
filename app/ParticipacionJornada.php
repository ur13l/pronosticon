<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_participacion
 * @property int $id_jornada
 * @property int $puntuacion
 * @property boolean $registrada
 * @property string $created_at
 * @property string $updated_at
 */
class ParticipacionJornada extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'participacion_jornada';

    /**
     * @var array
     */
    protected $fillable = ['id_participacion', 'id_jornada', 'puntuacion', 'registrada', 'created_at', 'updated_at'];

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
    public function jornada()
    {
        return $this->belongsTo('App\Jornada', 'id_jornada');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pronosticos()
    {
        return $this->hasMany('App\Pronostico', 'id_participacion_jornada');
    }
}
