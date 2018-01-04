<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_liga
 * @property int $id_tipo_quiniela
 * @property string $nombre
 * @property string $descripcion
 * @property string $imagen
 * @property boolean $permitir_marcador
 * @property integer $cantidad_reponches
 * @property string $created_at
 * @property string $updated_at
 * @property Liga $liga
 * @property TipoQuiniela $tipoQuiniela
 * @property Bolsa[] $bolsas
 * @property Participacion[] $participacions
 */
class Quiniela extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'quiniela';

    /**
     * @var array
     */
    protected $fillable = ['id_liga', 'id_tipo_quiniela', 'nombre', 'descripcion', 'imagen', 'permitir_marcador', 'cantidad_reponches', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function liga()
    {
        return $this->belongsTo('App\Liga', 'id_liga');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoQuiniela()
    {
        return $this->belongsTo('App\TipoQuiniela', 'id_tipo_quiniela');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bolsas()
    {
        return $this->hasMany('App\Bolsa', 'id_quiniela')->orderBy('premio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participacions()
    {
        return $this->hasMany('App\Participacion', 'id_quiniela');
    }

}
