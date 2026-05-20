<?php

namespace Database\Seeders;

use App\Models\Catalogo\Departamento;
use App\Models\Catalogo\Distrito;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistritoSeeder extends Seeder
{
    public function run(): void
    {
        $distritos = require database_path('data/distritos_el_salvador.php');

        $departamentosValidos = Departamento::pluck('id')->all();

        foreach ($distritos as $distrito) {
            if (! in_array($distrito['departamento_id'], $departamentosValidos, true)) {
                continue;
            }

            Distrito::updateOrCreate(
                ['id' => $distrito['id']],
                [
                    'departamento_id' => $distrito['departamento_id'],
                    'codigo' => $distrito['codigo'],
                    'nombre' => $distrito['nombre'],
                    'activo' => $distrito['activo'],
                ]
            );
        }

        $maxId = collect($distritos)->max('id');
        DB::statement('ALTER TABLE distritos AUTO_INCREMENT = '.($maxId + 1));
    }
}
