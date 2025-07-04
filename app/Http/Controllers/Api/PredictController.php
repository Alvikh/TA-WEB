<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PredictController extends Controller
{
    public function predictFuture(Request $request)
    {
        // Validasi input dari client Laravel
        $validated = $request->validate([
            'duration_type' => 'required|in:week,month,year',
            'num_periods' => 'required|integer|min:1',
            'start_date' => 'sometimes|date_format:d-m-Y H:i:s',
            'last_sensor_data' => 'required|array',
            'last_sensor_data.voltage' => 'required|numeric',
            'last_sensor_data.current' => 'required|numeric',
            'last_sensor_data.energy' => 'required|numeric',
            'last_sensor_data.frequency' => 'required|numeric',
            'last_sensor_data.power_factor' => 'required|numeric',
            'last_sensor_data.temperature' => 'required|numeric',
            'last_sensor_data.humidity' => 'required|numeric',
        ]);

        try {
            // Base URL Flask API
            $flaskBaseUrl = 'http://103.219.251.163:5050';
            
            // Kirim request ke Flask API
            $response = Http::post("$flaskBaseUrl/api/predict-future", $validated);
            
            // Jika request gagal
            if ($response->failed()) {
                Log::error('Flask API request failed', [
                    'status' => $response->status(),
                    'error' => $response->json()
                ]);
                
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to get prediction from model service',
                    'error_details' => $response->json()
                ], $response->status());
            }
            
            // Jika request sukses
            return response()->json([
                'status' => 'success',
                'data' => $response->json()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Prediction error: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error',
                'error_details' => $e->getMessage()
            ], 500);
        }
    }
}