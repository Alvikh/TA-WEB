        <!-- Footer -->
        <footer class="bg-blue-900 bg-opacity-80 py-12">
            <div class="container mx-auto px-20">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center mb-6 md:mb-0">
                        <img src="{{ asset('images/LOGO.png') }}" alt="Smart Power Management Logo" class="h-8 mr-3">
                        <span class="text-xl font-bold">Smart Power Management</span>
                    </div>
                    <div class="flex space-x-6 mb-6 md:mb-0">
                        <a href="https://www.facebook.com/share/1AhP7tUPjZ/?mibextid=wwXIfr" class="text-blue-300 hover:text-white transition">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="https://www.twitter.com" class="text-blue-300 hover:text-white transition">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="https://www.linkedin.com" class="text-blue-300 hover:text-white transition">
                            <i class="fab fa-linkedin-in text-xl"></i>
                        </a>
                        <a href="https://www.instagram.com/alveyy.kh" class="text-blue-300 hover:text-white transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="https://www.youtube.com" class="text-blue-300 hover:text-white transition">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    </div>
                    <div class="text-blue-200 text-sm">
                        &copy; 2023 Smart Power Management. All rights reserved.
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
                duration: 800
                , easing: 'ease-in-out'
                , once: true
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
