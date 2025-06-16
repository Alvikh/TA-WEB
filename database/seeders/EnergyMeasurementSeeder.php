<?php

namespace Database\Seeders;

use App\Models\EnergyMeasurement;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EnergyMeasurementSeeder extends Seeder
{
    public function run()
    {
        $devices = \App\Models\Device::all();
        $now = Carbon::now();

        foreach ($devices as $device) {
            // Buat data untuk 7 hari terakhir
            for ($i = 0; $i < 7; $i++) {
                $date = $now->copy()->subDays($i);
                
                // Buat 24 data per hari (setiap jam)
                for ($h = 0; $h < 24; $h++) {
                    $measureTime = $date->copy()->addHours($h);
                    
                    EnergyMeasurement::create([
                        'device_id' => $device->id,
                        'voltage' => rand(210, 230) + (rand(0, 99) / 100),
                        'current' => rand(5, 20) + (rand(0, 99) / 100),
                        'power' => rand(1000, 5000) + (rand(0, 99) / 100),
                        'energy' => rand(50, 200) + (rand(0, 99) / 100),
                        'frequency' => 49.8 + (rand(0, 40) / 100),
                        'power_factor' => 0.85 + (rand(0, 15) / 100),
                        'temperature' => 25 + (rand(0, 100) / 10),
                        'humidity' => 50 + rand(0, 40),
                        'measured_at' => $measureTime,
                    ]);
                }
            }
        }
    }
}