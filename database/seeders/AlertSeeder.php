<?php

namespace Database\Seeders;

use App\Models\Alert;
use Illuminate\Database\Seeder;

class AlertSeeder extends Seeder
{
    public function run()
    {
        // Alert untuk device 1
        Alert::create([
            'device_id' => 1,
            'type' => 'over_voltage',
            'message' => 'Voltage exceeds maximum limit (230V)',
            'severity' => 'high',
            'is_resolved' => true,
            'resolved_at' => now()->subHours(2),
        ]);

        Alert::create([
            'device_id' => 1,
            'type' => 'high_temperature',
            'message' => 'Device temperature above normal (35°C)',
            'severity' => 'medium',
            'is_resolved' => false,
        ]);

        // Alert untuk device 2
        Alert::create([
            'device_id' => 2,
            'type' => 'low_power_factor',
            'message' => 'Power factor below threshold (0.8)',
            'severity' => 'low',
            'is_resolved' => false,
        ]);

        Alert::factory()->count(10)->create();
    }
}