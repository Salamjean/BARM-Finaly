@extends('front.layouts.app')
@section('content')
    <!-- Hero Section -->
    <section class="hero-gradient relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute inset-0 military-pattern"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="text-center text-white">
                <div class="mb-8">
                    <img class="h-20 w-auto mx-auto mb-6" src="{{ asset(setting('app_logo')) }}" alt="BARM Logo">
                </div>
                <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in">
                    Bureau d'Accompagnement à la 
                    <span class="text-accent-300">Reconversion des Militaires</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto opacity-90">
                    Nous accompagnons les militaires et gendarmes dans leur reconversion professionnelle avec expertise et dévouement.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#services" class="bg-white text-primary-600 px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Découvrir nos services
                    </a>
                    <a href="{{ route('preregistration.form') }}" class="bg-blue-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-700 transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-edit mr-2"></i>
                        Faire ma pré-inscription
                    </a>
                    <a href="{{ route('contact') }}" class="border-2 border-white text-white px-8 py-4 rounded-xl font-semibold hover:bg-white hover:text-primary-600 transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-phone mr-2"></i>
                        Nous contacter
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Floating Elements -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-accent-300 opacity-20 rounded-full animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-32 h-32 bg-primary-300 opacity-20 rounded-full animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-white opacity-10 rounded-full animate-pulse delay-500"></div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white relative">
        <div class="absolute inset-0 military-pattern opacity-5"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="animate-fade-in">
                    <div class="inline-block bg-primary-100 text-primary-600 px-4 py-2 rounded-full text-sm font-semibold mb-6">
                        <i class="fas fa-star mr-2"></i>
                        À propos de nous
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        Bureau d'Accompagnement à la Reconversion des Militaires 
                        <span class="text-primary-600">(BARM)</span>
                    </h2>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Le BARM intervient dans la reconversion des militaires et gendarmes en fin de carrière. Créé par Arrêté N°0656 du 03 mai 2018 du Ministre d'État, Ministre de la Défense, nous coordonnons toutes les activités liées à la préparation, l'organisation, l'évaluation et le suivi des projets de reconversion des Militaires.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#services" class="bg-primary-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-primary-700 transition-all duration-300 transform hover:scale-105 text-center">
                            <i class="fas fa-cogs mr-2"></i>
                            Nos services
                        </a>
                        <a href="#contact" class="border-2 border-primary-600 text-primary-600 px-6 py-3 rounded-xl font-semibold hover:bg-primary-600 hover:text-white transition-all duration-300 transform hover:scale-105 text-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            En savoir plus
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="relative z-10">
                        <img src="{{ asset('front/images/barmphoto.jfif') }}" alt="BARM Image" class="w-full h-96 object-cover rounded-2xl shadow-2xl">
                    </div>
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-primary-200 rounded-full opacity-50"></div>
                    <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-accent-200 rounded-full opacity-50"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-gradient-to-br from-gray-50 to-primary-50 relative">
        <div class="absolute inset-0 military-pattern opacity-5"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-block bg-primary-100 text-primary-600 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-link mr-2"></i>
                    Services essentiels
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Liens <span class="text-primary-600">Utiles</span>
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Accédez rapidement aux services essentiels pour votre reconversion professionnelle
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ([
                    ['icon' => 'fas fa-sign-in-alt', 'title' => 'Espace personnel', 'description' => 'Connectez-vous à votre espace', 'color' => 'primary'],
                    ['icon' => 'fas fa-chart-bar', 'title' => 'Rapports', 'description' => 'Rapports d\'activités', 'color' => 'accent'],
                    ['icon' => 'fas fa-clipboard-check', 'title' => 'Résultats', 'description' => 'Consultez vos résultats', 'color' => 'primary'],
                    ['icon' => 'fas fa-question-circle', 'title' => 'FAQ', 'description' => 'Foire aux questions', 'color' => 'accent']
                ] as $service)
                    <div class="bg-white p-8 rounded-2xl shadow-lg card-hover border border-gray-100">
                        <div class="w-16 h-16 bg-{{ $service['color'] }}-100 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                            <i class="{{ $service['icon'] }} text-{{ $service['color'] }}-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3 text-center">{{ $service['title'] }}</h3>
                        <p class="text-gray-600 text-center">{{ $service['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-20 military-gradient relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Nos <span class="text-accent-300">Réalisations</span>
                </h2>
                <p class="text-xl text-white opacity-90">
                    Chiffres clés de notre accompagnement
                </p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                @foreach ([
                    ['count' => '14.6K', 'label' => 'Personnes accompagnées', 'icon' => 'fas fa-users'],
                    ['count' => '12.6K', 'label' => 'Projets réalisés', 'icon' => 'fas fa-project-diagram'],
                    ['count' => '14.7K', 'label' => 'Personnes réinsérées', 'icon' => 'fas fa-check-circle'],
                    ['count' => '25+', 'label' => 'Partenaires', 'icon' => 'fas fa-handshake']
                ] as $stat)
                    <div class="text-white">
                        <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="{{ $stat['icon'] }} text-white text-2xl"></i>
                        </div>
                        <div class="text-3xl md:text-4xl font-bold mb-2">{{ $stat['count'] }}</div>
                        <div class="text-lg opacity-90">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Jobs Section -->
    <section class="py-20 bg-white relative">
        <div class="absolute inset-0 military-pattern opacity-5"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-block bg-accent-100 text-accent-600 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-briefcase mr-2"></i>
                    Offres d'emploi / Offres formations
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Nos meilleures offres pour vous
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Découvrez les opportunités de reconversion qui s'offrent à vous
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($jobs as $job)
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-lg card-hover">
                        <div class="flex items-center justify-between mb-4">
                            <img src="{{ asset('front/images/logotest.png') }}" alt="Company Logo" class="h-8 w-auto">
                            <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $job->job_type }}
                            </span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ $job->title }}</h3>
                        <div class="flex items-center text-gray-600 mb-4">
                            <i class="fas fa-map-marker-alt mr-2 text-primary-500"></i>
                            <span>{{ $job->location }}</span>
                        </div>
                        <a href="#" class="text-primary-600 font-semibold hover:text-primary-700 transition-colors flex items-center">
                            Voir les détails 
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="#" class="bg-accent-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-accent-700 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-eye mr-2"></i>
                    Voir toutes les offres
                </a>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-accent-50 relative">
        <div class="absolute inset-0 military-pattern opacity-5"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-block bg-accent-100 text-accent-600 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-newspaper mr-2"></i>
                    Actualités
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Nos dernières nouvelles
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Restez informé des dernières actualités et événements du BARM
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($news as $item)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg card-hover">
                        <img src="{{ $item->image }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="text-sm text-gray-500 mb-2 flex items-center">
                                <i class="fas fa-calendar mr-2 text-primary-500"></i>
                                {{ $item->published_at }}
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ $item->title }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($item->excerpt, 120) }}</p>
                            <a href="#" class="text-primary-600 font-semibold hover:text-primary-700 transition-colors flex items-center">
                                Lire plus 
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 military-gradient relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Prêt à commencer votre reconversion ?
            </h2>
            <p class="text-xl mb-8 opacity-90">
                Rejoignez les milliers de militaires qui ont déjà réussi leur reconversion avec le BARM
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" class="bg-white text-primary-600 px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-phone mr-2"></i>
                    Nous contacter
                </a>
                
            </div>
        </div>
    </section>
@endsection
