<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_partido
 * @property int $id_equipo_ganador
 * @property int $resultado_local
 * @property int $resultado_visita
 * @property string $created_at
 * @property string $updated_at
 * @property Equipo $equipo
 * @property Partido $partido
 */
class Resultado extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'resultado';

    /**
     * @var array
     */
    protected $fillable = ['id_partido', 'id_equipo_ganador', 'resultado_local', 'resultado_visita', 'created_at', 'updated_at'];

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
    public function partido()
    {
        return $this->belongsTo('App\Partido', 'id_partido');
    }
}
