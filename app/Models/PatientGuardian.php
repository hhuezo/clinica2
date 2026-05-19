<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientGuardian extends Model
{
    protected $fillable = [
        'patient_id',
        'kinship_id',
        'first_name',
        'last_name',
        'document_type_id',
        'document_number',
        'phone',
        'email',
        'address',
        'is_primary',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function kinship(): BelongsTo
    {
        return $this->belongsTo(Kinship::class);
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
}
