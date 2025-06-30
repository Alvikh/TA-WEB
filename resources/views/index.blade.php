    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PowerSmartIQ - Smart Energy Prediction</title>
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            body {
                background: radial-gradient(circle at center, #0077cc 0%, #004080 100%);
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            .feature-card {
                backdrop-filter: blur(10px);
                background-color: rgba(255, 255, 255, 0.1);
                transition: all 0.3s ease;
            }
            .feature-card:hover {
                transform: translateY(-5px);
                background-color: rgba(255, 255, 255, 0.15);
            }
            .btn-download {
                background: linear-gradient(135deg, #00b4db, #0083b0);
                border: none;
            }
            .btn-download:hover {
                background: linear-gradient(135deg, #0083b0, #00b4db);
            }
            .service-card {
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(10px);
                transition: all 0.3s ease;
            }
            .service-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            }
            .team-card {
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(5px);
                transition: all 0.3s ease;
            }
            .team-card:hover {
                transform: translateY(-5px);
                background: rgba(255, 255, 255, 0.1);
            }
        </style>
    </head>
    <body class="text-white">
        <!-- Navigation -->
        <nav class="fixed w-full z-50 bg-gradient-to-r from-blue-800 to-blue-900 shadow-lg">
            <div class="container mx-auto px-6 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="{{ asset('images/LOGO.png') }}" alt="PowerSmartIQ Logo" class="w-[20%] h-[20%] mr-3">
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
        
        <div class="flex flex-col items-center justify-center h-full space-y-8">
            <a href="#home" class="nav-link text-white text-2xl hover:text-blue-300 transition">Home</a>
            <a href="#services" class="nav-link text-white text-2xl hover:text-blue-300 transition">Services</a>
            <a href="#about" class="nav-link text-white text-2xl hover:text-blue-300 transition">About</a>
            <a href="#features" class="nav-link text-white text-2xl hover:text-blue-300 transition">Features</a>
            <a href="#contact" class="nav-link text-white text-2xl hover:text-blue-300 transition">Contact</a>
            <a href="/login" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-full transition duration-300 text-lg">
                Login
            </a>
        </div>
    </div>  
                    
                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#home" class="nav-link hover:text-blue-300 transition">Home</a>
                        <a href="#services" class="nav-link hover:text-blue-300 transition">Services</a>
                        <a href="#about" class="nav-link hover:text-blue-300 transition">About</a>
                        <a href="#features" class="nav-link hover:text-blue-300 transition">Features</a>
                        <a href="#contact" class="nav-link hover:text-blue-300 transition">Contact</a>
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
                        <a href="#contact" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-700">Contact</a>
                        <a href="/login" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-full transition duration-300 mt-2">
                            Admin Login
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="home" class="pt-32 pb-20 px-2">
        <div class="container mx-auto" data-aos="fade-up">
                <div class="flex flex-col lg:flex-row items-center">
                    <div class="lg:w-1/2 mb-12 lg:mb-0">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">Smart Energy Prediction with <span class="text-blue-300">IoT Technology</span></h1>
                        <p class="text-xl mb-8 text-blue-100">PowerSmartIQ helps you monitor, analyze, and predict your electricity consumption with advanced machine learning algorithms.</p>
                        <div class="flex flex-wrap gap-4">
                            <a href="#download" class="btn-download text-white font-semibold px-6 py-3 rounded-full transition duration-300">
                                Download App
                            </a>
                            <a href="#services" class="border-2 border-white text-white font-semibold px-6 py-3 rounded-full hover:bg-white hover:text-blue-900 transition duration-300">
                                Our Services
                            </a>
                        </div>
                    </div>
                    <div class="lg:w-1/2" data-aos="fade-up">
                        <img src="{{ asset('images/main.png') }}" alt="PowerSmartIQ Dashboard" class="rounded-lg w-full">
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="py-20 bg-blue-900 bg-opacity-30">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Our <span class="text-blue-300">Smart Services</span></h2>
                    <p class="text-xl text-blue-200 max-w-2xl mx-auto">Comprehensive energy management solutions powered by IoT and AI</p>
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
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-blue-300 mr-2"></i>
                                <span>Seasonal adjustments</span>
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
                                <span>Appliance-level tracking</span>
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
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-blue-300 mr-2"></i>
                                <span>Energy-saving tips</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-blue-300 mr-2"></i>
                                <span>Tariff comparison</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Service 4 -->
    <div class="service-card rounded-xl p-8" data-aos="fade-up" data-aos-delay="100">
                        <div class="text-blue-300 mb-4">
                            <i class="fas fa-cloud text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Cloud Integration</h3>
                        <p class="text-blue-100 mb-6">Securely store and access your energy data from anywhere with our cloud-based platform that integrates with your existing systems.</p>
                        <ul class="space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-blue-300 mr-2"></i>
                                <span>Data history up to 5 years</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-blue-300 mr-2"></i>
                                <span>API access</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-blue-300 mr-2"></i>
                                <span>Multi-user access</span>
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
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">About <span class="text-blue-300">PowerSmartIQ</span></h2>
                    <p class="text-xl text-blue-200 max-w-3xl mx-auto">Innovating energy management through cutting-edge technology</p>
                </div>
                
                <div class="flex flex-col lg:flex-row items-center mb-20">
                    <div class="lg:w-1/2 mb-10 lg:mb-0 lg:pr-10">
                        <h3 class="text-2xl font-bold mb-6">Our Story</h3>
                        <p class="text-blue-100 mb-4">Founded in 2020, PowerSmartIQ began as a research project at a leading university's energy lab. Our team of engineers and data scientists recognized the growing need for intelligent energy management solutions in both residential and commercial sectors.</p>
                        <p class="text-blue-100 mb-4">Today, we've grown into a full-fledged IoT energy management company serving thousands of customers across multiple countries, helping them save millions in energy costs annually.</p>
                        <p class="text-blue-100">Our mission is to make energy consumption transparent, predictable, and optimized for everyone, from individual households to large enterprises.</p>
                    </div>
                    <div class="lg:w-1/2">
                        <img src="https://via.placeholder.com/600x400/0077cc/ffffff?text=Our+Team" alt="Our Team" class="rounded-lg shadow-xl w-full">
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
                
                <div class="text-center mb-16">
                    <h3 class="text-3xl font-bold mb-6">Meet Our <span class="text-blue-300">Leadership Team</span></h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="team-card rounded-xl p-6 text-center">
                        <img src="https://via.placeholder.com/150/0077cc/ffffff?text=CEO" alt="CEO" class="rounded-full w-32 h-32 mx-auto mb-4 border-4 border-blue-400">
                        <h4 class="text-xl font-bold">Dr. Sarah Johnson</h4>
                        <p class="text-blue-300 mb-3">CEO & Founder</p>
                        <p class="text-blue-100 text-sm">PhD in Electrical Engineering with 15+ years in energy systems</p>
                    </div>
                    
                    <div class="team-card rounded-xl p-6 text-center">
                        <img src="https://via.placeholder.com/150/0077cc/ffffff?text=CTO" alt="CTO" class="rounded-full w-32 h-32 mx-auto mb-4 border-4 border-blue-400">
                        <h4 class="text-xl font-bold">Michael Chen</h4>
                        <p class="text-blue-300 mb-3">Chief Technology Officer</p>
                        <p class="text-blue-100 text-sm">IoT and AI specialist with expertise in predictive analytics</p>
                    </div>
                    
                    <div class="team-card rounded-xl p-6 text-center">
                        <img src="https://via.placeholder.com/150/0077cc/ffffff?text=COO" alt="COO" class="rounded-full w-32 h-32 mx-auto mb-4 border-4 border-blue-400">
                        <h4 class="text-xl font-bold">David Rodriguez</h4>
                        <p class="text-blue-300 mb-3">Chief Operations Officer</p>
                        <p class="text-blue-100 text-sm">Operations expert with background in energy infrastructure</p>
                    </div>
                    
                    <div class="team-card rounded-xl p-6 text-center">
                        <img src="https://via.placeholder.com/150/0077cc/ffffff?text=CMO" alt="CMO" class="rounded-full w-32 h-32 mx-auto mb-4 border-4 border-blue-400">
                        <h4 class="text-xl font-bold">Lisa Thompson</h4>
                        <p class="text-blue-300 mb-3">Chief Marketing Officer</p>
                        <p class="text-blue-100 text-sm">Marketing strategist focused on sustainable technologies</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section (existing content) -->
        <section id="features" class="py-20 bg-blue-900 bg-opacity-30">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Key <span class="text-blue-300">Features</span></h2>
                    <p class="text-xl text-blue-200 max-w-2xl mx-auto">Revolutionizing energy management with IoT and AI</p>
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
                        <h3 class="text-xl font-bold text-center mb-4">AI Recommendations</h3>
                        <p class="text-center text-blue-100">Personalized suggestions to optimize your energy usage based on machine learning analysis.</p>
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
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">How <span class="text-blue-300">PowerSmartIQ</span> Works</h2>
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
                                    <h4 class="text-lg font-bold mb-2">Install IoT Sensors</h4>
                                    <p>Our certified technicians install non-invasive smart sensors on your electrical panel in under 2 hours.</p>
                                </div>
                            </div>
                            
                            <div class="flex mb-6">
                                <div class="mr-4">
                                    <div class="bg-blue-500 text-white rounded-full w-10 h-10 flex items-center justify-center">2</div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold mb-2">Data Collection</h4>
                                    <p>Sensors collect energy usage data every second and securely transmit it to our cloud platform.</p>
                                </div>
                            </div>
                            
                            <div class="flex mb-6">
                                <div class="mr-4">
                                    <div class="bg-blue-500 text-white rounded-full w-10 h-10 flex items-center justify-center">3</div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold mb-2">Analysis & Prediction</h4>
                                    <p>Our AI analyzes patterns and predicts future consumption with industry-leading accuracy.</p>
                                </div>
                            </div>
                            
                            <div class="flex">
                                <div class="mr-4">
                                    <div class="bg-blue-500 text-white rounded-full w-10 h-10 flex items-center justify-center">4</div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold mb-2">Insights Delivery</h4>
                                    <p>Access real-time data and predictions through our web dashboard or mobile app.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="lg:w-1/2">
                        <img src="https://via.placeholder.com/600x400/0077cc/ffffff?text=IoT+Installation" alt="IoT Installation" class="rounded-xl shadow-xl w-full">
                    </div>
                </div>
            </div>
        </section>

        <!-- Download Section (existing content) -->
    <section id="download" class="py-20 bg-blue-900 bg-opacity-30" data-aos="fade-up">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto text-center">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">Download Our <span class="text-blue-300">Mobile App</span></h2>
                    <p class="text-xl text-blue-200 mb-10">Monitor your energy consumption anytime, anywhere with the PowerSmartIQ mobile application.</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="#" class="bg-gray-900 hover:bg-gray-800 text-white font-semibold px-6 py-3 rounded-full transition duration-300 flex items-center">
                            <i class="fab fa-apple text-2xl mr-2"></i>
                            <div class="text-left">
                                <div class="text-xs">Download on the</div>
                                <div class="text-lg">App Store</div>
                            </div>
                        </a>
                        <a href="#" class="bg-white hover:bg-gray-100 text-gray-900 font-semibold px-6 py-3 rounded-full transition duration-300 flex items-center">
                            <i class="fab fa-google-play text-2xl mr-2"></i>
                            <div class="text-left">
                                <div class="text-xs">Get it on</div>
                                <div class="text-lg">Google Play</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section (existing content) -->
    <section id="contact" class="py-20" data-aos="fade-up">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold mb-4">Contact <span class="text-blue-300">Us</span></h2>
                        <p class="text-xl text-blue-200">Have questions? Get in touch with our team</p>
                    </div>
                    
                    <div class="bg-white bg-opacity-90 text-blue-900 rounded-xl shadow-xl overflow-hidden">
                        <div class="md:flex">
                            <div class="md:w-1/2 p-8 md:p-12">
                                <h3 class="text-2xl font-bold mb-6">Send us a message</h3>
                                <form>
                                    <div class="mb-6">
                                        <label class="block text-gray-700 font-medium mb-2" for="name">Your Name</label>
                                        <input type="text" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div class="mb-6">
                                        <label class="block text-gray-700 font-medium mb-2" for="email">Email Address</label>
                                        <input type="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div class="mb-6">
                                        <label class="block text-gray-700 font-medium mb-2" for="message">Message</label>
                                        <textarea id="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                    </div>
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-300">
                                        Send Message
                                    </button>
                                </form>
                            </div>
                            <div class="md:w-1/2 bg-blue-600 p-8 md:p-12 text-white">
                                <h3 class="text-2xl font-bold mb-6">Contact Information</h3>
                                <div class="space-y-6">
                                    <div class="flex items-start">
                                        <i class="fas fa-map-marker-alt text-xl mt-1 mr-4"></i>
                                        <div>
                                            <h4 class="font-bold mb-1">Our Office</h4>
                                            <p>123 Energy Street, Tech City, TC 12345</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <i class="fas fa-envelope text-xl mt-1 mr-4"></i>
                                        <div>
                                            <h4 class="font-bold mb-1">Email Us</h4>
                                            <p>info@powersmartiq.com</p>
                                            <p>support@powersmartiq.com</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <i class="fas fa-phone-alt text-xl mt-1 mr-4"></i>
                                        <div>
                                            <h4 class="font-bold mb-1">Call Us</h4>
                                            <p>+1 (800) 123-4567 (Toll-free)</p>
                                            <p>+1 (555) 123-4567 (International)</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <i class="fas fa-clock text-xl mt-1 mr-4"></i>
                                        <div>
                                            <h4 class="font-bold mb-1">Working Hours</h4>
                                            <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
                                            <p>Saturday: 10:00 AM - 4:00 PM</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-blue-900 bg-opacity-80 py-12">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center mb-6 md:mb-0">
                        <img src="{{ asset('images/LOGO.png') }}" alt="PowerSmartIQ Logo" class="h-8 mr-3">
                        <span class="text-xl font-bold">PowerSmartIQ</span>
                    </div>
                    <div class="flex space-x-6 mb-6 md:mb-0">
                        <a href="#" class="text-blue-300 hover:text-white transition">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="text-blue-300 hover:text-white transition">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-blue-300 hover:text-white transition">
                            <i class="fab fa-linkedin-in text-xl"></i>
                        </a>
                        <a href="#" class="text-blue-300 hover:text-white transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-blue-300 hover:text-white transition">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    </div>
                    <div class="text-blue-200 text-sm">
                        &copy; 2023 PowerSmartIQ. All rights reserved.
                    </div>
                </div>
                <div class="border-t border-blue-700 mt-8 pt-8">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                        <div>
                            <h4 class="text-lg font-bold mb-4">Company</h4>
                            <ul class="space-y-2">
                                <li><a href="#about" class="text-blue-200 hover:text-white transition">About Us</a></li>
                                <li><a href="#" class="text-blue-200 hover:text-white transition">Careers</a></li>
                                <li><a href="#" class="text-blue-200 hover:text-white transition">Blog</a></li>
                                <li><a href="#" class="text-blue-200 hover:text-white transition">Press</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold mb-4">Products</h4>
                            <ul class="space-y-2">
                                <li><a href="#features" class="text-blue-200 hover:text-white transition">Features</a></li>
                                <li><a href="#services" class="text-blue-200 hover:text-white transition">Services</a></li>
                                <li><a href="#download" class="text-blue-200 hover:text-white transition">Mobile App</a></li>
                                <li><a href="#" class="text-blue-200 hover:text-white transition">Pricing</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold mb-4">Support</h4>
                            <ul class="space-y-2">
                                <li><a href="#" class="text-blue-200 hover:text-white transition">Help Center</a></li>
                                <li><a href="#" class="text-blue-200 hover:text-white transition">Tutorials</a></li>
                                <li><a href="#" class="text-blue-200 hover:text-white transition">API Docs</a></li>
                                <li><a href="#" class="text-blue-200 hover:text-white transition">Contact</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold mb-4">Legal</h4>
                            <ul class="space-y-2">
                                <li><a href="#" class="text-blue-200 hover:text-white transition">Privacy Policy</a></li>
                                <li><a href="#" class="text-blue-200 hover:text-white transition">Terms of Service</a></li>
                                <li><a href="#" class="text-blue-200 hover:text-white transition">Cookie Policy</a></li>
                                <li><a href="#" class="text-blue-200 hover:text-white transition">GDPR</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Scripts -->
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>
    <!-- Add this right before your closing </body> tag -->
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburgerButton = document.getElementById('hamburger-button');
            const closeButton = document.getElementById('close-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            // Toggle mobile menu
            hamburgerButton.addEventListener('click', function() {
                mobileMenu.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent scrolling when menu is open
            });
            
            // Close mobile menu
            closeButton.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
                document.body.style.overflow = ''; // Restore scrolling
            });
            
            // Close when clicking on a link
            const navLinks = document.querySelectorAll('#mobile-menu .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                    document.body.style.overflow = ''; // Restore scrolling
                });
            });
            
            // Close when clicking outside menu content
            mobileMenu.addEventListener('click', function(e) {
                if (e.target === mobileMenu) {
                    mobileMenu.classList.add('hidden');
                    document.body.style.overflow = ''; // Restore scrolling
                }
            });
        });
    </script>
        <script>
            // Smooth scrolling for navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
            // Sticky header
            window.addEventListener('scroll', function() {
                const header = document.querySelector('header');
                header.classList.toggle('bg-blue-900', window.scrollY > 50);
                header.classList.toggle('bg-opacity-80', window.scrollY > 50);
            });
        </script>
    </body>
    </html>