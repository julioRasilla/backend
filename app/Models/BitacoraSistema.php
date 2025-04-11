<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Eloquent para el registro de actividades del sistema (bitácora).
 * 
 * Registra todas las acciones significativas realizadas por los usuarios en el sistema,
 * incluyendo detalles como el usuario, IP, funcionalidad accedida y datos relevantes.
 *
 * @property int $id Identificador único del registro de bitácora
 * @property int $id_usuario ID del usuario que realizó la acción
 * @property string $usuario Nombre o identificador del usuario
 * @property string $ip Dirección IP desde donde se realizó la acción
 * @property string $funcionalidad Nombre de la funcionalidad o módulo accedido
 * @property array $dato Datos adicionales relacionados con la acción (en formato JSON)
 * @property \Illuminate\Support\Carbon $fecha_creacion Fecha y hora del registro
 * 
 * @property-read \App\Models\Usuario|null $usuario Relación con el modelo de Usuario
 */
class BitacoraSistema extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     * @var string
     */
    protected $table = 'bitacora_sistemas';

    /**
     * Atributos que pueden ser asignados masivamente.
     * @var array
     */
    protected $fillable = [
        'id_usuario',
        'usuario',
        'ip',
        'funcionalidad',
        'dato',
        'fecha_creacion'
    ];

    /**
     * Conversiones de tipos para los atributos.
     * @var array
     */
    protected $casts = [
        'dato' => 'array', // Laravel convierte automáticamente JSON a array
    ];

    /**
     * Indica si el modelo debe usar timestamps.
     * @var bool
     */
    public $timestamps = false; // Se usa fecha_creacion manualmente

    /**
     * Define la relación con el usuario asociado al registro de bitácora.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}