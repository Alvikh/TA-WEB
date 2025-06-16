<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\EnergyMeasurement;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EnergyAnalyticsController extends Controller
{
    public function show($id)
    {
        // Get the specific device
        $device = Device::findOrFail($id);
        
        // Get the latest reading
        $latestReading = EnergyMeasurement::where('device_id', $id)
            ->latest('measured_at')
            ->first();
            
        // Get consumption data for the day
        $consumptionData = $this->getConsumptionData($id, 'day');
        
        // Get prediction data for 1 day ahead
        $predictionData = $this->getPredictionData($id, 'day');
        
        // Calculate metrics
        $avgDailyPower = EnergyMeasurement::where('device_id', $id)
            ->whereDate('measured_at', today())
            ->avg('power') ?? 0;
            
        $peakPowerToday = EnergyMeasurement::where('device_id', $id)
            ->whereDate('measured_at', today())
            ->max('power') ?? 0;
            
        $energyToday = EnergyMeasurement::where('device_id', $id)
            ->whereDate('measured_at', today())
            ->sum('energy') ?? 0;
            
        $predictedUsage = $this->predictEnergyUsage($id, 'day');
        $savingsPotential = rand(5, 25); // Replace with actual calculation

        return view('energy-analytics.show', [
            'device' => $device,
            'latestReading' => $latestReading,
            'consumptionLabels' => $consumptionData['labels'],
            'consumptionData' => $consumptionData['data'],
            'predictionLabels' => $predictionData['labels'],
            'predictionData' => $predictionData['data'],
            'historicalData' => $predictionData['historical'],
            'avgDailyPower' => round($avgDailyPower, 2),
            'peakPowerToday' => round($peakPowerToday, 2),
            'energyToday' => round($energyToday, 2),
            'predictedUsage' => round($predictedUsage, 2),
            'savingsPotential' => $savingsPotential
        ]);
    }
    
    public function getConsumptionData($id, $period)
    {
        $now = Carbon::now();
        $data = [];
        $labels = [];
        
        switch ($period) {
            case 'day':
                $readings = EnergyMeasurement::where('device_id', $id)
                    ->whereDate('measured_at', today())
                    ->orderBy('measured_at')
                    ->get();
                    
                foreach ($readings as $reading) {
                    $labels[] = $reading->measured_at->format('H:i');
                    $data[] = $reading->power;
                }
                break;
                
            case 'week':
                $startDate = $now->copy()->subDays(7);
                $readings = EnergyMeasurement::where('device_id', $id)
                    ->whereBetween('measured_at', [$startDate, $now])
                    ->orderBy('measured_at')
                    ->get()
                    ->groupBy(function($date) {
                        return Carbon::parse($date->measured_at)->format('Y-m-d');
                    });
                    
                foreach ($readings as $day => $dayReadings) {
                    $labels[] = Carbon::parse($day)->format('M d');
                    $data[] = $dayReadings->avg('power');
                }
                break;
                
            case 'month':
                $startDate = $now->copy()->subDays(30);
                $readings = EnergyMeasurement::where('device_id', $id)
                    ->whereBetween('measured_at', [$startDate, $now])
                    ->orderBy('measured_at')
                    ->get()
                    ->groupBy(function($date) {
                        return Carbon::parse($date->measured_at)->format('Y-m-d');
                    });
                    
                foreach ($readings as $day => $dayReadings) {
                    $labels[] = Carbon::parse($day)->format('M d');
                    $data[] = $dayReadings->avg('power');
                }
                break;
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
    
    public function getPredictionData($id, $period)
    {
        // In a real app, you would use a machine learning model here
        // This is just a simplified example with mock data
        
        $labels = [];
        $prediction = [];
        $historical = [];
        $now = Carbon::now();
        
        switch ($period) {
            case 'day':
                for ($i = 1; $i <= 24; $i++) {
                    $labels[] = $now->copy()->addHours($i)->format('H:i');
                    $prediction[] = rand(500, 1500) / 100;
                    $historical[] = rand(400, 1200) / 100;
                }
                break;
                
            case 'week':
                for ($i = 1; $i <= 7; $i++) {
                    $labels[] = $now->copy()->addDays($i)->format('D');
                    $prediction[] = rand(10, 30);
                    $historical[] = rand(8, 25);
                }
                break;
                
            case 'month':
                for ($i = 1; $i <= 30; $i += 2) {
                    $labels[] = $now->copy()->addDays($i)->format('M d');
                    $prediction[] = rand(100, 300);
                    $historical[] = rand(80, 250);
                }
                break;
        }
        
        return [
            'labels' => $labels,
            'data' => $prediction,
            'historical' => $historical
        ];
    }
    
    public function predictEnergyUsage($id, $period)
    {
        // Simplified prediction - replace with actual ML model
        $base = EnergyMeasurement::where('device_id', $id)
            ->whereDate('measured_at', today())
            ->avg('energy') ?? 10;
            
        switch ($period) {
            case 'day': return $base * 1.2;
            case 'week': return $base * 7 * 1.1;
            case 'month': return $base * 30 * 0.9;
        }
    }
    
    // AJAX endpoints
    public function getConsumption(Request $request, $id)
    {
        $period = $request->query('period', 'day');
        $data = $this->getConsumptionData($id, $period);
        
        // Calculate metrics for the period
        $now = Carbon::now();
        $startDate = match($period) {
            'day' => today(),
            'week' => $now->copy()->subDays(7),
            'month' => $now->copy()->subDays(30),
        };
        
        $readings = EnergyMeasurement::where('device_id', $id)
            ->whereBetween('measured_at', [$startDate, $now])
            ->get();
            
        $currentUsage = $readings->last()->power ?? 0;
        $avgDaily = $readings->avg('power') ?? 0;
        $peakToday = $readings->max('power') ?? 0;
        $energyToday = $readings->sum('energy') ?? 0;
        
        return response()->json([
            'labels' => $data['labels'],
            'data' => $data['data'],
            'currentUsage' => round($currentUsage, 2),
            'avgDaily' => round($avgDaily, 2),
            'peakToday' => round($peakToday, 2),
            'energyToday' => round($energyToday, 2)
        ]);
    }
    
    public function getPrediction(Request $request, $id)
    {
        $period = $request->query('period', 'day');
        $data = $this->getPredictionData($id, $period);
        $predictedUsage = array_sum($data['data']);
        $costEstimate = number_format($predictedUsage * 0.15, 2);
        $savingsPotential = rand(5, 25);
        
        return response()->json([
            'labels' => $data['labels'],
            'prediction' => $data['data'],
            'historical' => $data['historical'],
            'predictedUsage' => round($predictedUsage, 2),
            'costEstimate' => $costEstimate,
            'savingsPotential' => $savingsPotential
        ]);
    }
}