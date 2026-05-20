<?php

namespace App\Models;

use App\Models\Catalogo\Departamento;
use App\Models\Catalogo\Distrito;
use App\Models\Seguridad\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clinica extends Model
{
    protected $table = 'clinicas';

    protected $fillable = [
        'empresa_id',
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

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function distrito(): BelongsTo
    {
        return $this->belongsTo(Distrito::class, 'distrito_id');
    }

    public function sucursales(): HasMany
    {
        return $this->hasMany(Sucursal::class, 'clinica_id');
    }

    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class, 'clinica_id');
    }
}
