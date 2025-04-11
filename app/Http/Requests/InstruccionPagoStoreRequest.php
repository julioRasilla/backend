<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstruccionPagoStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100|unique:instrucciones_pagos,nombre',
        ];
    }
}