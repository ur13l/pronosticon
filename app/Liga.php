<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @property int $id
 * @property string $nombre
 * @property string $logo
 * @property string $imagen
 * @property string $id_deporte
 * @property string $created_at
 * @property string $updated_at
 * @property Equipo[] $equipos
 * @property Jornada[] $jornadas
 * @property Quiniela[] $quinielas
 */
class Liga extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'liga';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'logo', 'imagen', 'id_deporte', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipos()
    {
        return $this->hasMany('App\Equipo', 'id_liga')->orderBy('siglas');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jornadas()
    {
        return $this->hasMany('App\Jornada', 'id_liga')->orderBy('fecha_inicio');
    }

    public function proximaJornada() 
    {
        return $this->hasOne('App\Jornada', 'id_liga')
            ->where('fecha_inicio', '>', Carbon::now('America/Mexico_City'))
            ->orderBy('fecha_inicio', 'asc');
    }

    public function ultimaJornada() 
    {
        return $this->hasOne('App\Jornada', 'id_liga')
            ->where('fecha_fin', '<', Carbon::now('America/Mexico_City'))
            ->orderBy('fecha_fin', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quinielas()
    {
        return $this->hasMany('App\Quiniela', 'id_liga');
    }


    public function deporte() {
        return $this->belongsTo('App\Deporte', 'id_deporte');
    }
}
