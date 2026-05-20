<?php

namespace Database\Seeders;

use App\Models\Catalogo\TipoDocumento;
use Illuminate\Database\Seeder;

class TipoDocumentoSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'nombre' => 'Documento Único de Identidad (DUI)',
                'codigo' => 'DUI',
                'patron' => '^\d{8}-\d$',
                'para_adultos' => true,
                'para_menores' => false,
            ],
            [
                'nombre' => 'Partida de nacimiento',
                'codigo' => 'PARTIDA',
                'patron' => null,
                'para_adultos' => false,
                'para_menores' => true,
            ],
            [
                'nombre' => 'NIT',
                'codigo' => 'NIT',
                'patron' => '^\d{4}-\d{6}-\d{3}-\d$',
                'para_adultos' => true,
                'para_menores' => false,
            ],
            [
                'nombre' => 'Pasaporte',
                'codigo' => 'PASAPORTE',
                'patron' => null,
                'para_adultos' => true,
                'para_menores' => true,
            ],
            [
                'nombre' => 'Carnet de residente',
                'codigo' => 'RESIDENTE',
                'patron' => null,
                'para_adultos' => true,
                'para_menores' => true,
            ],
            [
                'nombre' => 'Carnet de minoridad',
                'codigo' => 'MINORIDAD',
                'patron' => null,
                'para_adultos' => false,
                'para_menores' => true,
            ],
        ];

        foreach ($types as $type) {
            TipoDocumento::updateOrCreate(
                ['codigo' => $type['codigo']],
                [...$type, 'activo' => true]
            );
        }
    }
}
