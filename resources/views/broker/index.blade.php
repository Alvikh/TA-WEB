@extends('layouts.app')

@section('content')
{{-- <div class="max-h-screen bg-gray-50 py-8"> --}}
<div class="max-h-screen max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">MQTT Monitoring Dashboard</h2>
            <p class="text-sm text-gray-600">Real-time data from IoT devices</p>
        </div>

        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Connection Status -->
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-blue-800">Connection Status</h3>
                    <div class="mt-2 flex items-center">
                        <span id="connection-status" class="h-3 w-3 rounded-full bg-gray-400"></span>
                        <span id="connection-text" class="ml-2 text-sm text-gray-700">Disconnected</span>
                    </div>
                    <div class="mt-2">
                        <button id="connect-btn" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">Connect</button>
                        <button id="disconnect-btn" class="ml-2 px-3 py-1 bg-gray-300 text-gray-700 rounded text-sm hover:bg-gray-400" disabled>Disconnect</button>
                    </div>
                </div>

                <!-- Topic Info -->
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-green-800">Topic Information</h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-700"><span class="font-medium">Topic:</span> <span id="topic-name">iot/monitoring</span></p>
                        <p class="text-sm text-gray-700"><span class="font-medium">QoS:</span> <span id="qos-level">0</span></p>
                    </div>
                </div>
            </div>

            <!-- Data Display -->
            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-800">Sensor Data</h3>
                <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white p-3 rounded shadow">
                        <p class="text-sm text-gray-500">Temperature</p>
                        <p class="text-xl font-semibold"><span id="suhu-value">--</span> <span class="text-sm">°C</span></p>
                    </div>
                    <div class="bg-white p-3 rounded shadow">
                        <p class="text-sm text-gray-500">Humidity</p>
                        <p class="text-xl font-semibold"><span id="kelembapan-value">--</span> <span class="text-sm">%</span></p>
                    </div>
                    <div class="bg-white p-3 rounded shadow">
                        <p class="text-sm text-gray-500">Voltage</p>
                        <p class="text-xl font-semibold"><span id="tegangan-value">--</span> <span class="text-sm">V</span></p>
                    </div>
                    <div class="bg-white p-3 rounded shadow">
                        <p class="text-sm text-gray-500">Current</p>
                        <p class="text-xl font-semibold"><span id="arus-value">--</span> <span class="text-sm">A</span></p>
                    </div>
                    <div class="bg-white p-3 rounded shadow">
                        <p class="text-sm text-gray-500">Power</p>
                        <p class="text-xl font-semibold"><span id="daya-value">--</span> <span class="text-sm">W</span></p>
                    </div>
                    <div class="bg-white p-3 rounded shadow">
                        <p class="text-sm text-gray-500">Energy</p>
                        <p class="text-xl font-semibold"><span id="energi-value">--</span> <span class="text-sm">kWh</span></p>
                    </div>
                </div>
            </div>

            <!-- Message Log -->
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-800">Message Log</h3>
                <div class="mt-2 bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div id="message-log" class="h-64 overflow-y-auto p-4 space-y-2 text-sm">
                        <!-- Messages will appear here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- </div> --}}

<script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
<script>
    // MQTT Client Implementation
    document.addEventListener('DOMContentLoaded', function() {
        const clientId = 'monitoring_' + Math.random().toString(16).substr(2, 8);
        const options = {
            username: 'Alvi'
            , clientId: clientId
            , clean: true
            , connectTimeout: 4000
            , reconnectPeriod: 1000
        , };

        let client = null;
        const topic = 'iot/monitoring';

        // DOM Elements
        const connectBtn = document.getElementById('connect-btn');
        const disconnectBtn = document.getElementById('disconnect-btn');
        const connectionStatus = document.getElementById('connection-status');
        const connectionText = document.getElementById('connection-text');
        const messageLog = document.getElementById('message-log');

        // Connect to MQTT
        connectBtn.addEventListener('click', function() {
            const client = mqtt.connect('wss://broker.emqx.io:8084/mqtt', options);

            client.on('connect', function() {
                connectionStatus.classList.remove('bg-gray-400');
                connectionStatus.classList.add('bg-green-500');
                connectionText.textContent = 'Connected';
                connectBtn.disabled = true;
                disconnectBtn.disabled = false;

                client.subscribe(topic, {
                    qos: 0
                }, function(err) {
                    if (!err) {
                        addToLog('Subscribed to topic: ' + topic);
                    }
                });
            });

            client.on('message', function(topic, message) {

                try {
                    addToLog(`[${timestamp}] Topic: ${topic} - ${message.toString()}`);
                    const data = JSON.parse(message.toString());
                    updateSensorData(data);

                    // Send data to Laravel backend
                    fetch('/monitoring', {
                            method: 'POST'
                            , headers: {
                                'Content-Type': 'application/json'
                                , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                            , body: JSON.stringify({
                                device_id: 1, // Set your device ID here or get it from the message
                                voltage: data.tegangan
                                , current: data.arus
                                , power: data.daya
                                , energy: data.energi
                                , temperature: data.suhu
                                , humidity: data.kelembapan
                                , measured_at: `${data.tanggal} ${data.waktu}`
                            })
                        })
                        .then(response => response.json())
                        .then(data => console.log('Measurement stored:', data))
                        .catch(error => console.error('Error storing measurement:', error));

                    const timestamp = new Date().toISOString();
                    addToLog(`[${timestamp}] Topic: ${topic} - ${message.toString()}`);
                } catch (e) {
                    addToLog('Error parsing message: ' + e.message);
                }

            });

            client.on('error', function(err) {
                connectionStatus.classList.remove('bg-green-500');
                connectionStatus.classList.add('bg-red-500');
                connectionText.textContent = 'Connection error';
                addToLog('Error: ' + err.message);
            });

            client.on('close', function() {
                connectionStatus.classList.remove('bg-green-500');
                connectionStatus.classList.add('bg-gray-400');
                connectionText.textContent = 'Disconnected';
                connectBtn.disabled = false;
                disconnectBtn.disabled = true;
                addToLog('Disconnected from broker');
            });

            client.on('reconnect', function() {
                connectionStatus.classList.remove('bg-gray-400');
                connectionStatus.classList.add('bg-yellow-500');
                connectionText.textContent = 'Reconnecting...';
                addToLog('Attempting to reconnect...');
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
            // const updateValue = (id, value) => {
            //     const el = document.getElementById(id);
            //     if (el && value !== undefined) el.innerHTML = value;
            // };
            console.log(data.tegangan);
            // if (data.tanggal) document.getElementById('tanggal-value').innerHTML = data.tanggal;
            // if (data.waktu) document.getElementById('waktu-value').innerHTML = data.waktu;
            document.getElementById('suhu-value').innerHTML = data.suhu ?? 0;
            document.getElementById('kelembapan-value').innerHTML = data.kelembapan ?? 0;
            document.getElementById('tegangan-value').innerHTML = data.tegangan ?? 0;
            document.getElementById('arus-value').innerHTML = data.arus ?? 0;
            document.getElementById('daya-value').innerHTML = data.daya ?? 0;
            document.getElementById('energi-value').innerHTML = data.energi ?? 0;

        }

        // Add message to log
        function addToLog(message) {
            const logEntry = document.createElement('div');
            logEntry.className = 'text-gray-700';
            logEntry.textContent = message;
            messageLog.appendChild(logEntry);
            messageLog.scrollTop = messageLog.scrollHeight;
        }
    });

</script>
@endsection
