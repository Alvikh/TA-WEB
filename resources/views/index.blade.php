<link rel="shortcut icon" href="{{ asset('images/LOGO.png') }}" type="image/png" />
@include('layouts.header')
<body class="text-white">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 bg-gradient-to-r from-blue-800 to-blue-900 shadow-lg">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="{{ asset('images/LOGO.png') }}" alt="Smart Power Management Logo" class="w-[20%] h-[20%] mr-3">
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <!-- Hamburger Button -->
                    <button id="hamburger-button" class="navbar-toggle text-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <!-- Mobile Menu (hidden by default) -->
                <div id="mobile-menu" class="hidden md:hidden fixed inset-0 bg-gray-900 bg-opacity-90 z-50 transition-all duration-300 ease-in-out">
                    <div class="flex justify-end p-4">
                        <button id="close-button" class="mobile-menu-close text-white focus:outline-none">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="nav-link hover:text-blue-300 transition">Home</a>
                    <a href="#services" class="nav-link hover:text-blue-300 transition">Services</a>
                    <a href="#about" class="nav-link hover:text-blue-300 transition">About</a>
                    <a href="#features" class="nav-link hover:text-blue-300 transition">Features</a>
                    {{-- <a href="#contact" class="nav-link hover:text-blue-300 transition">Contact</a> --}}
                    <a href="/login" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-full transition duration-300">
                        Login
                    </a>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="navbar-menu hidden md:hidden">
                <div class="px-2 pt-2 pb-4 space-y-1">
                    <a href="#home" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-700">Home</a>
                    <a href="#services" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-700">Services</a>
                    <a href="#about" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-700">About</a>
                    <a href="#features" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-700">Features</a>
                    {{-- <a href="#contact" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-700">Contact</a> --}}
                    <a href="/login" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-full transition duration-300 mt-2">
                        Admin Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="pt-30 pb-20 px-20">
        <div class="container mx-auto" data-aos="fade-up">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 mb-12 lg:mb-0">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">Smart Energy Prediction with <span class="text-blue-300">IoT Technology</span></h1>
                    <p class="text-xl mb-8 text-blue-100">Smart Power Management helps you monitor, analyze, and predict your electricity consumption with advanced machine learning algorithms.</p>
                </div>
                <div class="lg:w-1/2" data-aos="fade-up">
                    <img src="{{ asset('images/main.png') }}" alt="Smart Power Management Dashboard" class="rounded-lg w-full">
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-blue-900 bg-opacity-30">
        <div class="container mx-auto px-20">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Our <span class="text-blue-300">Smart Services</span></h2>
                <p class="text-xl text-blue-200 max-w-2xl mx-auto">Comprehensive energy management solutions powered by Internet of Things (IoT) dan Machine learning (ML)</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="service-card rounded-xl p-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-blue-300 mb-4">
                        <i class="fas fa-bolt text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Energy Prediction</h3>
                    <p class="text-blue-100 mb-6">Our advanced algorithms predict your future electricity consumption based on historical data and usage patterns, helping you plan and budget effectively.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-300 mr-2"></i>
                            <span>Daily, weekly, and monthly forecasts</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-300 mr-2"></i>
                            <span>Anomaly detection</span>
                        </li>
                    </ul>
                </div>

                <!-- Service 2 -->
                <div class="service-card rounded-xl p-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-blue-300 mb-4">
                        <i class="fas fa-chart-line text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Real-time Monitoring</h3>
                    <p class="text-blue-100 mb-6">Get instant access to your electricity usage data through our IoT-enabled sensors and dashboard, updated in real-time for accurate tracking.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-300 mr-2"></i>
                            <span>Live consumption data</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-300 mr-2"></i>
                            <span>Custom alerts and notifications</span>
                        </li>
                    </ul>
                </div>

                <!-- Service 3 -->
                <div class="service-card rounded-xl p-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-blue-300 mb-4">
                        <i class="fas fa-money-bill-wave text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Cost Optimization</h3>
                    <p class="text-blue-100 mb-6">Receive personalized recommendations to reduce your electricity bills by identifying inefficient appliances and suggesting optimal usage times.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-300 mr-2"></i>
                            <span>Peak/off-peak analysis</span>
                        </li>
                    </ul>
                </div>

                <!-- Service 5 -->
                <div class="service-card rounded-xl p-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-blue-300 mb-4">
                        <i class="fas fa-mobile-alt text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Mobile Access</h3>
                    <p class="text-blue-100 mb-6">Monitor and control your energy usage on the go with our intuitive mobile applications for iOS and Android devices.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-300 mr-2"></i>
                            <span>Push notifications</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-300 mr-2"></i>
                            <span>Remote control</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-300 mr-2"></i>
                            <span>Offline access</span>
                        </li>
                    </ul>
                </div>

                <!-- Service 6 -->
                <div class="service-card rounded-xl p-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-blue-300 mb-4">
                        <i class="fas fa-headset text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Premium Support</h3>
                    <p class="text-blue-100 mb-6">Our dedicated support team is available 24/7 to help you with any questions or issues regarding your energy management system.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-300 mr-2"></i>
                            <span>24/7 technical support</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-300 mr-2"></i>
                            <span>On-site assistance</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-blue-300 mr-2"></i>
                            <span>Regular system updates</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20" data-aos="fade-up">
        <div class="container mx-auto px-20">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">About <span class="text-blue-300">Smart Power Management</span></h2>
                <p class="text-xl text-blue-200 max-w-3xl mx-auto">Innovating energy management through cutting-edge technology</p>
            </div>

            <div class="flex flex-col lg:flex-row items-center mb-20">
                <div class="lg:w-1/2 mb-10 lg:mb-0 lg:pr-10">
                    <p class="text-blue-100 mb-4">Smart Power Management is an intelligent solution for energy management that integrates Internet of Things (IoT) technology and Machine Learning (ML) to help users monitor, control, and optimize electricity consumption efficiently. Through real-time data processing and a data-driven learning system, we enable users to understand energy usage patterns and make more informed decisions.</p>
                    <p class="text-blue-100 mb-4">Through features such as energy consumption prediction, real-time monitoring, cost optimization, and 24/7 technical support, we are here to meet energy needs across various sectors, from households to businesses and industries. Our ML technology continuously analyzes energy usage data to provide accurate recommendations and automatic adjustments according to user needs.</p>
                    <p class="text-blue-100">By using Smart Power Management, you can not only reduce energy waste and lower electricity costs, but also contribute to creating a more efficient and sustainable energy system.</p>
                </div>
                <div class="lg:w-1/2">
                    <img src="{{ asset('images/LOGO.png') }}" alt="SPM" class="rounded-lg shadow-xl w-full">
                </div>
            </div>

            <div class="text-center mb-16">
                <h3 class="text-3xl font-bold mb-6">Our <span class="text-blue-300">Core Values</span></h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
                <div class="feature-card p-8 rounded-xl h-full" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-blue-500 rounded-full p-4 inline-block mb-4">
                        <i class="fas fa-lightbulb text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold mb-3">Innovation</h4>
                    <p class="text-blue-100">We constantly push boundaries to develop smarter, more efficient energy solutions through cutting-edge technology.</p>
                </div>

                <div class="feature-card p-8 rounded-xl h-full" data-aos="fade-up" data-aos-delay="250">
                    <div class="bg-blue-500 rounded-full p-4 inline-block mb-4">
                        <i class="fas fa-shield-alt text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold mb-3">Integrity</h4>
                    <p class="text-blue-100">We maintain the highest ethical standards in our business practices and data handling.</p>
                </div>

                <div class="feature-card p-8 rounded-xl h-full" data-aos="fade-up" data-aos-delay="400">
                    <div class="bg-blue-500 rounded-full p-4 inline-block mb-4">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold mb-3">Customer Focus</h4>
                    <p class="text-blue-100">Our solutions are designed with real user needs in mind, ensuring maximum value and usability.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section (existing content) -->
    <section id="features" class="py-20 bg-blue-900 bg-opacity-30">
        <div class="container mx-auto px-20">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Key <span class="text-blue-300">Features</span></h2>
                <p class="text-xl text-blue-200 max-w-2xl mx-auto">Revolutionizing energy management with Internet of Things (IoT) dan Machine learning (ML)</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="feature-card p-8 rounded-xl h-full">
                    <div class="text-center mb-6">
                        <div class="bg-blue-500 rounded-full p-4 inline-block">
                            <i class="fas fa-chart-pie text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-4">Comprehensive Analytics</h3>
                    <p class="text-center text-blue-100">Detailed insights into your energy consumption patterns with customizable reports and visualizations.</p>
                </div>

                <div class="feature-card p-8 rounded-xl h-full">
                    <div class="text-center mb-6">
                        <div class="bg-blue-500 rounded-full p-4 inline-block">
                            <i class="fas fa-robot text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-4">ML Recommendations</h3>
                    <p class="text-center text-blue-100">Personalized suggestions to optimize your energy usage based on machine learning analysis of your consumption patterns.</p>
                </div>

                <div class="feature-card p-8 rounded-xl h-full">
                    <div class="text-center mb-6">
                        <div class="bg-blue-500 rounded-full p-4 inline-block">
                            <i class="fas fa-bell text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-4">Smart Alerts</h3>
                    <p class="text-center text-blue-100">Get notified about unusual consumption patterns, potential savings, and maintenance needs.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section (existing content) -->
    <section id="how-it-works" class="py-20" data-aos="fade-up">
        <div class="container mx-auto px-20">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">How <span class="text-blue-300">Smart Power Management</span> Works</h2>
                <p class="text-xl text-blue-200 max-w-2xl mx-auto">Simple setup, powerful insights</p>
            </div>

            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 mb-10 lg:mb-0 lg:pr-10">
                    <div class="bg-white bg-opacity-90 text-blue-900 p-8 rounded-xl shadow-lg">
                        <div class="flex mb-6">
                            <div class="mr-4">
                                <div class="bg-blue-500 text-white rounded-full w-10 h-10 flex items-center justify-center">1</div>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold mb-2">Data Collection via IoT Sensors</h4>
                                <p>Smart sensors installed in your environment collect real-time data on energy consumption at the device and system levels. This data is securely transmitted to the cloud for processing.</p>
                            </div>
                        </div>

                        <div class="flex mb-6">
                            <div class="mr-4">
                                <div class="bg-blue-500 text-white rounded-full w-10 h-10 flex items-center justify-center">2</div>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold mb-2">Data Analysis with Machine Learning</h4>
                                <p>The collected data is analyzed using ML algorithms to detect usage patterns, identify inefficiencies, and predict future consumption. The system continuously learns and adapts based on your behavior and energy usage trends.</p>
                            </div>
                        </div>

                        <div class="flex mb-6">
                            <div class="mr-4">
                                <div class="bg-blue-500 text-white rounded-full w-10 h-10 flex items-center justify-center">3</div>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold mb-2">Actionable Insights & Recommendations</h4>
                                <p>Based on the analysis, the system provides personalized recommendations to help you optimize your energy usage. This includes suggestions for reducing peak-time usage, identifying energy-hungry devices, and improving overall efficiency.</p>
                            </div>
                        </div>

                        <div class="flex mb-6">
                            <div class="mr-4">
                                <div class="bg-blue-500 text-white rounded-full w-10 h-10 flex items-center justify-center">4</div>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold mb-2">Real-Time Monitoring & Alerts</h4>
                                <p>Users can monitor their energy usage in real time through an intuitive dashboard. The system also sends alerts for unusual consumption, helping prevent energy waste or potential issues early on.</p>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="mr-4">
                                <div class="bg-blue-500 text-white rounded-full w-10 h-10 flex items-center justify-center">5</div>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold mb-2">Ongoing Optimization</h4>
                                <p>As more data is gathered, the system refines its predictions and recommendations, ensuring that your energy management remains accurate, cost-efficient, and adaptive to changing usage patterns.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/2">
                    <img src="{{ asset('images/main1.png') }}" alt="IoT Installation" class="rounded-xl shadow-xl w-full">
                </div>
            </div>
        </div>
    </section>


    @include('layouts.footer')