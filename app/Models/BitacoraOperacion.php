<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Eloquent para la tabla bitacora_operaciones
 * 
 * Representa un registro de auditoría en el sistema con los siguientes campos:
 * - id_usuario: Identificador del usuario que realizó la acción
 * - ip_usuario: Dirección IP desde donde se realizó la operación
 * - usuario: Nombre del usuario asociado
 * - funcionalidad: Módulo o característica del sistema afectada
 * - accion: Tipo de operación realizada (GET, POST, PUT, DELETE)
 * - datos: Información adicional en formato JSON
 * - fechaHoraCreacion: Marca de tiempo de la operación
 * 
 * Características:
 * - Usa la tabla 'bitacora_operaciones'
 * - Campos asignables masivamente definidos en $fillable
 * - Deshabilita timestamps automáticos (created_at/updated_at)
 * - Utiliza trait HasFactory para generación de factories
 */
class BitacoraOperacion extends Model
{
    use HasFactory;

    /**
     * @var string Nombre de la tabla asociada al modelo
     */
    protected $table = 'bitacora_operaciones';
    /**
     * @var bool Indica si el modelo debe usar timestamps
     */
    public $timestamps = false;    

    /**
     * @var array Campos que pueden ser asignados masivamente
     */
    protected $fillable = [
        'id_usuario',
        'ip_usuario',
        'usuario',
        'funcionalidad',
        'accion',
        'datos',
        'fechaHoraCreacion',
    ];


}