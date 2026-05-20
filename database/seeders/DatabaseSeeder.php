<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PaisSeeder::class,
            DepartamentoSeeder::class,
            DistritoSeeder::class,
            TipoDocumentoSeeder::class,
            ParentescoSeeder::class,
            RolPermisoSeeder::class,
            UsuariosRolesSeeder::class,
        ]);
    }
}
