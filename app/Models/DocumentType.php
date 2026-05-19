<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $fillable = [
        'name',
        'code',
        'pattern',
        'for_adults',
        'for_minors',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'for_adults' => 'boolean',
            'for_minors' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function scopeForAdults($query)
    {
        return $query->where('for_adults', true)->where('is_active', true);
    }

    public function scopeForMinors($query)
    {
        return $query->where('for_minors', true)->where('is_active', true);
    }
}
