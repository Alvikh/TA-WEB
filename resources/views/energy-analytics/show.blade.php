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
                            @foreach($energyHistory as $record)
                            <tr>
                                {{-- {{ dd($record['date']); }} --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record['date'] }}</td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($record['energy'], 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record['duration'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($record['avg_power'], 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
       <div class="bg-white rounded-2xl shadow-sm border border-blue-100 overflow-hidden">
    <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4">
        <h3 class="text-lg font-semibold text-white">
            <i class="fas fa-chart-line mr-2"></i> Energy Consumption Prediction
        </h3>
    </div>
    <div class="p-6">
            <!-- Prediction Chart -->
            
            
            <!-- Prediction Summary -->
            <div class="bg-blue-50 rounded-lg p-4">
                <div class="mb-4">
                    <h4 class="text-lg font-semibold text-blue-800 mb-2">Prediction Summary</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Predicted Period:</span>
                            <span id="prediction-period" class="font-medium">
                                {{ date('M j, Y', strtotime($predictionData['labels'][0])) }} to {{ date('M j, Y', strtotime(end($predictionData['labels']))) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Predicted Consumption:</span>
                            <span id="total-predicted" class="font-medium text-blue-800">
                                {{ number_format($predictionData['aggregates']['total_energy'], 2) }} kWh
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Estimated Cost:</span>
                            <span id="estimated-cost" class="font-medium text-blue-800">
                                Rp{{ number_format($predictionData['aggregates']['estimated_cost'], 2) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Average Daily Usage:</span>
                            <span id="avg-daily-predicted" class="font-medium text-blue-800">
                                {{ number_format($predictionData['aggregates']['average_power'], 2) }} kWh
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Peak Power:</span>
                            <span id="peak-power" class="font-medium text-blue-800">
                                {{ number_format($predictionData['aggregates']['peak_power'], 2) }} kWh
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <label for="prediction-range" class="block text-sm font-medium text-gray-700 mb-2">
                        Prediction Range:
                    </label>
                    <select id="prediction-range" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="7">1 Week</option>
                        <option value="30">1 Month</option>
                        <option value="365">1 Year</option>
                    </select>
                    
                    <button id="update-prediction" class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition">
                        Update Prediction
                    </button>
                </div>
            </div>

        <!-- Daily Averages Table -->
        <div class="mt-6 bg-white rounded-lg border border-gray-200 overflow-hidden">
            <h4 class="text-lg font-semibold text-gray-800 p-4 border-b">Daily Averages</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Average Power (kWh)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Energy (kWh)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peak Power (kWh)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($predictionData['daily_averages'] as $day)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $day['date'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($day['average'], 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($day['total'], 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($day['peak'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Hourly Data Table -->
        <div class="mt-6 bg-white rounded-lg border border-gray-200 overflow-hidden">
            <h4 class="text-lg font-semibold text-gray-800 p-4 border-b">Hourly Data Samples</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Power (kWh)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($predictionData['sampled_hourly_data'] as $hour)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $hour['time'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($hour['power'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
        options: getChartOptions('Power Consumption (W)')
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
        options: getChartOptions('Energy Usage (kWh)', 'bar')
    });

    function getChartOptions(title, type = 'line') {
        const commonOptions = {
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
                        text: title
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Time'
                    }
                }
            }
        };

        if (type === 'line') {
            commonOptions.interaction = {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            };
        }

        return commonOptions;
    }

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