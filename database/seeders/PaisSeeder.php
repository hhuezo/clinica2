<?php

namespace Database\Seeders;

use App\Models\Catalogo\Pais;
use Illuminate\Database\Seeder;

class PaisSeeder extends Seeder
{
    public function run(): void
    {
        Pais::firstOrCreate(
            ['codigo_iso' => 'SLV'],
            [
                'nombre' => 'El Salvador',
                'codigo_telefono' => '+503',
                'activo' => true,
            ]
        );

        Pais::firstOrCreate(
            ['codigo_iso' => 'GTM'],
            ['nombre' => 'Guatemala', 'codigo_telefono' => '+502', 'activo' => true]
        );

        Pais::firstOrCreate(
            ['codigo_iso' => 'HND'],
            ['nombre' => 'Honduras', 'codigo_telefono' => '+504', 'activo' => true]
        );

        Pais::firstOrCreate(
            ['codigo_iso' => 'NIC'],
            ['nombre' => 'Nicaragua', 'codigo_telefono' => '+505', 'activo' => true]
        );

        Pais::firstOrCreate(
            ['codigo_iso' => 'CRI'],
            ['nombre' => 'Costa Rica', 'codigo_telefono' => '+506', 'activo' => true]
        );

        Pais::firstOrCreate(
            ['codigo_iso' => 'PAN'],
            ['nombre' => 'Panamá', 'codigo_telefono' => '+507', 'activo' => true]
        );

        Pais::firstOrCreate(
            ['codigo_iso' => 'MEX'],
            ['nombre' => 'México', 'codigo_telefono' => '+52', 'activo' => true]
        );

        Pais::firstOrCreate(
            ['codigo_iso' => 'USA'],
            ['nombre' => 'Estados Unidos', 'codigo_telefono' => '+1', 'activo' => true]
        );
    }
}
