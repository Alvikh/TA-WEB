@props(['title', 'icon' => 'fa-box', 'color' => 'gray'])

@php
$colorClasses = [
    'blue' => 'text-blue-600 bg-blue-100',
    'green' => 'text-green-600 bg-green-100',
    'purple' => 'text-purple-600 bg-purple-100',
    'red' => 'text-red-600 bg-red-100',
    'yellow' => 'text-yellow-600 bg-yellow-100',
    'gray' => 'text-gray-600 bg-gray-100',
];

$iconColor = $colorClasses[$color] ?? $colorClasses['gray'];
@endphp

<div class="bg-white rounded-2xl shadow p-6 space-y-4">
    <div class="flex items-center space-x-3">
        <div class="p-3 rounded-full {{ $iconColor }}">
            <i class="fas {{ $icon }} text-lg"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>
    </div>
    <div>
        {{ $slot }}
    </div>
</div>
