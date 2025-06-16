<?php

namespace Database\Seeders;

use App\Models\Alert;
use App\Models\Building;
use App\Models\Device;
use App\Models\EnergyMeasurement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed users
        $this->call(UserSeeder::class);
        
        // Seed buildings
        $this->call(BuildingSeeder::class);
        
        // Seed devices
        $this->call(DeviceSeeder::class);
        
        // Seed energy measurements
        $this->call(EnergyMeasurementSeeder::class);
        
        // Seed alerts
        $this->call(AlertSeeder::class);
        
        // Assign buildings to users
        $this->call(BuildingUserSeeder::class);
    }
}