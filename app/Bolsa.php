<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_quiniela
 * @property int $premio
 * @property float $cantidad
 * @property string $created_at
 * @property string $updated_at
 * @property Quiniela $quiniela
 */
class Bolsa extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'bolsa';

    /**
     * @var array
     */
    protected $fillable = ['id_quiniela', 'cantidad', 'premio', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quiniela()
    {
        return $this->belongsTo('App\Quiniela', 'id_quiniela');
    }
}
