@extends('front.layouts.app')
@section('content')
    <!-- Header Section -->
    <section class="py-20 military-gradient relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute inset-0 military-pattern"></div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
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
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
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
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            


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
                    <div id="step1" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="mecano" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-id-badge mr-2 text-blue-500"></i>Mécano <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="mecano" name="mecano" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Votre numéro mécano">
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                Doit être enregistré dans notre base
                            </p>
                        </div>
                        <div>
                            <label for="lastname" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user mr-2 text-blue-500"></i>Nom <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="lastname" name="lastname" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Votre nom">
                        </div>
                        <div>
                            <label for="firstname" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user mr-2 text-blue-500"></i>Prénom <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="firstname" name="firstname" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Votre prénom">
                        </div>
                    </div>
                    
                    <div id="step2" class="hidden space-y-6 mt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-phone mr-2 text-blue-500"></i>Téléphone 1 <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="phone" name="phone" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Votre numéro de téléphone">
                            </div>
                            <div>
                                <label for="phone2" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-phone mr-2 text-blue-500"></i>Téléphone 2
                                </label>
                                <input type="tel" id="phone2" name="phone2" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Numéro de téléphone secondaire">
                            </div>
                        </div>
                        
                        <div>
                            <label for="residence" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>Lieu de résidence <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="residence" name="residence" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Votre lieu de résidence">
                        </div>

                        <!-- Axe d'insertion Section -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h3 class="text-xl font-bold text-red-600 text-center mb-6 uppercase tracking-wide">
                                Axe d'insertion
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-2 border-gray-800 p-4 rounded-xl bg-white shadow-sm">
                                <!-- 1. Auto emploi -->
                                <div class="border border-gray-400 rounded-lg p-4 flex flex-col justify-between space-y-4">
                                    <div class="flex items-center justify-between border-b pb-2 border-gray-300">
                                        <label for="axe_auto_emploi" class="font-bold text-gray-900 text-base cursor-pointer">Auto emploi</label>
                                        <input type="checkbox" id="axe_auto_emploi" name="axe_auto_emploi" value="1" class="w-5 h-5 text-blue-600 rounded border-gray-400 focus:ring-blue-500 cursor-pointer">
                                    </div>

                                    <div class="space-y-4">
                                        <div>
                                            <label for="auto_emploi_projet1" class="block text-xs font-bold text-gray-800 mb-1">Projet 1 :</label>
                                            <textarea id="auto_emploi_projet1" name="auto_emploi_projet1" rows="3" class="w-full p-2 border border-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm" placeholder="Description du projet 1"></textarea>
                                        </div>
                                        <div>
                                            <label for="auto_emploi_projet2" class="block text-xs font-bold text-gray-800 mb-1">Projet 2 :</label>
                                            <textarea id="auto_emploi_projet2" name="auto_emploi_projet2" rows="3" class="w-full p-2 border border-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm" placeholder="Description du projet 2"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- 2. Entreprise privée -->
                                <div class="border border-gray-400 rounded-lg p-4 flex flex-col justify-between space-y-4">
                                    <div class="flex items-center justify-between border-b pb-2 border-gray-300">
                                        <label for="axe_entreprise_privee" class="font-bold text-gray-900 text-base cursor-pointer">Entreprise privée</label>
                                        <input type="checkbox" id="axe_entreprise_privee" name="axe_entreprise_privee" value="1" class="w-5 h-5 text-blue-600 rounded border-gray-400 focus:ring-blue-500 cursor-pointer">
                                    </div>

                                    <div class="space-y-4">
                                        <div>
                                            <label for="entreprise_privee_emploi" class="block text-xs font-bold text-gray-800 mb-1">Emploi souhaité :</label>
                                            <textarea id="entreprise_privee_emploi" name="entreprise_privee_emploi" rows="2" class="w-full p-2 border border-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm" placeholder="Emploi souhaité"></textarea>
                                        </div>
                                        <div>
                                            <span class="block text-xs font-bold text-gray-800 mb-1">Formation souhaitée :</span>
                                            <div class="space-y-2">
                                                <div class="flex items-start gap-2">
                                                    <span class="text-xs font-bold mt-2">1.</span>
                                                    <textarea id="entreprise_privee_formation1" name="entreprise_privee_formation1" rows="2" class="w-full p-2 border border-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm" placeholder="Formation 1"></textarea>
                                                </div>
                                                <div class="flex items-start gap-2">
                                                    <span class="text-xs font-bold mt-2">2.</span>
                                                    <textarea id="entreprise_privee_formation2" name="entreprise_privee_formation2" rows="2" class="w-full p-2 border border-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm" placeholder="Formation 2"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 3. Fonction publique -->
                                <div class="border border-gray-400 rounded-lg p-4 flex flex-col justify-between space-y-4">
                                    <div class="flex items-center justify-between border-b pb-2 border-gray-300">
                                        <label for="axe_fonction_publique" class="font-bold text-gray-900 text-base cursor-pointer">Fonction publique</label>
                                        <input type="checkbox" id="axe_fonction_publique" name="axe_fonction_publique" value="1" class="w-5 h-5 text-blue-600 rounded border-gray-400 focus:ring-blue-500 cursor-pointer">
                                    </div>

                                    <div class="space-y-4">
                                        <div>
                                            <label for="fonction_publique_diplome" class="block text-xs font-bold text-gray-800 mb-1">Diplôme civil :</label>
                                            <input type="text" id="fonction_publique_diplome" name="fonction_publique_diplome" class="w-full p-2 border border-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm" placeholder="Diplôme civil">
                                        </div>
                                        <div>
                                            <label for="fonction_publique_emploi1" class="block text-xs font-bold text-gray-800 mb-1">Emploi 1 :</label>
                                            <textarea id="fonction_publique_emploi1" name="fonction_publique_emploi1" rows="2" class="w-full p-2 border border-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm" placeholder="Emploi 1"></textarea>
                                        </div>
                                        <div>
                                            <label for="fonction_publique_emploi2" class="block text-xs font-bold text-gray-800 mb-1">Emploi 2 :</label>
                                            <textarea id="fonction_publique_emploi2" name="fonction_publique_emploi2" rows="2" class="w-full p-2 border border-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm" placeholder="Emploi 2"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Alert Messages -->
                    <div id="alertMessage" class="hidden mt-6"></div>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center mt-6">
                        <button type="button" id="btnVerify" class="bg-blue-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-check-circle mr-2"></i>
                            Vérifier
                        </button>
                        <button type="submit" id="btnSubmit" class="hidden bg-green-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-green-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Envoyer ma demande de préinscription
                        </button>
                        <button type="button" id="btnReset" class="bg-gray-200 text-gray-700 px-8 py-4 rounded-xl font-semibold hover:bg-gray-300 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Réinitialiser
                        </button>
                        <a href="{{ route('acceuil') }}" class="border-2 border-gray-300 text-gray-700 px-8 py-4 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-300 text-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour à l'accueil
                        </a>
                    </div>
                </form>
            </div>

            <!-- Information Cards (Moved to bottom) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
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
    const btnVerify = document.getElementById('btnVerify');
    const btnSubmit = document.getElementById('btnSubmit');
    const btnReset = document.getElementById('btnReset');
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    
    // Reset form logic
    btnReset.addEventListener('click', function() {
        form.reset();
        
        // Remove readonly from step 1 fields
        document.getElementById('firstname').readOnly = false;
        document.getElementById('lastname').readOnly = false;
        document.getElementById('mecano').readOnly = false;
        
        // Hide step 2 and remove required
        step2.classList.add('hidden');
        document.getElementById('phone').required = false;
        document.getElementById('residence').required = false;
        
        // Reset buttons
        btnSubmit.classList.add('hidden');
        btnVerify.classList.remove('hidden');
        
        hideAlert();
    });
    
    // Validate Step 1 and proceed to Step 2
    btnVerify.addEventListener('click', function() {
        const firstname = document.getElementById('firstname').value.trim();
        const lastname = document.getElementById('lastname').value.trim();
        const mecano = document.getElementById('mecano').value.trim();
        
        if (!firstname || !lastname || !mecano) {
            showAlert('error', 'Veuillez remplir le prénom, le nom et le mécano.');
            return;
        }

        const originalButtonText = btnVerify.innerHTML;
        btnVerify.disabled = true;
        btnVerify.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Vérification...';
        hideAlert();

        fetch('{{ route("retired.preregistration.verify") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ firstname, lastname, mecano })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showAlert('success', data.message);
                
                // Readonly step 1 fields
                document.getElementById('firstname').readOnly = true;
                document.getElementById('lastname').readOnly = true;
                document.getElementById('mecano').readOnly = true;
                
                // Show step 2
                step2.classList.remove('hidden');
                document.getElementById('phone').required = true;
                document.getElementById('residence').required = true;
                
                // Switch buttons
                btnVerify.classList.add('hidden');
                btnSubmit.classList.remove('hidden');
                
            } else if (data.status === 'error') {
                showAlert('error', data.message);
            } else if (data.status === 'warning') {
                showAlert('warning', data.message);
            } else {
                showAlert('error', 'Une erreur est survenue.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'Une erreur de connexion est survenue.');
        })
        .finally(() => {
            btnVerify.disabled = false;
            btnVerify.innerHTML = originalButtonText;
        });
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // If step 2 is hidden, the user probably pressed Enter in step 1.
        if (step2.classList.contains('hidden')) {
            btnVerify.click();
            return;
        }
        
        // Get form data
        const formData = new FormData(form);
        const originalButtonText = btnSubmit.innerHTML;
        
        // Show loading state
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Envoi en cours...';
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
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = originalButtonText;
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
        
        alertDiv.className = `px-4 py-3 rounded-xl ${alertClasses[type]} block mt-6`;
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