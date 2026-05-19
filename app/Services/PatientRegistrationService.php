<?php

namespace App\Services;

use App\Models\DocumentType;
use App\Models\Patient;
use App\Models\PatientGuardian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PatientRegistrationService
{
    public const ADULT_AGE = 18;

    public function isMinor(Carbon|string $birthDate): bool
    {
        return Carbon::parse($birthDate)->age < self::ADULT_AGE;
    }

    /**
     * @param  array<string, mixed>  $patientData
     * @param  array<string, mixed>|null  $guardianData
     */
    public function register(array $patientData, ?array $guardianData = null): Patient
    {
        $minor = $this->isMinor($patientData['birth_date']);
        $patientData['is_minor'] = $minor;

        $this->validateDocumentForAge($patientData['document_type_id'], $minor);

        if ($minor) {
            if (empty($guardianData)) {
                throw ValidationException::withMessages([
                    'guardian' => 'Los pacientes menores de edad requieren datos del responsable.',
                ]);
            }
            $this->validateGuardianDocument($guardianData);
        }

        return DB::transaction(function () use ($patientData, $guardianData, $minor) {
            if (empty($patientData['code'])) {
                $patientData['code'] = $this->generatePatientCode();
            }

            $patient = Patient::create($patientData);

            if ($minor && $guardianData) {
                PatientGuardian::create([
                    ...$guardianData,
                    'patient_id' => $patient->id,
                    'is_primary' => $guardianData['is_primary'] ?? true,
                ]);
            }

            return $patient->load(['documentType', 'guardians.kinship', 'guardians.documentType']);
        });
    }

    protected function validateDocumentForAge(int $documentTypeId, bool $isMinor): void
    {
        $type = DocumentType::findOrFail($documentTypeId);

        if ($isMinor && ! $type->for_minors) {
            throw ValidationException::withMessages([
                'document_type_id' => 'Para menores de edad use un tipo de documento válido (ej. partida de nacimiento).',
            ]);
        }

        if (! $isMinor && $type->code === 'DUI' && ! $type->for_adults) {
            throw ValidationException::withMessages([
                'document_type_id' => 'El DUI aplica solo para mayores de edad.',
            ]);
        }

        if (! $isMinor && ! $type->for_adults) {
            throw ValidationException::withMessages([
                'document_type_id' => 'Para mayores de edad use DUI u otro documento de adulto.',
            ]);
        }
    }

    /**
     * @param  array<string, mixed>  $guardianData
     */
    protected function validateGuardianDocument(array $guardianData): void
    {
        $type = DocumentType::findOrFail($guardianData['document_type_id']);

        if (! $type->for_adults) {
            throw ValidationException::withMessages([
                'guardian.document_type_id' => 'El responsable debe identificarse con un documento de adulto (ej. DUI).',
            ]);
        }
    }

    protected function generatePatientCode(): string
    {
        $lastId = Patient::max('id') ?? 0;

        return 'PAC-'.str_pad((string) ($lastId + 1), 6, '0', STR_PAD_LEFT);
    }
}
