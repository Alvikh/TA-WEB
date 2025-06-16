<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\EnergyMeasurement;
use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProcessMqttMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function handle()
    {
        try {
            $data = json_decode($this->message, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Invalid JSON format in MQTT message");
            }

            // Validate required fields
            if (!isset($data['tanggal']) || !isset($data['waktu'])) {
                throw new \Exception("Missing timestamp fields in MQTT message");
            }

            // Create datetime from Indonesian format (20/05/2025 23:24:28)
            $measuredAt = Carbon::createFromFormat('d/m/Y H:i:s', $data['tanggal'].' '.$data['waktu']);

            // Get or create device (adjust as needed)
            $device = Device::firstOrCreate(
                ['id' => 1], // Default device ID, adjust as needed
                ['name' => 'MQTT Device', 'last_seen_at' => now()]
            );

            // Create energy measurement
            EnergyMeasurement::create([
                'device_id'     => $device->id,
                'voltage'      => $data['tegangan'] ?? 0,
                'current'      => $data['arus'] ?? 0,
                'power'        => $data['daya'] ?? 0,
                'energy'       => $data['energi'] ?? 0,
                'temperature'  => $data['suhu'] ?? 0,
                'humidity'     => $data['kelembapan'] ?? 0,
                'measured_at'  => $measuredAt,
                // Default values for fields not in MQTT message
                'frequency'    => 50.00, // Assuming 50Hz as default
                'power_factor' => 1.00,  // Assuming perfect power factor
            ]);

            // Update device last seen
            $device->update(['last_seen_at' => now()]);

            Log::info('MQTT message processed successfully', ['device_id' => $device->id]);

        } catch (\Exception $e) {
            Log::error('Failed to process MQTT message: '.$e->getMessage(), [
                'message' => $this->message,
                'trace' => $e->getTraceAsString()
            ]);
            
            // You can also implement retry logic here if needed
            if ($this->attempts() < 3) {
                $this->release(10); // Retry after 10 seconds
            }
        }
    }

    public function failed(\Exception $exception)
    {
        // Called when the job fails after all retries
        Log::critical('MQTT message processing failed permanently', [
            'message' => $this->message,
            'error' => $exception->getMessage()
        ]);
    }
}