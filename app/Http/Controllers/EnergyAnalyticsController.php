<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\EnergyMeasurement;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class EnergyAnalyticsController extends Controller
{
    public function show($id)
    {
        if (!is_numeric($id)) {
            $device = Device::where('device_id', $id)->firstOrFail();
        } else {
            $device = Device::findOrFail($id);
        }

        if ($device->type == "monitoring") {
            return $this->showMonitoringDevice($device);
        } else {
            return $this->showControlDevice($device);
        }
    }

    protected function showMonitoringDevice($device)
    {
        $latestReading = EnergyMeasurement::where('device_id', $device->device_id)
            ->where('measured_at', '>=', now()->subMinutes(5))
            ->latest('measured_at')
            ->first() ?? $this->createEmptyMonitoringReading();

// dd($latestReading);
        $consumptionData = $this->getHourlyConsumption($device->device_id);
        $energyHistory = $this->getEnergyHistory($device->device_id);
        $metrics = $this->calculateMetrics($device->device_id);
        $predictionData = $this->getPredictionData($device);
        // dd($predictionData);

        $data = [
            'device' => $device,
            'latestReading' => $latestReading,
            'consumptionLabels' => $consumptionData['labels'],
            'consumptionData' => $consumptionData['data'],
            'historyLabels' => $energyHistory['labels'],
            'historyData' => $energyHistory['data'],
            'energyHistory' => $energyHistory['records'],
            'avgDailyPower' => $metrics['avgDailyPower'],
            'peakPowerToday' => $metrics['peakPowerToday'],
            'energyToday' => $metrics['energyToday'],
            'predictionData' => $predictionData,
            'plotUrl' => $predictionData['plot_url'] ?? null
        ];

        return view('energy-analytics.show', $data);
    }

    protected function showControlDevice($device)
    {
        $latestReading = EnergyMeasurement::where('device_id', $device->device_id)
            ->latest('measured_at')
            ->first() ?? $this->createEmptyControlReading();

        $readings = EnergyMeasurement::where('device_id', $device->device_id)
            ->orderBy('measured_at', 'desc')
            ->take(20)
            ->get();

        $data = [
            'device' => $device,
            'latestReading' => $latestReading,
            'readings' => $readings
        ];

        return view('energy-analytics.control', $data);
    }
protected function createEmptyMonitoringReading()
    {
        return new EnergyMeasurement([
            'voltage' => 0,
            'current' => 0,
            'power' => 0,
            'energy' => 0,
            'frequency' => 0,
            'power_factor' => 0,
            'temperature' => 0,
            'humidity' => 0,
            'measured_at' => now()
        ]);
    }

    protected function createEmptyControlReading()
    {
        return new EnergyMeasurement([
            'temperature' => 0,
            'humidity' => 0,
            'relay_state' => 'OFF',
            'timestamp' => now()->timestamp,
            'measured_at' => now()
        ]);
    }
    protected function getPredictionData($device, $durationType = 'year', $numPeriods = 1)
{
    Log::debug('--- [START] getPredictionData ---', [
        'device_id' => $device->device_id,
        'duration_type' => $durationType,
        'num_periods' => $numPeriods
    ]);

    $flaskBaseUrl = 'http://103.219.251.171:5050';
    
    try {
        Log::debug('[DB] Check database connection');
        DB::connection()->getPdo();
        
        Log::debug('[DB] Fetch latest sensor data from EnergyMeasurement');
        $latestReading = EnergyMeasurement::where('device_id', $device->device_id)
            ->latest('measured_at')
            ->firstOrFail();

        $sensorData = [
            'voltage' => $latestReading->voltage,
            'current' => $latestReading->current,
            'energy' => $latestReading->energy,
            'frequency' => $latestReading->frequency,
            'power_factor' => $latestReading->power_factor,
            'temperature' => $latestReading->temperature,
            'humidity' => $latestReading->humidity,
            'measured_at' => $latestReading->measured_at->format('d-m-Y H:i:s')
        ];

        Log::debug('[Payload] Preparing data to send to Flask API', $sensorData);

        $payload = [
            'duration_type' => $durationType,
            'num_periods' => $numPeriods,
            'last_sensor_data' => $sensorData,
            'device_id' => $device->device_id,
            'start_date' => now()->format('d-m-Y H:i:s')
        ];

        Log::debug('[HTTP] Sending POST request to Flask API: /api/predict-future');
        Log::debug('Memory before request: ' . memory_get_usage());

        $response = Http::timeout(15)
            ->retry(3, 100)
            ->post("$flaskBaseUrl/api/predict-future", $payload);

        Log::debug('Memory after request: ' . memory_get_usage());

        if ($response->successful()) {
            Log::debug('[HTTP] Flask API response received successfully');
            $rawData = $response->json();

            if (!isset($rawData['daily_predictions'])) {
                Log::error('[Response] Missing daily_predictions in response');
                throw new \Exception("Invalid response format: daily_predictions missing");
            }

            Log::debug('[DB] Fetching 30-day historical energy data');
            $historical = EnergyMeasurement::where('device_id', $device->device_id)
                ->where('measured_at', '>=', now()->subDays(30))
                ->orderBy('measured_at')
                ->get()
                ->map(function ($item) {
    try {
        return [
            'timestamp' => $item->measured_at->format('Y-m-d H:i:s'),
            'power' => $item->power,
            'energy' => $item->energy,
            'voltage' => $item->voltage,
            'current' => $item->current
        ];
    } catch (\Exception $e) {
        Log::error('[Map Error] Failed processing item: ' . $e->getMessage());
        return [];
    }
                })->toArray();

            Log::debug('[Process] Formatting prediction and historical data');
            $processedData = [
                'start_date' => $rawData['start_date'] ?? now()->format('Y-m-d'),
                'duration_type' => $rawData['duration_type'] ?? $durationType,
                'num_periods' => $rawData['num_periods'] ?? $numPeriods,
                'daily_predictions' => $rawData['daily_predictions'] ?? [],
                'monthly_predictions' => $rawData['monthly_predictions'] ?? [],
                'yearly_predictions' => $rawData['yearly_predictions'] ?? [],
                'historical_data' => $historical,
                'plot_url' => $rawData['plot_url'] ?? null,
                'total_kwh' => 0,
                'estimated_cost' => 0
            ];

            if (!empty($processedData['daily_predictions'])) {
                Log::debug('[Calculate] Calculating total_kwh and estimated_cost');
                $total_kwh = array_reduce($processedData['daily_predictions'], 
                    fn($carry, $item) => $carry + ($item['total_energy_kwh'] ?? 0), 
                    0);

                $processedData['total_kwh'] = $total_kwh;
                $processedData['estimated_cost'] = $total_kwh * 1500; // Adjust rate as needed
            }

            Log::debug('--- [END] getPredictionData SUCCESS ---');
            return $processedData;

        } else {
            Log::error('[HTTP] Flask API returned error: ' . $response->status());
            Log::error('[HTTP] Response body: ' . $response->body());
            return $this->getDefaultData($durationType, $numPeriods);
        }

    } catch (\Illuminate\Http\Client\ConnectionException $e) {
        Log::error('[Exception] Flask API connection failed: ' . $e->getMessage());
        return $this->getDefaultData($durationType, $numPeriods);
    } catch (\Exception $e) {
        Log::error('[Exception] Error in getPredictionData: ' . $e->getMessage());
        return $this->getDefaultData($durationType, $numPeriods);
    }
}

    protected function processPredictionData($rawData)
{
    if (!isset($rawData['daily_predictions']) || !is_array($rawData['daily_predictions'])) {
        return [];
    }

    $predictions = $rawData['daily_predictions'];
    $totalPoints = count($predictions);
    $totalPower = 0;
    $peakPower = 0;
    $monthlyData = [];
    $dailyData = [];
    $hourlyData = []; // Tetap pakai ini kalau mau sampling

    foreach ($predictions as $pred) {
        $power = abs($pred['average_power_w']) / 1000; // dari watt ke kWh rata-rata per hari
        $energy = $pred['total_energy_kwh'];
        $timestamp = Carbon::createFromFormat('d-m-Y', $pred['period']);

        $totalPower += $power;
        $peakPower = max($peakPower, $power);

        // Monthly aggregation
        $monthKey = $timestamp->format('Y-m');
        if (!isset($monthlyData[$monthKey])) {
            $monthlyData[$monthKey] = ['total' => 0, 'count' => 0, 'peak' => 0];
        }
        $monthlyData[$monthKey]['total'] += $energy;
        $monthlyData[$monthKey]['count']++;
        $monthlyData[$monthKey]['peak'] = max($monthlyData[$monthKey]['peak'], $power);

        // Daily aggregation
        $dayKey = $timestamp->format('Y-m-d');
        $dailyData[$dayKey] = [
            'total' => $energy,
            'average' => $power,
            'peak' => $power
        ];

        // Optional: ambil data sampling jam tertentu
        if ($timestamp->day % 5 === 0) { // contoh: ambil tiap 5 hari
            $hourlyData[] = [
                'time' => $timestamp->format('Y-m-d'),
                'power' => round($power, 2)
            ];
        }
    }

    // Format monthly data
    $formattedMonthly = array_map(function ($month, $data) {
        return [
            'month' => $month,
            'average_power' => round($data['total'] / $data['count'], 2),
            'total_energy' => round($data['total'], 2),
            'peak_power' => round($data['peak'], 2)
        ];
    }, array_keys($monthlyData), $monthlyData);

    // Format daily data
    $formattedDaily = array_map(function ($day, $data) {
        return [
            'date' => $day,
            'average' => round($data['average'], 2),
            'total' => round($data['total'], 2),
            'peak' => round($data['peak'], 2)
        ];
    }, array_keys($dailyData), $dailyData);

    // Estimasi biaya total
    $totalEnergy = array_sum(array_column($predictions, 'total_energy_kwh'));
    $electricityRate = 1444.70;

    return [
        'labels' => array_column($hourlyData, 'time'),
        'data' => array_column($hourlyData, 'power'),
        'plot_url' => $rawData['plot_url'] ?? null,
        'aggregates' => [
            'total_energy' => round($totalEnergy, 2),
            'average_power' => round($totalPower / $totalPoints, 2),
            'peak_power' => round($peakPower, 2),
            'estimated_cost' => round($totalEnergy * $electricityRate, 2)
        ],
        'monthly_data' => $formattedMonthly,
        'daily_averages' => array_slice($formattedDaily, 0, 30),
        'sampled_hourly_data' => $hourlyData
    ];
}

    protected function createEmptyReading()
    {
        return new EnergyMeasurement([
            'voltage' => 0,
            'current' => 0,
            'power' => 0,
            'energy' => 0,
            'frequency' => 0,
            'power_factor' => 0,
            'temperature' => 0,
            'humidity' => 0,
            'measured_at' => now()
        ]);
    }

    protected function getHourlyConsumption($deviceId)
    {
        $today = now()->startOfDay();
        $readings = EnergyMeasurement::where('device_id', $deviceId)
            ->where('measured_at', '>=', $today)
            ->selectRaw('HOUR(measured_at) as hour, AVG(power) as avg_power')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        $labels = [];
        $data = [];
        for ($i = 0; $i < 24; $i++) {
            $labels[] = sprintf('%02d:00', $i);
            $hourData = $readings->firstWhere('hour', $i);
            $data[] = $hourData ? round($hourData->avg_power, 2) : 0;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

   protected function getEnergyHistory($deviceId, $days = 7)
{
    $startDate = now()->subDays($days)->startOfDay();
    
    // Ambil data per 5 menit (bukan per detik)
    $history = EnergyMeasurement::where('device_id', $deviceId)
        ->where('measured_at', '>=', $startDate)
        ->selectRaw('
            FLOOR(UNIX_TIMESTAMP(measured_at)/300) as timekey,
            DATE_FORMAT(measured_at, "%Y-%m-%d %H:%i:00") as time,
            AVG(power) as avg_power,
            MAX(energy) - MIN(energy) as energy_used
        ')
        ->groupBy('timekey', 'time')
        ->orderBy('timekey')
        ->take(288) // Maksimal 288 data (1 hari @5 menit)
        ->get();

    return [
        'labels' => $history->pluck('time')->map(fn($t) => Carbon::parse($t)->format('M d H:i'))->toArray(),
        'data' => $history->pluck('avg_power')->toArray(),
        'records' => $history->map(function($item) {
            return [
                'timestamp' => $item->time,
                'power' => round($item->avg_power, 2),
                'energy' => round($item->energy_used, 4),
                'duration' => '5m'
            ];
        })->toArray()
    ];
}
    protected function formatDuration($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        return sprintf('%02dh %02dm', $hours, $minutes);
    }

    protected function calculateMetrics($deviceId)
    {
        $today = now()->startOfDay();
        $stats = EnergyMeasurement::where('device_id', $deviceId)
            ->where('measured_at', '>=', $today)
            ->selectRaw('AVG(power) as avg_power, MAX(power) as peak_power, SUM(energy) as total_energy')
            ->first();

        return [
            'avgDailyPower' => round($stats->avg_power ?? 0, 2),
            'peakPowerToday' => round($stats->peak_power ?? 0, 2),
            'energyToday' => round($stats->total_energy ?? 0, 2)
        ];
    }
public function exportPdf($id)
{
    $device = is_numeric($id) 
        ? Device::findOrFail($id)
        : Device::where('device_id', $id)->firstOrFail();

    $latestReading = EnergyMeasurement::where('device_id', $device->device_id)
        ->where('measured_at', '>=', now()->subMinutes(5))
        ->latest('measured_at')
        ->first() ?? $this->createEmptyReading();

    $consumptionData = $this->getHourlyConsumption($device->device_id);
    $energyHistory = $this->getEnergyHistory($device->device_id);
    $metrics = $this->calculateMetrics($device->device_id);
    $predictionData = $this->getPredictionData($device);

    $pdf = Pdf::loadView('exports.energy_analytics_pdf', [
        'device' => $device,
        'latestReading' => $latestReading,
        'consumptionLabels' => $consumptionData['labels'],
        'consumptionData' => $consumptionData['data'],
        'energyHistory' => $energyHistory['records'],
        'avgDailyPower' => $metrics['avgDailyPower'],
        'peakPowerToday' => $metrics['peakPowerToday'],
        'energyToday' => $metrics['energyToday'],
        'predictionData' => $predictionData,
        'plotUrl' => $predictionData['plot_url'] ?? null
    ]);

    return $pdf->download('energy_report_'.$device->device_id.'.pdf');
}

}
