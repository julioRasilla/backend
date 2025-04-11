<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantillaAsunto extends Model
{
    use HasFactory;

    protected $table = 'plantillas_asuntos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = ['nombre', 'plantilla'];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime'
    ];

    protected $appends = ['fecha_creacion', 'fecha_actualizacion'];
    protected $dates = [
        'fecha_creacion',
        'fecha_actualizacion'
    ];
}