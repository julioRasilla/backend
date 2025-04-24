<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodigoRecuperacion extends Model
{
    protected $table = 'codigos_recuperacion';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'codigo',
        'fecha_expiracion'
    ];

    protected $casts = [
        'fecha_expiracion' => 'datetime'
    ];
}