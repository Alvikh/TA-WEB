<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    // Get all devices
    public function me(Request $request)
    {
        $user = User::find($request->user()->id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
            ], 401);
        }

        $devices = $user->devices;

        return response()->json([
            'success' => true,
            'data' => $devices
        ]);
    }
    public function index(Request $request)
    {
        $devices = Device::query();
        
        // Filter by status if provided
        if ($request->has('status')) {
            $devices->where('status', $request->status);
        }
        
        // Filter by type if provided
        if ($request->has('type')) {
            $devices->where('type', $request->type);
        }
        
        // Filter by building if provided
        if ($request->has('building')) {
            $devices->where('building', $request->building);
        }

        $devices = $devices->get();

        return response()->json([
            'success' => true,
            'data' => $devices
        ]);
    }

    // Create a new device
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'device_id' => 'required|string|unique:devices,device_id',
            'type' => 'required|string',
            'building' => 'required|string',
            'installation_date' => 'required|date',
            'status' => 'required|string|in:active,inactive,maintenance',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $device = Device::create([
            'name' => $request->name,
            'device_id' => $request->device_id,
            'type' => $request->type,
            'building' => $request->building,
            'installation_date' => $request->installation_date,
            'status' => $request->status,
            'owner_id' => Auth::user()->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Device created successfully',
            'data' => $device
        ], 201);
    }

    // Get single device
    public function show($id)
    {
        $device = Device::find($id);

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $device
        ]);
    }

    // Update device
    public function update(Request $request, $id)
    {
           $device = Device::find($id) ?? Device::where('device_id', $id)->first();
return $device;

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'device_id' => 'sometimes|required|string|unique:devices,device_id,'.$id,
            'type' => 'sometimes|required|string',
            'building' => 'sometimes|required|string',
            'installation_date' => 'sometimes|required|date',
            'status' => 'sometimes|required|string|in:active,inactive,maintenance',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $device->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Device updated successfully',
            'data' => $device
        ]);
    }

    // Delete device
    public function destroy($id)
    {
        $device = Device::find($id);

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found',
            ], 404);
        }

        $device->delete();

        return response()->json([
            'success' => true,
            'message' => 'Device deleted successfully',
        ]);
    }

    // Get devices by building
    public function byBuilding($building)
    {
        $devices = Device::where('building', $building)->get();

        return response()->json([
            'success' => true,
            'data' => $devices
        ]);
    }

    // Get devices by status
    public function byStatus($status)
    {
        $validator = Validator::make(['status' => $status], [
            'status' => 'required|string|in:active,inactive,maintenance',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $devices = Device::where('status', $status)->get();

        return response()->json([
            'success' => true,
            'data' => $devices
        ]);
    }
}