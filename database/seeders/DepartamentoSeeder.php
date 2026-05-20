<?php

namespace Database\Seeders;

use App\Models\Catalogo\Departamento;
use App\Models\Catalogo\Pais;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    public function run(): void
    {
        $pais = Pais::where('codigo_iso', 'SLV')->first();

        if (! $pais) {
            $pais = Pais::create([
                'nombre' => 'El Salvador',
                'codigo_iso' => 'SLV',
                'codigo_telefono' => '+503',
                'activo' => true,
            ]);
        }

        $departamentos = require database_path('data/departamentos_el_salvador.php');

        foreach ($departamentos as $departamento) {
            Departamento::updateOrCreate(
                ['id' => $departamento['id']],
                [
                    'pais_id' => $pais->id,
                    'codigo' => $departamento['codigo'],
                    'nombre' => $departamento['nombre'],
                    'activo' => true,
                ]
            );
        }

        $maxId = collect($departamentos)->max('id');
        DB::statement('ALTER TABLE departamentos AUTO_INCREMENT = '.($maxId + 1));
    }
}
