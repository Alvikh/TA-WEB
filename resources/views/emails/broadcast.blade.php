@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-blue-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-blue-800">Broadcast Email</h1>
                <p class="text-sm text-blue-600">Send important information or announcements directly to users' emails</p>
            </div>
        </div>

<div class="container mx-auto px-4">
    <!-- Broadcast to All Users Section -->
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Broadcast Email to All Users</h2>
        </div>
        
        <div class="p-6">
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('broadcast.send') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="text" value="📢 Informasi Penting dari Smart Power Management" readonly
                               class="flex-1 block w-full rounded-md bg-gray-100 border-gray-300 p-3 border text-gray-700 focus:ring-blue-500 focus:border-blue-500">
                        <input type="hidden" name="subject" value="📢 Informasi Penting dari Smart Power Management">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                    <div class="mt-1">
                        <textarea name="message" id="message" rows="8"
                                  class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border border-gray-300 rounded-md p-3">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                        Send Broadcast
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Broadcast to Selected Users Section -->
    <div class="max-w-4xl mx-auto mt-12 bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-green-800 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Broadcast Email to Selected Users</h2>
        </div>
        
        <div class="p-6">
            <form action="{{ route('broadcast.send.selected') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="user-search" class="block text-sm font-medium text-gray-700 mb-2">Search Users</label>
                    <div class="relative mt-1">
                        <input type="text" id="user-search" placeholder="Search by name or email..."
                               class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md p-2.5 mb-2">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <label for="users" class="block text-sm font-medium text-gray-700 mb-2">Select Users</label>
                    <div class="mt-1">
                        <select name="users[]" id="users" multiple
                                class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md h-48 user-select">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" data-search="{{ strtolower($user->name.' '.$user->email) }}">
                                    {{ $user->name }} &lt;{{ $user->email }}&gt;
                                </option>
                            @endforeach
                        </select>
                        @error('users')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Hold Ctrl/Cmd to select multiple users</p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="text" value="📢 Informasi Penting dari Smart Power Management" readonly
                               class="flex-1 block w-full rounded-md bg-gray-100 border-gray-300 p-3 border text-gray-700 focus:ring-green-500 focus:border-green-500">
                        <input type="hidden" name="subject" value="📢 Informasi Penting dari Smart Power Management">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="message_selected" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                    <div class="mt-1">
                        <textarea name="message" id="message_selected" rows="8"
                                  class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border border-gray-300 rounded-md p-3">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                        <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                        Send to Selected Users
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Style for selected options in the multi-select */
    select option:checked {
        background-color: #05966920; /* green-600 with opacity */
        color: #065F46; /* green-800 */
        font-weight: 500;
    }
    
    /* Better scrollbar styling */
    select::-webkit-scrollbar {
        width: 8px;
    }
    
    select::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    select::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 4px;
    }
    
    select::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userSearch = document.getElementById('user-search');
    const userSelect = document.getElementById('users');
    
    userSearch.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const options = userSelect.options;
        
        for (let i = 0; i < options.length; i++) {
            const option = options[i];
            const searchText = option.getAttribute('data-search');
            
            if (searchText.includes(searchTerm)) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        }
    });
    
    // Keep selected options visible when searching
    userSelect.addEventListener('change', function() {
        const options = this.options;
        for (let i = 0; i < options.length; i++) {
            if (options[i].selected) {
                options[i].style.display = '';
            }
        }
    });
});
</script>
@endsection