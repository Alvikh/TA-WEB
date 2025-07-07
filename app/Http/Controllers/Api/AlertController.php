<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AlertNotification;
use App\Models\Device;

class AlertController extends Controller
{
    public function sendAlertEmail(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string',  // device_id
            'type' => 'required|string',
            'message' => 'required|string',
            'severity' => 'required|in:low,medium,high,critical'
        ]);

        // Cari device beserta ownernya sekaligus
        $device = Device::with('owner')->find($validated['id']);
        
        if (!$device) {
            return response()->json(['message' => 'Device not found'], 404);
        }

        // Periksa apakah device memiliki owner
        if (!$device->owner) {
            return response()->json(['message' => 'Owner not found for this device'], 404);
        }

        // Kirim email
        Mail::to($device->owner->email)->send(new AlertNotification(
            $validated['type'],
            $validated['message'],
            $validated['severity']
        ));

        return response()->json([
            'message' => 'Alert email sent successfully',
            'to' => $device->owner->email
        ]);
    }
}