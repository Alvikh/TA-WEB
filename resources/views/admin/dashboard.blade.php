@extends('layouts.app')
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
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
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div class="bg-blue-50 p-2 rounded-lg">
                            <p class="text-blue-500">Role</p>
                            <p class="text-blue-800 font-medium capitalize">{{ auth()->user()->role }}</p>
                        </div>
                        <div class="bg-blue-50 p-2 rounded-lg">
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
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" 
                                      fill="none" stroke="#e6e6e6" stroke-width="3" stroke-dasharray="100, 100" />
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" 
                                      fill="none" stroke="#0ea5e9" stroke-width="3" stroke-dasharray="{{ $deviceOnlinePercentage }}, 100" />
                                <text x="18" y="20.5" text-anchor="middle" font-size="10" fill="#0ea5e9" font-weight="bold">
                                    {{ $deviceOnlinePercentage }}%
                                </text>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-sky-800">Devices Online</h4>
                        <p class="text-sm text-sky-600">{{ $activeDevices }} of {{ $totalDevices }} active</p>
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

                <!-- Device ID Card -->
<div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium text-blue-800 flex items-center">
            <i class="fas fa-id-card-alt text-blue-500 mr-2"></i> Device Information
        </h3>
        <!-- Tombol Show Device -->
        <a href="#" id="show-device-btn"
           class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
            <i class="fas fa-eye mr-2"></i> Show Device
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-blue-500 uppercase tracking-wider">Device ID</p>
                    <p class="text-2xl font-semibold text-blue-800 mt-1">
                        <span id="device-id-value">--</span>
                    </p>
                </div>
                <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-fingerprint"></i>
                </div>
            </div>
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
                                        <p class="text-2xl font-bold text-blue-800"><span id="suhu-value">--</span> °C</p>
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
                                        <p class="text-2xl font-bold text-blue-800"><span id="kelembapan-value">--</span> %</p>
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
                                        <p class="text-2xl font-bold text-blue-800"><span id="tegangan-value">--</span> V</p>
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
                                        <p class="text-2xl font-bold text-blue-800"><span id="arus-value">--</span> A</p>
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
                                        <p class="text-2xl font-bold text-blue-800"><span id="daya-value">--</span> W</p>
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
                                        <p class="text-2xl font-bold text-blue-800"><span id="energi-value">--</span> kWh</p>
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
        <div class="p-6">

        <!-- MQTT Broker Info -->
        <div class="bg-white rounded-2xl shadow-sm border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-700 to-blue-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">
                        <i class="fas fa-server mr-2"></i> MQTT Broker Configuration
                    </h3>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-200 text-blue-800">
                           <i class="fas fa-info-circle mr-1"></i> wss://broker.hivemq.com:8884/mqtt

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
    <span class="ml-auto font-medium text-blue-800">wss://broker.hivemq.com:8884/mqtt</span>
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
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 mr-2">
                                    <i class="fas fa-chart-line mr-1"></i> iot/monitoring
                                </span>
                                <span class="ml-auto text-blue-600">Primary data channel</span>
                            </li>
                            <li class="flex items-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mr-2">
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

<script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const clientId = 'monitoring_' + Math.random().toString(16).substr(2, 8);
        const options = {
            clientId: clientId,
            clean: true,
            connectTimeout: 4000,
            reconnectPeriod: 1000,
            protocol: 'wss'
        };

        let client = null;
        const topic = 'iot/monitoring';

        const connectBtn = document.getElementById('connect-btn');
        const disconnectBtn = document.getElementById('disconnect-btn');
        const connectionStatus = document.getElementById('connection-status');
        const connectionText = document.getElementById('connection-text');
        const messageLog = document.getElementById('message-log');
        const clearLogBtn = document.getElementById('clear-log');

        clearLogBtn.addEventListener('click', function() {
            messageLog.innerHTML = '<div class="text-gray-400 italic">Log cleared</div>';
        });

        connectBtn.addEventListener('click', function() {
            client = mqtt.connect('wss://broker.hivemq.com:8884/mqtt', options);

            client.on('connect', function() {
                connectionStatus.classList.remove('bg-gray-300', 'bg-red-500', 'bg-yellow-500');
                connectionStatus.classList.add('bg-green-500');
                connectionText.textContent = 'Connected';
                connectBtn.disabled = true;
                disconnectBtn.disabled = false;

                client.subscribe(topic, { qos: 0 }, function(err) {
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

                    updateSensorData(data);

                    addToLog(`[${timestamp}] ${topic}: ${message.toString()}`, 'message');

                    fetch('/monitoring', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                        },
                        body: JSON.stringify({
                            device_id: 1,
                            voltage: data.voltage,
                            current: data.current,
                            power: data.power,
                            energy: data.energy,
                            temperature: data.temperature,
                            humidity: data.humidity,
                            measured_at: data.measured_at
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
                connectionStatus.classList.remove('bg-green-500');
                connectionStatus.classList.add('bg-red-500');
                connectionText.textContent = 'Connection error';
                addToLog('Error: ' + err.message, 'error');
            });

            client.on('close', function() {
                connectionStatus.classList.remove('bg-green-500', 'bg-red-500', 'bg-yellow-500');
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

        disconnectBtn.addEventListener('click', function() {
            if (client) {
                client.end();
                addToLog('Manual disconnect triggered', 'warning');
            }
        });

        function updateSensorData(data) {
            const updateValue = (id, value) => {
                const el = document.getElementById(id);
                if (el && value !== undefined) {
                    const val = typeof value === 'number' ? value.toFixed(2) : value;
                    el.textContent = val;
                    el.classList.add('animate-pulse');
                    setTimeout(() => el.classList.remove('animate-pulse'), 500);
                }
            };

            updateValue('device-id-value', data.id ?? '--');
            updateValue('suhu-value', data.temperature ?? '--');
            updateValue('kelembapan-value', data.humidity ?? '--');
            updateValue('tegangan-value', data.voltage ?? '--');
            updateValue('arus-value', data.current ?? '--');
            updateValue('daya-value', data.power ?? '--');
            updateValue('energi-value', data.energy ?? '--');
            if (data.id && data.id !== '--') {
        const showDeviceBtn = document.getElementById('show-device-btn');
        showDeviceBtn.href = `/devices/analytics/monitor/${data.id}`;
    }
        }

        function addToLog(message, type = 'info') {
            const logEntry = document.createElement('div');
            const timestamp = new Date().toLocaleTimeString();

            if (messageLog.firstChild?.classList?.contains('italic')) {
                messageLog.removeChild(messageLog.firstChild);
            }

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

        // ✅ Auto-connect saat halaman dimuat
        addToLog('Auto connecting to MQTT broker...', 'info');
        connectBtn.click();
    });
</script>
@endsection