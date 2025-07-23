@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-blue-50 py-8 px-4 sm:px-6 lg:px-4">
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-blue-800">
                    Device Control: <span id="device-name">{{ $device->name }}</span>
                </h1>
                <p class="text-blue-600">
                    Control panel for device <span id="device-id">{{ $device->device_id }}</span>
                </p>
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
                    <i class="fas fa-tachometer-alt mr-2"></i> Real-time Status
                </h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-xs text-blue-500">Temperature</p>
                    <p class="text-lg font-semibold text-blue-800">
                        <span id="temperature-value">{{ $latestReading->temperature ?? 'N/A' }}</span> °C
                    </p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-xs text-green-500">Humidity</p>
                    <p class="text-lg font-semibold text-green-800">
                        <span id="humidity-value">{{ $latestReading->humidity ?? 'N/A' }}</span>%
                    </p>
                </div>
                <div class="bg-red-50 p-4 rounded-lg">
                    <p class="text-xs text-red-500">Relay State</p>
                    <p class="text-lg font-semibold text-red-800">
                        <span id="relay-state-value">{{ $latestReading->relay_state ?? 'N/A' }}</span>
                    </p>
                </div>
            </div>
            <div class="px-6 pb-4 text-sm text-gray-500">
                Last updated: <span id="measured-at">{{ $latestReading ? $latestReading->timestamp : 'N/A' }}</span>
            </div>
        </div>

        <!-- Control Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fas fa-toggle-on mr-2"></i> Device Control
                </h3>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-center">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-4">Toggle the relay state</p>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="relay-toggle" class="sr-only peer" {{ ($latestReading->relay_state ?? 'OFF') === 'ON' ? 'checked' : '' }}>
                            <div class="w-24 h-12 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-12 peer-checked:after:border-white after:content-[''] after:absolute after:top-[6px] after:left-[6px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-9 after:w-9 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-lg font-medium text-gray-900">
                                <span id="toggle-state">{{ ($latestReading->relay_state ?? 'OFF') === 'ON' ? 'ON' : 'OFF' }}</span>
                            </span>
                        </label>
                        <p class="mt-4 text-xs text-gray-500">Clicking the toggle will send a control command to the device</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- History Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fas fa-history mr-2"></i> State History
                </h3>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timestamp</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Temperature</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Humidity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Relay State</th>
                            </tr>
                        </thead>
                        <tbody id="history-body" class="bg-white divide-y divide-gray-200">
                            @foreach($readings as $reading)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $reading->timestamp }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reading->temperature }} °C</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $reading->humidity }}%</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $reading->relay_state === 'ON' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $reading->relay_state }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MQTT Script -->
<script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
<script>
    // Initialize MQTT connection
    const deviceId = "{{ $device->device_id }}";
    const mqttDataTopic = `smartpower/device/sensor`;
    const mqttControlTopic = `smartpower/device/control`;
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
            client.subscribe(mqttDataTopic, function(err) {
                if (!err) {
                    console.log(`Subscribed to ${mqttDataTopic}`);
                }
            });
        });

        client.on('message', function(topic, message) {
            try {
                const data = JSON.parse(message.toString());
                if (data.id === deviceId) {
                    updateRealTimeData(data);
                    updateHistory(data);
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

        updateValue('temperature-value', data.temperature, '°C');
        updateValue('humidity-value', data.humidity, '%');
        
        // Update relay state
        const relayStateElement = document.getElementById('relay-state-value');
        const toggleStateElement = document.getElementById('toggle-state');
        const toggleElement = document.getElementById('relay-toggle');
        
        if (data.relay_state) {
            relayStateElement.textContent = data.relay_state;
            toggleStateElement.textContent = data.relay_state;
            
            // Update toggle position without triggering change event
            toggleElement.checked = data.relay_state === 'ON';
            
            // Update toggle color
            relayStateElement.className = data.relay_state === 'ON' ? 
                'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800' : 
                'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800';
        }

        if (data.timestamp) {
            const measuredAt = new Date(data.timestamp * 1000).toLocaleString();
            document.getElementById('measured-at').textContent = measuredAt;
        }

        // Update last updated time
        document.getElementById('last-updated').textContent = 'Just now';
    }

    // Update history table
    function updateHistory(data) {
        const tbody = document.getElementById('history-body');
        const newRow = document.createElement('tr');
        
        newRow.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${new Date(data.timestamp * 1000).toLocaleString()}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${data.temperature}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${data.humidity}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${data.relay_state === 'ON' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                    ${data.relay_state}
                </span>
            </td>
        `;
        
        // Add new row at the top
        tbody.insertBefore(newRow, tbody.firstChild);
        
        // Limit to 20 rows
        if (tbody.children.length > 20) {
            tbody.removeChild(tbody.lastChild);
        }
    }

    // Toggle relay state
    document.getElementById('relay-toggle').addEventListener('change', function() {
        const newState = this.checked ? 'ON' : 'OFF';
        
        // Update UI immediately
        document.getElementById('toggle-state').textContent = newState;
        
        // Send MQTT command
        if (client && client.connected) {
            const payload = JSON.stringify({
                id: deviceId,
                action: 'relay_control',
                state: newState
            });
            
            client.publish(mqttControlTopic, payload, { qos: 1 }, function(err) {
                if (err) {
                    console.error('Error publishing message:', err);
                    // Revert toggle if failed
                    this.checked = !this.checked;
                    document.getElementById('toggle-state').textContent = this.checked ? 'ON' : 'OFF';
                } else {
                    console.log('Control command sent:', payload);
                }
            });
        } else {
            alert('Not connected to MQTT broker. Please try again.');
            // Revert toggle if not connected
            this.checked = !this.checked;
            document.getElementById('toggle-state').textContent = this.checked ? 'ON' : 'OFF';
        }
    });

    // Connect to MQTT when page loads
    document.addEventListener('DOMContentLoaded', function() {
        connectToMQTT();
    });

</script>
@endsection