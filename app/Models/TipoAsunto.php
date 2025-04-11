<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Eloquent para la gestión de tipos de asuntos
 *
 * Representa la entidad TipoAsunto en el sistema con sus atributos.
 * 
 * Configuración especial:
 * - Usa nombres personalizados para timestamps (fecha_creacion/fecha_actualizacion)
 * - Convierte automáticamente campos a tipos nativos (datetime)
 * 
 * @property int $id
 * @property string $nombre
 * @property \Illuminate\Support\Carbon $created_at (fecha_creacion)
 * @property \Illuminate\Support\Carbon $updated_at (fecha_actualizacion)
 */
class TipoAsunto extends Model
{
    use HasFactory;

    /** 
     * @var string Nombre de la tabla asociada al modelo
     */
    protected $table = 'tipos_asuntos';

    /**
     * @var string Nombre de la clave primaria
     */
    protected $primaryKey = 'id';

    /**
     * @var bool Indica si el modelo usa timestamps
     */
    public $timestamps = true;

    /**
     * @var string Nombre de la columna para created_at
     */
    const CREATED_AT = 'fecha_creacion';

    /**
     * @var string Nombre de la columna para updated_at
     */
    const UPDATED_AT = 'fecha_actualizacion';

    /**
     * @var array Campos asignables masivamente
     */
    protected $fillable = [
        'nombre'
    ];

    /**
     * @var array Conversiones de tipos para atributos
     */
    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];
}