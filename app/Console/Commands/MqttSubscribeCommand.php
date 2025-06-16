<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use App\Jobs\ProcessMqttMessage;
use Illuminate\Support\Facades\Log;

class MqttSubscribeCommand extends Command
{
    protected $signature = 'mqtt:subscribe';
    protected $description = 'Subscribe to MQTT topics and process incoming messages';

    public function handle()
    {
        $server   = 'broker.emqx.io';
        $port     = 1883;
        $clientId = 'laravel-subscriber-' . uniqid();
        $username = null; // Anonymous access
        $password = null;
        $topic    = 'iot/monitoring';   

        $mqtt = new MqttClient($server, $port, $clientId);

        try {
            $this->info("Connecting to MQTT broker {$server}:{$port}...");
            $mqtt->connect($username, $password, true);

            $this->info("Subscribing to topic: {$topic}");
            $mqtt->subscribe($topic, function ($topic, $message) {
                $this->processIncomingMessage($topic, $message);
            }, 0);

            $this->info("Listening for messages... [Press CTRL+C to exit]");
            $mqtt->loop(true);

        } catch (\Exception $e) {
            Log::error('MQTT Connection Error: ' . $e->getMessage());
            $this->error("Error: " . $e->getMessage());
            $mqtt->disconnect();
        }
    }

    protected function processIncomingMessage($topic, $message)
    {
        try {
            $this->info("Received message on topic: {$topic}");
            Log::debug("MQTT Message Received", ['topic' => $topic, 'message' => $message]);

            // Dispatch to queue for processing
            ProcessMqttMessage::dispatch($message)
                ->onQueue('mqtt')
                ->delay(now()->addSeconds(1)); // Optional delay if needed

        } catch (\Exception $e) {
            Log::error('Failed to process MQTT message: ' . $e->getMessage(), [
                'topic' => $topic,
                'message' => $message
            ]);
        }
    }
}