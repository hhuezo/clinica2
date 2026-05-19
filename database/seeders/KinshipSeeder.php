<?php

namespace Database\Seeders;

use App\Models\Kinship;
use Illuminate\Database\Seeder;

class KinshipSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Padre', 'code' => 'padre'],
            ['name' => 'Madre', 'code' => 'madre'],
            ['name' => 'Abuelo(a)', 'code' => 'abuelo'],
            ['name' => 'Tío(a)', 'code' => 'tio'],
            ['name' => 'Hermano(a)', 'code' => 'hermano'],
            ['name' => 'Tutor legal', 'code' => 'tutor'],
            ['name' => 'Apoderado', 'code' => 'apoderado'],
            ['name' => 'Otro', 'code' => 'otro'],
        ];

        foreach ($items as $item) {
            Kinship::updateOrCreate(['code' => $item['code']], [...$item, 'is_active' => true]);
        }
    }
}
