<?php

namespace App\Models\Seguridad;

use App\Models\Clinica;
use App\Models\Empresa;
use App\Models\Medico;
use App\Models\Sucursal;
use Database\Factories\Seguridad\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'telefono',
        'password',
        'avatar',
        'proveedor',
        'proveedor_id',
        'activo',
        'empresa_id',
        'clinica_id',
        'sucursal_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function clinica(): BelongsTo
    {
        return $this->belongsTo(Clinica::class, 'clinica_id');
    }

    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function medico(): HasOne
    {
        return $this->hasOne(Medico::class, 'usuario_id');
    }

    public function hasPassword(): bool
    {
        return ! empty($this->password);
    }
}
