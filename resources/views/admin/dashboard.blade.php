@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="min-h-screen bg-blue-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Header Section -->
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-blue-800">Dashboard Overview</h1>
                    <p class="text-sm text-blue-600">Welcome back, {{ auth()->user()->name }} <span
                            class="text-blue-400">•</span> {{ now()->format('l, F j, Y') }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="inline-flex items-center px-4 py-2 bg-white text-blue-600 border border-blue-200 text-sm font-semibold rounded-xl hover:bg-blue-50 transition duration-200 shadow-sm">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- User Info Card -->
                <div class="bg-white rounded-xl shadow-sm border border-blue-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-400 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-white">
                                <i class="fas fa-user-circle mr-2"></i> My Account
                            </h3>
                            <div class="p-2 rounded-full bg-blue-300 bg-opacity-30">
                                <i class="fas fa-user text-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-user text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-blue-800">{{ auth()->user()->name }}</h4>
                                <p class="text-sm text-blue-500">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="bg-blue-50 p-3 rounded-lg">
                                <p class="text-blue-500">Role</p>
                                <p class="text-blue-800 font-medium capitalize">{{ auth()->user()->role }}</p>
                            </div>
                            <div class="bg-blue-50 p-3 rounded-lg">
                                <p class="text-blue-500">Last Login</p>
                                <p class="text-blue-800 font-medium">
                                    {{ auth()->user()->last_login_at ? auth()->user()->last_login_at->format('d M Y, H:i') : 'Never' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Users Card -->
                <div class="bg-white rounded-xl shadow-sm border border-blue-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-500 to-cyan-400 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-white">
                                <i class="fas fa-users mr-2"></i> Users
                            </h3>
                            <div class="p-2 rounded-full bg-cyan-300 bg-opacity-30">
                                <i class="fas fa-users text-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="text-center mb-4">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-cyan-100 text-cyan-600 mb-3">
                                <i class="fas fa-users text-2xl"></i>
                            </div>
                            <h4 class="text-3xl font-bold text-cyan-800">{{ $totalUsers }}</h4>
                            <p class="text-sm text-cyan-600">Total Users</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div class="bg-cyan-50 p-2 rounded-lg text-center">
                                <p class="text-cyan-800 font-semibold">{{ $activeUsersToday }}</p>
                                <p class="text-cyan-600 text-xs">Active Today</p>
                            </div>
                            <div class="bg-cyan-50 p-2 rounded-lg text-center">
                                <p class="text-cyan-800 font-semibold">{{ $newUsersThisWeek }}</p>
                                <p class="text-cyan-600 text-xs">New This Week</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Device Info Card -->
                <div class="bg-white rounded-xl shadow-sm border border-blue-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-400 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-white">
                                <i class="fas fa-microchip mr-2"></i> Devices
                            </h3>
                            <div class="p-2 rounded-full bg-indigo-300 bg-opacity-30">
                                <i class="fas fa-plug text-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="text-center mb-4">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 text-indigo-600 mb-3">
                                <i class="fas fa-microchip text-2xl"></i>
                            </div>
                            <h4 class="text-3xl font-bold text-indigo-800">{{ $totalDevices }}</h4>
                            <p class="text-sm text-indigo-600">Total Devices</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div class="bg-indigo-50 p-2 rounded-lg text-center">
                                <p class="text-indigo-800 font-semibold">{{ $activeDevices }}</p>
                                <p class="text-indigo-600 text-xs">Active Now</p>
                            </div>
                            <div class="bg-indigo-50 p-2 rounded-lg text-center">
                                <p class="text-indigo-800 font-semibold">{{ $maintenanceDevices }}</p>
                                <p class="text-indigo-600 text-xs">In Maintenance</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Online Status Card -->
                <div class="bg-white rounded-xl shadow-sm border border-blue-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-sky-500 to-sky-400 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-white">
                                <i class="fas fa-signal mr-2"></i> Online Status
                            </h3>
                            <div class="p-2 rounded-full bg-sky-300 bg-opacity-30">
                                <i class="fas fa-wifi text-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col items-center">
                            <div class="relative w-24 h-24 mb-4">
                                <svg class="w-full h-full" viewBox="0 0 36 36">
                                    <path d="M18 2.0845
                                        a 15.9155 15.9155 0 0 1 0 31.831
                                        a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#e6e6e6" stroke-width="3"
                                        stroke-dasharray="100, 100" />
                                    <path d="M18 2.0845
                                        a 15.9155 15.9155 0 0 1 0 31.831
                                        a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#0ea5e9" stroke-width="3"
                                        stroke-dasharray="{{ $deviceOnlinePercentage }}, 100" />
                                    <text x="18" y="20.5" text-anchor="middle" font-size="10" fill="#0ea5e9"
                                        font-weight="bold">{{ $deviceOnlinePercentage }}%</text>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-sky-800">Devices Online</h4>
                            <p class="text-sm text-sky-600">{{ $activeDevices }} of {{ $totalDevices }} active</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Server Disk Usage Card -->
    <div class="bg-white rounded-xl shadow-sm border border-purple-100 overflow-hidden">
        <div class="bg-gradient-to-r from-purple-500 to-purple-400 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fas fa-hdd mr-2"></i> Disk Usage
                </h3>
                <div class="p-2 rounded-full bg-purple-300 bg-opacity-30">
                    <i class="fas fa-database text-white"></i>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="text-center mb-4">
                <div class="relative w-24 h-24 mx-auto mb-3">
                    <svg class="w-full h-full" viewBox="0 0 36 36">
                        <path d="M18 2.0845
                            a 15.9155 15.9155 0 0 1 0 31.831
                            a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#e6e6e6" stroke-width="3"
                            stroke-dasharray="100, 100" />
                        <path d="M18 2.0845
                            a 15.9155 15.9155 0 0 1 0 31.831
                            a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#8b5cf6" stroke-width="3"
                            stroke-dasharray="{{ $disk_usage_percentage }}, 100" />
                        <text x="18" y="20.5" text-anchor="middle" font-size="10" fill="#8b5cf6"
                            font-weight="bold">{{ $disk_usage_percentage }}%</text>
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-purple-800">Storage</h4>
                <p class="text-sm text-purple-600">{{ $disk_used }} of {{ $disk_total }} used</p>
            </div>
            <div class="bg-purple-50 p-3 rounded-lg text-center">
                <p class="text-purple-800 font-medium">{{ $disk_free }} available</p>
            </div>
        </div>
    </div>

    <!-- Server Memory Usage Card -->
    <div class="bg-white rounded-xl shadow-sm border border-amber-100 overflow-hidden">
        <div class="bg-gradient-to-r from-amber-500 to-amber-400 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fas fa-memory mr-2"></i> Memory
                </h3>
                <div class="p-2 rounded-full bg-amber-300 bg-opacity-30">
                    <i class="fas fa-microchip text-white"></i>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="text-center mb-4">
                <div class="relative w-24 h-24 mx-auto mb-3">
                    <svg class="w-full h-full" viewBox="0 0 36 36">
                        <path d="M18 2.0845
                            a 15.9155 15.9155 0 0 1 0 31.831
                            a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#e6e6e6" stroke-width="3"
                            stroke-dasharray="100, 100" />
                        <path d="M18 2.0845
                            a 15.9155 15.9155 0 0 1 0 31.831
                            a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#f59e0b" stroke-width="3"
                            stroke-dasharray="{{ $memory_usage_percentage }}, 100" />
                        <text x="18" y="20.5" text-anchor="middle" font-size="10" fill="#f59e0b"
                            font-weight="bold">{{ $memory_usage_percentage }}%</text>
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-amber-800">RAM Usage</h4>
                <p class="text-sm text-amber-600">{{ $memory_usage }} of {{ $memory_total }}</p>
            </div>
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div class="bg-amber-50 p-2 rounded-lg text-center">
                    <p class="text-amber-800 font-semibold">{{ $memory_usage }}</p>
                    <p class="text-amber-600 text-xs">Current</p>
                </div>
                <div class="bg-amber-50 p-2 rounded-lg text-center">
                    <p class="text-amber-800 font-semibold">{{ $memory_peak }}</p>
                    <p class="text-amber-600 text-xs">Peak</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CPU Load Card -->
    <div class="bg-white rounded-xl shadow-sm border border-red-100 overflow-hidden">
        <div class="bg-gradient-to-r from-red-500 to-red-400 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fas fa-tachometer-alt mr-2"></i> CPU Load
                </h3>
                <div class="p-2 rounded-full bg-red-300 bg-opacity-30">
                    <i class="fas fa-cog text-white"></i>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="text-center mb-4">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 text-red-600 mb-3">
                    <i class="fas fa-brain text-2xl"></i>
                </div>
                <h4 class="text-3xl font-bold text-red-800">{{ number_format($cpu_load_1min, 2) }}</h4>
                <p class="text-sm text-red-600">1-minute average</p>
            </div>
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div class="bg-red-50 p-2 rounded-lg text-center">
                    <p class="text-red-800 font-semibold">{{ number_format($cpu_load_5min, 2) }}</p>
                    <p class="text-red-600 text-xs">5-minute</p>
                </div>
                <div class="bg-red-50 p-2 rounded-lg text-center">
                    <p class="text-red-800 font-semibold">{{ number_format($cpu_load_15min, 2) }}</p>
                    <p class="text-red-600 text-xs">15-minute</p>
                </div>
            </div>
        </div>
    </div>

    <!-- System Status Card -->
    <div class="bg-white rounded-xl shadow-sm border border-emerald-100 overflow-hidden">
        <div class="bg-gradient-to-r from-emerald-500 to-emerald-400 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fas fa-server mr-2"></i> System Status
                </h3>
                <div class="p-2 rounded-full bg-emerald-300 bg-opacity-30">
                    <i class="fas fa-heartbeat text-white"></i>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-emerald-800 font-medium">Uptime</span>
                    <span class="text-emerald-600">{{ exec('uptime -p') ?: 'N/A' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-emerald-800 font-medium">PHP Version</span>
                    <span class="text-emerald-600">{{ phpversion() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-emerald-800 font-medium">Laravel</span>
                    <span class="text-emerald-600">{{ app()->version() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-emerald-800 font-medium">OS</span>
                    <span class="text-emerald-600">{{ php_uname('s') }} {{ php_uname('r') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

            <!-- MQTT Monitoring Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-blue-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-700 to-blue-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white">
                            <i class="fas fa-chart-line mr-2"></i> Real-time Monitoring
                        </h3>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <span id="connection-status" class="w-3 h-3 rounded-full bg-gray-300 mr-2"></span>
                                <span id="connection-text" class="text-sm text-white">Disconnected</span>
                            </div>
                            <button id="connect-btn"
                                class="px-3 py-1 bg-white bg-opacity-20 text-white text-xs rounded-lg hover:bg-opacity-30 transition">
                                <i class="fas fa-plug mr-1"></i> Connect
                            </button>
                            <button id="disconnect-btn" disabled
                                class="px-3 py-1 bg-white bg-opacity-10 text-white text-xs rounded-lg hover:bg-opacity-20 transition">
                                <i class="fas fa-power-off mr-1"></i> Disconnect
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Sensor Data -->
                        <div class="lg:col-span-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Temperature -->
                                <div class="bg-white border border-blue-100 rounded-lg p-4 shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-blue-500">Temperature</h4>
                                            <p class="text-2xl font-bold text-blue-800"><span id="suhu-value">--</span> °C
                                            </p>
                                        </div>
                                        <div class="p-3 rounded-full bg-red-100 text-red-500">
                                            <i class="fas fa-temperature-high text-xl"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Humidity -->
                                <div class="bg-white border border-blue-100 rounded-lg p-4 shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-blue-500">Humidity</h4>
                                            <p class="text-2xl font-bold text-blue-800"><span
                                                    id="kelembapan-value">--</span> %</p>
                                        </div>
                                        <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                                            <i class="fas fa-tint text-xl"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Voltage -->
                                <div class="bg-white border border-blue-100 rounded-lg p-4 shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-blue-500">Voltage</h4>
                                            <p class="text-2xl font-bold text-blue-800"><span
                                                    id="tegangan-value">--</span> V</p>
                                        </div>
                                        <div class="p-3 rounded-full bg-green-100 text-green-500">
                                            <i class="fas fa-bolt text-xl"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Current -->
                                <div class="bg-white border border-blue-100 rounded-lg p-4 shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-blue-500">Current</h4>
                                            <p class="text-2xl font-bold text-blue-800"><span id="arus-value">--</span> A
                                            </p>
                                        </div>
                                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                                            <i class="fas fa-bolt text-xl"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Power -->
                                <div class="bg-white border border-blue-100 rounded-lg p-4 shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-blue-500">Power</h4>
                                            <p class="text-2xl font-bold text-blue-800"><span id="daya-value">--</span> W
                                            </p>
                                        </div>
                                        <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                                            <i class="fas fa-charging-station text-xl"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Energy -->
                                <div class="bg-white border border-blue-100 rounded-lg p-4 shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-blue-500">Energy</h4>
                                            <p class="text-2xl font-bold text-blue-800"><span id="energi-value">--</span>
                                                kWh</p>
                                        </div>
                                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-500">
                                            <i class="fas fa-battery-full text-xl"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Message Log -->
                        <div class="bg-white border border-blue-100 rounded-lg shadow-sm">
                            <div class="bg-blue-50 px-4 py-3 border-b border-blue-100 flex justify-between items-center">
                                <h4 class="text-sm font-medium text-blue-700">MQTT Message Log</h4>
                                <button id="clear-log" class="text-xs text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-trash-alt mr-1"></i> Clear
                                </button>
                            </div>
                            <div id="message-log" class="h-64 overflow-y-auto p-3 text-sm">
                                <div class="text-gray-400 italic">No messages received yet</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MQTT Broker Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-blue-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-700 to-blue-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white">
                            <i class="fas fa-server mr-2"></i> MQTT Broker Configuration
                        </h3>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-200 text-blue-800">
                            <i class="fas fa-info-circle mr-1"></i> wss://broker.emqx.io:8084/mqtt
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="text-sm font-semibold text-blue-700 mb-3">Connection Settings</h4>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-center">
                                    <i class="fas fa-globe text-blue-400 mr-2 w-5"></i>
                                    <span class="text-blue-600">Broker URL:</span>
                                    <span class="ml-auto font-medium text-blue-800">wss://broker.emqx.io:8084/mqtt</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-user text-blue-400 mr-2 w-5"></i>
                                    <span class="text-blue-600">Username:</span>
                                    <span class="ml-auto font-medium text-blue-800">Alvi</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-key text-blue-400 mr-2 w-5"></i>
                                    <span class="text-blue-600">Password:</span>
                                    <span class="ml-auto font-medium text-blue-800">Not required</span>
                                </li>
                            </ul>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="text-sm font-semibold text-blue-700 mb-3">Monitoring Topics</h4>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-center">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 mr-2">
                                        <i class="fas fa-chart-line mr-1"></i> iot/monitoring
                                    </span>
                                    <span class="ml-auto text-blue-600">Primary data channel</span>
                                </li>
                                <li class="flex items-center">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                                        <i class="fas fa-cog mr-1"></i> iot/controlling
                                    </span>
                                    <span class="ml-auto text-blue-600">Device control channel</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- MQTT.js Library -->
    <script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>

    <!-- MQTT Monitoring Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const clientId = 'monitoring_' + Math.random().toString(16).substr(2, 8);
            const options = {
                username: 'Alvi',
                clientId: clientId,
                clean: true,
                connectTimeout: 4000,
                reconnectPeriod: 1000,
            };

            let client = null;
            const topic = 'iot/monitoring';

            // DOM Elements
            const connectBtn = document.getElementById('connect-btn');
            const disconnectBtn = document.getElementById('disconnect-btn');
            const connectionStatus = document.getElementById('connection-status');
            const connectionText = document.getElementById('connection-text');
            const messageLog = document.getElementById('message-log');
            const clearLogBtn = document.getElementById('clear-log');

            // Clear log button
            clearLogBtn.addEventListener('click', function() {
                messageLog.innerHTML = '<div class="text-gray-400 italic">Log cleared</div>';
            });

            // Connect to MQTT
            connectBtn.addEventListener('click', function() {
                client = mqtt.connect('wss://broker.emqx.io:8084/mqtt', options);

                client.on('connect', function() {
                    connectionStatus.classList.remove('bg-gray-300', 'bg-red-500', 'bg-yellow-500');
                    connectionStatus.classList.add('bg-green-500');
                    connectionText.textContent = 'Connected';
                    connectBtn.disabled = true;
                    disconnectBtn.disabled = false;

                    client.subscribe(topic, {
                        qos: 0
                    }, function(err) {
                        if (!err) {
                            addToLog('Successfully subscribed to: ' + topic, 'success');
                        } else {
                            addToLog('Subscription error: ' + err.message, 'error');
                        }
                    });
                });

                client.on('message', function(topic, message) {
                    try {
                        const timestamp = new Date().toLocaleTimeString();
                        const data = JSON.parse(message.toString());

                        // Update UI with sensor data
                        updateSensorData(data);

                        // Log the message
                        addToLog(`[${timestamp}] ${topic}: ${message.toString()}`, 'message');

                        // Send to Laravel backend
                        fetch('/monitoring', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({
                                    device_id: 1,
                                    voltage: data.tegangan,
                                    current: data.arus,
                                    power: data.daya,
                                    energy: data.energi,
                                    temperature: data.suhu,
                                    humidity: data.kelembapan,
                                    measured_at: `${data.tanggal} ${data.waktu}`
                                })
                            })
                            .then(response => response.json())
                            .then(data => console.log('Measurement stored:', data))
                            .catch(error => console.error('Error storing measurement:', error));

                    } catch (e) {
                        addToLog('Error parsing message: ' + e.message, 'error');
                    }
                });

                client.on('error', function(err) {
                    connectionStatus.classList.remove('bg-green-500', 'bg-gray-300');
                    connectionStatus.classList.add('bg-red-500');
                    connectionText.textContent = 'Connection error';
                    addToLog('Error: ' + err.message, 'error');
                });

                client.on('close', function() {
                    connectionStatus.classList.remove('bg-green-500', 'bg-red-500',
                    'bg-yellow-500');
                    connectionStatus.classList.add('bg-gray-300');
                    connectionText.textContent = 'Disconnected';
                    connectBtn.disabled = false;
                    disconnectBtn.disabled = true;
                    addToLog('Disconnected from broker', 'warning');
                });

                client.on('reconnect', function() {
                    connectionStatus.classList.remove('bg-gray-300');
                    connectionStatus.classList.add('bg-yellow-500');
                    connectionText.textContent = 'Reconnecting...';
                    addToLog('Attempting to reconnect...', 'warning');
                });
            });

            // Disconnect from MQTT
            disconnectBtn.addEventListener('click', function() {
                if (client) {
                    client.end();
                }
            });

            // Update sensor data display
            function updateSensorData(data) {
                const updateValue = (id, value) => {
                    const el = document.getElementById(id);
                    if (el && value !== undefined) {
                        el.textContent = value;
                        // Add animation effect
                        el.classList.add('animate-pulse');
                        setTimeout(() => el.classList.remove('animate-pulse'), 500);
                    }
                };

                updateValue('suhu-value', data.suhu ?? '--');
                updateValue('kelembapan-value', data.kelembapan ?? '--');
                updateValue('tegangan-value', data.tegangan ?? '--');
                updateValue('arus-value', data.arus ?? '--');
                updateValue('daya-value', data.daya ?? '--');
                updateValue('energi-value', data.energi ?? '--');
            }

            // Add message to log with different types
            function addToLog(message, type = 'info') {
                const logEntry = document.createElement('div');
                const timestamp = new Date().toLocaleTimeString();

                // Remove initial placeholder if exists
                if (messageLog.firstChild?.classList?.contains('italic')) {
                    messageLog.removeChild(messageLog.firstChild);
                }

                // Set styling based on message type
                let textColor = 'text-gray-700';
                if (type === 'error') textColor = 'text-red-600';
                if (type === 'success') textColor = 'text-green-600';
                if (type === 'warning') textColor = 'text-yellow-600';
                if (type === 'message') textColor = 'text-blue-600';

                logEntry.className = `${textColor} py-1 border-b border-gray-100 last:border-0`;
                logEntry.innerHTML = `<span class="text-gray-500 text-xs">[${timestamp}]</span> ${message}`;

                messageLog.prepend(logEntry);
                messageLog.scrollTop = 0;
            }
        });
    </script>
@endsection
