<?php

return [
    // Obtiene el valor de la variable BITACORA_STORAGE desde el archivo .env
    // Si no existe, por defecto será 'file'
    'storage' => env('BITACORA_STORAGE', 'file'),
];
