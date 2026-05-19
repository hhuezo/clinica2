<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Department;
use App\Models\District;
use Illuminate\Database\Seeder;

class ElSalvadorGeoSeeder extends Seeder
{
    public function run(): void
    {
        $geo = require database_path('data/el_salvador_geo.php');

        $country = Country::firstOrCreate(
            ['iso_code' => $geo['country']['iso_code']],
            [
                'name' => $geo['country']['name'],
                'phone_code' => $geo['country']['phone_code'],
                'is_active' => true,
            ]
        );

        foreach ($geo['departments'] as $dept) {
            $department = Department::updateOrCreate(
                [
                    'country_id' => $country->id,
                    'name' => $dept['name'],
                ],
                [
                    'code' => $dept['code'],
                    'is_active' => true,
                ]
            );

            foreach ($dept['districts'] as $districtName) {
                District::updateOrCreate(
                    [
                        'department_id' => $department->id,
                        'name' => $districtName,
                    ],
                    ['is_active' => true]
                );
            }
        }
    }
}
