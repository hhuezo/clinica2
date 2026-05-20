<?php

namespace App\Models;

use App\Models\Seguridad\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medico extends Model
{
    protected $table = 'medicos';

    protected $fillable = [
        'usuario_id',
        'nombres',
        'apellidos',
        'especialidad',
        'numero_colegiado',
        'telefono',
        'biografia',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function sucursales(): BelongsToMany
    {
        return $this->belongsToMany(Sucursal::class, 'medico_sucursal', 'medico_id', 'sucursal_id');
    }

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'medico_id');
    }

    public function historialesMedicos(): HasMany
    {
        return $this->hasMany(HistorialMedico::class, 'medico_id');
    }

    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->nombres} {$this->apellidos}");
    }
}
