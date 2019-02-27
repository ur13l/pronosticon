<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
/**
 * @property int $id
 * @property string $nombre
 * @property string $email
 * @property string $codigo
 * @property string $avatar
 * @property string $created_at
 * @property string $updated_at
 * @property Participacion[] $participacions
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'usuario';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'email', 'codigo', 'admin', 'avatar', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participacions()
    {
        return $this->hasMany('App\Participacion', 'id_usuario');
    }
}
