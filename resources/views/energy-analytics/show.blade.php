@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-blue-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-blue-800">Device Monitoring: {{ $device->name }}</h1>
                <p class="text-blue-600">Detailed analytics for device {{ $device->device_id }}</p>
            </div>
            <a href="{{ url()->previous() }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
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
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                    @endif
                </div>
                <div class="bg-pink-50 p-4 rounded-lg">
                    <p class="text-xs text-pink-500">Last Updated</p>
                    <p class="text-lg font-semibold text-pink-800">{{ $device->updated_at->diffForHumans() }}</p>
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
                    <p class="text-lg font-semibold text-blue-800">{{ $latestReading->voltage ?? 'N/A' }} V</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-xs text-green-500">Current</p>
                    <p class="text-lg font-semibold text-green-800">{{ $latestReading->current ?? 'N/A' }} A</p>
                </div>
                <div class="bg-amber-50 p-4 rounded-lg">
                    <p class="text-xs text-amber-500">Power</p>
                    <p class="text-lg font-semibold text-amber-800">{{ $latestReading->power ?? 'N/A' }} W</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <p class="text-xs text-purple-500">Energy</p>
                    <p class="text-lg font-semibold text-purple-800">{{ $latestReading->energy ?? 'N/A' }} kWh</p>
                </div>
                <div class="bg-indigo-50 p-4 rounded-lg">
                    <p class="text-xs text-indigo-500">Frequency</p>
                    <p class="text-lg font-semibold text-indigo-800">{{ $latestReading->frequency ?? 'N/A' }} Hz</p>
                </div>
                <div class="bg-red-50 p-4 rounded-lg">
                    <p class="text-xs text-red-500">Power Factor</p>
                    <p class="text-lg font-semibold text-red-800">{{ $latestReading->power_factor ?? 'N/A' }}</p>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <p class="text-xs text-yellow-500">Temperature</p>
                    <p class="text-lg font-semibold text-yellow-800">{{ $latestReading->temperature ?? 'N/A' }} °C</p>
                </div>
                <div class="bg-teal-50 p-4 rounded-lg">
                    <p class="text-xs text-teal-500">Humidity</p>
                    <p class="text-lg font-semibold text-teal-800">{{ $latestReading->humidity ?? 'N/A' }}%</p>
                </div>
            </div>
            <div class="px-6 pb-4 text-sm text-gray-500">
