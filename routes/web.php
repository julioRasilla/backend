<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodigoRecuperacionMail;

Route::get('/test-email', function() {
    Mail::to('test@example.com')->send(new CodigoRecuperacionMail('TEST123'));
    return "Correo enviado! Revisa Mailpit en http://localhost:8025";
});