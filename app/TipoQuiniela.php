<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nombre
 * @property boolean $survivor
 * @property int $cantidad_reponches
 * @property string $created_at
 * @property string $updated_at
 * @property Quiniela[] $quinielas
 */
class TipoQuiniela extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipo_quiniela';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'survivor', 'cantidad_reponches', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quinielas()
    {
        return $this->hasMany('App\Quiniela', 'id_tipo_quiniela');
    }
}
