<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void registrar(int $userId, string $username, array $data)
 * @method static mixed otroMetodo()
 * 
 * @see \App\Logging\BitacoraSistemaContext
 */
class LogSistema extends Facade
{
    /*protected static function getFacadeAccessor()
    {
        return \App\Logging\BitacoraSistemaContext::class;
    }*/

    protected static function getFacadeAccessor()
    {
        return 'log.sistema';
    }    
}