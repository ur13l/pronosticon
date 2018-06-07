<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $id_liga
 * @property string $nombre
 * @property string $siglas
 * @property string $imagen
 * @property string $created_at
 * @property string $updated_at
 * @property Liga $liga
 * @property Partido[] $partidos
 * @property Partido[] $partidos
 * @property Pronostico[] $pronosticos
 * @property Resultado[] $resultados
 */
class Equipo extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'equipo';

    /**
     * @var array
     */
    protected $fillable = ['id_liga', 'nombre', 'siglas', 'imagen', 'created_at', 'updated_at'];

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
    public function partidosLocal()
    {
        return $this->hasMany('App\Partido', 'id_equipo_local');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partidosVisita()
    {
        return $this->hasMany('App\Partido', 'id_equipo_visita');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pronosticos()
    {
        return $this->hasMany('App\Pronostico', 'id_equipo_ganador');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function resultados()
    {
        return $this->hasMany('App\Resultado', 'id_equipo_ganador');
    }
}
