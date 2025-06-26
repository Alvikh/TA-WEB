<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    public function definition()
    {
        $types = ['Smart Meter', 'Environment Sensor', 'Power Monitor', 'Energy Logger'];
        $statuses = ['active', 'inactive', 'maintenance'];
        $buildings = [
            "Gedung A",
            "Gedung B",
            "Gedung C",
            "Gedung Serbaguna",
            "Gedung Rektorat",
            "Gedung Laboratorium",
            "Gedung Perpustakaan",
            "Gedung Kuliah Umum",
            "Gedung Administrasi",
            "Gedung Teknik"
        ];

        return [
            'building' => $this->faker->randomElement($buildings),
            'owner_id' => $this->faker->numberBetween(1, 5),
            'name' => $this->faker->word() . ' ' . $this->faker->randomElement(['Sensor', 'Meter', 'Device']),
            'device_id' => 'DEV-' . $this->faker->unique()->bothify('??-####'),
            'type' => $this->faker->randomElement($types),
            'installation_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'status' => $this->faker->randomElement($statuses),
        ];
    }
}
