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

        // Server statistics
        $serverStats = $this->getServerStats();
$totalMemory = $this->getMemoryTotal();
        return view('admin.dashboard', array_merge([
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
            'memory_total'=> $this->formatBytes($totalMemory),
            'recentMessages' => $recentMessages,
            'memory_usage_percentage' => $totalMemory > 0
    ? round((memory_get_usage(true) / $totalMemory) * 100, 2)
    : 0,
        ], $serverStats));
    }

    protected function getServerStats()
    {
        // Disk usage (works on both Windows and Linux)
        $totalSpace = disk_total_space('/');
        $freeSpace = disk_free_space('/');
        $usedSpace = $totalSpace - $freeSpace;
        $diskUsagePercentage = $totalSpace > 0 ? round(($usedSpace / $totalSpace) * 100) : 0;

        // Memory usage (works everywhere)
        $memoryUsage = memory_get_usage(true);
        $memoryPeak = memory_get_peak_usage(true);
        
        // CPU Load (platform-specific)
        $cpuLoad = $this->getCpuLoad();
        
        // System info
        $systemInfo = [
            'php_version' => phpversion(),
            'laravel_version' => app()->version(),
            'os' => PHP_OS_FAMILY,
        ];

        return [
            'disk_total' => $this->formatBytes($totalSpace),
            'disk_free' => $this->formatBytes($freeSpace),
            'disk_used' => $this->formatBytes($usedSpace),
            'disk_usage_percentage' => $diskUsagePercentage,
            'memory_usage' => $this->formatBytes($memoryUsage),
            'memory_peak' => $this->formatBytes($memoryPeak),
            'cpu_load_1min' => $cpuLoad[0] ?? 0,
            'cpu_load_5min' => $cpuLoad[1] ?? 0,
            'cpu_load_15min' => $cpuLoad[2] ?? 0,
            'system_info' => $systemInfo,
        ];
    }

    protected function getMemoryTotal()
    {
        if (is_readable('/proc/meminfo')) {
            $meminfo = file_get_contents('/proc/meminfo');
            preg_match('/MemTotal:\s+(\d+)\s+kB/', $meminfo, $matches);
            return isset($matches[1]) ? $matches[1] * 1024 : 0;
        }
        return 0;
    }

    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
protected function getCpuLoad()
    {
        if (function_exists('sys_getloadavg')) {
            return sys_getloadavg();
        }

        // Windows fallback
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            try {
                $output = shell_exec('wmic cpu get loadpercentage');
                if ($output) {
                    $load = (int)trim(explode("\n", $output)[1]);
                    return [$load/100, 0, 0]; // Convert to similar format
                }
            } catch (\Exception $e) {
                // Ignore errors
            }
        }

        return [0, 0, 0]; // Default fallback
    }

    // public function sendMqtt()
    // {
    //     $mqtt = new MqttService();
    //     $mqtt->publish('test/topic', 'Hello MQTT from Laravel!');
    //     return 'Message sent!';
    // }
}