<?php

namespace App\Models;

use App\Models\Catalogo\Departamento;
use App\Models\Catalogo\Distrito;
use App\Models\Seguridad\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sucursal extends Model
{
    protected $table = 'sucursales';

    protected $fillable = [
        'clinica_id',
        'nombre',
        'codigo',
        'telefono',
        'correo',
        'direccion',
        'departamento_id',
        'distrito_id',
        'es_principal',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'es_principal' => 'boolean',
            'activo' => 'boolean',
        ];
    }

    public function clinica(): BelongsTo
    {
        return $this->belongsTo(Clinica::class, 'clinica_id');
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function distrito(): BelongsTo
    {
        return $this->belongsTo(Distrito::class, 'distrito_id');
    }

    public function medicos(): BelongsToMany
    {
        return $this->belongsToMany(Medico::class, 'medico_sucursal', 'sucursal_id', 'medico_id');
    }

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'sucursal_id');
    }

    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class, 'sucursal_id');
    }
}
