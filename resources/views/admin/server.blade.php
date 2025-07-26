@extends('layouts.app')

@section('title', 'Server Monitoring Dashboard')

@section('content')
<div class="min-h-screen bg-blue-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-server mr-3 text-blue-500"></i>
                    Server Monitoring Dashboard
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Last updated: {{ now()->format('H:i:s') }}
                </p>
            </div>

            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-500">
                    <i class="fas fa-circle text-green-500 mr-1"></i> System Operational
                </span>
                <button class="inline-flex items-center px-3 py-1 bg-white text-blue-600 border border-blue-200 text-sm font-semibold rounded-lg hover:bg-blue-50 transition duration-200 shadow-sm">
                    <i class="fas fa-sync-alt mr-2"></i> Refresh
                </button>
                {{-- <a href="{{ route('admin.server.export') }}" class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M6 2a1 1 0 00-1 1v2h10V3a1 1 0 00-1-1H6zM4 6v10a2 2 0 002 2h8a2 2 0 002-2V6H4zm4 2h4v2H8V8zm0 4h4v2H8v-2z" />
                    </svg>
                    Export PDF
                </a> --}}
            </div>
        </div>

        <!-- System Health Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 mb-8">
            <!-- CPU Card -->
            <div class="bg-white rounded-xl shadow-sm border border-blue-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-400 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white">
                            <i class="fas fa-microchip mr-2"></i> CPU Usage
                        </h3>
                        <div class="p-2 rounded-full bg-blue-300 bg-opacity-30">
                            <i class="fas fa-tachometer-alt text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="text-center mb-4">
                        <div class="relative w-25 h-25 mx-auto mb-3">
                            <svg class="w-full h-full" viewBox="0 0 36 36">
                                <path d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#e6e6e6" stroke-width="3" stroke-dasharray="100, 100" />
                                <path d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#3b82f6" stroke-width="3" stroke-dasharray="{{ $data['system']['cpu']['usage_percent'] ?? 0 }}, 100" />
                                <text x="18" y="20.5" text-anchor="middle" font-size="5" fill="#3b82f6" font-weight="bold">{{ $data['system']['cpu']['usage_percent'] ?? 0 }}%</text>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-blue-800">CPU Load</h4>
                        <p class="text-sm text-blue-600">{{ $data['system']['cpu']['cores'] ?? 'N/A' }} Cores</p>
                    </div>
                    <div class="grid grid-cols-3 gap-3 text-sm">
                        <div class="bg-blue-50 p-2 rounded-lg text-center">
                            <p class="text-blue-800 font-semibold">{{ isset($data['system']['cpu']['load_1m']) ? number_format($data['system']['cpu']['load_1m'], 2) : 'N/A' }}</p>
                            <p class="text-blue-600 text-xs">1m Load</p>
                        </div>
                        <div class="bg-blue-50 p-2 rounded-lg text-center">
                            <p class="text-blue-800 font-semibold">{{ isset($data['system']['cpu']['load_5m']) ? number_format($data['system']['cpu']['load_5m'], 2) : 'N/A' }}</p>
                            <p class="text-blue-600 text-xs">5m Load</p>
                        </div>
                        <div class="bg-blue-50 p-2 rounded-lg text-center">
                            <p class="text-blue-800 font-semibold">{{ isset($data['system']['cpu']['load_15m']) ? number_format($data['system']['cpu']['load_15m'], 2) : 'N/A' }}</p>
                            <p class="text-blue-600 text-xs">15m Load</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Memory Card -->
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
                    @php
                    $totalMem = $data['system']['memory']['total_mb'] ?? 0;
                    $usedMem = $data['system']['memory']['used_mb'] ?? 0;
                    $memPercent = ($totalMem > 0) ? round(($usedMem / $totalMem) * 100) : 0;
                    @endphp
                    <div class="text-center mb-4">
                        <div class="relative w-25 h-25 mx-auto mb-3">
                            <svg class="w-full h-full" viewBox="0 0 36 36">
                                <path d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#e6e6e6" stroke-width="3" stroke-dasharray="100, 100" />
                                <path d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#f59e0b" stroke-width="3" stroke-dasharray="{{ $memPercent }}, 100" />
                                <text x="18" y="20.5" text-anchor="middle" font-size="5" fill="#f59e0b" font-weight="bold">{{ $memPercent }}%</text>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-amber-800">RAM Usage</h4>
                        <p class="text-sm text-amber-600">{{ $usedMem }} of {{ $totalMem }} MB</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div class="bg-amber-50 p-2 rounded-lg text-center">
                            <p class="text-amber-800 font-semibold">{{ $usedMem }} MB</p>
                            <p class="text-amber-600 text-xs">Used</p>
                        </div>
                        <div class="bg-amber-50 p-2 rounded-lg text-center">
                            <p class="text-amber-800 font-semibold">{{ $data['system']['memory']['free_mb'] ?? 'N/A' }} MB</p>
                            <p class="text-amber-600 text-xs">Free</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Disk Card -->
            <div class="bg-white rounded-xl shadow-sm border border-purple-100 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-purple-400 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white">
                            <i class="fas fa-hdd mr-2"></i> Disk
                        </h3>
                        <div class="p-2 rounded-full bg-purple-300 bg-opacity-30">
                            <i class="fas fa-database text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @if(isset($data['system']['disk']) && count($data['system']['disk']) > 0)
                    @foreach($data['system']['disk'] as $disk)
                    <div class="mb-4">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">{{ $disk['filesystem'] ?? 'Unknown' }}</span>
                            <span class="font-medium">{{ $disk['use_percent'] ?? 0 }}%</span>
                        </div>
                        <div class="progress-bar bg-gray-200">
                            <div class="progress-bar-fill 
                                    {{ ($disk['use_percent'] ?? 0) > 90 ? 'bg-red-500' : 'bg-purple-500' }}" style="width: {{ $disk['use_percent'] ?? 0 }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>{{ $disk['available'] ?? 'N/A' }} free</span>
                            <span>{{ $disk['used'] ?? 'N/A' }} of {{ $disk['size'] ?? 'N/A' }}</span>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="text-center py-4 text-gray-500">
                        <i class="fas fa-exclamation-circle mr-2"></i> No disk information available
                    </div>
                    @endif
                </div>
            </div>

            <!-- System Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-green-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-400 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white">
                            <i class="fas fa-info-circle mr-2"></i> System Info
                        </h3>
                        <div class="p-2 rounded-full bg-green-300 bg-opacity-30">
                            <i class="fas fa-server text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-green-800 font-medium">OS</span>
                            <span class="text-green-600">{{ $data['system']['os'] ?? 'Unknown' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-green-800 font-medium">Uptime</span>
                            <span class="text-green-600">{{ $data['system']['uptime'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-green-800 font-medium">PHP Version</span>
                            <span class="text-green-600">{{ $data['system']['php_version'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-green-800 font-medium">Server Time</span>
                            <span class="text-green-600">{{ $data['timestamp'] ?? now()->format('Y-m-d H:i:s') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Web Server Card -->
            <div class="bg-white rounded-xl shadow-sm border border-indigo-100 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-indigo-400 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white">
                            <i class="fas fa-globe mr-2"></i> Web Server
                        </h3>
                        <div class="p-2 rounded-full bg-indigo-300 bg-opacity-30">
                            <i class="fas fa-globe-europe text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-indigo-800 font-medium">Server Type</span>
                            <span class="text-indigo-600">{{ $data['web_server']['server_type'] ?? 'Unknown' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-indigo-800 font-medium">PHP Version</span>
                            <span class="text-indigo-600">{{ $data['web_server']['php_version'] ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Database Card -->
            <div class="bg-white rounded-xl shadow-sm border border-red-100 overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-red-400 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white">
                            <i class="fas fa-database mr-2"></i> Database
                        </h3>
                        <div class="p-2 rounded-full bg-red-300 bg-opacity-30">
                            <i class="fas fa-database text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-red-800 font-medium">Driver</span>
                            <span class="text-red-600">{{ $data['database']['driver'] ?? 'Unknown' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-red-800 font-medium">Status</span>
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ ($data['database']['status'] ?? 'error') === 'ok' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $data['database']['status'] ?? 'error' }}
                            </span>
                        </div>
                        @if(isset($data['database']['error']))
                        <div class="flex items-center justify-between">
                            <span class="text-red-800 font-medium">Error</span>
                            <span class="text-red-600">{{ $data['database']['error'] }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Application Card -->
            <div class="bg-white rounded-xl shadow-sm border border-purple-100 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-purple-400 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white">
                            <i class="fas fa-code mr-2"></i> Application
                        </h3>
                        <div class="p-2 rounded-full bg-purple-300 bg-opacity-30">
                            <i class="fas fa-laptop-code text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-purple-50 p-3 rounded-lg text-center">
                            <div class="text-xs text-purple-500">Memory Usage</div>
                            <div class="text-xl font-bold text-purple-800 mt-1">
                                {{ isset($data['application']['performance']['memory_usage']) ? formatBytes($data['application']['performance']['memory_usage']) : 'N/A' }}
                            </div>
                        </div>
                        <div class="bg-purple-50 p-3 rounded-lg text-center">
                            <div class="text-xs text-purple-500">Total Users</div>
                            <div class="text-xl font-bold text-purple-800 mt-1">
                                {{ $data['application']['business']['users'] ?? 0 }}
                            </div>
                        </div>
                        <div class="bg-purple-50 p-3 rounded-lg text-center">
                            <div class="text-xs text-purple-500">Active Users</div>
                            <div class="text-xl font-bold text-purple-800 mt-1">
                                {{ $data['application']['business']['active_users'] ?? 0 }}
                            </div>
                        </div>
                        <div class="bg-purple-50 p-3 rounded-lg text-center">
                            <div class="text-xs text-purple-500">Response Time</div>
                            <div class="text-xl font-bold text-purple-800 mt-1">
                                {{ isset($data['application']['performance']['response_time']) ? round($data['application']['performance']['response_time'], 2).'s' : round(microtime(true) - LARAVEL_START, 2).'s' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Third Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Errors Card -->
            <div class="bg-white rounded-xl shadow-sm border border-red-100 overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-red-400 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white">
                            <i class="fas fa-exclamation-triangle mr-2"></i> Errors
                        </h3>
                        <div class="p-2 rounded-full bg-red-300 bg-opacity-30">
                            <i class="fas fa-bug text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-red-50 p-4 rounded-lg text-center">
                            <div class="text-3xl font-bold text-red-600">
                                {{ $data['errors']['errors']['total'] ?? 0 }}
                            </div>
                            <div class="text-sm text-red-500 mt-1">Total Errors</div>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg text-center">
                            <div class="text-3xl font-bold text-red-600">
                                {{ $data['errors']['errors']['last_24h'] ?? 0 }}
                            </div>
                            <div class="text-sm text-red-500 mt-1">Last 24h</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Card -->
            <div class="bg-white rounded-xl shadow-sm border border-blue-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-400 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white">
                            <i class="fas fa-shield-alt mr-2"></i> Security
                        </h3>
                        <div class="p-2 rounded-full bg-blue-300 bg-opacity-30">
                            <i class="fas fa-lock text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="bg-blue-50 p-4 rounded-lg text-center">
                        <div class="text-3xl font-bold text-blue-600">
                            {{ $data['errors']['security']['failed_logins'] ?? 0 }}
                        </div>
                        <div class="text-sm text-blue-500 mt-1">Failed Logins (24h)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-refresh every 60 seconds
    setTimeout(function() {
        window.location.reload();
    }, 60000);

</script>
@endpush

@endsection
