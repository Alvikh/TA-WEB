<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;


class ServerMonitoringControllers extends Controller
{
    public function index()
    {
        $data = [
            'system' => $this->getSystemMetrics(),
            'web_server' => $this->getWebServerMetrics(),
            'database' => $this->getDatabaseMetrics(),
            'application' => $this->getApplicationMetrics(),
            'errors' => $this->getErrorMetrics(),
            'timestamp' => now()->toDateTimeString()
        ];

        return view('admin.server', compact('data'));
    }

    private function getSystemMetrics()
    {
        return [
            'cpu' => $this->getCpuMetrics(),
            'memory' => $this->getMemoryMetrics(),
            'disk' => $this->getDiskMetrics(),
            'network' => $this->getNetworkMetrics(),
            'uptime' => $this->getUptime(),
            'os' => php_uname(),
            'php_version' => phpversion()
        ];
    }

    private function getCpuMetrics()
    {
        if (!function_exists('sys_getloadavg')) {
            return [
                'usage_percent' => 0,
                'load_1m' => 0,
                'load_5m' => 0,
                'load_15m' => 0,
                'cores' => 1
            ];
        }

        $load = sys_getloadavg();
        $cores = (int) shell_exec('nproc') ?? 1;

        return [
            'usage_percent' => $this->getCpuUsage(),
            'load_1m' => $load[0],
            'load_5m' => $load[1],
            'load_15m' => $load[2],
            'cores' => $cores
        ];
    }

    private function getMemoryMetrics()
    {
        if (!function_exists('shell_exec')) {
            return [
                'total_mb' => 0,
                'used_mb' => 0,
                'free_mb' => 0,
                'swap_total_mb' => 0,
                'swap_used_mb' => 0
            ];
        }

        $free = shell_exec('free -m');
        $lines = explode("\n", $free);
        
        if (count($lines) < 2) {
            return [
                'total_mb' => 0,
                'used_mb' => 0,
                'free_mb' => 0,
                'swap_total_mb' => 0,
                'swap_used_mb' => 0
            ];
        }

        $mem = preg_split('/\s+/', $lines[1]);
        $swap = count($lines) > 2 ? preg_split('/\s+/', $lines[2]) : [0, 0, 0];

        return [
            'total_mb' => (int) ($mem[1] ?? 0),
            'used_mb' => (int) ($mem[2] ?? 0),
            'free_mb' => (int) ($mem[3] ?? 0),
            'swap_total_mb' => (int) ($swap[1] ?? 0),
            'swap_used_mb' => (int) ($swap[2] ?? 0)
        ];
    }

    private function getDiskMetrics()
    {
        $disks = [];
        
        if (function_exists('disk_total_space')) {
            $disks[] = [
                'filesystem' => 'local',
                'size' => $this->formatBytes(disk_total_space('/')),
                'used' => $this->formatBytes(disk_total_space('/') - disk_free_space('/')),
                'available' => $this->formatBytes(disk_free_space('/')),
                'use_percent' => round((disk_total_space('/') - disk_free_space('/')) / disk_total_space('/') * 100),
                'mount' => '/'
            ];
        }

        return $disks;
    }

    private function getNetworkMetrics()
    {
        if (!file_exists('/proc/net/dev')) {
            return [];
        }

        $network = file_get_contents('/proc/net/dev');
        $lines = explode("\n", trim($network));
        $interfaces = [];

        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                $parts = preg_split('/\s+/', trim($line));
                $interface = rtrim($parts[0], ':');
                $interfaces[$interface] = [
                    'rx_bytes' => $parts[1] ?? 0,
                    'tx_bytes' => $parts[9] ?? 0
                ];
            }
        }

        return $interfaces;
    }

    private function getUptime()
    {
        if (!file_exists('/proc/uptime')) {
            return 'N/A';
        }

        $uptime = file_get_contents('/proc/uptime');
        $uptime = floatval($uptime);
        
        $days = floor($uptime / 86400);
        $hours = floor(($uptime % 86400) / 3600);
        $minutes = floor(($uptime % 3600) / 60);
        
        return "{$days}d {$hours}h {$minutes}m";
    }

    private function getWebServerMetrics()
    {
        $webServer = strtolower($_SERVER['SERVER_SOFTWARE'] ?? 'unknown');
        
        $metrics = [
            'server_type' => $webServer,
            'php_version' => phpversion(),
        ];

        return $metrics;
    }

    private function getDatabaseMetrics()
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        $metrics = [
            'driver' => $driver,
            'status' => 'ok'
        ];

        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            $metrics['status'] = 'error';
            $metrics['error'] = $e->getMessage();
        }

        return $metrics;
    }

    private function getApplicationMetrics()
    {
        return [
            'performance' => [
                'response_time' => 0, // Will be calculated in view
                'memory_usage' => memory_get_usage(true),
                'memory_peak' => memory_get_peak_usage(true),
            ],
            'business' => [
                'users' => \App\Models\User::count(),
                'active_users' => \App\Models\User::where('last_login_at', '>', now()->subDay())->count(),
            ]
        ];
    }

    private function getErrorMetrics()
    {
        return [
            'errors' => [
                'total' => \App\Models\ErrorLog::count(),
                'last_24h' => \App\Models\ErrorLog::where('created_at', '>', now()->subDay())->count(),
            ],
            'security' => [
                'failed_logins' => \App\Models\LoginAttempt::where('successful', false)
                    ->where('created_at', '>', now()->subDay())
                    ->count(),
            ]
        ];
    }

    private function getCpuUsage()
    {
        if (!file_exists('/proc/stat')) {
            return 0;
        }

        $stat1 = file('/proc/stat');
        usleep(100000); // 0.1 second delay
        $stat2 = file('/proc/stat');

        $info1 = explode(" ", preg_replace("!cpu +!", "", $stat1[0]));
        $info2 = explode(" ", preg_replace("!cpu +!", "", $stat2[0]));

        $dif = [];
        $dif['user'] = $info2[0] - $info1[0];
        $dif['nice'] = $info2[1] - $info1[1];
        $dif['sys'] = $info2[2] - $info1[2];
        $dif['idle'] = $info2[3] - $info1[3];
        $total = array_sum($dif);
        $usage = $total > 0 ? ($total - $dif['idle']) / $total * 100 : 0;

        return round($usage, 2);
    }

    public static function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function exportPDF()
{
    $data = [
        'system' => $this->getSystemMetrics(),
        'web_server' => $this->getWebServerMetrics(),
        'database' => $this->getDatabaseMetrics(),
        'application' => $this->getApplicationMetrics(),
        'errors' => $this->getErrorMetrics(),
        'timestamp' => now()->toDateTimeString()
    ];

    $pdf = Pdf::loadView('exports.server_pdf', compact('data'))->setPaper('a4', 'portrait');
    return $pdf->stream('server-monitoring-' . now()->format('Ymd_His') . '.pdf');
}

}