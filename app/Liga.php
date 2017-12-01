<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nombre
 * @property string $logo
 * @property string $imagen
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
    protected $fillable = ['nombre', 'logo', 'imagen', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipos()
    {
        return $this->hasMany('App\Equipo', 'id_liga');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jornadas()
    {
        return $this->hasMany('App\Jornada', 'id_liga');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quinielas()
    {
        return $this->hasMany('App\Quiniela', 'id_liga');
    }
}