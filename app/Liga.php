<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
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
    use SoftDeletes;
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
            ->where('fecha_inicio', '<', Carbon::now('America/Mexico_City'))
            ->orderBy('fecha_inicio', 'desc');
    }

    public function jornadaActual() 
    {
        return $this->hasOne('App\Jornada', 'id_liga')
            ->where('fecha_inicio', '<', Carbon::now('America/Mexico_City'))
            ->where('fecha_fin', '>', Carbon::now('America/Mexico_City'))
            ->orderBy('fecha_inicio', 'desc');
    }

    public function quinielasSurvivor() 
    {
        $tq = TipoQuiniela::where('nombre', 'Survivor')->first();
        return $this->hasMany('App\Quiniela', 'id_liga')
            ->where('id_tipo_quiniela', $tq->id);
            
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
