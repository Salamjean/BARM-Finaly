<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - BARM</title>
    
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
        
        .auth-gradient {
            background: linear-gradient(135deg, #16a34a 0%, #f97316 100%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .animate-fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .floating-elements {
            animation: float 8s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(5deg); }
        }
        
        .input-focus {
            transition: all 0.3s ease;
        }
        
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(34, 197, 94, 0.3);
        }
        
        .btn-hover {
            transition: all 0.3s ease;
        }
        
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(34, 197, 94, 0.4);
        }
        
        .military-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(34, 197, 94, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(249, 115, 22, 0.1) 0%, transparent 50%);
        }
    </style>
</head>

<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-primary-50">
    <div class="min-h-screen flex">
        <!-- Left Side - Login Form -->
        <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-10 animate-fade-in">
                <!-- Logo and Header -->
                <div class="text-center">
                    <div class="flex justify-center mb-8">
                        <div class="relative">
                            <img class="h-16 w-auto" src="{{ asset(setting('app_logo')) }}" alt="BARM Logo">
                            <div class="absolute -inset-2 bg-primary-100 rounded-full opacity-50 blur-lg"></div>
                        </div>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-3">
                        Bienvenue
                    </h1>
                    <p class="text-lg text-gray-600">
                        Connectez-vous à votre espace personnel
                    </p>
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-8">
                    @csrf
                    <input type="hidden" name="user" value="client" />

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="mecano" class="block text-sm font-semibold text-gray-700">
                            Adresse e-mail
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400 group-focus-within:text-primary-500 transition-colors"></i>
                            </div>
                            <input 
                                type="email" 
                                id="mecano" 
                                name="mecano"
                                value="{{ old('mecano') }}"
                                required
                                autofocus
                                class="w-full pl-12 pr-4 py-4 bg-white border-2 border-gray-200 rounded-xl input-focus focus:border-primary-500 focus:ring-0 @error('mecano') border-red-500 @enderror"
                                placeholder="votre.email@exemple.com"
                            >
                        </div>
                        @error('mecano')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-gray-700">
                            Mot de passe
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400 group-focus-within:text-primary-500 transition-colors"></i>
                            </div>
                            <input 
                                type="password" 
                                id="password" 
                                name="password"
                                required
                                class="w-full pl-12 pr-12 py-4 bg-white border-2 border-gray-200 rounded-xl input-focus focus:border-primary-500 focus:ring-0 @error('password') border-red-500 @enderror"
                                placeholder="••••••••••••"
                            >
                            <button 
                                type="button" 
                                id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center"
                            >
                                <i class="fas fa-eye text-gray-400 hover:text-primary-500 transition-colors" id="passwordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button 
                            type="submit" 
                            class="w-full bg-gradient-to-r from-primary-600 to-primary-700 text-white py-4 px-6 rounded-xl font-semibold btn-hover focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                        >
                            <i class="fas fa-sign-in-alt mr-3"></i>
                            Se connecter
                        </button>
                    </div>
                </form>

                <!-- Help Section -->
                <div class="text-center space-y-4">
                    <div class="flex items-center justify-center space-x-4 text-sm text-gray-500">
                        <span class="flex items-center">
                            <i class="fas fa-shield-alt mr-2 text-primary-500"></i>
                            Connexion sécurisée
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-clock mr-2 text-accent-500"></i>
                            24h/24
                        </span>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-6">
                        <p class="text-sm text-gray-600 mb-3">
                            Besoin d'aide ? Contactez-nous
                        </p>
                        <a href="tel:{{ setting('app_phone') }}" class="text-primary-600 hover:text-primary-700 font-semibold transition-colors">
                            <i class="fas fa-phone mr-2"></i>
                            (+225) {{ setting('app_phone') }}
                        </a>
                    </div>
                </div>

                <!-- Back to Home -->
                <div class="text-center pt-4">
                    <a href="{{ route('acceuil') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium transition-colors group">
                        <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                        Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Side - Background -->
        <div class="hidden lg:flex lg:w-1/2 auth-gradient relative overflow-hidden">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0">
                <div class="absolute top-20 left-20 w-40 h-40 bg-white opacity-5 rounded-full floating-elements"></div>
                <div class="absolute bottom-20 right-20 w-32 h-32 bg-accent-300 opacity-10 rounded-full floating-elements" style="animation-delay: -2s;"></div>
                <div class="absolute top-1/2 left-1/3 w-24 h-24 bg-primary-300 opacity-10 rounded-full floating-elements" style="animation-delay: -4s;"></div>
                <div class="absolute top-1/3 right-1/4 w-20 h-20 bg-white opacity-10 rounded-full floating-elements" style="animation-delay: -6s;"></div>
            </div>
            
            <!-- Content Overlay -->
            <div class="relative z-10 flex items-center justify-center w-full">
                <div class="text-center text-white max-w-lg px-8">
                    <div class="mb-12">
                        <div class="relative inline-block mb-8">
                            <img class="h-24 w-auto mx-auto" src="{{ asset(setting('app_logo')) }}" alt="BARM Logo">
                            <div class="absolute -inset-4 bg-white bg-opacity-10 rounded-full blur-xl"></div>
                        </div>
                        <h1 class="text-5xl font-bold mb-6 leading-tight">
                            Bureau d'Accompagnement à la 
                            <span class="text-accent-300">Reconversion</span>
                        </h1>
                        <p class="text-xl opacity-90 leading-relaxed">
                            Accédez à votre espace personnel pour gérer votre reconversion professionnelle en toute simplicité
                        </p>
                    </div>
                    
                    <!-- Features Grid -->
                    <div class="grid grid-cols-1 gap-6 max-w-md mx-auto">
                        <div class="flex items-center justify-center p-4 glass-effect rounded-xl">
                            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-shield-alt text-white text-lg"></i>
                            </div>
                            <div class="text-left">
                                <h3 class="text-white font-semibold">Accès sécurisé</h3>
                                <p class="text-white text-sm opacity-80">Protection de vos données</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-center p-4 glass-effect rounded-xl">
                            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-clock text-white text-lg"></i>
                            </div>
                            <div class="text-left">
                                <h3 class="text-white font-semibold">Disponible 24h/24</h3>
                                <p class="text-white text-sm opacity-80">Accès permanent</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-center p-4 glass-effect rounded-xl">
                            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-users text-white text-lg"></i>
                            </div>
                            <div class="text-left">
                                <h3 class="text-white font-semibold">Accompagnement</h3>
                                <p class="text-white text-sm opacity-80">Personnalisé et expert</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Password toggle functionality
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        });

        // Enhanced form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('mecano').value;
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                e.preventDefault();
                // Add visual feedback
                if (!email) {
                    document.getElementById('mecano').classList.add('border-red-500');
                }
                if (!password) {
                    document.getElementById('password').classList.add('border-red-500');
                }
            }
        });

        // Remove error styling on input
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('border-red-500');
            });
        });
    </script>
</body>
</html>
