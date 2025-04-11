<?php

namespace App\Constants;

/**
 * Códigos de error de base de datos PostgreSQL
 * 
 * Esta clase contiene constantes que representan los códigos de error más comunes
 * en PostgreSQL, para facilitar su identificación y manejo en la aplicación.
 */
class DbErrorCodes
{
    /**
     * Violación de restricción única (duplicado)
     * Ocurre cuando se intenta insertar o actualizar un registro con un valor que ya existe en una columna única
     */
    public const UNIQUE_VIOLATION = '23505';

    /**
     * Violación de clave foránea
     * Ocurre cuando se referencia un valor que no existe en la tabla relacionada
     */
    public const FOREIGN_KEY_VIOLATION = '23503';

    /**
     * Violación de valor nulo
     * Ocurre cuando se inserta NULL en una columna que no permite valores nulos
     */
    public const NULL_VIOLATION = '23502';

    /**
     * Violación de restricción CHECK
     * Ocurre cuando no se cumple una condición definida en una restricción CHECK
     */
    public const CHECK_VIOLATION = '23514';

    /**
     * Violación de campo NOT NULL (alias de NULL_VIOLATION)
     * Ocurre cuando se intenta insertar NULL en una columna definida como NOT NULL
     */
    public const NOT_NULL_VIOLATION = '23502';

    /**
     * Deadlock detectado
     * Ocurre cuando dos o más transacciones se bloquean mutuamente
     */
    public const DEADLOCK_DETECTED = '40P01';
}