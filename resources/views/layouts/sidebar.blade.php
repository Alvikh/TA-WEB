<aside class="w-64 bg-gradient-to-b from-blue-50 to-blue-100 border-r border-blue-200 flex-shrink-0 shadow-lg">
    <div class="h-full flex flex-col">
        <!-- Logo Section -->
        <div class="px-6 py-5 flex justify-center border-b border-blue-200">
            <img src="/images/LOGO3.png" alt="Logo" class="w-40 h-20 object-contain" />
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 py-6 space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group
                   {{ request()->routeIs('admin.dashboard') ? 'bg-blue-300 text-blue-900 font-semibold border-l-4 border-blue-600' : 'text-blue-800 hover:bg-blue-200 hover:text-blue-900' }}">
                <span class="w-6 h-6 mr-3 flex items-center justify-center
                    {{ request()->is('admin.dashboard') ? 'text-blue-900' : 'text-blue-600 group-hover:text-blue-800' }}">
                    <i class="fas fa-chart-pie text-lg"></i>
                </span>
                <span class="font-medium">Dashboard</span>
            </a>

            <!-- User Management -->
            <a href="{{ route('users.index') }}" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group
                   {{ request()->routeIs('users.index') ? 'bg-blue-300 text-blue-900 font-semibold border-l-4 border-blue-600' : 'text-blue-800 hover:bg-blue-200 hover:text-blue-900' }}">
                <span class="w-6 h-6 mr-3 flex items-center justify-center
                    {{ request()->routeIs('users.index') ? 'text-blue-900' : 'text-blue-600 group-hover:text-blue-800' }}">
                    <i class="fas fa-user-circle text-lg"></i>
                </span>
                <span class="font-medium">User Management</span>
            </a>

            <!-- Device Management -->
            <a href="{{ route('devices.index') }}" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group
                   {{ request()->routeIs('devices.index') ? 'bg-blue-300 text-blue-900 font-semibold border-l-4 border-blue-600' : 'text-blue-800 hover:bg-blue-200 hover:text-blue-900' }}">
                <span class="w-6 h-6 mr-3 flex items-center justify-center
                   {{ request()->routeIs('devices.index') ? 'text-blue-900' : 'text-blue-600 group-hover:text-blue-800' }}">
                    <i class="fas fa-plug text-lg"></i>
                </span>
                <span class="font-medium">Device Management</span>
            </a>

            <!-- MQTT Broker -->
            <a href="{{ route('devices.monitoring') }}" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group
                   {{ request()->routeIs('devices.monitoring') ? 'bg-blue-300 text-blue-900 font-semibold border-l-4 border-blue-600' : 'text-blue-800 hover:bg-blue-200 hover:text-blue-900' }}">
                <span class="w-6 h-6 mr-3 flex items-center justify-center
                   {{ request()->routeIs('devices.monitoring') ? 'text-blue-900' : 'text-blue-600 group-hover:text-blue-800' }}">
                    <i class="fas fa-microchip text-lg"></i>
                </span>
                <span class="font-medium">MQTT Broker</span>
            </a>

            <!-- MQTT Broker -->
            <a href="{{ route('admin.server.monitoring') }}" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group
                   {{ request()->routeIs('admin.server.monitoring') ? 'bg-blue-300 text-blue-900 font-semibold border-l-4 border-blue-600' : 'text-blue-800 hover:bg-blue-200 hover:text-blue-900' }}">
                <span class="w-6 h-6 mr-3 flex items-center justify-center
                   {{ request()->routeIs('admin.server.monitoring') ? 'text-blue-900' : 'text-blue-600 group-hover:text-blue-800' }}">
                    <i class="fas fa-server text-lg"></i>
                </span>
                <span class="font-medium">Server Monitoring</span>
            </a>

            <!-- Report -->
            <a href="" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group
                   {{ request()->routeIs('#') ? 'bg-blue-300 text-blue-900 font-semibold border-l-4 border-blue-600' : 'text-blue-800 hover:bg-blue-200 hover:text-blue-900' }}">
                <span class="w-6 h-6 mr-3 flex items-center justify-center
                   {{ request()->routeIs('#') ? 'text-blue-900' : 'text-blue-600 group-hover:text-blue-800' }}">
                    <i class="fas fa-book text-lg"></i>
                </span>
                <span class="font-medium">Report Management</span>
            </a>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left flex items-center px-4 py-3 rounded-lg transition-all duration-200 group
        {{ request()->routeIs('logout') ? 'bg-blue-300 text-blue-900 font-semibold border-l-4 border-blue-600' : 'text-blue-800 hover:bg-blue-200 hover:text-blue-900' }}">
                    <span class="w-6 h-6 mr-3 flex items-center justify-center
            {{ request()->routeIs('logout') ? 'text-blue-900' : 'text-blue-600 group-hover:text-blue-800' }}">
                        <i class="fas fa-sign-out-alt text-lg"></i>
                    </span>
                    <span class="font-medium">Logout</span>
                </button>
            </form>


        </nav>
    </div>
</aside>
