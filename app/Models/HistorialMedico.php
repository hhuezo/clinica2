<?php

namespace App\Models;

use App\Models\Seguridad\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistorialMedico extends Model
{
    protected $table = 'historiales_medicos';

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'sucursal_id',
        'cita_id',
        'fecha_visita',
        'motivo_consulta',
        'antecedentes',
        'examen_fisico',
        'diagnostico',
        'tratamiento',
        'recetas',
        'signos_vitales',
        'observaciones',
        'creado_por',
    ];

    protected function casts(): array
    {
        return [
            'fecha_visita' => 'datetime',
            'signos_vitales' => 'array',
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

    public function cita(): BelongsTo
    {
        return $this->belongsTo(Cita::class, 'cita_id');
    }

    public function creadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
}