Last measured: {{ $latestReading ? $latestReading->measured_at->format('Y-m-d H:i:s') : 'N/A' }}
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
                                <p class="text-lg font-semibold text-blue-800">{{ $latestReading->power ?? '0' }} W</p>
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
                                <p class="text-lg font-semibold text-green-800">{{ $avgDailyPower ?? '0' }} W</p>
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
                                <p class="text-lg font-semibold text-amber-800">{{ $peakPowerToday ?? '0' }} W</p>
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
                                <p class="text-lg font-semibold text-purple-800">{{ $energyToday ?? '0' }} kWh</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Energy Prediction Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fas fa-chart-line mr-2"></i> Energy Usage Prediction
                </h3>
            </div>
            <div class="p-6">
                <div class="flex space-x-4 mb-6">
                    <button id="predictionDayBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg">1 Day Ahead</button>
                    <button id="predictionWeekBtn" class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg">7 Days Ahead</button>
                    <button id="predictionMonthBtn" class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg">1 Month Ahead</button>
                </div>
                <div class="h-80">
                    <canvas id="energyPredictionChart" class="w-full h-full"></canvas>
                </div>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-xs text-blue-500">Predicted Usage</p>
                        <p class="text-lg font-semibold text-blue-800">{{ $predictedUsage ?? '0' }} kWh</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="text-xs text-green-500">Cost Estimate</p>
                        <p class="text-lg font-semibold text-green-800">${{ number_format(($predictedUsage ?? 0) * 0.15, 2) }}</p>
                    </div>
                    <div class="bg-amber-50 p-4 rounded-lg">
                        <p class="text-xs text-amber-500">Savings Potential</p>
                        <p class="text-lg font-semibold text-amber-800">Up to {{ $savingsPotential ?? '0' }}%</p>
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
<script>
    // Current Consumption Chart
    const consumptionCtx = document.getElementById('electricCurrentChart').getContext('2d');
    const consumptionChart = new Chart(consumptionCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($consumptionLabels ?? []) !!},
            datasets: [
                {
                    label: 'Power (W)',
                    data: {!! json_encode($consumptionData ?? []) !!},
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'white',
                    pointBorderColor: 'rgba(59, 130, 246, 1)',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 5
                }
            ]
        },
        options: getChartOptions('Power Consumption (W)')
    });

    // Energy Prediction Chart
    const predictionCtx = document.getElementById('energyPredictionChart').getContext('2d');
    const predictionChart = new Chart(predictionCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($predictionLabels ?? []) !!},
            datasets: [
                {
                    label: 'Predicted Energy (kWh)',
                    data: {!! json_encode($predictionData ?? []) !!},
                    borderColor: 'rgba(139, 92, 246, 1)',
                    backgroundColor: 'rgba(139, 92, 246, 0.05)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'white',
                    pointBorderColor: 'rgba(139, 92, 246, 1)',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 5
                },
                {
                    label: 'Historical Average',
                    data: {!! json_encode($historicalData ?? []) !!},
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.05)',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    tension: 0.4,
                    fill: false
                }
            ]
        },
        options: getChartOptions('Energy Prediction (kWh)')
    });

    function getChartOptions(title) {
        return {
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
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y.toFixed(2);
                        }
                    }
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
                        text: title,
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
        };
    }

    // Time period buttons functionality
    document.getElementById('dayBtn').addEventListener('click', function() {
        updateChartTimePeriod('day');
        setActiveButton(this);
    });
    
    document.getElementById('weekBtn').addEventListener('click', function() {
        updateChartTimePeriod('week');
        setActiveButton(this);
    });
    
    document.getElementById('monthBtn').addEventListener('click', function() {
        updateChartTimePeriod('month');
        setActiveButton(this);
    });

    // Prediction period buttons functionality
    document.getElementById('predictionDayBtn').addEventListener('click', function() {
        updatePredictionPeriod('day');
        setActivePredictionButton(this);
    });
    
    document.getElementById('predictionWeekBtn').addEventListener('click', function() {
        updatePredictionPeriod('week');
        setActivePredictionButton(this);
    });
    
    document.getElementById('predictionMonthBtn').addEventListener('click', function() {
        updatePredictionPeriod('month');
        setActivePredictionButton(this);
    });

    function setActiveButton(button) {
        document.querySelectorAll('#dayBtn, #weekBtn, #monthBtn').forEach(btn => {
            btn.classList.remove('bg-blue-400', 'bg-opacity-30', 'text-white');
            btn.classList.add('bg-blue-400', 'bg-opacity-10');
        });
        button.classList.remove('bg-opacity-10');
        button.classList.add('bg-opacity-30');
    }

    function setActivePredictionButton(button) {
        document.querySelectorAll('#predictionDayBtn, #predictionWeekBtn, #predictionMonthBtn').forEach(btn => {
            btn.classList.remove('bg-blue-600', 'text-white');
            btn.classList.add('bg-blue-100', 'text-blue-800');
        });
        button.classList.remove('bg-blue-100', 'text-blue-800');
        button.classList.add('bg-blue-600', 'text-white');
    }

    function updateChartTimePeriod(period) {
        // AJAX call to get new data based on period
        fetch(`/device/{{ $device->id }}/consumption?period=${period}`)
            .then(response => response.json())
            .then(data => {
                consumptionChart.data.labels = data.labels;
                consumptionChart.data.datasets[0].data = data.data;
                consumptionChart.update();
                
                // Update metrics
                document.querySelector('.text-blue-800').textContent = data.currentUsage + ' W';
                document.querySelector('.text-green-800').textContent = data.avgDaily + ' W';
                document.querySelector('.text-amber-800').textContent = data.peakToday + ' W';
                document.querySelector('.text-purple-800').textContent = data.energyToday + ' kWh';
            });
    }

    function updatePredictionPeriod(period) {
        // AJAX call to get new prediction data
        fetch(`/device/{{ $device->id }}/prediction?period=${period}`)
            .then(response => response.json())
            .then(data => {
                predictionChart.data.labels = data.labels;
                predictionChart.data.datasets[0].data = data.prediction;
                predictionChart.data.datasets[1].data = data.historical;
                predictionChart.update();
                
                // Update prediction metrics
                document.querySelectorAll('.text-blue-800')[1].textContent = data.predictedUsage + ' kWh';
                document.querySelector('.text-green-800').textContent = '$' + data.costEstimate;
                document.querySelector('.text-amber-800').textContent = data.savingsPotential + '%';
            });
    }
</script>
@endsection