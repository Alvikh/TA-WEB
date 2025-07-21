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
{public function getConsumptionHistoryApi(Request $request, $id)
    {
        try {
            $startDate = $request['start_date'] 
                ? Carbon::parse($request['start_date'])->startOfDay()
                : now()->subDays(7)->startOfDay();
            $endDate = $request['end_date']
                ? Carbon::parse($request['end_date'])->endOfDay()
                : now()->endOfDay();
            
            $interval = $request['interval']; // hourly or daily
            
            $device = Device::findOrFail($id);
            $deviceId = $device->device_id;
// return $deviceId;
            // Get data based on interval
            $data = match($interval) {
                'hourly' => $this->getHourlyConsumption($deviceId, $startDate, $endDate),
                'daily' => $this->getDailyConsumption($deviceId, $startDate, $endDate),
                default => throw new \InvalidArgumentException('Invalid interval specified')
            };
            // return $data;
            // Calculate metrics for the selected period
            $metrics = $this->calculateMetrics($deviceId, $startDate, $endDate);

            return response()->json([
                'status' => 'success',
                'period' => $interval,
                'start_date' => $startDate->toDateTimeString(),
                'end_date' => $endDate->toDateTimeString(),
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

    protected function getHourlyConsumption($deviceId, $startDate, $endDate)
{
    $readings = EnergyMeasurement::where('device_id', $deviceId)
        ->whereBetween('measured_at', [$startDate, $endDate])
        ->selectRaw('HOUR(measured_at) as hour, 
                    DATE(measured_at) as date,
                    SUM(power) as total_power,
                    COUNT(*) as count_entries')
        ->groupBy('date', 'hour')
        ->orderBy('date')
        ->orderBy('hour')
        ->get();

    // Init 0 values
    $hourlyData = [];
    $currentDate = $startDate->copy();
    
    while ($currentDate <= $endDate) {
        $dateStr = $currentDate->format('Y-m-d');
        $hourlyData[$dateStr] = array_fill(0, 24, 0);
        $currentDate->addDay();
    }

    // Fill actual energy data
    foreach ($readings as $reading) {
    $dateStr = Carbon::parse($reading->date)->format('Y-m-d');
    
    // Ambil rata-rata power per entry
    $avgPower = $reading->count_entries > 0
        ? $reading->total_power / $reading->count_entries
        : 0;

    // Karena ini power per jam, maka energi dalam jam itu = avg power (Watt) ÷ 1000 → kWh
    $energyInKWh = $avgPower / 1000;

    $hourlyData[$dateStr][$reading->hour] = round($energyInKWh, 4);
}


    // If one day
    if ($startDate->isSameDay($endDate)) {
        $labels = array_map(fn($h) => sprintf('%02d:00', $h), range(0, 23));
        $data = $hourlyData[$startDate->format('Y-m-d')] ?? array_fill(0, 24, 0);

        return [
            'labels' => $labels,
            'data' => $data,
            'unit' => 'kWh'
        ];
    }

    // Multiple day: daily energy sum
    $dailyTotals = [];
    $labels = [];

    foreach ($hourlyData as $date => $hours) {
        $total = array_sum($hours);
        $dailyTotals[] = round($total, 4);
        $labels[] = Carbon::parse($date)->format('M d');
    }

    return [
        'labels' => $labels,
        'data' => $dailyTotals,
        'unit' => 'kWh'
    ];
}


   protected function getDailyConsumption($deviceId, $startDate, $endDate)
{
    // First get all raw measurements in the date range
    $measurements = EnergyMeasurement::where('device_id', $deviceId)
        ->whereBetween('measured_at', [$startDate, $endDate])
        ->select(['measured_at', 'power', 'energy'])
        ->orderBy('measured_at')
        ->get();

    // Initialize results array
    $results = [];
    $currentDate = $startDate->copy();

    while ($currentDate <= $endDate) {
        $dateStr = $currentDate->format('Y-m-d');
        $results[$dateStr] = [
            'total_energy' => 0,
            'power_samples' => [],
            'last_measurement' => null,
            'first_measurement' => null
        ];
        $currentDate->addDay();
    }

    // Process each measurement
    foreach ($measurements as $i => $measurement) {
    if ($i === 0) continue;

    $prev = $measurements[$i - 1];
    $date = Carbon::parse($measurement->measured_at)->format('Y-m-d');

    $diff = $measurement->energy - $prev->energy;

    if ($diff >= 0 && isset($results[$date])) {
        $results[$date]['total_energy'] += $diff / 1000; // Convert Wh → kWh
        $results[$date]['power_samples'][] = $measurement->power;
    }
}


    // Calculate daily values
    $dailyData = [];
    foreach ($results as $date => $data) {
        $totalEnergy = 0;
        $avgPower = 0;

        if ($data['first_measurement'] && $data['last_measurement']) {
            // Calculate energy consumption more precisely
            $energyDiff = $data['last_measurement']->energy - $data['first_measurement']->energy;
            $totalEnergy = max(0, $energyDiff / 1000); // Convert Wh to kWh, ensure non-negative
        }

        // Calculate average power from samples
        if (count($data['power_samples']) > 0) {
            $avgPower = array_sum($data['power_samples']) / count($data['power_samples']);
        }

        $dailyData[] = [
            'date' => $date,
            'total_energy_kwh' => round($totalEnergy, 4),
            'avg_power_kw' => round($avgPower, 2)
        ];
    }

    // Prepare output
    $labels = array_map(fn($d) => Carbon::parse($d['date'])->format('M d'), $dailyData);
    $energyData = array_column($dailyData, 'total_energy_kwh');
    $powerData = array_column($dailyData, 'avg_power_kw');

    return [
        'status' => 'success',
        'labels' => $labels,
        'data' => $energyData,
        'unit' => 'kWh',
        'meta' => [
            'average_power_data' => $powerData,
            'power_unit' => 'kW',
            'measurement_count' => $measurements->count(),
            'days_with_data' => count(array_filter($energyData, fn($v) => $v > 0))
        ],
        'timestamp' => now()->toDateTimeString()
    ];
}

protected function calculateMetrics($deviceId, $startDate, $endDate)
{
    $stats = EnergyMeasurement::where('device_id', $deviceId)
        ->whereBetween('measured_at', [$startDate, $endDate])
        ->selectRaw('AVG(power) as avg_power, 
                     MAX(power) as peak_power, 
                     SUM(power) as total_power_sum,
                     COUNT(*) as count_entries')
        ->first();

    $days = $startDate->diffInDays($endDate) + 1;

    $totalEnergyKwh = $stats && $stats->total_power_sum
        ? round(($stats->total_power_sum * 5) / 3600000, 4)
        : 0;

    return [
        'avg_daily_energy' => $days > 0
            ? round($totalEnergyKwh / $days, 4)
            : 0,
        'peak_power' => round($stats->peak_power ?? 0, 2),
        'total_energy' => $totalEnergyKwh,
        'units' => [
            'power' => 'kW',
            'energy' => 'kWh'
        ]
    ];
}



    public function getDeviceData($id)
{
    Log::debug('1. Memulai getDeviceData', ['device_id' => $id]);

    try {
        Log::debug('2. Mencari device...');
        $device = Device::find($id);
        if (!$device) {
            Log::error('Device tidak ditemukan', ['id' => $id]);
            throw new \Exception("Device dengan ID {$id} tidak ditemukan");
        }
        Log::debug('3. Device ditemukan', ['device_name' => $device->name]);

        $startDate = now()->subDays(7)->startOfDay();
        $endDate = now()->endOfDay();
        Log::debug('4. Rentang tanggal', ['start' => $startDate, 'end' => $endDate]);

        Log::debug('5. Mengambil data hourly...');
        $hourlyConsumption = $this->getHourlyConsumption($device->device_id, $startDate, $endDate);
        Log::debug('6. Data hourly', ['sample' => array_slice($hourlyConsumption['data'] ?? [], 0, 3)]);

        Log::debug('7. Mengambil data daily...');
        $dailyConsumption = $this->getDailyConsumption($device->device_id, $startDate, $endDate);
        Log::debug('8. Data daily', ['sample' => array_slice($dailyConsumption['data'] ?? [], 0, 3)]);

        Log::debug('9. Mengambil energy history...');
        $energyHistory = $this->getEnergyHistory($device->device_id);
        Log::debug('10. Energy history', ['count' => count($energyHistory['data'] ?? [])]);

        Log::debug('11. Menghitung metrics...');
        $metrics = $this->calculateMetrics($device->device_id, $startDate, $endDate);
        Log::debug('12. Metrics', $metrics);

        Log::debug('13. Mengambil prediksi...');
        $predictionData = $this->getPredictionData($device);
        Log::debug('14. Prediction data', ['keys' => array_keys($predictionData)]);

        Log::debug('15. Membuat response akhir...');
        $response = [
            'status' => 'success',
            'device' => $device->only(['id', 'device_id', 'name']),
            'latest_reading' => EnergyMeasurement::where('device_id', $device->device_id)
                ->latest('measured_at')
                ->first()?->toArray() ?? [],
            'consumption' => [
                'hourly' => $hourlyConsumption,
                'daily' => $dailyConsumption,
            ],
            'energy_history' => $energyHistory,
            'metrics' => $metrics,
            'prediction' => $predictionData,
            'timestamp' => now()->toDateTimeString()
        ];

        Log::debug('16. Response siap dikirim', ['keys' => array_keys($response)]);
        return response()->json($response);

    } catch (\Exception $e) {
        Log::error('ERROR DALAM getDeviceData', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'device_id' => $id
        ]);
        
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to fetch device data',
            'error' => $e->getMessage(),
            'debug_step' => 'Terjadi error pada langkah terakhir yang di-log'
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
        $flaskBaseUrl = 'http://103.219.251.171:5050';
        // $flaskBaseUrl = 'http://192.168.1.10:5050';
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
            ->limit(1000)
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

   
}
