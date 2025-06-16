@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-blue-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-blue-800">Monitoring Energy Analytics</h1>
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
        </div>

<!-- Chart.js Script -->
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
</script>
@endsection