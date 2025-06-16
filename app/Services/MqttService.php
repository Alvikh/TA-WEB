<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

class MqttService
{
    protected $mqtt;

    public function __construct()
    {
        $server   = 'localhost'; // Ganti dengan broker MQTT (misal: test.mosquitto.org)
        $port     = 1883;
        $clientId = uniqid('laravel_', true);

        $settings = (new ConnectionSettings)
            ->setUsername(null)
            ->setPassword(null)
            ->setKeepAliveInterval(60);

        $this->mqtt = new MqttClient($server, $port, $clientId);
        $this->mqtt->connect($settings, true);
    }

    public function publish($topic, $message)
    {
        $this->mqtt->publish($topic, $message, 0);
        $this->mqtt->disconnect();
    }

    public function subscribe($topic, callable $callback)
    {
        $this->mqtt->subscribe($topic, function ($topic, $message) use ($callback) {
            $callback($topic, $message);
        }, 0);

        $this->mqtt->loop(true);
        $this->mqtt->disconnect();
    }
}
