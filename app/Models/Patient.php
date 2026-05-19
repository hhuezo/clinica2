<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Patient extends Model
{
    protected $fillable = [
        'code',
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'document_type_id',
        'document_number',
        'country_id',
        'department_id',
        'district_id',
        'address',
        'phone',
        'email',
        'is_minor',
        'notes',
        'registered_by',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'is_minor' => 'boolean',
        ];
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function registeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    public function guardians(): HasMany
    {
        return $this->hasMany(PatientGuardian::class);
    }

    public function primaryGuardian(): HasOne
    {
        return $this->hasOne(PatientGuardian::class)->where('is_primary', true);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getAgeAttribute(): int
    {
        return $this->birth_date->age;
    }
}
