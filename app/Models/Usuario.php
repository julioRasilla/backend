<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Modelo de Usuario para autenticación y gestión de usuarios
 *
 * Extiende Authenticatable para funcionalidad de autenticación
 * Utiliza Sanctum para manejo de tokens API
 * 
 * Características principales:
 * - Autenticación personalizada con campo 'clave'
 * - Timestamps personalizados (fecha_creacion/fecha_actualizacion)
 * - Fillable fields dinámicos mediante trait
 * - Relaciones con empleados y clientes
 * 
 * @property int $id
 * @property string $usuario
 * @property string $clave
 * @property int $id_perfil
 * @property int|null $id_empleado
 * @property int|null $id_cliente
 * @property bool $activo
 * @property string $fecha_creacion
 * @property string|null $fecha_actualizacion
 * @property string|null $remember_token
 * @property int $id_tipo_usuario
 * 
 * @property-read \App\Models\Empleado|null $empleado
 */
class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory;

    /**
     * @var string Nombre de la tabla asociada
     */
    protected $table = 'usuarios';

    /**
     * @var array Campos asignables masivamente (se establece dinámicamente)
     */
    protected $fillable = [
        'id_usuario_creacion',
        'id_usuario_actualizacion',
        'id_tipo_usuario',
        'id_perfil',
        'id_empleado',
        'id_cliente',
        'usuario',
        'clave',
        'remember_token',
        'activo',
        'fecha_creacion',
        'fecha_actualizacion',
    ];

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
     * Constructor que establece fillable dinámicamente
     *
     * @param array $attributes Atributos iniciales
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @var array Campos ocultos en serializaciones
     */
    protected $hidden = ['clave', 'remember_token'];

    /**
     * Relación con el modelo Empleado
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    /**
     * Relación con el modelo Cliente
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    /**
     * Obtiene la contraseña para autenticación
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->clave;
    }
}
