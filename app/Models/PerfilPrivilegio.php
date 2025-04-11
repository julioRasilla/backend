<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Eloquent para la gestión de la relación entre perfiles y privilegios.
 * 
 * Representa la tabla intermedia en una relación muchos-a-muchos entre Perfiles y Menús (privilegios),
 * almacenando qué privilegios tiene asignado cada perfil. Incluye información de auditoría
 * sobre quién y cuándo creó o modificó cada asignación.
 *
 * @property int $id Identificador único del registro
 * @property int $id_usuario_creacion ID del usuario que creó el registro
 * @property int|null $id_usuario_actualizacion ID del usuario que actualizó el registro (nullable)
 * @property int $id_perfil ID del perfil asociado
 * @property int $id_menu ID del menú/privilegio asociado
 * @property \Illuminate\Support\Carbon $fecha_creacion Fecha de creación del registro
 * @property \Illuminate\Support\Carbon|null $fecha_actualizacion Fecha de última actualización (nullable)
 * 
 * @property-read \App\Models\Usuario $usuarioCreacion Relación con el usuario creador
 * @property-read \App\Models\Usuario|null $usuarioActualizacion Relación con el usuario que actualizó (nullable)
 * @property-read \App\Models\Perfil $perfil Relación con el perfil asociado
 * @property-read \App\Models\Menu $menu Relación con el menú/privilegio asociado
 */
class PerfilPrivilegio extends Model
{
    use HasFactory;

    /**
     * @var string Nombre de la tabla en la base de datos
     */
    protected $table = 'perfiles_privilegios';

    /**
     * @var string Nombre de la clave primaria
     */
    protected $primaryKey = 'id';

    /**
     * @var bool Indica si el modelo debe manejar timestamps automáticamente
     */
    public $timestamps = true;

    /**
     * @var string Nombre de la columna para el timestamp de creación
     */
    const CREATED_AT = 'fecha_creacion';

    /**
     * @var string Nombre de la columna para el timestamp de actualización
     */
    const UPDATED_AT = 'fecha_actualizacion';

    /**
     * @var array Lista de atributos asignables masivamente
     */
    protected $fillable = [
        'id_usuario_creacion',
        'id_usuario_actualizacion',
        'id_perfil',
        'id_menu',
        'fecha_creacion',
        'fecha_actualizacion'
    ];

    /**
     * @var array Conversiones de tipos para los atributos
     */
    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];

    /**
     * Constructor del modelo.
     * 
     * Inicializa los campos fillable dinámicamente usando el trait PerfilPrivilegioTrait.
     *
     * @param array $attributes Atributos para inicializar el modelo
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * Define la relación con el usuario que creó el registro.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuarioCreacion()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_creacion');
    }

    /**
     * Define la relación con el usuario que actualizó el registro.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuarioActualizacion()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_actualizacion');
    }

    /**
     * Define la relación con el perfil asociado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'id_perfil');
    }

    /**
     * Define la relación con el menú/privilegio asociado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }
}