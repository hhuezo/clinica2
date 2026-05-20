<?php

namespace App\Models;

use App\Models\Catalogo\Departamento;
use App\Models\Catalogo\Distrito;
use App\Models\Catalogo\Pais;
use App\Models\Catalogo\TipoDocumento;
use App\Models\Seguridad\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Paciente extends Model
{
    protected $table = 'pacientes';

    protected $fillable = [
        'codigo',
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'genero',
        'tipo_documento_id',
        'numero_documento',
        'pais_id',
        'departamento_id',
        'distrito_id',
        'direccion',
        'telefono',
        'correo',
        'es_menor',
        'notas',
        'registrado_por',
    ];

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
            'es_menor' => 'boolean',
        ];
    }

    public function tipoDocumento(): BelongsTo
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }

    public function pais(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function distrito(): BelongsTo
    {
        return $this->belongsTo(Distrito::class, 'distrito_id');
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    public function responsables(): HasMany
    {
        return $this->hasMany(ResponsablePaciente::class, 'paciente_id');
    }

    public function responsablePrincipal(): HasOne
    {
        return $this->hasOne(ResponsablePaciente::class, 'paciente_id')->where('es_principal', true);
    }

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'paciente_id');
    }

    public function historialesMedicos(): HasMany
    {
        return $this->hasMany(HistorialMedico::class, 'paciente_id');
    }

    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->nombres} {$this->apellidos}");
    }

    public function getEdadAttribute(): int
    {
        return $this->fecha_nacimiento->age;
    }
}
