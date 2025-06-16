@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="min-h-screen bg-blue-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-blue-800">Dashboard Overview</h1>
                <p class="text-sm text-blue-600">Welcome back, {{ auth()->user()->name }} <span class="text-blue-400">•</span> {{ now()->format('l, F j, Y') }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="inline-flex items-center px-4 py-2 bg-white text-blue-600 border border-blue-200 text-sm font-semibold rounded-xl hover:bg-blue-50 transition duration-200 shadow-sm">
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
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-cyan-100 text-cyan-600 mb-3">
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
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 text-indigo-600 mb-3">
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
                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none"
                                    stroke="#e6e6e6"
                                    stroke-width="3"
                                    stroke-dasharray="100, 100"
                                />
                                <path d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none"
                                    stroke="#0ea5e9"
                                    stroke-width="3"
                                    stroke-dasharray="{{ $deviceOnlinePercentage }}, 100"
                                />
                                <text x="18" y="20.5" text-anchor="middle" font-size="10" fill="#0ea5e9" font-weight="bold">{{ $deviceOnlinePercentage }}%</text>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-sky-800">Devices Online</h4>
                        <p class="text-sm text-sky-600">{{ $activeDevices }} of {{ $totalDevices }} active</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- <!-- Chart Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">
                        <i class="fas fa-bolt mr-2"></i> Electricity Consumption
                    </h3>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 bg-blue-400 bg-opacity-30 text-white text-xs rounded-lg hover:bg-opacity-50 transition">Day</button>
                        <button class="px-3 py-1 bg-blue-400 bg-opacity-10 text-white text-xs rounded-lg hover:bg-opacity-30 transition">Week</button>
                        <button class="px-3 py-1 bg-blue-400 bg-opacity-10 text-white text-xs rounded-lg hover:bg-opacity-30 transition">Month</button>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="h-80">
                    <canvas id="electricCurrentChart" class="w-full h-full"></canvas>
                </div>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-2 rounded-full bg-blue-100 text-blue-600 mr-3">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <div>
                                <p class="text-xs text-blue-500">Current Usage</p>
                                <p class="text-lg font-semibold text-blue-800">15.2 A</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-2 rounded-full bg-green-100 text-green-600 mr-3">
                                <i class="fas fa-arrow-down"></i>
                            </div>
                            <div>
                                <p class="text-xs text-green-500">Avg. Daily</p>
                                <p class="text-lg font-semibold text-green-800">12.4 A</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-amber-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-2 rounded-full bg-amber-100 text-amber-600 mr-3">
                                <i class="fas fa-arrow-up"></i>
                            </div>
                            <div>
                                <p class="text-xs text-amber-500">Peak Today</p>
                                <p class="text-lg font-semibold text-amber-800">18.7 A</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-2 rounded-full bg-purple-100 text-purple-600 mr-3">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <p class="text-xs text-purple-500">Forecast</p>
                                <p class="text-lg font-semibold text-purple-800">14.3 A</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- MQTT Broker Info -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-blue-100 overflow-hidden lg:col-span-2">
                <div class="bg-gradient-to-r from-blue-700 to-blue-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white">
                            <i class="fas fa-server mr-2"></i> MQTT Broker
                        </h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $mqttStatus ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                            {{ $mqttStatus ? 'Connected' : 'Disconnected' }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="text-sm font-semibold text-blue-700 mb-3">Broker Details</h4>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-center">
                                    <i class="fas fa-globe text-blue-400 mr-2 w-5"></i>
                                    <span class="text-blue-600">Host:</span>
                                    <span class="ml-auto font-medium text-blue-800">{{ config('mqtt.host') }}</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-plug text-blue-400 mr-2 w-5"></i>
                                    <span class="text-blue-600">Port:</span>
                                    <span class="ml-auto font-medium text-blue-800">{{ config('mqtt.port') }}</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-id-card text-blue-400 mr-2 w-5"></i>
                                    <span class="text-blue-600">Client ID:</span>
                                    <span class="ml-auto font-medium text-blue-800">{{ config('mqtt.client_id') }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="text-sm font-semibold text-blue-700 mb-3">Activity</h4>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-center">
                                    <i class="fas fa-list text-blue-400 mr-2 w-5"></i>
                                    <span class="text-blue-600">Subscribed Topics:</span>
                                    <span class="ml-auto font-medium text-blue-800">{{ $subscribedTopics }}</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-envelope text-blue-400 mr-2 w-5"></i>
                                    <span class="text-blue-600">Messages Today:</span>
                                    <span class="ml-auto font-medium text-blue-800">{{ $messagesToday }}</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-clock text-blue-400 mr-2 w-5"></i>
                                    <span class="text-blue-600">Last Message:</span>
                                    <span class="ml-auto font-medium text-blue-800">2 min ago</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <h4 class="text-sm font-semibold text-blue-700 mb-3">Recent Messages</h4>
                    <div class="border border-blue-100 rounded-lg overflow-hidden">
                        @if(count($recentMessages) > 0)
                            <table class="min-w-full divide-y divide-blue-100">
                                <thead class="bg-blue-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Topic</th>
                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Message</th>
                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Time</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-blue-100">
                                    @foreach($recentMessages as $message)
                                    <tr class="hover:bg-blue-50 transition">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-blue-800">{{ $message->topic }}</td>
                                        <td class="px-4 py-3 text-sm text-blue-600">{{ Str::limit($message->payload, 30) }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-blue-500">{{ $message->created_at->diffForHumans() }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="p-4 text-center text-sm text-blue-500">
                                No recent messages available
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-sm border border-blue-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">
                        <i class="fas fa-bolt mr-2"></i> Quick Actions
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <button class="w-full flex items-center justify-between p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <span class="text-sm font-medium text-blue-800">Add New Device</span>
                            </div>
                            <i class="fas fa-chevron-right text-blue-400"></i>
                        </button>
                        
                        <button class="w-full flex items-center justify-between p-4 bg-green-50 hover:bg-green-100 rounded-lg transition">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <span class="text-sm font-medium text-green-800">Generate Report</span>
                            </div>
                            <i class="fas fa-chevron-right text-green-400"></i>
                        </button>
                        
                        <button class="w-full flex items-center justify-between p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <span class="text-sm font-medium text-purple-800">System Settings</span>
                            </div>
                            <i class="fas fa-chevron-right text-purple-400"></i>
                        </button>
                        
                        <button class="w-full flex items-center justify-between p-4 bg-amber-50 hover:bg-amber-100 rounded-lg transition">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-amber-100 text-amber-600 mr-4">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <span class="text-sm font-medium text-amber-800">View Alerts</span>
                            </div>
                            <i class="fas fa-chevron-right text-amber-400"></i>
                        </button>
                    </div>
                    
                    <div class="mt-6 border-t border-blue-100 pt-6">
                        <h4 class="text-sm font-semibold text-blue-700 mb-3">System Status</h4>
                        <div class="space-y-3">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-blue-600">Storage</span>
                                    <span class="font-medium text-blue-800">65% used</span>
                                </div>
                                <div class="w-full bg-blue-100 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: 65%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-blue-600">Memory</span>
                                    <span class="font-medium text-blue-800">42% used</span>
                                </div>
                                <div class="w-full bg-blue-100 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: 42%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-blue-600">CPU Load</span>
                                    <span class="font-medium text-blue-800">28% used</span>
                                </div>
                                <div class="w-full bg-blue-100 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: 28%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('electricCurrentChart').getContext('2d');
    const electricCurrentChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($electricCurrentLabels ?? ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '23:59']) !!},
            datasets: [
                {
                    label: 'Current (A)',
                    data: {!! json_encode($electricCurrentData ?? [8.2, 7.5, 12.4, 15.7, 18.2, 14.5, 9.8]) !!},
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'white',
                    pointBorderColor: 'rgba(59, 130, 246, 1)',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Forecast (A)',
                    data: {!! json_encode($electricForecastData ?? [7.8, 8.1, 11.9, 16.2, 17.8, 15.1, 10.2]) !!},
                    borderColor: 'rgba(139, 92, 246, 1)',
                    backgroundColor: 'rgba(139, 92, 246, 0.05)',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    tension: 0.4,
                    fill: false,
                    pointBackgroundColor: 'white',
                    pointBorderColor: 'rgba(139, 92, 246, 1)',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(30, 58, 138, 0.9)',
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    grid: {
                        color: 'rgba(219, 234, 254, 1)'
                    },
                    ticks: {
                        color: 'rgba(30, 64, 175, 0.8)'
                    },
                    title: {
                        display: true,
                        text: 'Ampere (A)',
                        color: 'rgba(30, 64, 175, 0.8)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(219, 234, 254, 1)'
                    },
                    ticks: {
                        color: 'rgba(30, 64, 175, 0.8)'
                    },
                    title: {
                        display: true,
                        text: 'Time',
                        color: 'rgba(30, 64, 175, 0.8)'
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            }
        }
    });
</script> --}}
@endsection