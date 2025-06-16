<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use App\Models\EnergyMeasurement;
use Carbon\Carbon;

class MqttSubscriber extends Command
{
    protected $signature = 'mqtt:subscribe';
    protected $description = 'Subscribe to MQTT topic and process messages';

    public function handle()
    {
        $server = 'broker.emqx.io'; // or your broker URL
        $port = 1883;
        $clientId = 'laravel-subscriber-' . uniqid();
        $username = 'Alvi'; // or your username
        $password = null; // or your password if required
        $topic = 'IoV/monitoring';

        $mqtt = new MqttClient($server, $port, $clientId);

        // Configure connection settings
        $connectionSettings = (new ConnectionSettings())
            ->setUsername($username)
            ->setPassword($password)
            ->setKeepAliveInterval(60)
            ->setLastWillTopic('last/will')
            ->setLastWillMessage('client disconnect')
            ->setLastWillQualityOfService(1);

        try {
            $this->info("Connecting to MQTT broker {$server}:{$port}...");
            
            // Connect with clean session (true) and connection settings
            $mqtt->connect($connectionSettings, true);
            
            $this->info("Subscribed to topic: {$topic}");
            $mqtt->subscribe($topic, function ($topic, $message) {
                $this->info("Received message on topic: {$topic}");
                Log::debug("MQTT Message", ['topic' => $topic, 'message' => $message]);
                
                ProcessMqttMessage::dispatch($message)->onQueue('mqtt');
            }, 0);

            $mqtt->loop(true); // Keep listening indefinitely

        } catch (\Exception $e) {
            Log::error('MQTT Error: ' . $e->getMessage());
            $this->error("Error: " . $e->getMessage());
            $mqtt->disconnect();
        }
    }

    protected function processMessage($message)
    {
        try {
            $data = json_decode($message, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Invalid JSON format");
            }

            EnergyMeasurement::create([
                'device_id' => 1, // Ganti jika perlu
                'voltage' => $data['tegangan'] ?? 0,
                'current' => $data['arus'] ?? 0,
                'power' => $data['daya'] ?? 0,
                'energy' => $data['energi'] ?? 0,
                'temperature' => $data['suhu'] ?? 0,
                'humidity' => $data['kelembapan'] ?? 0,
                'measured_at' => isset($data['tanggal'], $data['waktu']) 
                    ? Carbon::createFromFormat('d/m/Y H:i:s', $data['tanggal'] . ' ' . $data['waktu']) 
                    : now()
            ]);

            $this->info("Message processed: " . substr($message, 0, 50) . "...");

        } catch (\Exception $e) {
            $this->error("Failed to process message: " . $e->getMessage());
        }
    }
}
