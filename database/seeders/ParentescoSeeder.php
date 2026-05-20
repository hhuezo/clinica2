<?php

namespace Database\Seeders;

use App\Models\Catalogo\Parentesco;
use Illuminate\Database\Seeder;

class ParentescoSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['nombre' => 'Padre', 'codigo' => 'padre'],
            ['nombre' => 'Madre', 'codigo' => 'madre'],
            ['nombre' => 'Abuelo(a)', 'codigo' => 'abuelo'],
            ['nombre' => 'Tío(a)', 'codigo' => 'tio'],
            ['nombre' => 'Hermano(a)', 'codigo' => 'hermano'],
            ['nombre' => 'Tutor legal', 'codigo' => 'tutor'],
            ['nombre' => 'Apoderado', 'codigo' => 'apoderado'],
            ['nombre' => 'Otro', 'codigo' => 'otro'],
        ];

        foreach ($items as $item) {
            Parentesco::updateOrCreate(['codigo' => $item['codigo']], [...$item, 'activo' => true]);
        }
    }
}
