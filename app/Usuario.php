<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nombre
 * @property string $email
 * @property string $codigo
 * @property string $created_at
 * @property string $updated_at
 * @property Participacion[] $participacions
 */
class Usuario extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'usuario';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'email', 'codigo', 'admin', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participacions()
    {
        return $this->hasMany('App\Participacion', 'id_usuario');
    }
}
