<?php

namespace App\Http\Controllers\Organizacion\Concerns;

use App\Models\Catalogo\Departamento;

trait CargaCatalogoUbicacion
{
    protected function catalogoUbicacion(): array
    {
        return [
            'departamentos' => Departamento::query()
                ->with(['distritos' => fn ($q) => $q->orderBy('nombre')])
                ->orderBy('nombre')
                ->get(),
        ];
    }
}
