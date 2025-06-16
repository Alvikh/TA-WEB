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
            'building_id' => 1,
            'name' => 'Smart Meter Lantai 1',
            'device_id' => 'SM-001-2023',
            'type' => 'Smart Meter',
            'manufacturer' => 'PowerTech',
            'model' => 'PT-1000',
            'firmware_version' => '2.3.4',
            'installation_date' => '2023-01-15',
            'status' => 'active',
        ]);

        Device::create([
            'building_id' => 1,
            'name' => 'Environment Sensor Lantai 1',
            'device_id' => 'ES-001-2023',
            'type' => 'Environment Sensor',
            'manufacturer' => 'EnviroSense',
            'model' => 'ES-200',
            'firmware_version' => '1.2.1',
            'installation_date' => '2023-01-20',
            'status' => 'active',
        ]);

        // Device untuk Gedung 2
        Device::create([
            'building_id' => 2,
            'name' => 'Smart Meter Lantai 2',
            'device_id' => 'SM-002-2023',
            'type' => 'Smart Meter',
            'manufacturer' => 'PowerTech',
            'model' => 'PT-1000',
            'firmware_version' => '2.3.4',
            'installation_date' => '2023-02-10',
            'status' => 'active',
        ]);

        Device::factory()->count(7)->create();
    }
}   