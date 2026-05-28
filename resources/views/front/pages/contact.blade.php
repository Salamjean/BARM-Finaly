@extends('front.layouts.app')
@section('content')
    <!-- Hero Section -->
    <section class="military-gradient relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute inset-0 military-pattern"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center text-white">
                <div class="mb-8">
                    <img class="h-20 w-auto mx-auto mb-6" src="{{ asset(setting('app_logo')) }}" alt="BARM Logo">
                </div>
                <h1 class="text-4xl md:text-5xl font-bold mb-6">
                    Contactez-nous
                </h1>
                <p class="text-xl opacity-90 max-w-2xl mx-auto">
                    Nous sommes là pour vous accompagner dans votre reconversion professionnelle. N'hésitez pas à nous contacter.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Information Section -->
    <section class="py-20 bg-white relative">
        <div class="absolute inset-0 military-pattern opacity-5"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-block bg-primary-100 text-primary-600 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-address-book mr-2"></i>
                    Nos coordonnées
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Comment nous joindre
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Retrouvez toutes nos informations de contact pour nous joindre facilement
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Phone -->
                <div class="text-center p-8 bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-phone text-primary-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Téléphone</h3>
                    <p class="text-gray-600 font-medium">(+225) {{ setting('app_phone') }}</p>
                </div>

                <!-- Address -->
                <div class="text-center p-8 bg-gradient-to-br from-accent-50 to-accent-100 rounded-2xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-accent-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-map-marker-alt text-accent-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Adresse</h3>
                    <p class="text-gray-600 font-medium">{{ setting('app_address') }}</p>
                </div>

                <!-- Email -->
                <div class="text-center p-8 bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-envelope text-primary-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Email</h3>
                    <p class="text-gray-600 font-medium">{{ setting('app_mail') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-accent-50 relative">
        <div class="absolute inset-0 military-pattern opacity-5"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <div class="inline-block bg-accent-100 text-accent-600 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-map mr-2"></i>
                    Notre localisation
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Retrouvez-nous facilement
                </h2>
                <p class="text-lg text-gray-600">
                    Localisez nos bureaux grâce à notre carte interactive
                </p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="w-full h-96">
                    @php echo setting('app_map') @endphp
                </div>
            </div>
        </div>
    </section>

    

    <!-- Additional Information Section -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-accent-50 relative">
        <div class="absolute inset-0 military-pattern opacity-5"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Office Hours -->
                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-clock text-accent-600 mr-3"></i>
                        Horaires d'ouverture
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium text-gray-900">Lundi - Vendredi</span>
                            <span class="text-gray-600 font-semibold">8h00 - 17h00</span>
                        </div>
                        
                        {{-- <div class="flex justify-between items-center py-3">
                            <span class="font-medium text-gray-900">Samedi - Dimanche</span>
                            <span class="text-gray-600 font-semibold">Fermé</span>
                        </div> --}}
                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-exclamation-triangle text-accent-600 mr-3"></i>
                        Contact
                    </h3>
                    <p class="text-gray-600 mb-6">
                        Pour les urgences ou les demandes nécessitant une réponse immédiate, contactez-nous directement par téléphone.
                    </p>
                    <div class="bg-gradient-to-r from-accent-50 to-accent-100 p-6 rounded-xl border border-accent-200">
                        <p class="text-accent-800 font-semibold text-lg flex items-center">
                            <i class="fas fa-phone mr-3 text-accent-600"></i>
                            (+225) {{ setting('app_phone') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-white relative">
        <div class="absolute inset-0 military-pattern opacity-5"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-block bg-accent-100 text-accent-600 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-question-circle mr-2"></i>
                    Questions fréquentes
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Trouvez rapidement des réponses
                </h2>
                <p class="text-lg text-gray-600">
                    Réponses aux questions les plus courantes
                </p>
            </div>

            <div class="space-y-6">
                @foreach ([
                    [
                        'question' => 'Comment puis-je m\'inscrire pour une reconversion ?',
                        'answer' => 'Vous pouvez vous inscrire en ligne via notre plateforme ou nous contacter directement par téléphone ou email pour un accompagnement personnalisé.'
                    ],
                    [
                        'question' => 'Quels sont les documents requis pour une demande de reconversion ?',
                        'answer' => 'Les documents requis incluent votre carte militaire, votre CV, une lettre de motivation et les justificatifs de formation si applicable.'
                    ],
                    [
                        'question' => 'Combien de temps dure le processus de reconversion ?',
                        'answer' => 'La durée varie selon votre profil et vos objectifs. En moyenne, le processus complet prend entre 6 mois et 1 an.'
                    ],
                    [
                        'question' => 'Proposez-vous des formations gratuites ?',
                        'answer' => 'Oui, nous proposons plusieurs formations gratuites pour les militaires en reconversion, financées par nos partenaires.'
                    ]
                ] as $faq)
                    <div class="bg-gradient-to-r from-gray-50 to-primary-50 rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition-all duration-300">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-info-circle mr-3 text-primary-500"></i>
                            {{ $faq['question'] }}
                        </h3>
                        <p class="text-gray-600 ml-8">{{ $faq['answer'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
