<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Eloquent para la gestión de clientes
 *
 * Representa la entidad Cliente en el sistema con sus atributos y relaciones.
 * 
 * Configuración especial:
 * - Usa nombres personalizados para timestamps (fecha_creacion/fecha_actualizacion)
 * - Convierte automáticamente campos a tipos nativos (boolean, datetime)
 * 
 * @property int $id
 * @property int $id_usuario_creacion
 * @property int|null $id_usuario_actualizacion
 * @property string $nombre
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string|null $telefono
 * @property string|null $telefono_celular
 * @property bool $activo
 * @property \Illuminate\Support\Carbon $fecha_creacion
 * @property \Illuminate\Support\Carbon|null $fecha_actualizacion
 * 
 * @property-read \App\Models\Usuario $usuarioCreacion
 * @property-read \App\Models\Usuario|null $usuarioActualizacion
 */
class Cliente extends Model
{
    use HasFactory;

    /** 
     * @var string Nombre de la tabla asociada al modelo
     */
    protected $table = 'clientes';

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
     * @var array Campos asignables masivamente (se establece dinámicamente)
     */
    protected  $fillable = [
        'id_usuario_creacion',
        'id_usuario_actualizacion',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'telefono_celular',
        'activo',
        'fecha_creacion',
        'fecha_actualizacion'
    ];    

    /**
     * @var array Conversiones de tipos para atributos
     */
    protected $casts = [
        'activo' => 'boolean',
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];

    /**
     * Constructor que establece fillable dinámicamente
     *
     * @param array $attributes Atributos iniciales
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }    

    /**
     * Relación con el usuario que creó el registro del cliente
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuarioCreacion()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_creacion');
    }

    /**
     * Relación con el usuario que actualizó por última vez el registro
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuarioActualizacion()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_actualizacion');
    }
}