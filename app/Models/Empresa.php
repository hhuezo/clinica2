<?php

namespace App\Models;

use App\Models\Catalogo\Departamento;
use App\Models\Catalogo\Distrito;
use App\Models\Seguridad\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    protected $table = 'empresas';

    protected $fillable = [
        'nombre',
        'razon_social',
        'nit',
        'telefono',
        'correo',
        'sitio_web',
        'ruta_logo',
        'direccion',
        'departamento_id',
        'distrito_id',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function distrito(): BelongsTo
    {
        return $this->belongsTo(Distrito::class, 'distrito_id');
    }

    public function clinicas(): HasMany
    {
        return $this->hasMany(Clinica::class, 'empresa_id');
    }

    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class, 'empresa_id');
    }
}
