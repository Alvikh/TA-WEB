<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Models\EnergyMeasurement;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class EnergyAnalyticsApiController extends Controller
{
    public function getDeviceData($id)
    {
        try {
            $device = Device::findOrFail($id);

        $latestReading = EnergyMeasurement::where('device_id', $device->device_id)
            ->where('measured_at', '>=', now()->subMinutes(5))
            ->latest('measured_at')
            ->first() ?? $this->createEmptyReading();

        $hourlyConsumption = $this->getHourlyConsumption($device->device_id);
        $dailyConsumption = $this->getDailyConsumption($device->device_id, 7);
        $energyHistory = $this->getEnergyHistory($device->device_id, 7);
        $metrics = $this->calculateMetrics($device->device_id);
        $predictionData = $this->getPredictionData($device);

        return response()->json([
            'status' => 'success',
            'device' => $device,
            'latest_reading' => $latestReading,
            'consumption' => [
                'hourly' => $hourlyConsumption,
                'daily' => $dailyConsumption,
            ],
            'energy_history' => $energyHistory,
            'metrics' => $metrics,
            'prediction' => $predictionData,
            'plot_url' => $predictionData['plot_url'] ?? null,
            'timestamp' => now()->toDateTimeString()
        ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch device data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getPredictionDataApi($id)
    {
        try {
            $device = Device::findOrFail($id);
            $predictionData = $this->getPredictionData($device);

            return response()->json([
                'status' => 'success',
                'prediction' => $predictionData,
                'timestamp' => now()->toDateTimeString()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch prediction data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getConsumptionHistoryApi(Request $request, $id)
    {
        try {
            $period = $request->query('period', 'day');
            $days = $request->query('days', 7);
            
            $data = match($period) {
                'day' => $this->getHourlyConsumption($id),
                'week', 'month' => $this->getDailyConsumption($id, $days),
                default => throw new \InvalidArgumentException('Invalid period specified')
            };
            
            $metrics = $this->calculateMetrics($id);

            return response()->json([
                'status' => 'success',
                'period' => $period,
                'days' => $days,
                'data' => $data,
                'metrics' => $metrics,
                'timestamp' => now()->toDateTimeString()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch consumption data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function storeMeasurementApi(Request $request, $id)
    {
        try {
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
            
            DB::table('energy_measurements')->insert($validated);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Measurement stored successfully',
                'timestamp' => now()->toDateTimeString()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store measurement',
                'error' => $e->getMessage()
            ], 500);
        }
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

    protected function processPredictionData($rawData)
    {
        if (!isset($rawData['predictions']) || !is_array($rawData['predictions'])) {
            return [];
        }

        $predictions = $rawData['predictions'];
        $totalPoints = count($predictions);
        
        $totalPower = 0;
        $peakPower = 0;
        $monthlyData = [];
        $dailyData = [];
        $hourlyData = [];

        foreach ($predictions as $pred) {
            $power = abs($pred['predicted_power']) / 1000; // Convert Wh to kWh
            $timestamp = Carbon::createFromFormat('d-m-Y H:i:s', $pred['timestamp']);
            
            $totalPower += $power;
            $peakPower = max($peakPower, $power);
            
            // Monthly aggregation
            $monthKey = $timestamp->format('Y-m');
            if (!isset($monthlyData[$monthKey])) {
                $monthlyData[$monthKey] = ['total' => 0, 'count' => 0, 'peak' => 0];
            }
            $monthlyData[$monthKey]['total'] += $power;
            $monthlyData[$monthKey]['count']++;
            $monthlyData[$monthKey]['peak'] = max($monthlyData[$monthKey]['peak'], $power);
            
            // Daily aggregation
            $dayKey = $timestamp->format('Y-m-d');
            if (!isset($dailyData[$dayKey])) {
                $dailyData[$dayKey] = ['total' => 0, 'count' => 0, 'peak' => 0];
            }
            $dailyData[$dayKey]['total'] += $power;
            $dailyData[$dayKey]['count']++;
            $dailyData[$dayKey]['peak'] = max($dailyData[$dayKey]['peak'], $power);
            
            // Sample hourly data
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
            'predicted_usage' => round($totalPower, 2),
            'aggregates' => [
                'total_energy' => round($totalPower, 2),
                'average_power' => round($totalPower / $totalPoints, 2),
                'peak_power' => round($peakPower, 2),
                'estimated_cost' => round($totalPower * $electricityRate, 2)
            ],
            'monthly_data' => $formattedMonthly,
            'daily_averages' => array_slice($formattedDaily, 0, 30),
            'sampled_hourly_data' => $hourlyData
        ];
    }

    protected function createEmptyReading()
    {
        return [
            'voltage' => 0,
            'current' => 0,
            'power' => 0,
            'energy' => 0,
            'frequency' => 0,
            'power_factor' => 0,
            'temperature' => 0,
            'humidity' => 0,
            'measured_at' => now()->toDateTimeString()
        ];
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
            'data' => $data,
            'unit' => 'kW'
        ];
    }

    protected function getDailyConsumption($deviceId, $days = 7)
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
            'data' => $data,
            'unit' => 'kW'
        ];
    }

    protected function getEnergyHistory($deviceId, $days = 7)
    {
        $startDate = now()->subDays($days)->startOfDay();
        
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
            'records' => $records,
            'unit' => 'kWh'
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
            ->selectRaw('AVG(power) as avg_power, 
                        MAX(power) as peak_power, 
                        SUM(energy) as total_energy')
            ->first();
            
        return [
            'avg_daily_power' => round($stats->avg_power ?? 0, 2),
            'peak_power_today' => round($stats->peak_power ?? 0, 2),
            'energy_today' => round($stats->total_energy ?? 0, 2),
            'units' => [
                'power' => 'kW',
                'energy' => 'kWh'
            ]
        ];
    }
}