<?php

namespace App\Models;

use App\Models\Seguridad\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cita extends Model
{
    protected $table = 'citas';

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'sucursal_id',
        'fecha_programada',
        'duracion_minutos',
        'estado',
        'motivo',
        'notas',
        'creado_por',
    ];

    protected function casts(): array
    {
        return [
            'fecha_programada' => 'datetime',
        ];
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function medico(): BelongsTo
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }

    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function creadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function historialMedico(): HasOne
    {
        return $this->hasOne(HistorialMedico::class, 'cita_id');
    }
}
