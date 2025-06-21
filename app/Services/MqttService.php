<?php

namespace App\Services;

use App\Models\Device;
use App\Models\EnergyMeasurement;
use Bluerhinos\phpMQTT;

class MQTTService
{
    private $mqtt;
    private $server;
    private $port;
    private $username;
    private $password;
    private $clientId;

    public function __construct()
    {
        $this->server = env('MQTT_HOST', 'localhost');
        $this->port = env('MQTT_PORT', 1883);
        $this->username = env('MQTT_USERNAME');
        $this->password = env('MQTT_PASSWORD');
        $this->clientId = 'laravel-' . uniqid();
    }

    public function connect()
    {
        $this->mqtt = new phpMQTT($this->server, $this->port, $this->clientId);
        
        if (!$this->mqtt->connect(true, null, $this->username, $this->password)) {
            throw new \Exception("Failed to connect to MQTT broker");
        }
    }

    public function subscribeAndProcess($topic)
    {
        $this->connect();
        
        $this->mqtt->subscribe([$topic => ['qos' => 0, 'function' => function($topic, $msg) {
            $this->processMessage($topic, $msg);
        }]], 0);

        while ($this->mqtt->proc()) {
            // Keep processing messages
        }

        $this->mqtt->close();
    }

    protected function processMessage($topic, $message)
    {
        try {
            $data = json_decode($message, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Invalid JSON format");
            }

            // Validasi device_id
            if (!isset($data['device_id']) || !Device::find($data['device_id'])) {
                throw new \Exception("Invalid or unknown device_id");
            }

            // Simpan data ke database
            $measurement = EnergyMeasurement::create([
                'device_id' => $data['device_id'],
                'voltage' => $data['voltage'] ?? null,
                'current' => $data['current'] ?? null,
                'power' => $data['power'] ?? null,
                'energy' => $data['energy'] ?? null,
                'frequency' => $data['frequency'] ?? null,
                'power_factor' => $data['power_factor'] ?? null,
                'temperature' => $data['temperature'] ?? null,
                'humidity' => $data['humidity'] ?? null,
                'measured_at' => $data['timestamp'] ?? now(),
            ]);

            Log::info("Measurement saved for device {$data['device_id']}", [
                'measurement_id' => $measurement->id
            ]);

        } catch (\Exception $e) {
            Log::error("MQTT message processing error: " . $e->getMessage(), [
                'topic' => $topic,
                'message' => $message
            ]);
        }
    }
}