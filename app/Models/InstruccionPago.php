<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstruccionPago extends Model
{
    use HasFactory;

    protected $table = 'instrucciones_pagos';
    protected $primaryKey = 'id';
    public $timestamps = true; // Cambiar a true

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = ['nombre'];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime'
    ];

    // Añadir estos atributos para que aparezcan siempre en JSON
    protected $appends = ['fecha_creacion', 'fecha_actualizacion'];

    // Asegurar que las fechas se devuelvan en formato ISO
    protected $dates = [
        'fecha_creacion',
        'fecha_actualizacion'
    ];
}