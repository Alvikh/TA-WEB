<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    public function run()
    {
        // Device untuk Gedung 1
        Device::create([
            'building' => "lab digital",
            'owner_id' => 1,
            'name' => 'Smart Meter Lantai 1',
            'device_id' => 'SM-001-2023',
            'type' => 'monitoring',
            'installation_date' => '2023-01-15',
            'status' => 'active',
        ]);

        Device::create([
            'building' => "lab software engineering",
            'owner_id' => 2,
            'name' => 'Environment Sensor Lantai 1',
            'device_id' => 'ES-001-2023',
            'type' => 'control',
            'installation_date' => '2023-01-20',
            'status' => 'active',
        ]);

        // Device untuk Gedung 2
        Device::create([
            'owner_id'=> 2,
            'building' => "lab rpl",
            'name' => 'Smart Meter Lantai 2',
            'device_id' => 'SM-002-2023',
            'type' => 'monitoring',
            'installation_date' => '2023-02-10',
            'status' => 'active',
        ]);
                Device::factory()->count(20)->create();


    }
}   