<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Documento Único de Identidad (DUI)',
                'code' => 'DUI',
                'pattern' => '^\d{8}-\d$',
                'for_adults' => true,
                'for_minors' => false,
            ],
            [
                'name' => 'Partida de nacimiento',
                'code' => 'PARTIDA',
                'pattern' => null,
                'for_adults' => false,
                'for_minors' => true,
            ],
            [
                'name' => 'NIT',
                'code' => 'NIT',
                'pattern' => '^\d{4}-\d{6}-\d{3}-\d$',
                'for_adults' => true,
                'for_minors' => false,
            ],
            [
                'name' => 'Pasaporte',
                'code' => 'PASAPORTE',
                'pattern' => null,
                'for_adults' => true,
                'for_minors' => true,
            ],
            [
                'name' => 'Carnet de residente',
                'code' => 'RESIDENTE',
                'pattern' => null,
                'for_adults' => true,
                'for_minors' => true,
            ],
            [
                'name' => 'Carnet de minoridad',
                'code' => 'MINORIDAD',
                'pattern' => null,
                'for_adults' => false,
                'for_minors' => true,
            ],
        ];

        foreach ($types as $type) {
            DocumentType::updateOrCreate(
                ['code' => $type['code']],
                [...$type, 'is_active' => true]
            );
        }
    }
}
