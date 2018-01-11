<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nombre
 */
class Deporte extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'deporte';

    /**
     * @var array
     */
    protected $fillable = ['nombre'];

   
}
