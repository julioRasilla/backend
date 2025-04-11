<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Eloquent que representa un perfil de usuario en el sistema.
 * 
 * Un perfil define un conjunto de privilegios y configuración de acceso
 * que puede ser asignado a uno o más usuarios.
 *
 * @property int $id Identificador único del perfil
 * @property int $id_usuario_creacion ID del usuario que creó el perfil
 * @property int|null $id_usuario_actualizacion ID del usuario que actualizó el perfil (nullable)
 * @property string $nombre Nombre descriptivo del perfil
 * @property bool $activo Indica si el perfil está activo (true) o inactivo (false)
 * @property \Illuminate\Support\Carbon $fecha_creacion Fecha de creación del perfil
 * @property \Illuminate\Support\Carbon|null $fecha_actualizacion Fecha de última actualización (nullable)
 * 
 * @property-read \App\Models\Usuario $usuarioCreacion Relación con el usuario creador
 * @property-read \App\Models\Usuario|null $usuarioActualizacion Relación con el usuario que realizó la última actualización
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\PerfilPrivilegio> $privilegios Colección de privilegios asociados al perfil
 */
class Perfil extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     * @var string
     */
    protected $table = 'perfiles';

    /**
     * Nombre de la clave primaria.
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indica si el modelo usa timestamps.
     * @var bool
     */
    public $timestamps = true;

    /**
     * Nombre del campo para el timestamp de creación.
     * @var string
     */
    const CREATED_AT = 'fecha_creacion';

    /**
     * Nombre del campo para el timestamp de actualización.
     * @var string
     */
    const UPDATED_AT = 'fecha_actualizacion';

    /**
     * Atributos que pueden ser asignados masivamente.
     * @var array
     */
    protected $fillable = [
        'id_usuario_creacion',
        'id_usuario_actualizacion',
        'nombre',
        'activo',
        'fecha_creacion',
        'fecha_actualizacion',
    ];

    /**
     * Conversiones de tipos para los atributos.
     * @var array
     */
    protected $casts = [
        'activo' => 'boolean',
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];

    /**
     * Constructor del modelo.
     * @param array $attributes Atributos iniciales
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * Define la relación con el usuario que creó el perfil.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuarioCreacion()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_creacion');
    }

    /**
     * Define la relación con el usuario que actualizó el perfil.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuarioActualizacion()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_actualizacion');
    }
    
    /**
     * Define la relación con los privilegios asociados al perfil.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function privilegios()
    {
        return $this->hasMany(PerfilPrivilegio::class, 'id_perfil');
    }
}