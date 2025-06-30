@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Form Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-indigo-700">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-white">Edit Device: {{ $device->name }}</h1>
                    <a href="{{ route('devices.show', $device) }}" class="text-white hover:text-blue-100 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Back to Device
                    </a>
                </div>
            </div>

            <!-- Form Content -->
            <form action="{{ route('devices.update', $device) }}" method="POST" class="p-6 sm:p-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Building Selection -->
                    <div class="sm:col-span-2">
                        <label for="building" class="block text-sm font-medium text-gray-700">Building <span class="text-red-500">*</span></label>
                        <input type="text" name="building" id="building" value="{{ old('building', $device->building) }}" required
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="e.g., Lab RPL">
                        @error('building')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Device Name -->
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Device Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $device->name) }}" required
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="e.g., Main Entrance Sensor">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Device ID -->
                    <div>
                        <label for="device_id" class="block text-sm font-medium text-gray-700">Device ID <span class="text-red-500">*</span></label>
                        <input type="text" name="device_id" id="device_id" value="{{ old('device_id', $device->device_id) }}" required
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Unique device identifier">
                        @error('device_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Device Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Device Type <span class="text-red-500">*</span></label>
                        <select name="type" id="type" required
                            class="mt-1 block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Select Type</option>
                            <option value="sensor" {{ old('type', $device->type) == 'sensor' ? 'selected' : '' }}>Sensor</option>
                            <option value="controller" {{ old('type', $device->type) == 'controller' ? 'selected' : '' }}>Controller</option>
                            <option value="gateway" {{ old('type', $device->type) == 'gateway' ? 'selected' : '' }}>Gateway</option>
                            <option value="meter" {{ old('type', $device->type) == 'meter' ? 'selected' : '' }}>Meter</option>
                        </select>
                        @error('type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Installation Date -->
                    <div>
                        <label for="installation_date" class="block text-sm font-medium text-gray-700">Installation Date</label>
                        <input type="date" name="installation_date" id="installation_date" 
                            value="{{ old('installation_date', $device->installation_date ? $device->installation_date->format('Y-m-d') : '') }}"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('installation_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                        <select name="status" id="status" required
                            class="mt-1 block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="active" {{ old('status', $device->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $device->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="maintenance" {{ old('status', $device->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('devices.show', $device) }}" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Update Device
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection