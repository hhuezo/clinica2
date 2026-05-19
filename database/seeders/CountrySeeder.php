<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Department;
use App\Models\District;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        Country::firstOrCreate(
            ['iso_code' => 'SLV'],
            [
                'name' => 'El Salvador',
                'phone_code' => '+503',
                'is_active' => true,
            ]
        );

        Country::firstOrCreate(
            ['iso_code' => 'GTM'],
            ['name' => 'Guatemala', 'phone_code' => '+502', 'is_active' => true]
        );

        Country::firstOrCreate(
            ['iso_code' => 'HND'],
            ['name' => 'Honduras', 'phone_code' => '+504', 'is_active' => true]
        );

        Country::firstOrCreate(
            ['iso_code' => 'NIC'],
            ['name' => 'Nicaragua', 'phone_code' => '+505', 'is_active' => true]
        );

        Country::firstOrCreate(
            ['iso_code' => 'CRI'],
            ['name' => 'Costa Rica', 'phone_code' => '+506', 'is_active' => true]
        );

        Country::firstOrCreate(
            ['iso_code' => 'PAN'],
            ['name' => 'Panamá', 'phone_code' => '+507', 'is_active' => true]
        );

        Country::firstOrCreate(
            ['iso_code' => 'MEX'],
            ['name' => 'México', 'phone_code' => '+52', 'is_active' => true]
        );

        Country::firstOrCreate(
            ['iso_code' => 'USA'],
            ['name' => 'Estados Unidos', 'phone_code' => '+1', 'is_active' => true]
        );
    }
}
