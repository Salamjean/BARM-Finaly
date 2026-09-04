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
            


            <div id="formCardContainer" class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
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
                            <h3 class="text-xl font-bold text-red-600 text-center mb-2 uppercase tracking-wide">
                                Axe d'insertion
                            </h3>
                            <p class="text-center text-sm text-gray-600 mb-6 font-semibold">
                                <i class="fas fa-info-circle text-blue-500 mr-1"></i> Veuillez sélectionner <strong>un seul axe d'insertion</strong> parmi les options ci-dessous :
                            </p>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-2 border-gray-800 p-4 rounded-xl bg-white shadow-sm">
                                <!-- 1. Auto emploi -->
                                <div id="box_auto_emploi" class="border border-gray-400 rounded-lg p-4 flex flex-col justify-between space-y-4 transition-all">
                                    <div class="flex items-center justify-between border-b pb-2 border-gray-300">
                                        <label for="axe_auto_emploi" class="font-bold text-gray-900 text-base cursor-pointer flex items-center gap-2">
                                            <input type="radio" id="axe_auto_emploi" name="axe_type" value="auto_emploi" class="w-5 h-5 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer axe-radio">
                                            Auto emploi
                                        </label>
                                    </div>

                                    <div class="space-y-4">
                                        <div>
                                            <label for="auto_emploi_projet1" class="block text-xs font-bold text-gray-800 mb-1">Projet 1 :</label>
                                            <textarea id="auto_emploi_projet1" name="auto_emploi_projet1" rows="3" class="w-full p-2 border border-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm axe-input" placeholder="Description du projet 1"></textarea>
                                        </div>
                                        <div>
                                            <label for="auto_emploi_projet2" class="block text-xs font-bold text-gray-800 mb-1">Projet 2 :</label>
                                            <textarea id="auto_emploi_projet2" name="auto_emploi_projet2" rows="3" class="w-full p-2 border border-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm axe-input" placeholder="Description du projet 2"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- 2. Entreprise privée -->
                                <div id="box_entreprise_privee" class="border border-gray-400 rounded-lg p-4 flex flex-col justify-between space-y-4 transition-all">
                                    <div class="flex items-center justify-between border-b pb-2 border-gray-300">
                                        <label for="axe_entreprise_privee" class="font-bold text-gray-900 text-base cursor-pointer flex items-center gap-2">
                                            <input type="radio" id="axe_entreprise_privee" name="axe_type" value="entreprise_privee" class="w-5 h-5 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer axe-radio">
                                            Entreprise privée
                                        </label>
                                    </div>

                                    <div class="space-y-4">
                                        <div>
                                            <label for="entreprise_privee_emploi" class="block text-xs font-bold text-gray-800 mb-1">Emploi souhaité :</label>
                                            <textarea id="entreprise_privee_emploi" name="entreprise_privee_emploi" rows="2" class="w-full p-2 border border-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm axe-input" placeholder="Emploi souhaité"></textarea>
                                        </div>
                                        <div>
                                            <span class="block text-xs font-bold text-gray-800 mb-1">Formation souhaitée :</span>
                                            <div class="space-y-2">
                                                <div class="flex items-start gap-2">
                                                    <span class="text-xs font-bold mt-2">1.</span>
                                                    <textarea id="entreprise_privee_formation1" name="entreprise_privee_formation1" rows="2" class="w-full p-2 border border-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm axe-input" placeholder="Formation 1"></textarea>
                                                </div>
                                                <div class="flex items-start gap-2">
                                                    <span class="text-xs font-bold mt-2">2.</span>
                                                    <textarea id="entreprise_privee_formation2" name="entreprise_privee_formation2" rows="2" class="w-full p-2 border border-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm axe-input" placeholder="Formation 2"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 3. Fonction publique -->
                                <div id="box_fonction_publique" class="border border-gray-400 rounded-lg p-4 flex flex-col justify-between space-y-4 transition-all">
                                    <div class="flex items-center justify-between border-b pb-2 border-gray-300">
                                        <label for="axe_fonction_publique" class="font-bold text-gray-900 text-base cursor-pointer flex items-center gap-2">
                                            <input type="radio" id="axe_fonction_publique" name="axe_type" value="fonction_publique" class="w-5 h-5 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer axe-radio">
                                            Fonction publique
                                        </label>
                                    </div>

                                    <div class="space-y-4">
                                        <div>
                                            <label for="fonction_publique_diplome" class="block text-xs font-bold text-gray-800 mb-1">Diplôme civil :</label>
                                            <input type="text" id="fonction_publique_diplome" name="fonction_publique_diplome" class="w-full p-2 border border-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm axe-input" placeholder="Diplôme civil">
                                        </div>
                                        <div>
                                            <label for="fonction_publique_emploi1" class="block text-xs font-bold text-gray-800 mb-1">Emploi 1 :</label>
                                            <textarea id="fonction_publique_emploi1" name="fonction_publique_emploi1" rows="2" class="w-full p-2 border border-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm axe-input" placeholder="Emploi 1"></textarea>
                                        </div>
                                        <div>
                                            <label for="fonction_publique_emploi2" class="block text-xs font-bold text-gray-800 mb-1">Emploi 2 :</label>
                                            <textarea id="fonction_publique_emploi2" name="fonction_publique_emploi2" rows="2" class="w-full p-2 border border-gray-400 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm axe-input" placeholder="Emploi 2"></textarea>
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

            <!-- Success View Container -->
            <div id="successView" class="hidden space-y-8 bg-white rounded-2xl shadow-lg border border-gray-200 p-6 md:p-8">
                <!-- Banner Success -->
                <div class="bg-emerald-50 border-2 border-emerald-500 rounded-2xl p-6 text-center shadow-sm">
                    <div class="w-16 h-16 bg-emerald-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl shadow-md">
                        <i class="fas fa-check"></i>
                    </div>
                    <h2 id="successBannerTitle" class="text-2xl md:text-3xl font-extrabold text-emerald-800 mb-2">
                        Pré-inscription terminée !
                    </h2>
                    <p id="successBannerSubtitle" class="text-base md:text-lg font-semibold text-emerald-700 max-w-2xl mx-auto">
                        Merci de vous rapprocher du bureau BARM le plus proche pour votre inscription.
                    </p>
                </div>

                <!-- Points Focaux Table Card -->
                <div class="bg-white rounded-xl border border-gray-300 shadow-sm overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-white px-6 py-4 flex items-center justify-between">
                        <h3 class="text-lg font-bold flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-red-500"></i>
                            Bureaux BARM et Points Focaux
                        </h3>
                        <span class="text-xs bg-blue-600 px-3 py-1 rounded-full font-semibold">Contacts</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b border-gray-300 text-gray-800 font-bold uppercase text-xs">
                                    <th class="py-3 px-4 w-12 text-center">N°</th>
                                    <th class="py-3 px-4">ZONE DE COMPÉTENCE</th>
                                    <th class="py-3 px-4">CONTACTS</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4 text-center font-bold text-gray-500">1</td>
                                    <td class="py-3 px-4 font-semibold text-gray-900">POINT FOCAL MAN</td>
                                    <td class="py-3 px-4 text-blue-700 font-medium">0709106274 / 0101427374</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4 text-center font-bold text-gray-500">2</td>
                                    <td class="py-3 px-4 font-semibold text-gray-900">POINT FOCAL KORHOGO</td>
                                    <td class="py-3 px-4 text-blue-700 font-medium">0777976090 / 0759365610</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4 text-center font-bold text-gray-500">3</td>
                                    <td class="py-3 px-4 font-semibold text-gray-900">POINT FOCAL BOUAKE</td>
                                    <td class="py-3 px-4 text-blue-700 font-medium">0103476391 / 07 58 48 41 93</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4 text-center font-bold text-gray-500">4</td>
                                    <td class="py-3 px-4 font-semibold text-gray-900">POINT FOCAL ABENGOUROU</td>
                                    <td class="py-3 px-4 text-blue-700 font-medium">0102798715</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4 text-center font-bold text-gray-500">5</td>
                                    <td class="py-3 px-4 font-semibold text-gray-900">POINT FOCAL DALOA</td>
                                    <td class="py-3 px-4 text-blue-700 font-medium">0140098122</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4 text-center font-bold text-gray-500">6</td>
                                    <td class="py-3 px-4 font-semibold text-gray-900">POINT FOCAL SAN-PEDRO</td>
                                    <td class="py-3 px-4 text-blue-700 font-medium">0709094077 / 0102470800</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4 text-center font-bold text-gray-500">7</td>
                                    <td class="py-3 px-4 font-semibold text-gray-900">POINT FOCAL EGS MARCORY</td>
                                    <td class="py-3 px-4 text-blue-700 font-medium">0747642888</td>
                                </tr>
                                <tr class="bg-blue-50/50 hover:bg-blue-50 transition-colors">
                                    <td class="py-3 px-4 text-center font-bold text-blue-600">8</td>
                                    <td class="py-3 px-4 font-bold text-gray-900">
                                        BARM ABIDJAN (Siège) Cocody Angré pont Soro
                                    </td>
                                    <td class="py-3 px-4 text-blue-700 font-semibold">
                                        0504423153 / 0747709955<br>
                                        0152441468 / 0556499851
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Dossiers d'inscription Card -->
                <div class="bg-white rounded-xl border border-gray-300 shadow-sm p-6">
                    <h3 class="text-base md:text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center gap-2">
                        <i class="fas fa-folder-open text-amber-600"></i>
                        DOSSIERS D’INSCRIPTION AU BUREAU D’ACCOMPAGNEMENT A LA RECONVERSION DES MILITAIRES (BARM)
                    </h3>

                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-800 font-medium">
                        <li class="flex items-start gap-2 bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <i class="fas fa-check-square text-emerald-600 mt-1"></i>
                            <span>Demande manuscrite adressée au Chef BARM</span>
                        </li>
                        <li class="flex items-start gap-2 bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <i class="fas fa-check-square text-emerald-600 mt-1"></i>
                            <span>Fiche d’inscription à retirer au BARM (pré-profilage)</span>
                        </li>
                        <li class="flex items-start gap-2 bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <i class="fas fa-check-square text-emerald-600 mt-1"></i>
                            <span>Curriculum Vitae (CV)</span>
                        </li>
                        <li class="flex items-start gap-2 bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <i class="fas fa-check-square text-emerald-600 mt-1"></i>
                            <span>Fiche d’engagement légalisée (à télécharger par le candidat)</span>
                        </li>
                        <li class="flex items-start gap-2 bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <i class="fas fa-check-square text-emerald-600 mt-1"></i>
                            <span>Fiche individuelle (DORH / BRH) ou L’Etat signalétique des services (Troupe) pour les Gendarmes</span>
                        </li>
                        <li class="flex items-start gap-2 bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <i class="fas fa-check-square text-emerald-600 mt-1"></i>
                            <span>Copie d’une pièce d’identité (CNI ou carte de retraité ou passeport)</span>
                        </li>
                        <li class="flex items-start gap-2 bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <i class="fas fa-check-square text-emerald-600 mt-1"></i>
                            <span>Arrêté de radiation</span>
                        </li>
                        <li class="flex items-start gap-2 bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <i class="fas fa-check-square text-emerald-600 mt-1"></i>
                            <span>Quatre (04) photos d’identité</span>
                        </li>
                        <li class="flex items-start gap-2 bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <i class="fas fa-check-square text-emerald-600 mt-1"></i>
                            <span>Chemise à rabat</span>
                        </li>
                        <li class="flex items-start gap-2 bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <i class="fas fa-check-square text-emerald-600 mt-1"></i>
                            <span>Certificat médical (pathologies spécifiques)</span>
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center pt-2">
                    <a id="btnDownloadInfo" href="{{ route('preregistration.pdf') }}" target="_blank" class="bg-red-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-red-700 transition-all flex items-center justify-center gap-2 shadow-sm">
                        <i class="fas fa-file-pdf"></i>
                        Télécharger les informations (PDF)
                    </a>
                    <a id="btnDownloadFicheEngagement" href="{{ route('preregistration.fiche_engagement.pdf') }}" target="_blank" class="bg-emerald-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-emerald-700 transition-all flex items-center justify-center gap-2 shadow-sm">
                        <i class="fas fa-file-contract"></i>
                        Télécharger la Fiche d'Engagement (PDF)
                    </a>
                    <a href="{{ route('acceuil') }}" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-all flex items-center justify-center gap-2 shadow-sm">
                        <i class="fas fa-home"></i>
                        Retour à l'accueil
                    </a>
                </div>
            </div>

            <!-- Information Cards (Moved to bottom) -->
            <div id="infoCardsContainer" class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
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
    
    // Dynamic Axe Selection Handling
    const axeRadios = document.querySelectorAll('.axe-radio');
    const axeBoxes = {
        'auto_emploi': {
            box: document.getElementById('box_auto_emploi'),
            inputs: document.querySelectorAll('#box_auto_emploi .axe-input')
        },
        'entreprise_privee': {
            box: document.getElementById('box_entreprise_privee'),
            inputs: document.querySelectorAll('#box_entreprise_privee .axe-input')
        },
        'fonction_publique': {
            box: document.getElementById('box_fonction_publique'),
            inputs: document.querySelectorAll('#box_fonction_publique .axe-input')
        }
    };

    function updateAxeSelection() {
        const checkedRadio = document.querySelector('input[name="axe_type"]:checked');
        const selectedVal = checkedRadio ? checkedRadio.value : null;

        Object.keys(axeBoxes).forEach(key => {
            const { box, inputs } = axeBoxes[key];
            if (!box) return;

            if (key === selectedVal) {
                box.classList.add('border-blue-600', 'bg-blue-50/40', 'ring-2', 'ring-blue-500');
                box.classList.remove('border-gray-400', 'opacity-60');
                inputs.forEach(input => { input.disabled = false; });
            } else {
                box.classList.remove('border-blue-600', 'bg-blue-50/40', 'ring-2', 'ring-blue-500');
                box.classList.add('border-gray-400', 'opacity-60');
                inputs.forEach(input => { 
                    input.disabled = true;
                });
            }
        });
    }

    axeRadios.forEach(radio => radio.addEventListener('change', updateAxeSelection));
    updateAxeSelection(); // Initialize state

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
        
        updateAxeSelection();
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
                
            } else if (data.status === 'already_registered') {
                showSuccessView(true);
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

        if (!document.querySelector('input[name="axe_type"]:checked')) {
            showAlert('error', "Veuillez sélectionner un axe d'insertion (un seul axe doit être choisi).");
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
                showSuccessView(false);
            } else if (data.status === 'already_registered') {
                showSuccessView(true);
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

    function showSuccessView(isAlreadyRegistered = false) {
        hideAlert();
        
        const formCard = document.getElementById('formCardContainer');
        if (formCard) formCard.classList.add('hidden');
        
        const infoCards = document.getElementById('infoCardsContainer');
        if (infoCards) infoCards.classList.add('hidden');

        const titleEl = document.getElementById('successBannerTitle');
        const subtitleEl = document.getElementById('successBannerSubtitle');

        if (isAlreadyRegistered) {
            if (titleEl) titleEl.textContent = "Vous êtes déjà pré-inscrit !";
            if (subtitleEl) subtitleEl.textContent = "Votre demande de pré-inscription est déjà enregistrée dans nos services. Vous pouvez télécharger la fiche d'informations ci-dessous.";
        } else {
            if (titleEl) titleEl.textContent = "Pré-inscription terminée !";
            if (subtitleEl) subtitleEl.textContent = "Merci de vous rapprocher du bureau BARM le plus proche pour votre inscription.";
        }

        const mecanoVal = document.getElementById('mecano') ? document.getElementById('mecano').value.trim() : '';
        const btnEngagement = document.getElementById('btnDownloadFicheEngagement');
        if (btnEngagement && mecanoVal) {
            const baseUrl = '{{ route("preregistration.fiche_engagement.pdf") }}';
            btnEngagement.href = `${baseUrl}?mecano=${encodeURIComponent(mecanoVal)}`;
        }

        const successView = document.getElementById('successView');
        if (successView) {
            successView.classList.remove('hidden');
            successView.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
});
</script>
@endpush