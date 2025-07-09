@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-blue-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-blue-800">Device Monitoring: <span id="device-name">{{ $device->name }}</span></h1>
                <p class="text-blue-600">Detailed analytics for device <span id="device-id">{{ $device->device_id }}</span></p>
            </div>
            <a href="{{ url()->previous() }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <!-- Connection Status Indicator -->
        <div class="flex items-center justify-end space-x-2">
            <span id="connection-status" class="h-3 w-3 rounded-full bg-gray-300"></span>
            <span id="connection-text" class="text-sm text-gray-600">Disconnected</span>
        </div>

        <!-- Device Info Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fas fa-info-circle mr-2"></i> Device Information
                </h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-xs text-blue-500">Device ID</p>
                    <p class="text-lg font-semibold text-blue-800">{{ $device->device_id }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-xs text-green-500">Type</p>
                    <p class="text-lg font-semibold text-green-800">{{ ucfirst($device->type) }}</p>
                </div>
                <div class="bg-amber-50 p-4 rounded-lg">
                    <p class="text-xs text-amber-500">Building</p>
                    <p class="text-lg font-semibold text-amber-800">{{ $device->building }}</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <p class="text-xs text-purple-500">Installation Date</p>
                    <p class="text-lg font-semibold text-purple-800">{{ $device->installation_date->format('Y-m-d') }}</p>
                </div>
                <div class="bg-indigo-50 p-4 rounded-lg">
                    <p class="text-xs text-indigo-500">Status</p>
                    @if($device->status === 'active')
                        <span id="device-status" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                    @else
                        <span id="device-status" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                    @endif
                </div>
                <div class="bg-pink-50 p-4 rounded-lg">
                    <p class="text-xs text-pink-500">Last Updated</p>
                    <p id="last-updated" class="text-lg font-semibold text-pink-800">{{ $device->updated_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>

        <!-- Real-time Metrics Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fas fa-tachometer-alt mr-2"></i> Real-time Metrics
                </h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-xs text-blue-500">Voltage</p>
                    <p class="text-lg font-semibold text-blue-800">
                        <span id="voltage-value">{{ $latestReading->voltage ?? 'N/A' }}</span> V
                    </p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-xs text-green-500">Current</p>
                    <p class="text-lg font-semibold text-green-800">
                        <span id="current-value">{{ $latestReading->current ?? 'N/A' }}</span> A
                    </p>
                </div>
                <div class="bg-amber-50 p-4 rounded-lg">
                    <p class="text-xs text-amber-500">Power</p>
                    <p class="text-lg font-semibold text-amber-800">
                        <span id="power-value">{{ $latestReading->power ?? 'N/A' }}</span> W
                    </p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <p class="text-xs text-purple-500">Energy</p>
                    <p class="text-lg font-semibold text-purple-800">
                        <span id="energy-value">{{ $latestReading->energy ?? 'N/A' }}</span> kWh
                    </p>
                </div>
                <div class="bg-indigo-50 p-4 rounded-lg">
                    <p class="text-xs text-indigo-500">Frequency</p>
                    <p class="text-lg font-semibold text-indigo-800">
                        <span id="frequency-value">{{ $latestReading->frequency ?? 'N/A' }}</span> Hz
                    </p>
                </div>
                <div class="bg-red-50 p-4 rounded-lg">
                    <p class="text-xs text-red-500">Power Factor</p>
                    <p class="text-lg font-semibold text-red-800">
                        <span id="power-factor-value">{{ $latestReading->power_factor ?? 'N/A' }}</span>
                    </p>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <p class="text-xs text-yellow-500">Temperature</p>
                    <p class="text-lg font-semibold text-yellow-800">
                        <span id="temperature-value">{{ $latestReading->temperature ?? 'N/A' }}</span> °C
                    </p>
                </div>
                <div class="bg-teal-50 p-4 rounded-lg">
                    <p class="text-xs text-teal-500">Humidity</p>
                    <p class="text-lg font-semibold text-teal-800">
                        <span id="humidity-value">{{ $latestReading->humidity ?? 'N/A' }}</span>%
                    </p>
                </div>
            </div>
            <div class="px-6 pb-4 text-sm text-gray-500">
                Last measured: <span id="measured-at">{{ $latestReading ? $latestReading->measured_at->format('Y-m-d H:i:s') : 'N/A' }}</span>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">
                        <i class="fas fa-bolt mr-2"></i> Electricity Consumption
                    </h3>
                    <div class="flex space-x-2">
                        <button id="dayBtn" class="px-3 py-1 bg-blue-400 bg-opacity-30 text-white text-xs rounded-lg hover:bg-opacity-50 transition">Day</button>
                        <button id="weekBtn" class="px-3 py-1 bg-blue-400 bg-opacity-10 text-white text-xs rounded-lg hover:bg-opacity-30 transition">Week</button>
                        <button id="monthBtn" class="px-3 py-1 bg-blue-400 bg-opacity-10 text-white text-xs rounded-lg hover:bg-opacity-30 transition">Month</button>
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
                                <p class="text-lg font-semibold text-blue-800">
                                    <span id="current-usage">{{ $latestReading->power ?? '0' }}</span> W
                                </p>
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
                                <p class="text-lg font-semibold text-green-800">
                                    <span id="avg-daily">{{ $avgDailyPower ?? '0' }}</span> W
                                </p>
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
                                <p class="text-lg font-semibold text-amber-800">
                                    <span id="peak-today">{{ $peakPowerToday ?? '0' }}</span> W
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-2 rounded-full bg-purple-100 text-purple-600 mr-3">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <p class="text-xs text-purple-500">Energy Today</p>
                                <p class="text-lg font-semibold text-purple-800">
                                    <span id="energy-today">{{ $energyToday ?? '0' }}</span> kWh
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Energy History Section -->
       <div class="bg-white rounded-2xl shadow-sm border border-blue-100 overflow-hidden">
    <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4">
        <h3 class="text-lg font-semibold text-white">
            <i class="fas fa-history mr-2"></i> Energy Usage History
        </h3>
    </div>
    <div class="p-6">
        <div class="h-80">
            <canvas id="energyHistoryChart" class="w-full h-full"></canvas>
        </div>
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Energy (kWh)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Power (W)</th>
                    </tr>
                </thead>
                <tbody id="energy-history-body" class="bg-white divide-y divide-gray-200">
                    @foreach($predictionData['historical_data'] as $record)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($record['timestamp'])->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ number_format($record['energy'], 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{-- Calculate duration if needed --}}
                            N/A
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ number_format($record['power'], 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

        <!-- Energy Prediction Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fas fa-chart-line mr-2"></i> Energy Consumption Prediction
                </h3>
            </div>
            <div class="p-6">
                <!-- Prediction Visualization -->
                {{-- @if(isset($predictionData['plot_url']))
                <div class="mb-8">
                    <img src="{{ $predictionData['plot_url'] }}" alt="Energy Prediction Chart" class="w-full rounded-lg shadow">
                </div>
                @endif --}}

                <!-- Prediction Summary -->
                <div class="bg-blue-50 rounded-lg p-6 mb-8">
                    <h4 class="text-xl font-bold text-blue-800 mb-4">Prediction Summary</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Prediction Info -->
                        <div class="space-y-4">
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-gray-500 mb-1">Prediction Period</p>
                                <p class="text-lg font-semibold">
                                    {{ \Carbon\Carbon::parse($predictionData['start_date'])->format('M j, Y') }} 
                                    to 
                                    {{ \Carbon\Carbon::parse($predictionData['daily_predictions'][count($predictionData['daily_predictions'])-1]['period'] ?? \Carbon\Carbon::parse($predictionData['start_date'])->addDays($predictionData['num_periods']-1)->format('M j, Y')) }}
                                </p>
                            </div>
                            
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-gray-500 mb-1">Duration Type</p>
                                <p class="text-lg font-semibold capitalize">{{ $predictionData['duration_type'] }}</p>
                            </div>
                            
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-gray-500 mb-1">Number of Periods</p>
                                <p class="text-lg font-semibold">{{ $predictionData['num_periods'] }}</p>
                            </div>
                        </div>
                        
                        <!-- Aggregated Metrics -->
                        <div class="space-y-4">
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-gray-500 mb-1">Total Predicted Consumption</p>
                                <p class="text-lg font-semibold text-blue-600">
                                    @php
                                        $total_kwh = array_reduce($predictionData['daily_predictions'], function($carry, $item) {
                                            return $carry + $item['total_energy_kwh'];
                                        }, 0);
                                    @endphp
                                    {{ number_format($total_kwh, 2) }} kWh
                                </p>
                            </div>
                            
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-gray-500 mb-1">Estimated Cost</p>
                                <p class="text-lg font-semibold text-blue-600">
                                    Rp{{ number_format($total_kwh * 1500, 2) }}
                                </p>
                            </div>
                            
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <p class="text-sm text-gray-500 mb-1">Average Daily Usage</p>
                                <p class="text-lg font-semibold text-blue-600">
                                    @php
                                        $avg_daily = $total_kwh / count($predictionData['daily_predictions']);
                                    @endphp
                                    {{ number_format($avg_daily, 2) }} kWh/day
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Predictions -->
                <div class="space-y-8">
                    <!-- Daily Predictions -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Daily Predictions</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Power (W)</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Energy (kWh)</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estimated Cost</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach(array_slice($predictionData['daily_predictions'], 0, 7) as $day)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $day['period'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($day['average_power_w'], 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($day['total_energy_kwh'], 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp{{ number_format($day['estimated_cost'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Monthly Predictions -->
                    @if(isset($predictionData['monthly_predictions']) && count($predictionData['monthly_predictions']) > 0)
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Monthly Predictions</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Power (W)</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Energy (kWh)</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estimated Cost</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($predictionData['monthly_predictions'] as $month)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $month['period'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($month['average_power_w'], 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($month['total_energy_kwh'], 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp{{ number_format($month['estimated_cost'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Yearly Predictions -->
                    @if(isset($predictionData['yearly_predictions']) && count($predictionData['yearly_predictions']) > 0)
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Yearly Predictions</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Power (W)</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Energy (kWh)</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estimated Cost</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($predictionData['yearly_predictions'] as $year)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $year['period'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($year['average_power_w'], 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($year['total_energy_kwh'], 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp{{ number_format($year['estimated_cost'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Historical Data Comparison -->
                <div class="mt-12 bg-gray-50 p-6 rounded-lg">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Historical Data Comparison</h4>
                    
                    @if(isset($predictionData['historical_data']) && count($predictionData['historical_data']) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timestamp</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Power (W)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Energy (kWh)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Voltage (V)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current (A)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach(array_slice($predictionData['historical_data'], 0, 10) as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record['timestamp'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($record['power'], 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($record['energy'], 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($record['voltage'], 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($record['current'], 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-gray-500">No historical data available for comparison.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment"></script>
<script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
<script>
    // Initialize history chart with prediction data
    const historyCtx = document.getElementById('energyHistoryChart').getContext('2d');
    const historyChart = new Chart(historyCtx, {
        type: 'line',
        data: {
            labels: @json(array_map(function($record) {
                return \Carbon\Carbon::parse($record['timestamp'])->format('d M H:i');
            }, $predictionData['historical_data'])),
            datasets: [
                {
                    label: 'Power (W)',
                    data: @json(array_column($predictionData['historical_data'], 'power')),
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                    borderWidth: 2,
                    tension: 0.4,
                    yAxisID: 'y'
                },
                {
                    label: 'Energy (kWh)',
                    data: @json(array_column($predictionData['historical_data'], 'energy')),
                    borderColor: 'rgba(79, 70, 229, 1)',
                    backgroundColor: 'rgba(79, 70, 229, 0.05)',
                    borderWidth: 2,
                    tension: 0.4,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.dataset.label.includes('Power') ? 
                                    context.parsed.y.toFixed(2) + ' W' : 
                                    context.parsed.y.toFixed(2) + ' kWh';
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Time'
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Power (W)'
                    },
                    beginAtZero: true
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Energy (kWh)'
                    },
                    beginAtZero: true,
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });
</script>
<script>
    // Initialize MQTT connection
    const deviceId = "{{ $device->device_id }}";
    const mqttTopic = `iot/monitoring`;
    let client = null;
    
    // Connect to MQTT broker
    function connectToMQTT() {
        const clientId = 'web_' + Math.random().toString(16).substr(2, 8);
        const options = {
            clientId: clientId,
            clean: true,
            connectTimeout: 4000,
            reconnectPeriod: 1000,
        };

        client = mqtt.connect('wss://broker.hivemq.com:8884/mqtt', options);

        client.on('connect', function() {
            updateConnectionStatus(true);
            console.log('Connected to MQTT broker');
            client.subscribe(mqttTopic, function(err) {
                if (!err) {
                    console.log(`Subscribed to ${mqttTopic}`);
                }
            });
        });

        client.on('message', function(topic, message) {
            try {
                const data = JSON.parse(message.toString());
                if (data.id === deviceId) {
                    updateRealTimeData(data);
                    updateChartData(data);
                }
            } catch (e) {
                console.error('Error parsing MQTT message:', e);
            }
        });

        client.on('error', function(err) {
            console.error('MQTT error:', err);
            updateConnectionStatus(false);
        });

        client.on('close', function() {
            updateConnectionStatus(false);
        });
    }

    // Update connection status UI
    function updateConnectionStatus(connected) {
        const statusElement = document.getElementById('connection-status');
        const textElement = document.getElementById('connection-text');
        
        if (connected) {
            statusElement.classList.remove('bg-gray-300', 'bg-red-500');
            statusElement.classList.add('bg-green-500');
            textElement.textContent = 'Connected';
            textElement.classList.remove('text-gray-600');
            textElement.classList.add('text-green-600');
        } else {
            statusElement.classList.remove('bg-green-500', 'bg-gray-300');
            statusElement.classList.add('bg-red-500');
            textElement.textContent = 'Disconnected';
            textElement.classList.remove('text-green-600');
            textElement.classList.add('text-gray-600');
        }
    }

    // Update real-time data display
    function updateRealTimeData(data) {
        const updateValue = (elementId, value, unit = '') => {
            const element = document.getElementById(elementId);
            if (element) {
                element.textContent = value !== undefined ? value + (unit ? ' ' + unit : '') : 'N/A';
                // Add animation
                element.classList.add('animate-pulse');
                setTimeout(() => element.classList.remove('animate-pulse'), 500);
            }
        };

        updateValue('voltage-value', data.voltage);
        updateValue('current-value', data.current);
        updateValue('power-value', data.power);
        updateValue('energy-value', data.energy);
        updateValue('frequency-value', data.frequency);
        updateValue('power-factor-value', data.power_factor);
        updateValue('temperature-value', data.temperature);
        updateValue('humidity-value', data.humidity);
        updateValue('current-usage', data.power);
        
        if (data.measured_at) {
            const measuredAt = new Date(data.measured_at).toLocaleString();
            document.getElementById('measured-at').textContent = measuredAt;
        }
        
        // Update last updated time
        document.getElementById('last-updated').textContent = 'Just now';
    }

    // Initialize charts
    const consumptionCtx = document.getElementById('electricCurrentChart').getContext('2d');
    const consumptionChart = new Chart(consumptionCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($consumptionLabels ?? []) !!},
            datasets: [{
                label: 'Power (W)',
                data: {!! json_encode($consumptionData ?? []) !!},
                borderColor: 'rgba(59, 130, 246, 1)',
                backgroundColor: 'rgba(59, 130, 246, 0.05)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Power (W)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Time'
                    }
                }
            }
        }
    });

    const historyCtx = document.getElementById('energyHistoryChart').getContext('2d');
    const historyChart = new Chart(historyCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($historyLabels ?? []) !!},
            datasets: [{
                label: 'Energy Usage (kWh)',
                data: {!! json_encode($historyData ?? []) !!},
                backgroundColor: 'rgba(79, 70, 229, 0.7)',
                borderColor: 'rgba(79, 70, 229, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Energy Usage (kWh)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                }
            }
        }
    });

    // Update chart with new data
    function updateChartData(data) {
        // Update consumption chart
        const now = new Date();
        const timeLabel = now.toLocaleTimeString();
        
        // Add new data point (limit to 20 points for performance)
        if (consumptionChart.data.labels.length > 20) {
            consumptionChart.data.labels.shift();
            consumptionChart.data.datasets[0].data.shift();
        }
        
        consumptionChart.data.labels.push(timeLabel);
        consumptionChart.data.datasets[0].data.push(data.power);
        consumptionChart.update();
    }

    // Time period buttons functionality
    document.getElementById('dayBtn').addEventListener('click', function() {
        fetchChartData('day');
        setActiveButton(this);
    });
    
    document.getElementById('weekBtn').addEventListener('click', function() {
        fetchChartData('week');
        setActiveButton(this);
    });
    
    document.getElementById('monthBtn').addEventListener('click', function() {
        fetchChartData('month');
        setActiveButton(this);
    });

    function setActiveButton(button) {
        document.querySelectorAll('#dayBtn, #weekBtn, #monthBtn').forEach(btn => {
            btn.classList.remove('bg-blue-400', 'bg-opacity-30', 'text-white');
            btn.classList.add('bg-blue-400', 'bg-opacity-10');
        });
        button.classList.remove('bg-opacity-10');
        button.classList.add('bg-opacity-30');
    }

    function fetchChartData(period) {
        fetch(`/devices/analytics/{{$device->device_id}}/consumption?period=${period}`)
            .then(response => response.json())
            .then(data => {
                consumptionChart.data.labels = data.labels;
                consumptionChart.data.datasets[0].data = data.data;
                consumptionChart.update();
                
                // Update metrics
                document.getElementById('avg-daily').textContent = data.avgDaily || '0';
                document.getElementById('peak-today').textContent = data.peakToday || '0';
                document.getElementById('energy-today').textContent = data.energyToday || '0';
            });
    }

    // Connect to MQTT when page loads
    document.addEventListener('DOMContentLoaded', function() {
        connectToMQTT();
        
        // Auto-refresh history every 5 minutes
        setInterval(fetchEnergyHistory, 300000);
    });

    // Fetch energy history data
    function fetchEnergyHistory() {
        fetch(`/devices/analytics/{{$device->device_id}}/consumption?period=${period}`)
            .then(response => response.json())
            .then(data => {
                historyChart.data.labels = data.labels;
                historyChart.data.datasets[0].data = data.data;
                historyChart.update();
                
                // Update table
                const tbody = document.getElementById('energy-history-body');
                tbody.innerHTML = data.records.map(record => `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${record.date}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${record.energy.toFixed(2)}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${record.duration}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${record.avg_power.toFixed(2)}</td>
                    </tr>
                `).join('');
            });
    }
</script>

@endsection