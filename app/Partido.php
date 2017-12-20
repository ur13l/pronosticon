<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_equipo_local
 * @property int $id_equipo_visita
 * @property int $id_jornada
 * @property string $fecha_hora
 * @property string $created_at
 * @property string $updated_at
 * @property Equipo $equipo
 * @property Equipo $equipo
 * @property Jornada $jornada
 * @property Pronostico[] $pronosticos
 * @property Resultado[] $resultados
 */
class Partido extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'partido';

    /**
     * @var array
     */
    protected $fillable = ['id_equipo_local', 'id_equipo_visita', 'id_jornada', 'fecha_hora', 'created_at', 'updated_at'];

    protected $dates = ['fecha_hora'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipoLocal()
    {
        return $this->belongsTo('App\Equipo', 'id_equipo_local');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipoVisita()
    {
        return $this->belongsTo('App\Equipo', 'id_equipo_visita');
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
        return $this->hasMany('App\Pronostico', 'id_partido');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function resultados()
    {
        return $this->hasMany('App\Resultado', 'id_partido');
    }
}
