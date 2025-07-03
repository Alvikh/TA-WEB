<?php

namespace App\Http\Controllers\Api;

use App\Models\EnergyMeasurement;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EnergyMeasurementController extends Controller
{
    // Get all measurements with optional filters
    public function index(Request $request)
    {
        $measurements = EnergyMeasurement::with('device')
            ->orderBy('measured_at', 'desc');

        // Filter by device_id if provided
        if ($request->has('device_id')) {
            $measurements->where('device_id', $request->device_id);
        }

        // Filter by date range if provided
        if ($request->has(['start_date', 'end_date'])) {
            $measurements->whereBetween('measured_at', [
                $request->start_date,
                $request->end_date
            ]);
        }

        // Pagination
        $perPage = $request->has('per_page') ? (int)$request->per_page : 20;
        $measurements = $measurements->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $measurements
        ]);
    }

    public function store(Request $request)
{
    // $jsonData = json_decode(file_get_contents('php://input'), true);
    
    // Log::error('Invalid JSON', [
    //     'raw_input' => file_get_contents('php://input'),
    //     'headers' => $request->headers->all()
    // ]);
    
    // return response()->json([
    //     'success' => false,
    //     'message' => 'Invalid JSON format',
    //     'debug' => [
    //         'php_input' => file_get_contents('php://input'),
    //         'headers' => $request->headers->all()
    //     ]
    // ], 400);
    // if (json_last_error() !== JSON_ERROR_NONE) {
    // }



    $data = $request->all();

    // Cek apakah request berupa array (multiple entries)
    $isBatch = is_array($data) && isset($data[0]);

    $rules = [
        'device_id' => 'required|exists:devices,device_id',
        'voltage' => 'required|numeric',
        'current' => 'required|numeric',
        'power' => 'required|numeric',
        'energy' => 'required|numeric',
        'frequency' => 'sometimes|numeric|nullable',
        'power_factor' => 'sometimes|numeric|nullable|between:0,1',
        'temperature' => 'sometimes|numeric|nullable',
        'humidity' => 'sometimes|numeric|nullable|between:0,100',
        'measured_at' => 'sometimes|date_format:d-m-Y H:i:s'
    ];

    if ($isBatch) {
        $validatedData = [];
        foreach ($data as $index => $item) {
            $validator = Validator::make($item, $rules);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => "Row $index: " . $validator->errors()->first()
                ], 400);
            }

            // Ubah format tanggal jika perlu
            if (!isset($item['measured_at'])) {
                $item['measured_at'] = now();
            } else {
                $item['measured_at'] = \Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $item['measured_at']);
            }

            $validatedData[] = $item;
        }

        // Simpan semua data
        EnergyMeasurement::insert($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Batch energy measurements stored successfully.',
        ], 201);
    } else {
        // Single data
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        if (!isset($data['measured_at'])) {
            $data['measured_at'] = now();
        } else {
            $data['measured_at'] = \Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $data['measured_at']);
        }

        $measurement = EnergyMeasurement::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Energy measurement created successfully',
            'data' => $measurement->load('device')
        ], 201);
    }
}


    // Get single measurement
    public function show($id)
    {
        $measurement = EnergyMeasurement::with('device')->find($id);

        if (!$measurement) {
            return response()->json([
                'success' => false,
                'message' => 'Energy measurement not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $measurement
        ]);
    }

    // Update measurement
    public function update(Request $request, $id)
    {
        $measurement = EnergyMeasurement::find($id);

        if (!$measurement) {
            return response()->json([
                'success' => false,
                'message' => 'Energy measurement not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'device_id' => 'sometimes|required|exists:devices,id',
            'voltage' => 'sometimes|required|numeric',
            'current' => 'sometimes|required|numeric',
            'power' => 'sometimes|required|numeric',
            'energy' => 'sometimes|required|numeric',
            'frequency' => 'sometimes|numeric|nullable',
            'power_factor' => 'sometimes|numeric|nullable|between:0,1',
            'temperature' => 'sometimes|numeric|nullable',
            'humidity' => 'sometimes|numeric|nullable|between:0,100',
            'measured_at' => 'sometimes|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $measurement->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Energy measurement updated successfully',
            'data' => $measurement->load('device')
        ]);
    }

    // Delete measurement
    public function destroy($id)
    {
        $measurement = EnergyMeasurement::find($id);

        if (!$measurement) {
            return response()->json([
                'success' => false,
                'message' => 'Energy measurement not found',
            ], 404);
        }

        $measurement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Energy measurement deleted successfully',
        ]);
    }

    // Get latest measurements for a device
    public function latest($deviceId)
    {
        $device = Device::find($deviceId);

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found',
            ], 404);
        }

        $measurement = EnergyMeasurement::where('device_id', $deviceId)
            ->orderBy('measured_at', 'desc')
            ->first();

        return response()->json([
            'success' => true,
            'data' => $measurement
        ]);
    }

    // Get measurements statistics for a device
    public function statistics($deviceId)
    {
        $device = Device::find($deviceId);

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found',
            ], 404);
        }

        $stats = EnergyMeasurement::where('device_id', $deviceId)
            ->selectRaw('
                AVG(voltage) as avg_voltage,
                AVG(current) as avg_current,
                SUM(power) as total_power,
                SUM(energy) as total_energy,
                MAX(power) as peak_power,
                MIN(power) as min_power,
                COUNT(*) as measurement_count
            ')
            ->first();

        return response()->json([
            'success' => true,
            'data' => [
                'device' => $device,
                'statistics' => $stats
            ]
        ]);
    }
}