<?php

namespace App\Models;

use App\Models\Catalogo\Parentesco;
use App\Models\Catalogo\TipoDocumento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResponsablePaciente extends Model
{
    protected $table = 'responsables_paciente';

    protected $fillable = [
        'paciente_id',
        'parentesco_id',
        'nombres',
        'apellidos',
        'tipo_documento_id',
        'numero_documento',
        'telefono',
        'correo',
        'direccion',
        'es_principal',
    ];

    protected function casts(): array
    {
        return [
            'es_principal' => 'boolean',
        ];
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function parentesco(): BelongsTo
    {
        return $this->belongsTo(Parentesco::class, 'parentesco_id');
    }

    public function tipoDocumento(): BelongsTo
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }

    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->nombres} {$this->apellidos}");
    }
}
