@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-blue-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fas fa-plus mr-2"></i> {{ isset($energyAnalytic) ? 'Edit' : 'Add' }} Energy Device
                </h3>
            </div>
            <div class="p-6">
                <form action="{{ isset($energyAnalytic) ? route('energy-analytics.update', $energyAnalytic->id) : route('energy-analytics.store') }}" method="POST">
                    @csrf
                    @if(isset($energyAnalytic))
                        @method('PUT')
                    @endif
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Device Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $energyAnalytic->name ?? '') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="device_id" class="block text-sm font-medium text-gray-700">Device ID</label>
                            <input type="text" name="device_id" id="device_id" value="{{ old('device_id', $energyAnalytic->device_id ?? '') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('device_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Device Type</label>
                            <select name="type" id="type" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Type</option>
                                <option value="sensor" {{ old('type', $energyAnalytic->type ?? '') == 'sensor' ? 'selected' : '' }}>Sensor</option>
                                <option value="meter" {{ old('type', $energyAnalytic->type ?? '') == 'meter' ? 'selected' : '' }}>Meter</option>
                                <option value="controller" {{ old('type', $energyAnalytic->type ?? '') == 'controller' ? 'selected' : '' }}>Controller</option>
                            </select>
                            @error('type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="building" class="block text-sm font-medium text-gray-700">Building</label>
                            <input type="text" name="building" id="building" value="{{ old('building', $energyAnalytic->building ?? '') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('building')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="installation_date" class="block text-sm font-medium text-gray-700">Installation Date</label>
                            <input type="date" name="installation_date" id="installation_date" value="{{ old('installation_date', isset($energyAnalytic) ? $energyAnalytic->installation_date->format('Y-m-d') : '') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('installation_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="active" {{ old('status', $energyAnalytic->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $energyAnalytic->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="maintenance" {{ old('status', $energyAnalytic->status ?? '') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('energy-analytics.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ isset($energyAnalytic) ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection