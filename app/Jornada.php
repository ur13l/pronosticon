<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_liga
 * @property string $nombre
 * @property string $fecha_inicio
 * @property string $fecha_fin
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

    /**
     * @var array
     */
    protected $fillable = ['id_liga', 'nombre', 'fecha_inicio', 'fecha_fin', 'created_at', 'updated_at'];

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
        return $this->hasMany('App\Partido', 'id_jornada');
    }
}
