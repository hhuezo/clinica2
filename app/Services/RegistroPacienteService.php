<?php

namespace App\Services;

use App\Models\Paciente;
use App\Models\ResponsablePaciente;
use App\Models\Catalogo\TipoDocumento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegistroPacienteService
{
    public const EDAD_ADULTO = 18;

    public function esMenor(Carbon|string $fechaNacimiento): bool
    {
        return Carbon::parse($fechaNacimiento)->age < self::EDAD_ADULTO;
    }

    /**
     * @param  array<string, mixed>  $datosPaciente
     * @param  array<string, mixed>|null  $datosResponsable
     */
    public function registrar(array $datosPaciente, ?array $datosResponsable = null): Paciente
    {
        $esMenor = $this->esMenor($datosPaciente['fecha_nacimiento']);
        $datosPaciente['es_menor'] = $esMenor;

        $this->validarDocumentoPorEdad($datosPaciente['tipo_documento_id'], $esMenor);

        if ($esMenor) {
            if (empty($datosResponsable)) {
                throw ValidationException::withMessages([
                    'responsable' => 'Los pacientes menores de edad requieren datos del responsable.',
                ]);
            }
            $this->validarDocumentoResponsable($datosResponsable);
        }

        return DB::transaction(function () use ($datosPaciente, $datosResponsable, $esMenor) {
            if (empty($datosPaciente['codigo'])) {
                $datosPaciente['codigo'] = $this->generarCodigoPaciente();
            }

            $paciente = Paciente::create($datosPaciente);

            if ($esMenor && $datosResponsable) {
                ResponsablePaciente::create([
                    ...$datosResponsable,
                    'paciente_id' => $paciente->id,
                    'es_principal' => $datosResponsable['es_principal'] ?? true,
                ]);
            }

            return $paciente->load(['tipoDocumento', 'responsables.parentesco', 'responsables.tipoDocumento']);
        });
    }

    protected function validarDocumentoPorEdad(int $tipoDocumentoId, bool $esMenor): void
    {
        $tipo = TipoDocumento::findOrFail($tipoDocumentoId);

        if ($esMenor && ! $tipo->para_menores) {
            throw ValidationException::withMessages([
                'tipo_documento_id' => 'Para menores de edad use un tipo de documento válido (ej. partida de nacimiento).',
            ]);
        }

        if (! $esMenor && $tipo->codigo === 'DUI' && ! $tipo->para_adultos) {
            throw ValidationException::withMessages([
                'tipo_documento_id' => 'El DUI aplica solo para mayores de edad.',
            ]);
        }

        if (! $esMenor && ! $tipo->para_adultos) {
            throw ValidationException::withMessages([
                'tipo_documento_id' => 'Para mayores de edad use DUI u otro documento de adulto.',
            ]);
        }
    }

    /**
     * @param  array<string, mixed>  $datosResponsable
     */
    protected function validarDocumentoResponsable(array $datosResponsable): void
    {
        $tipo = TipoDocumento::findOrFail($datosResponsable['tipo_documento_id']);

        if (! $tipo->para_adultos) {
            throw ValidationException::withMessages([
                'responsable.tipo_documento_id' => 'El responsable debe identificarse con un documento de adulto (ej. DUI).',
            ]);
        }
    }

    protected function generarCodigoPaciente(): string
    {
        $ultimoId = Paciente::max('id') ?? 0;

        return 'PAC-'.str_pad((string) ($ultimoId + 1), 6, '0', STR_PAD_LEFT);
    }
}
