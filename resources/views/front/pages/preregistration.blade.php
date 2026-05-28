@extends('front.layouts.app')
@section('content')
    <!-- Header Section -->
    <section class="py-20 military-gradient relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute inset-0 military-pattern"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <div class="mb-8">
                <img class="h-16 w-auto mx-auto mb-6" src="{{ asset(setting('app_logo')) }}" alt="BARM Logo">
            </div>
            <h1 class="text-3xl md:text-5xl font-bold mb-6">
                Pré-inscription Retraités
            </h1>
            <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">
                Commencez votre démarche de reconversion professionnelle avec le BARM
            </p>
        </div>
    </section>

    <!-- Breadcrumb -->
    <section class="py-4 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav aria-label="breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="{{ route('acceuil') }}" class="text-blue-600 hover:text-blue-800">Accueil</a></li>
                    <li><i class="fas fa-chevron-right text-gray-400 mx-2"></i></li>
                    <li class="text-gray-900 font-semibold">Pré-inscription</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Pre-inscription Form Section -->
    <section class="py-16 bg-white relative">
        <div class="absolute inset-0 military-pattern opacity-5"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Information Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-blue-50 p-6 rounded-xl text-center">
                    <i class="fas fa-shield-check text-3xl text-blue-600 mb-4"></i>
                    <h3 class="font-semibold text-gray-900 mb-2">Vérification Automatique</h3>
                    <p class="text-sm text-gray-600">Votre mécano est vérifié automatiquement dans notre base de données</p>
                </div>
                <div class="bg-green-50 p-6 rounded-xl text-center">
                    <i class="fas fa-clock text-3xl text-green-600 mb-4"></i>
                    <h3 class="font-semibold text-gray-900 mb-2">Traitement Rapide</h3>
                    <p class="text-sm text-gray-600">Votre demande sera traitée dans les 48h ouvrables</p>
                </div>
                <div class="bg-orange-50 p-6 rounded-xl text-center">
                    <i class="fas fa-phone text-3xl text-orange-600 mb-4"></i>
                    <h3 class="font-semibold text-gray-900 mb-2">Contact Direct</h3>
                    <p class="text-sm text-gray-600">Notre équipe vous contactera pour la suite du processus</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">
                        Formulaire de Pré-inscription
                    </h2>
                    <p class="text-gray-600">
                        Veuillez remplir tous les champs obligatoires pour commencer votre démarche
                    </p>
                </div>
                
                <form id="preInscriptionForm" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="firstname" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user mr-2 text-blue-500"></i>Prénom <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="firstname" name="firstname" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Votre prénom">
                        </div>
                        <div>
                            <label for="lastname" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user mr-2 text-blue-500"></i>Nom <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="lastname" name="lastname" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Votre nom">
                        </div>
                    </div>
                    
                    <div>
                        <label for="mecano" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-id-badge mr-2 text-blue-500"></i>Mécano <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="mecano" name="mecano" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Votre numéro mécano">
                        <p class="text-sm text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Votre mécano doit être enregistré dans notre base de données
                        </p>
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-phone mr-2 text-blue-500"></i>Téléphone <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="phone" name="phone" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Votre numéro de téléphone">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-blue-500"></i>Email
                        </label>
                        <input type="email" id="email" name="email" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Votre adresse email (optionnel)">
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-comment mr-2 text-blue-500"></i>Message/Motivation
                        </label>
                        <textarea id="message" name="message" rows="4" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Décrivez brièvement votre motivation ou vos questions (optionnel)"></textarea>
                    </div>
                    
                    <!-- Alert Messages -->
                    <div id="alertMessage" class="hidden"></div>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button type="submit" class="bg-blue-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Envoyer ma demande de préinscription
                        </button>
                        <a href="{{ route('acceuil') }}" class="border-2 border-gray-300 text-gray-700 px-8 py-4 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-300 text-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour à l'accueil
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Besoin d'aide ?</h3>
            <p class="text-gray-600 mb-6">
                Notre équipe est là pour vous accompagner dans vos démarches
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto">
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <i class="fas fa-phone text-2xl text-blue-600 mb-3"></i>
                    <h4 class="font-semibold mb-2">Par téléphone</h4>
                    <p class="text-gray-600">+225  27 22 5 90 178</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <i class="fas fa-envelope text-2xl text-blue-600 mb-3"></i>
                    <h4 class="font-semibold mb-2">Par email</h4>
                    <p class="text-gray-600">contact@barm.ci</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('preInscriptionForm');
    const alertDiv = document.getElementById('alertMessage');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(form);
        const submitButton = form.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.innerHTML;
        
        // Show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Vérification en cours...';
        hideAlert();
        
        // Send AJAX request
        fetch('{{ route("retired.preregistration.submit") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') || formData.get('_token'),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showAlert('success', data.message);
                form.reset();
                
                // Redirect to home after 3 seconds
                setTimeout(() => {
                    window.location.href = '{{ route("acceuil") }}';
                }, 3000);
            } else if (data.status === 'error') {
                showAlert('error', data.message);
            } else if (data.status === 'warning') {
                showAlert('warning', data.message);
            } else {
                showAlert('error', 'Une erreur est survenue. Veuillez réessayer.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'Une erreur de connexion est survenue. Veuillez vérifier votre connexion internet et réessayer.');
        })
        .finally(() => {
            // Reset button state
            submitButton.disabled = false;
            submitButton.innerHTML = originalButtonText;
        });
    });
    
    function showAlert(type, message) {
        const alertClasses = {
            success: 'bg-green-100 border border-green-400 text-green-700',
            error: 'bg-red-100 border border-red-400 text-red-700',
            warning: 'bg-yellow-100 border border-yellow-400 text-yellow-700'
        };
        
        const icons = {
            success: 'fas fa-check-circle',
            error: 'fas fa-exclamation-circle',
            warning: 'fas fa-exclamation-triangle'
        };
        
        alertDiv.className = `px-4 py-3 rounded-xl ${alertClasses[type]} block`;
        alertDiv.innerHTML = `
            <div class="flex items-center">
                <i class="${icons[type]} mr-2"></i>
                <span>${message}</span>
            </div>
        `;
        alertDiv.classList.remove('hidden');
        
        // Auto-hide success messages after 5 seconds
        if (type === 'success') {
            setTimeout(() => {
                hideAlert();
            }, 5000);
        }
        
        // Scroll to alert
        alertDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    
    function hideAlert() {
        alertDiv.classList.add('hidden');
    }
});
</script>
@endpush