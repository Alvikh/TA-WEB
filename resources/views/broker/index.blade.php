@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
        <!-- Header Section -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-white">MQTT Monitoring Dashboard</h2>
                    <p class="text-sm text-blue-100">Real-time data from IoT devices</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span id="connection-status" class="h-3 w-3 rounded-full bg-gray-300"></span>
                    <span id="connection-text" class="text-sm text-white">Disconnected</span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="p-6 space-y-6">
            <!-- Connection Controls -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Connection Card -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-medium text-blue-800 mb-3 flex items-center">
                        <i class="fas fa-plug text-blue-500 mr-2"></i> Connection Controls
                    </h3>
                    <div class="flex flex-wrap gap-3">
                        <button id="connect-btn" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center">
                            <i class="fas fa-link mr-2"></i> Connect
                        </button>
                        <button id="disconnect-btn" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm font-medium transition-colors flex items-center" disabled>
                            <i class="fas fa-unlink mr-2"></i> Disconnect
                        </button>
                    </div>
                </div>

                <!-- Topic Info Card -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-medium text-blue-800 mb-3 flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i> Topic Information
                    </h3>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-600 w-24">Topic:</span>
                            <span id="topic-name" class="text-sm bg-blue-50 text-blue-700 px-3 py-1 rounded">iot/monitoring</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-600 w-24">QoS Level:</span>
                            <span id="qos-level" class="text-sm bg-blue-50 text-blue-700 px-3 py-1 rounded">0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sensor Data Grid -->
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="text-lg font-medium text-blue-800 mb-4 flex items-center">
                    <i class="fas fa-microchip text-blue-500 mr-2"></i> Sensor Data
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    <!-- Temperature -->
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 transition-all hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-blue-500 uppercase tracking-wider">Temperature</p>
                                <p class="text-2xl font-semibold text-blue-800 mt-1">
                                    <span id="suhu-value">--</span>
                                    <span class="text-sm text-blue-600">°C</span>
                                </p>
                            </div>
                            <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-temperature-high"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Humidity -->
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 transition-all hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-blue-500 uppercase tracking-wider">Humidity</p>
                                <p class="text-2xl font-semibold text-blue-800 mt-1">
                                    <span id="kelembapan-value">--</span>
                                    <span class="text-sm text-blue-600">%</span>
                                </p>
                            </div>
                            <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-tint"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Voltage -->
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 transition-all hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-blue-500 uppercase tracking-wider">Voltage</p>
                                <p class="text-2xl font-semibold text-blue-800 mt-1">
                                    <span id="tegangan-value">--</span>
                                    <span class="text-sm text-blue-600">V</span>
                                </p>
                            </div>
                            <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-bolt"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Current -->
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 transition-all hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-blue-500 uppercase tracking-wider">Current</p>
                                <p class="text-2xl font-semibold text-blue-800 mt-1">
                                    <span id="arus-value">--</span>
                                    <span class="text-sm text-blue-600">A</span>
                                </p>
                            </div>
                            <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-bolt"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Power -->
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 transition-all hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-blue-500 uppercase tracking-wider">Power</p>
                                <p class="text-2xl font-semibold text-blue-800 mt-1">
                                    <span id="daya-value">--</span>
                                    <span class="text-sm text-blue-600">W</span>
                                </p>
                            </div>
                            <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-charging-station"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Energy -->
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 transition-all hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-blue-500 uppercase tracking-wider">Energy</p>
                                <p class="text-2xl font-semibold text-blue-800 mt-1">
                                    <span id="energi-value">--</span>
                                    <span class="text-sm text-blue-600">kWh</span>
                                </p>
                            </div>
                            <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-battery-three-quarters"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message Log -->
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-blue-800 flex items-center">
                        <i class="fas fa-terminal text-blue-500 mr-2"></i> Message Log
                    </h3>
                    <button id="clear-log" class="text-xs text-blue-600 hover:text-blue-800 flex items-center">
                        <i class="fas fa-trash-alt mr-1"></i> Clear Log
                    </button>
                </div>
                <div id="message-log" class="h-64 overflow-y-auto bg-gray-50 border border-gray-200 rounded-lg p-4 space-y-2 text-sm font-mono">
                    <div class="text-gray-400 italic">Waiting for incoming messages...</div>
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
            client = mqtt.connect('mqtt://broker.hivemq.com:1883/mqtt', options);

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
                    
                    // Update UI with sensor data
                    updateSensorData(data);
                    
                    // Log the message
                    addToLog(`[${timestamp}] ${topic}: ${message.toString()}`, 'message');
                    
                    // Send to Laravel backend
                    fetch('/monitoring', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
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