<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_usuario
 * @property int $id_quiniela
 * @property int $puntuacion
 * @property boolean $activo
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
    protected $fillable = ['id_usuario', 'id_quiniela', 'puntuacion', 'activo', 'no_reponches', 'created_at', 'updated_at'];

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
}
