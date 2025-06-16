<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    public function run()
    {
        Building::create([
            'name' => 'Gedung Kantor Pusat',
            'address' => 'Jl. Sudirman No. 123',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'postal_code' => '10220',
            'latitude' => -6.2088,
            'longitude' => 106.8456,
            'description' => 'Gedung utama perusahaan',
        ]);

        Building::create([
            'name' => 'Gedung Operasional',
            'address' => 'Jl. Thamrin No. 45',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'postal_code' => '10350',
            'latitude' => -6.1865,
            'longitude' => 106.8223,
            'description' => 'Gedung operasional dan maintenance',
        ]);

        Building::factory()->count(3)->create();
    }
}