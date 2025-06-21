<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MQTTService;

class MQTTListenerCommand extends Command
{
    protected $signature = 'mqtt:listen {topic}';
    protected $description = 'Listen to MQTT topic and process messages';

    public function handle()
    {
        $topic = $this->argument('topic');
        $mqttService = new MQTTService();
        
        $this->info("Starting MQTT listener for topic: {$topic}");
        
        try {
            $mqttService->subscribeAndProcess($topic);
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            // Restart listener after 5 seconds if it fails
            sleep(5);
            $this->handle();
        }
    }
}