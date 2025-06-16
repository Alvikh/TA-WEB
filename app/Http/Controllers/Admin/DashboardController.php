<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Device;
use App\Models\MqttMessage;
use Illuminate\Http\Request;
use App\Services\MqttService;
use App\Models\EnergyMeasurement;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // User statistics
        $totalUsers = User::count();
        $activeUsersToday = User::where('last_login_at', '>=', Carbon::today())->count();
        $newUsersThisWeek = User::where('created_at', '>=', Carbon::now()->subWeek())->count();

        // Device statistics
        $totalDevices = Device::count();
        $activeDevices = Device::where('status', 'active')->count();
        $maintenanceDevices = Device::where('status', 'maintenance')->count();
        $deviceOnlinePercentage = $totalDevices > 0 ? round(($activeDevices / $totalDevices) * 100) : 0;

        // MQTT statistics
        $mqttStatus = true; // You would check actual connection status here
        $subscribedTopics = 5; // Example value
        $messagesToday = EnergyMeasurement::whereDate('created_at', Carbon::today())->count();
        $recentMessages = EnergyMeasurement::latest()->take(5)->get();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'activeUsersToday' => $activeUsersToday,
            'newUsersThisWeek' => $newUsersThisWeek,
            'totalDevices' => $totalDevices,
            'activeDevices' => $activeDevices,
            'maintenanceDevices' => $maintenanceDevices,
            'deviceOnlinePercentage' => $deviceOnlinePercentage,
            'mqttStatus' => $mqttStatus,
            'subscribedTopics' => $subscribedTopics,
            'messagesToday' => $messagesToday,
            'recentMessages' => $recentMessages,
        ]);
    }

public function sendMqtt()
{
    $mqtt = new MqttService();
    $mqtt->publish('test/topic', 'Hello MQTT from Laravel!');
    return 'Message sent!';
}

}