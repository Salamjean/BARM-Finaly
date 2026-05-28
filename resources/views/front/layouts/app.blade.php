<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="BARM, barm, Reconversion, Millitaire, Armée">
    <meta name="description" content="BARM - Bureau d'Accompagnement à la Reconversion des Militaires">
    <meta property="og:site_name" content="BARM">
    <meta property="og:url" content="https://barm.kks-technologies.com/">
    <meta property="og:type" content="website">
    <meta property="og:title" content="BARM">
    <meta name="og:image" content="{{ asset(setting('app_logo')) }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#059669">
    <meta name="msapplication-navbutton-color" content="#059669">
    <meta name="apple-mobile-web-app-status-bar-style" content="#059669">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BARM-Bureau d'Accompagnement à la Reconversion des Militaires</title>
    <link rel="icon" type="image/png" sizes="72x33" href="{{ asset(setting('app_logo')) }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        accent: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        .gradient-bg {
            background: linear-gradient(135deg, #16a34a 0%, #f97316 100%);
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #166534 0%, #16a34a 50%, #22c55e 100%);
        }
        
        .military-gradient {
            background: linear-gradient(135deg, #14532d 0%, #16a34a 50%, #f97316 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(34, 197, 94, 0.1), 0 10px 10px -5px rgba(34, 197, 94, 0.04);
        }
        
        .animate-fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .military-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(34, 197, 94, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(249, 115, 22, 0.1) 0%, transparent 50%);
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <!-- Loading Screen -->
    <div id="preloader" class="fixed inset-0 z-50 flex items-center justify-center bg-white">
        <div class="text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-primary-600 mx-auto mb-4"></div>
            <h1 class="text-2xl font-bold text-primary-600">BARM</h1>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('acceuil') }}" class="flex items-center">
                        <img class="h-8 w-auto" src="{{ asset(setting('app_logo')) }}" alt="BARM Logo">
                        <span class="ml-2 text-xl font-bold text-gray-900">BARM</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('acceuil') }}" class="text-gray-900 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Accueil</a>
                        <a href="{{ route('contact') }}" class="text-gray-500 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Contact</a>
                        <a href="{{ route('login') }}" class="bg-primary-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primary-700 transition-colors">Connexion</a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="mobile-menu-button bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                        <span class="sr-only">Ouvrir le menu principal</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div class="mobile-menu hidden md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="{{ route('acceuil') }}" class="text-gray-900 hover:text-primary-600 block px-3 py-2 rounded-md text-base font-medium">Accueil</a>
                    <a href="{{ route('contact') }}" class="text-gray-500 hover:text-primary-600 block px-3 py-2 rounded-md text-base font-medium">Contact</a>
                    <a href="{{ route('login') }}" class="bg-primary-600 text-white block px-3 py-2 rounded-md text-base font-medium">Connexion</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo and Description -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <img class="h-8 w-auto" src="{{ asset(setting('app_logo')) }}" alt="BARM Logo">
                        <span class="ml-2 text-xl font-bold">BARM</span>
                    </div>
                    <p class="text-gray-300 mb-4 max-w-md">
                        Bureau d'Accompagnement à la Reconversion des Militaires. Nous accompagnons les militaires et gendarmes dans leur reconversion professionnelle.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('acceuil') }}" class="text-gray-300 hover:text-white transition-colors">Accueil</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <div class="space-y-2 text-gray-300">
                        <p><i class="fas fa-phone mr-2"></i> (+225) {{ setting('app_phone') }}</p>
                        <p><i class="fas fa-envelope mr-2"></i> {{ setting('app_mail') }}</p>
                        <p><i class="fas fa-map-marker-alt mr-2"></i> {{ setting('app_address') }}</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} BARM. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button id="scrollToTop" class="fixed bottom-8 right-8 bg-primary-600 text-white p-3 rounded-full shadow-lg hover:bg-primary-700 transition-all duration-300 opacity-0 invisible">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script>
        // Hide preloader
        window.addEventListener('load', function() {
            document.getElementById('preloader').style.display = 'none';
        });

        // Mobile menu toggle
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            document.querySelector('.mobile-menu').classList.toggle('hidden');
        });

        // Scroll to top functionality
        const scrollToTopBtn = document.getElementById('scrollToTop');
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.remove('opacity-0', 'invisible');
                scrollToTopBtn.classList.add('opacity-100', 'visible');
            } else {
                scrollToTopBtn.classList.add('opacity-0', 'invisible');
                scrollToTopBtn.classList.remove('opacity-100', 'visible');
            }
        });

        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

    @stack('scripts')

    @if (setting('tawk_to') != '')
        @php echo setting('tawk_to') @endphp
    @endif
</body>
</html>
