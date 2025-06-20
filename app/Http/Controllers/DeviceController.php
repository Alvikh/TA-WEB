<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::latest()->paginate(10);
        return view('devices.index', compact('devices'));
    }

    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'device_id' => 'required|string|max:255|unique:devices',
            'type' => 'required|string|max:255',
            'building' => 'required|string|max:255',
            'installation_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Device::create($validator->validated());

        return redirect()->route('devices.index')
            ->with('success', 'Device berhasil ditambahkan.');
    }

    public function show(Device $device)
    {
        return view('devices.show', compact('device'));
    }

    public function edit(Device $device)
    {
        return view('devices.edit', compact('device'));
    }

    public function update(Request $request, Device $device)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'device_id' => 'required|string|max:255|unique:devices,device_id,' . $device->id,
            'type' => 'required|string|max:255',
            'building' => 'required|string|max:255',
            'installation_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $device->update($validator->validated());

        return redirect()->route('devices.index')
            ->with('success', 'Device berhasil diperbarui.');
    }

    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('devices.index')
            ->with('success', 'Device berhasil dihapus.');
    }

    public function monitor()
{
    $devices = Device::all(); // Atau dengan pagination, tergantung kebutuhan
    return view('devices.monitor', compact('devices'));
}
    public function monitorDevice($id)
{
    $device = Device::find($id)->first();
        $electricCurrentLabels = ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '23:59'];
        $electricCurrentData = [8.2, 7.5, 12.4, 15.7, 18.2, 14.5, 9.8];
        $electricForecastData = [7.8, 8.1, 11.9, 16.2, 17.8, 15.1, 10.2];
        
        return view('devices.monitor_device', [
            'analytics' => $device,
            'electricCurrentLabels' => $electricCurrentLabels,
            'electricCurrentData' => $electricCurrentData,
            'electricForecastData' => $electricForecastData
        ]);}

}
