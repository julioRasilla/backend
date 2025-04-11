<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstruccionPagoUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|integer|min:1',
            'nombre' => 'required|string|max:100|unique:instrucciones_pagos,nombre,'.$this->route('id'),
        ];
    }

    public function validationData()
    {
        $data = $this->all();
        $data['id'] = $this->route('id');
        return $data;
    }
}