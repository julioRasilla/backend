<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlantillaAsuntoUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|integer|min:1',
            'nombre' => 'required|string|max:100|unique:plantillas_asuntos,nombre,'.$this->route('id'),
            'plantilla' => 'required|string'
        ];
    }

    public function validationData()
    {
        $data = $this->all();
        $data['id'] = $this->route('id');
        return $data;
    }
}