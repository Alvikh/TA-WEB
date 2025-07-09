<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Models\EnergyMeasurement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class EnergyAnalyticsController extends Controller
{
    public function show($id)
    {
        $device = Device::findOrFail($id);
        
        $latestReading = EnergyMeasurement::where('device_id', $device->device_id)
            ->where('measured_at', '>=', now()->subMinutes(5))
            ->latest('measured_at')
            ->first() ?? $this->createEmptyReading();
            
        $consumptionData = $this->getHourlyConsumption($device->device_id);
        $energyHistory = $this->getEnergyHistory($device->device_id);
        $metrics = $this->calculateMetrics($device->device_id);
        
        // Get prediction data
        $predictionData = $this->getPredictionData($device);
// dd($predictionData);
        return view('energy-analytics.show', [
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
        ]);
    }

    protected function getPredictionData($device, $durationType = 'year', $numPeriods = 1)
    {
        $flaskBaseUrl = 'http://103.219.251.163:5050';
        $latestReading = EnergyMeasurement::where('device_id', $device->device_id)
            ->latest('measured_at')
            ->firstOrFail();

        $defaultData = [
            'labels' => [],
            'data' => [],
            'historical' => [],
            'predictedUsage' => 0,
            'savingsPotential' => 0,
            'plot_url' => null,
            'aggregates' => [
                'total_energy' => 0,
                'average_power' => 0,
                'peak_power' => 0,
                'estimated_cost' => 0
            ],
            'monthly_data' => [],
            'daily_averages' => [],
            'sampled_hourly_data' => []
        ];

        try {
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

            $response = Http::post("$flaskBaseUrl/api/predict-future", [
                'duration_type' => $durationType,
                'num_periods' => $numPeriods,
                'last_sensor_data' => $sensorData,
                'device_id' => $device->device_id,
                'start_date' => now()->format('d-m-Y H:i:s')
            ]);
return $response->json();
            // if ($response->successful()) {
            //     $rawData = $response->json();
            //     $processedData = $this->processPredictionData($rawData);
                
            //     return array_merge($defaultData, $processedData);
            // }
        } catch (\Exception $e) {
            Log::error('Prediction failed: '.$e->getMessage());
        }

        return $defaultData;
    }
// Di EnergyAnalyticsController.php
public function getPrediction(Device $device, Request $request)
{
    $durationType = $request->query('duration', 'day');
    $numPeriods = 1; // Atau ambil dari request jika ingin dinamis
    
    // Panggil method yang sudah ada untuk generate prediksi
    $predictionData = $this->getPredictionData($device, $durationType, $numPeriods);
    
    return view('energy-analytics.prediction-content', [
        'predictionData' => $predictionData,
        'device' => $device
    ]);
}

    protected function processPredictionData($rawData)
    {
        if (!isset($rawData['predictions']) || !is_array($rawData['predictions'])) {
            return [];
        }

        $predictions = $rawData['predictions'];
        $totalPoints = count($predictions);
        
        // Initialize aggregates
        $totalPower = 0;
        $peakPower = 0;
        $monthlyData = [];
        $dailyData = [];
        $hourlyData = [];

        foreach ($predictions as $pred) {
            // Convert from Wh to kWh by dividing by 1000
            $power = abs($pred['predicted_power']) / 1000;
            $timestamp = Carbon::createFromFormat('d-m-Y H:i:s', $pred['timestamp']);
            
            // Aggregate totals
            $totalPower += $power;
            $peakPower = max($peakPower, $power);
            
            // Group by month
            $monthKey = $timestamp->format('Y-m');
            if (!isset($monthlyData[$monthKey])) {
                $monthlyData[$monthKey] = [
                    'total' => 0,
                    'count' => 0,
                    'peak' => 0
                ];
            }
            $monthlyData[$monthKey]['total'] += $power;
            $monthlyData[$monthKey]['count']++;
            $monthlyData[$monthKey]['peak'] = max($monthlyData[$monthKey]['peak'], $power);
            
            // Group by day
            $dayKey = $timestamp->format('Y-m-d');
            if (!isset($dailyData[$dayKey])) {
                $dailyData[$dayKey] = [
                    'total' => 0,
                    'count' => 0,
                    'peak' => 0
                ];
            }
            $dailyData[$dayKey]['total'] += $power;
            $dailyData[$dayKey]['count']++;
            $dailyData[$dayKey]['peak'] = max($dailyData[$dayKey]['peak'], $power);
            
            // Sample hourly data (every 6 hours)
            if ($timestamp->hour % 6 === 0) {
                $hourlyData[] = [
                    'time' => $timestamp->format('Y-m-d H:i'),
                    'power' => round($power, 2)
                ];
            }
        }

        // Format monthly data
        $formattedMonthly = array_map(function($month, $data) {
            return [
                'month' => $month,
                'average_power' => round($data['total'] / $data['count'], 2),
                'total_energy' => round($data['total'], 2),
                'peak_power' => round($data['peak'], 2)
            ];
        }, array_keys($monthlyData), $monthlyData);

        // Format daily data
        $formattedDaily = array_map(function($day, $data) {
            return [
                'date' => $day,
                'average' => round($data['total'] / $data['count'], 2),
                'total' => round($data['total'], 2),
                'peak' => round($data['peak'], 2)
            ];
        }, array_keys($dailyData), $dailyData);

        // Electricity rate in Rp per kWh
        $electricityRate = 1444.70;

        return [
            'labels' => array_column($hourlyData, 'time'),
            'data' => array_column($hourlyData, 'power'),
            'plot_url' => $rawData['plot_url'] ?? null,
            'aggregates' => [
                'total_energy' => round($totalPower, 2), // Already in kWh
                'average_power' => round($totalPower / $totalPoints, 2), // Average kWh
                'peak_power' => round($peakPower, 2), // Peak in kWh
                'estimated_cost' => round($totalPower * $electricityRate, 2) // Cost in Rp
            ],
            'monthly_data' => $formattedMonthly,
            'daily_averages' => array_slice($formattedDaily, 0, 30), // Last 30 days
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
        
        // Fill 24 hours with data
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
public function getPredictions($id)
{
    $device = Device::findOrFail($id);
    
    $latestReading = EnergyMeasurement::where('device_id', $device->device_id)
        ->latest('measured_at')
        ->firstOrFail();

    $predictionData = [
        'device' => $device,
        'latestReading' => $latestReading,
        'prediction' => [
            'labels' => [],
            'data' => [],
            'historical' => []
        ],
        'predictedUsage' => 0,
        'savingsPotential' => 0
    ];

    try {
        // Prepare sensor data payload
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

        // Default prediction request (1 day ahead)
        $predictionRequest = [
            'duration_type' => 'day',
            'num_periods' => 1,
            'start_date' => now()->format('d-m-Y H:i:s'),
            'last_sensor_data' => $sensorData,
            'device_id' => $device->device_id,
            'device_type' => $device->type
        ];

        // Flask API configuration
        $flaskBaseUrl = config('services.flask_api.url', 'http://103.219.251.163:5050');
        $timeout = config('services.flask_api.timeout', 30);
        
        // Send prediction request
        $response = Http::timeout($timeout)
            ->retry(3, 1000)
            ->post("$flaskBaseUrl/api/predict-future", $predictionRequest);
        // dd($response);
        if ($response->successful()) {
            $apiResponse = $response->json();
            
            // Format the prediction data for the view
            $predictionData['prediction'] = [
                'labels' => $apiResponse['prediction_dates'] ?? [],
                'data' => $apiResponse['predicted_values'] ?? [],
                'historical' => $apiResponse['historical_values'] ?? []
            ];
            
            $predictionData['predictedUsage'] = $apiResponse['total_predicted_usage'] ?? 0;
            $predictionData['savingsPotential'] = $apiResponse['savings_potential'] ?? 0;
        }

    } catch (\Exception $e) {
        // Log error but don't fail the page load
        Log::error('Prediction error: ' . $e->getMessage());
    }

    return view('energy-analytics.prediction', $predictionData);
}
    protected function getEnergyHistory($deviceId, $days = 7)
    {
        $startDate = now()->subDays($days)->startOfDay();
        
        // Get daily aggregates
        $history = EnergyMeasurement::where('device_id', $deviceId)
            ->where('measured_at', '>=', $startDate)
            ->selectRaw('DATE(measured_at) as date, 
                        SUM(energy) as total_energy,
                        AVG(power) as avg_power,
                        TIMESTAMPDIFF(SECOND, MIN(measured_at), MAX(measured_at)) as duration_seconds')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $labels = [];
        $data = [];
        $records = [];
        
        foreach ($history as $record) {
            $date = Carbon::parse($record->date);
            $labels[] = $date->format('M d');
            $data[] = round($record->total_energy, 2);
            
            $duration = $this->formatDuration($record->duration_seconds);
            
            $records[] = [
                'date' => $date->format('Y-m-d'),
                'energy' => $record->total_energy,
                'duration' => $duration,
                'avg_power' => $record->avg_power
            ];
        }
        
        return [
            'labels' => $labels,
            'data' => $data,
            'records' => $records
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
        
        // Single query to get all metrics
        $stats = EnergyMeasurement::where('device_id', $deviceId)
            ->where('measured_at', '>=', $today)
            ->selectRaw('AVG(power) as avg_power, 
                        MAX(power) as peak_power, 
                        SUM(energy) as total_energy')
            ->first();
            
        return [
            'avgDailyPower' => round($stats->avg_power ?? 0, 2),
            'peakPowerToday' => round($stats->peak_power ?? 0, 2),
            'energyToday' => round($stats->total_energy ?? 0, 2)
        ];
    }

    // AJAX Endpoints for dynamic updates
    public function getConsumption(Request $request, $id)
    {
        $period = $request->query('period', 'day');
        
        $data = match($period) {
            'day' => $this->getHourlyConsumption($id),
            'week' => $this->getDailyConsumption($id, 7),
            'month' => $this->getDailyConsumption($id, 30),
        };
        
        $metrics = $this->calculateMetrics($id);
        
        return response()->json([
            'labels' => $data['labels'],
            'data' => $data['data'],
            'currentUsage' => $metrics['avgDailyPower'],
            'avgDaily' => $metrics['avgDailyPower'],
            'peakToday' => $metrics['peakPowerToday'],
            'energyToday' => $metrics['energyToday']
        ]);
    }

    protected function getDailyConsumption($deviceId, $days)
    {
        $startDate = now()->subDays($days)->startOfDay();
        
        $readings = EnergyMeasurement::where('device_id', $deviceId)
            ->where('measured_at', '>=', $startDate)
            ->selectRaw('DATE(measured_at) as date, AVG(power) as avg_power')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $labels = [];
        $data = [];
        
        foreach ($readings as $reading) {
            $labels[] = Carbon::parse($reading->date)->format('M d');
            $data[] = round($reading->avg_power, 2);
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    // Endpoint for MQTT data storage
    public function storeMeasurement(Request $request, $id)
    {
        $validated = $request->validate([
            'voltage' => 'required|numeric',
            'current' => 'required|numeric',
            'power' => 'required|numeric',
            'energy' => 'required|numeric',
            'frequency' => 'nullable|numeric',
            'power_factor' => 'nullable|numeric',
            'temperature' => 'nullable|numeric',
            'humidity' => 'nullable|numeric',
            'measured_at' => 'required|date'
        ]);
        
        $validated['device_id'] = $id;
        
        try {
            // Use insert instead of create for better performance with high frequency data
            DB::table('energy_measurements')->insert($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Measurement stored'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to store measurement'
            ], 500);
        }
    }
}