<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipos_documento';

    protected $fillable = [
        'nombre',
        'codigo',
        'patron',
        'para_adultos',
        'para_menores',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'para_adultos' => 'boolean',
            'para_menores' => 'boolean',
            'activo' => 'boolean',
        ];
    }

    public function scopeParaAdultos($query)
    {
        return $query->where('para_adultos', true)->where('activo', true);
    }

    public function scopeParaMenores($query)
    {
        return $query->where('para_menores', true)->where('activo', true);
    }
}
