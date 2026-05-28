<?php


use App\Models\Candidature;
use App\Exports\BudgetPlanExport;
use App\Exports\BudgetPlanExportMem;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;
use App\Http\Controllers\PAController;
use App\Http\Controllers\NewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CvlmController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\ExcelController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\LeaveController;

use App\Http\Controllers\TrashController;
use App\Http\Controllers\BesoinController;
use App\Http\Controllers\CohortController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\GadgetController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SearchController;
use App\Exports\BudgetPlanMonitoringExport;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\DossierController;

use App\Http\Controllers\PartnerController;

use App\Http\Controllers\RetiredController;
use App\Http\Controllers\RetiredPreregistrationController;

use App\Http\Controllers\SettingController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\PointingController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntretienController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\SubmissionConroller;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\BesoinitemController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\PartenaireController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RdvpartnerController;
use App\Http\Controllers\TenPercentController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\ChoiceFinalController;
use App\Http\Controllers\ConsommableController;
use App\Http\Controllers\DataCollectController;
use App\Http\Controllers\EntreestockController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\AnnualBudgetController;
use App\Http\Controllers\DisbursementController;
use App\Http\Controllers\PersonalBarmController;
use App\Http\Controllers\PostMonitoredController;
use App\Http\Controllers\PreCommissionController;
use App\Http\Controllers\AccountOpeningController;
use App\Http\Controllers\PrepaentretienController;
use App\Http\Controllers\BilancompetenceController;
use App\Http\Controllers\CreditCommitteeController;
use App\Http\Controllers\FavorableOpinionController;
use App\Http\Controllers\ProjectFinancingController;
use App\Http\Controllers\Budget\BudgetPlanController;
use App\Http\Controllers\SessioncollectiveController;
use App\Http\Controllers\SoumissiondossierController;
use App\Http\Controllers\CandidatentrepriseController;
use App\Http\Controllers\GadgetDistributionController;
use App\Http\Controllers\BudgetPlanMonitoringController;
use App\Http\Controllers\DisbursementDeadlineController;
use App\Http\Controllers\LettrerecommandationController;
use App\Http\Controllers\Budget\BudgetPlanPartController;
use App\Http\Controllers\ValidationCandidatureController;
use App\Http\Controllers\Budget\BudgetPlanSectionController;
use App\Http\Controllers\AnnualBudgetEstablishmentController;
use App\Http\Controllers\Budget\BudgetPlanActivityController;
use App\Http\Controllers\Budget\BudgetPlanComponentController;
use App\Http\Controllers\Budget\BudgetPlanSubComponentController;
use App\Http\Controllers\DuplicatCandidatureController;
use App\Models\Sessioncollective;

// use App\Http\Controllers\ExportController;

Route::get('/welcome', function () {
    // return view('dashboard.pointing.index');
});
//Route::get('/inscription/form', [InscriptionController::class, 'createStepTest']);

//login && register
Route::middleware('guest')->group(function () {

    //admin && personal && partner && client
    route::get('login', [AuthController::class, 'signIn']);
    route::get('login/{user}', [AuthController::class, 'signIn'])->name('login.form');

    route::post('login', [AuthController::class, 'login'])->name('login');

    //forgot-password
    route::get('forgot_password/{user}', [AuthController::class, 'forgot_password'])->name('forgot-password');
    route::get('verifucation_auth', [AuthController::class, 'two_step'])->name('forgot-password.verification');
    route::post('forgot_password', [AuthController::class, 'three_step'])->name('forgot-password.send');

    //register
    // route::get('register', [AuthController::class, 'signOut'])->name('register.form');
    // route::post('register', [AuthController::class, 'register'])->name('register');

    Route::get('subscribe', [MailController::class, 'news_letter_store'])->name('mail.subscribe');
});
Route::get('/', [FrontController::class, 'acceuil'])->name('acceuil');
Route::get('/preregistration', [FrontController::class, 'preregistrationForm'])->name('preregistration.form');
Route::post('/retired/preregistration', [FrontController::class, 'submitPreregistration'])->name('retired.preregistration.submit');
Route::get('/about', [FrontController::class, 'about'])->name('about');
Route::get('/offres', [FrontController::class, 'offres'])->name('offres');
Route::get('/contact', [FrontController::class, 'contact'])->name('contact');
Route::get('single_offre/{id}', [FrontController::class, 'single_offre'])->name('single_offre');
Route::get('search/offres', [FrontController::class, 'search'])->name('offres.search');
Route::get('titles/offres/{$title}', [FrontController::class, 'getTitles'])->name('offres.titles');

Route::group(['middleware' => ['auth']], function () {

    Route::prefix('pdf')->name('pdf.')->group(function () {
        Route::get('file_candidature/{user}', [DashboardController::class, 'fileCandidature'])->name('file_candidature');
    });

    //Retired
    Route::put('retired/{id}/auth_forced', [RetiredController::class, 'forced'])->name('retired.update.forced');
    Route::get('retired/datatables', [RetiredController::class, 'datatables'])->name('retired.datatables');
    Route::resource('retired', RetiredController::class);
    
    // Retired Preregistrations
    Route::prefix('retired-preregistrations')->name('retired-preregistrations.')->group(function () {
        Route::get('/', [RetiredPreregistrationController::class, 'index'])->name('index');
        Route::get('/{id}', [RetiredPreregistrationController::class, 'show'])->name('show');
        Route::put('/{id}/approve', [RetiredPreregistrationController::class, 'approve'])->name('approve');
        Route::put('/{id}/reject', [RetiredPreregistrationController::class, 'reject'])->name('reject');
        Route::get('/datatables/data', [RetiredPreregistrationController::class, 'datatables'])->name('datatables');
    });
    
    Route::prefix('export')->name('export.')->group(function () {
        Route::get('/adherent/{id}', [ExportController::class, 'adherent'])->name('adherent');
    });

    //Excel
    Route::prefix('excel')->name('excel.')->group(function () {
        Route::get('/upload', [ExcelController::class, 'upload_adherent_list'])->name('upload.adherent_list');
        Route::post('/import', [ExcelController::class, 'import_adherent_list'])->name('import.adherent_list');
    });

    //search
    Route::prefix('search')->name('search.')->group(function () {
        Route::get('', [SearchController::class, 'index'])->name('index');
        Route::get('candidatures', [SearchController::class, 'search'])->name('candidatures');
        Route::get('export', [SearchController::class, 'export'])->name('export');
    });

    //Finance et validation candidature //
    Route::prefix('personnel')->name('personnel.')->group(function () {
        Route::get('index', [PersonnelController::class, 'index'])->name('index');
        Route::get('create', [PersonnelController::class, 'create'])->name('create');
        Route::post('store', [PersonnelController::class, 'store'])->name('store');
        Route::get('edit/{id}', [PersonnelController::class, 'edit'])->name('edit');
        Route::put('{id}', [PersonnelController::class, 'update'])->name('update');
        Route::put('{id}/password', [PersonnelController::class, 'update_password'])->name('update.password');
        Route::put('{id}/lock-unlock', [PersonnelController::class, 'lock_unlock'])->name('update.lock_unlock');
        Route::delete('{id}', [PersonnelController::class, 'destroy'])->name('destroy');

        Route::get('death', [PersonnelController::class, 'createDeath'])->name('death.create');
        Route::put('death', [PersonnelController::class, 'death'])->name('death');
    });

    Route::prefix('partenaire')->name('partenaire.')->group(function () {
        Route::get('index', [PartenaireController::class, 'index'])->name('index');
        Route::get('create', [PartenaireController::class, 'create'])->name('create');
        Route::post('store', [PartenaireController::class, 'store'])->name('store');
        Route::get('edit/{id}', [PartenaireController::class, 'edit'])->name('edit');
        Route::put('{id}', [PartenaireController::class, 'update'])->name('update');
        Route::put('{id}/password', [PartenaireController::class, 'update_password'])->name('update.password');
        Route::put('{id}/lock-unlock', [PartenaireController::class, 'lock_unlock'])->name('update.lock_unlock');
        Route::delete('{id}', [PartenaireController::class, 'destroy'])->name('destroy');
    });


    Route::prefix('personalbarm')->name('personalbarm.')->group(function () {
        Route::get('index', [PersonalBarmController::class, 'index'])->name('index');
        Route::get('create/civil', [PersonalBarmController::class, 'createPersonnelCivil'])->name('civil');
        Route::get('create/militaire', [PersonalBarmController::class, 'createPersonnelMilitaire'])->name('militaire');
        Route::post('store', [PersonalBarmController::class, 'store'])->name('store');
        Route::post('update/{id}', [PersonalBarmController::class, 'update'])->name('update');
        Route::put('update/password/{id}', [PersonalBarmController::class, 'updatePassword'])->name('update.password');
        Route::get('edit/{id}', [PersonalBarmController::class, 'edit'])->name('edit');
        Route::get('show/{id}', [PersonalBarmController::class, 'show'])->name('show');
        Route::delete('destroy/{id}', [PersonalBarmController::class, 'destroy'])->name('destroy');

        Route::get('death', [PersonalBarmController::class, 'createDeath'])->name('death.create');
        Route::put('death', [PersonalBarmController::class, 'death'])->name('death');
    });

    //gestion administrative //
    Route::prefix('demande')->name('demande.')->group(function () {
        Route::get('personnel/leave/list', [PersonalBarmController::class, 'PersonelLeaveList'])->name('PersonelLeave');
        Route::get('personnel/leave/edit/{id}', [PersonalBarmController::class, 'editPersonnelLeave'])->name('editPersonnelLeave');
        Route::post('personnel/leave/update', [PersonalBarmController::class, 'updatePersonnelLeave'])->name('updatePersonnelLeave');
        Route::post('demande/search', [PersonalBarmController::class, 'leavefilter'])->name('leaveSearch');
    });

    Route::prefix('attestion')->name('certificat.')->group(function () {
        Route::get('personnel/list', [PersonalBarmController::class, 'Personelindex'])->name('PersonelList');
        Route::get('attestation-pdf/{id}', [PersonalBarmController::class, 'attestatGAionPdf'])->name('attestationPdf');
        Route::get('post-pdf/{id}', [PersonalBarmController::class, 'postPdf'])->name('postPdf');
        Route::get('conge-pdf/{id}', [PersonalBarmController::class, 'demandeCongePdf'])->name('demandeCongePdf');


        Route::post('attestation/search', [PersonalBarmController::class, 'filter'])->name('attestationSearch');
    });

    //Informations RH
    Route::prefix('information')->name('info.')->group(function () {
        Route::get('/info', [InfoController::class, 'index'])->name('histo');
        Route::get('create', [InfoController::class, 'create'])->name('info-create');
        Route::post('store', [InfoController::class, 'store'])->name('info-store');
        Route::get('status/{id}', [InfoController::class, 'status'])->name('status');

        Route::get('edit/{id}', [InfoController::class, 'editInfo'])->name('edit');
        Route::post('update/{id}', [InfoController::class, 'updateInfo'])->name('update');
        Route::get('delete/info/{id}', [InfoController::class, 'deleteInfo'])->name('delete');
    });

    Route::get('profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('profil/update/{type}', [ProfilController::class, 'update'])->name('profil.update');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('index', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('store', [UserController::class, 'store'])->name('store');
        Route::post('update', [UserController::class, 'update'])->name('update');
        Route::get('destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
        Route::get('show/{id}', [UserController::class, 'show'])->name('show');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
    });

    Route::prefix('role')->name('role.')->group(function () {
        Route::get('list', [RoleController::class, 'listRole'])->name('index');
        Route::get('create', [RoleController::class, 'createRole'])->name('create');
        Route::post('store', [RoleController::class, 'store'])->name('store');
        Route::post('update/{slug}', [RoleController::class, 'update'])->name('update');
        Route::get('destroy/{slug}', [RoleController::class, 'destroy'])->name('destroy');

        Route::get('edit/{slug}', [RoleController::class, 'edit'])->name('edit');
    });

    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::get('index', [PermissionController::class, 'index'])->name('index');
        Route::get('create', [PermissionController::class, 'create'])->name('create');
        Route::post('store', [PermissionController::class, 'store'])->name('store');
        Route::post('update', [PermissionController::class, 'update'])->name('update');
        Route::get('destroy/{slug}', [PermissionController::class, 'destroy'])->name('destroy');
        Route::get('show/{slug}', [PermissionController::class, 'show'])->name('show');
        Route::get('edit/{slug}', [PermissionController::class, 'edit'])->name('edit');
    });

    //Cohort
    Route::prefix('cohort')->name('cohort.')->group(function () {
        Route::get('add_adherent/{id}', [CohortController::class, 'add_adherent'])->name('add_adherent');
        Route::put('update_adherent/{id}', [CohortController::class, 'update_adherent'])->name('update_adherent');
        
        // API routes for DataTable server-side processing
        Route::get('{cohortId}/adherents/{type}', [CohortController::class, 'getAdherentsData'])->name('adherents.data');
        Route::get('{cohortId}/available-adherents', [CohortController::class, 'getAvailableAdherentsData'])->name('available_adherents.data');

        /**
         * route training
         * @model partner
         * @method route<get, post, put, delete>
         */
        Route::prefix('partner')->name('partner.')->group(function () {
            Route::get('index', [CohortController::class, 'cohortPartner'])->name('index');
            Route::get('show/{id}', [CohortController::class, 'cohortPartnerShow'])->name('show');
        });


        /**
         * route training
         * @model training
         * @method route<get, post, put, delete>
         */
        Route::prefix('training')->name('training.')->group(function () {
            Route::get('index/{idCohort}', [TrainingController::class, 'index'])->name('index');
            Route::get('create/{idCohort}', [TrainingController::class, 'create'])->name('create');
            Route::post('create/{idCohort}', [TrainingController::class, 'store'])->name('store');

            Route::get('show/{id}', [TrainingController::class, 'show'])->name('show');
            Route::put('update/{id}', [TrainingController::class, 'update'])->name('update');

        });

        //personal
        Route::get('personal/training', [TrainingController::class, 'cohortPersonal'])->name('personal.training');
        Route::get('{idCohort}/personal/training', [TrainingController::class, 'cohortPersonalTraining'])->name('show.personal.training');
        Route::get('/personal/training/{id}', [TrainingController::class, 'cohortPersonalTrainingShow'])->name('personal.training.show');

        /**
         * route data_collect
         * @model data_collect
         * @method route<get, post, put, delete>
         */
        Route::prefix('data_collect')->name('data_collect.')->group(function () {
            Route::get('list', [DataCollectController::class, 'list'])->name('list');
            Route::get('index/{idCohort}', [DataCollectController::class, 'index'])->name('index');

            Route::post('create/{idAdherent}', [DataCollectController::class, 'store'])->name('store');
            // Route::put('update/{id}', [DataCollectController::class, 'update'])->name('update');
            Route::post('validate', [DataCollectController::class, 'validateDC'])->name('validate');
        });

        /**
         * route pa
         * @model pa
         * @method route<get, post, put, delete>
         */
        Route::prefix('pa')->name('pa.')->group(function () {

            Route::get('cohorts', [PAController::class, 'cohorts'])->name('cohorts');
            Route::get('cohort/{id}', [PAController::class, 'cohort'])->name('cohort');

            Route::get('list_pending', [PAController::class, 'list_pending'])->name('list_pending');

            //financial
            // Route::get('list_accepted', [PAController::class, 'list_accepted'])->name('list_accepted');
            // Route::get('list_new', [PAController::class, 'list_new_partner_financial'])->name('list_new');

            Route::get('refused', [PAController::class, 'refused'])->name('refused');
            Route::post('create/{idAdherent}', [PAController::class, 'store'])->name('store');
            Route::put('update/{id}', [PAController::class, 'update'])->name('update');
        });
    });

    /**
     * route monitored-evaluation
     * @model monitored-evaluation
     * @method route<get, post, put, delete>
     */
    Route::prefix('monitored-evaluation')->name('monitored-evaluation.')->group(function () {

        Route::prefix('favorable_opinion')->name('favorable_opinion.')->group(function () {
            Route::get('cohort', [FavorableOpinionController::class, 'cohorts'])->name('cohorts');
            Route::get('cohort/{id}', [FavorableOpinionController::class, 'cohort'])->name('cohort');
            Route::put('cohort/adherent/{id}/approved', [FavorableOpinionController::class, 'approved'])->name('approved');
        });

        Route::prefix('account_opening')->name('account_opening.')->group(function () {

            Route::get('file/adherent/{id}', [AccountOpeningController::class, 'file'])->name('file');
            Route::post('imputation/adherent', [AccountOpeningController::class, 'imputation'])->name('imputation');

            Route::get('cohort', [AccountOpeningController::class, 'cohorts'])->name('cohorts');
            Route::get('cohort/authorization', [AccountOpeningController::class, 'cohorts_authorization'])->name('cohorts.authorization');

            Route::get('cohort/{id}/plug_removal', [AccountOpeningController::class, 'plug_removal'])->name('cohort.plug_removal');
            Route::put('cohort/adherent/{id}/approved_account_opening', [AccountOpeningController::class, 'approved_account_opening'])->name('approved_account_opening');

            Route::get('cohort/{id}/authorization', [AccountOpeningController::class, 'authorization'])->name('cohort.authorization');
            Route::put('cohort/adherent/{id}/authorization_approved', [AccountOpeningController::class, 'authorization_approved'])->name('authorization_approved');
        });

        Route::prefix('credit_committee')->name('credit_committee.')->group(function () {

            Route::get('index', [CreditCommitteeController::class, 'index'])->name('index');
            Route::get('create', [CreditCommitteeController::class, 'create'])->name('create');
            Route::get('{id}', [CreditCommitteeController::class, 'show'])->name('show');
            Route::post('', [CreditCommitteeController::class, 'store'])->name('store');
            Route::post('validation', [CreditCommitteeController::class, 'validation'])->name('validation');
            Route::post('ajourner', [CreditCommitteeController::class, 'ajourner'])->name('ajourner');
            Route::post('remettre-en-attente', [CreditCommitteeController::class, 'remettreEnAttente'])->name('remettre_en_attente');
        });

        Route::prefix('ten_percent')->name('ten_percent.')->group(function () {
            Route::get('', [TenPercentController::class, 'index'])->name('index');
            Route::post('', [TenPercentController::class, 'store'])->name('store');
        });

        Route::prefix('disbursement')->name('disbursement.')->group(function () {
            Route::get('cohort', [DisbursementController::class, 'cohorts'])->name('cohorts');
            Route::get('cohort/{id}', [DisbursementController::class, 'cohort'])->name('cohort');
            Route::get('adherent/{id}', [DisbursementController::class, 'adherent'])->name('adherent');
            Route::post('adherent', [DisbursementController::class, 'store'])->name('store');

            Route::post('{id}/update/loan', [DisbursementController::class, 'updateLoan'])->name('update.loan');

            Route::post('{id}/store/authorization', [DisbursementController::class, 'storeAuthorization'])->name('store.authorization');

            Route::post('{id}/update/authorization', [DisbursementController::class, 'updateAuthorization'])->name('update.authorization');
            Route::post('{id}/update/disbursement', [DisbursementController::class, 'updateDisbursement'])->name('update.disbursement');
            Route::post('{id}/update/last_report', [DisbursementController::class, 'updateLastReport'])->name('update.last_report');
            Route::post('{id}/update/file_signed_report', [DisbursementController::class, 'updateSignedReport'])->name('update.file_signed_report');
        });

        Route::prefix('disbursement_deadline')->name('disbursement_deadline.')->group(function () {
            Route::post('', [DisbursementDeadlineController::class, 'store'])->name('store');
            Route::post('{id}', [DisbursementDeadlineController::class, 'update'])->name('update');
            Route::post('reminder/{id}', [DisbursementDeadlineController::class, 'update_reminder'])->name('reminder');
        });

        Route::prefix('post_monitored')->name('post_monitored.')->group(function () {
            Route::post('adherent/{id}', [PostMonitoredController::class, 'store'])->name('store');

            Route::get('cohort', [PostMonitoredController::class, 'cohorts'])->name('cohorts');
            Route::get('cohort/{id}', [PostMonitoredController::class, 'cohort'])->name('cohort');
            Route::get('candidats_fp', [PostMonitoredController::class, 'candidats_fp'])->name('candidats_fp');
            Route::get('candidats_ep', [PostMonitoredController::class, 'candidats_ep'])->name('candidats_ep');
            Route::get('adherent/{id}', [PostMonitoredController::class, 'adherent'])->name('adherent');
        });
    });

    //Cohort
    Route::resource('cohort', CohortController::class);

    //search retired
    route::get('retiredSearch', [InscriptionController::class, 'retiredSearch'])->name('retiredSearch');

    //Adherent
    Route::prefix('adherent')->name('adherent.')->group(function () {


        route::get('form', [InscriptionController::class, 'createPersonal'])->name('create');
        // route::get('edit/{id}', [InscriptionController::class, 'edit'])->name('edit');
        route::get('form/{step}/{id}', [InscriptionController::class, 'stepPersonal'])->name('step');
        route::get('steps', [InscriptionController::class, 'steps'])->name('steps');
        route::get('pending', [InscriptionController::class, 'pending'])->name('pending');
        route::get('list', [InscriptionController::class, 'list'])->name('list');
        Route::get('list/pending_cohort', [InscriptionController::class, 'pending_cohort'])->name('list.pending_cohort');

        route::put('update/{step}/{id}', [InscriptionController::class, 'updatePersonal'])->name('update');
        route::put('approved/{id}', [InscriptionController::class, 'approved'])->name('approved');

        route::get('choice_final/{candidature}', [InscriptionController::class, 'choiceFinal'])->name('choice.final');
        route::post('choice_final/{id}', [InscriptionController::class, 'choiceFinalStore'])->name('choice.final.store');

        route::get('choice_partner/{id}', [InscriptionController::class, 'choicePartnerTechnicial'])->name('choice.partner.technical');
        route::get('show/{id}', [InscriptionController::class, 'show'])->name('show');
        route::get('edit/{id}', [InscriptionController::class, 'edit'])->name('edit');
        route::get('{id}/data', [InscriptionController::class, 'getAdherentData'])->name('data');
        route::put('profile-update/{id}', [InscriptionController::class, 'update'])->name('update.profile');
        route::put('password/{id}', [InscriptionController::class, 'updatePasswordProfile'])->name('profile.password');

        route::get('deaths', [InscriptionController::class, 'deaths'])->name('deaths');
        route::delete('death/{id}', [InscriptionController::class, 'death'])->name('death');

        route::get('resignations', [InscriptionController::class, 'resignations'])->name('resignations');
        route::delete('resignation/{id}', [InscriptionController::class, 'resignation'])->name('resignation');

        route::post('duplicate', [DuplicatCandidatureController::class, 'store'])->name('duplicate');


        /**
         * route validation
         * @model candidature, choice final
         * @method route<get, post, put, delete>
         */
        Route::prefix('candidature')->name('candidature.')->group(function () {

            Route::prefix('validation')->name('validation.')->group(function () {
                Route::get('pending', [ValidationCandidatureController::class, 'pending'])->name('pending');
                Route::get('list', [ValidationCandidatureController::class, 'list'])->name('list');
                Route::get('show/{id}', [ValidationCandidatureController::class, 'show'])->name('show');
                Route::get('status/{id}/{status}', [ValidationCandidatureController::class, 'status'])->name('status');
            });

            Route::prefix('choice-final')->name('choice-final.')->group(function () {
                Route::get('news', [ChoiceFinalController::class, 'news'])->name('news');
                Route::get('refused', [ChoiceFinalController::class, 'refused'])->name('refused');
                Route::get('show/{id}', [ChoiceFinalController::class, 'show'])->name('show');
                Route::get('remake/{id}', [ChoiceFinalController::class, 'remake'])->name('remake');
                Route::put('remake/{id}', [ChoiceFinalController::class, 'remakeUpdate'])->name('remake.update');
                Route::post('training/{id}', [ChoiceFinalController::class, 'training'])->name('training');
                Route::put('update/{id}', [ChoiceFinalController::class, 'update'])->name('update');
            });
        });
    });

    Route::prefix('inscription')->name('inscription.')->group(function () {

        route::get('form', [InscriptionController::class, 'create'])->name('create');
        route::get('form/{step}', [InscriptionController::class, 'step'])->name('step');
        route::put('update/{id}', [InscriptionController::class, 'update'])->name('update');

        route::post('choice_partner/{id}', [InscriptionController::class, 'choice_partner'])->name('choice_partner');
    });


    Route::prefix('candidature')->name('candidature.')->group(function () {
        route::get('liste_attente', [SubmissionConroller::class, 'liste_attente'])->name('liste_attente');
        route::get('liste_admis', [SubmissionConroller::class, 'liste_admis'])->name('liste_admis');
        route::get('liste_refus', [SubmissionConroller::class, 'liste_refus'])->name('liste_refus');
        route::post('accepte_candidature/{submission}', [SubmissionConroller::class, 'accepte_candidature'])->name('accepte_candidature');
        route::post('refuse_candidature/{submission}', [SubmissionConroller::class, 'refuse_candidature'])->name('refuse_candidature');
    });

    // ----------------------------------------------------------------
    // GADGET RESOURCES
    // ----------------------------------------------------------------
    Route::prefix('gadget')->name('gadget.')->group(function () {
        Route::get('pdf/{id}/distribution', [GadgetDistributionController::class, 'pdf_distribution'])->name('pdf_distribution');
        Route::get('pdf/{id}', [GadgetDistributionController::class, 'pdf_gadget'])->name('pdf_gadget');
        Route::resource('distribution', GadgetDistributionController::class);
    });
    Route::resource('gadget', GadgetController::class);

    // Dossiers
    Route::prefix('dossier')->name('dossier.')->group(function () {
        route::get('index', [DossierController::class, 'index'])->name('index');
        route::get('create', [DossierController::class, 'create'])->name('create');
        route::post('store', [DossierController::class, 'store'])->name('store');
        route::get('edit/{id}', [DossierController::class, 'edit'])->name('edit');
        route::put('update/{id}', [DossierController::class, 'update'])->name('update');
        route::get('show/{id}', [DossierController::class, 'show'])->name('show');
        route::delete('delete/{id}', [DossierController::class, 'destroy'])->name('delete');
        Route::get('/download-image/{id}', [DossierController::class, '@downloadImage'])->name('download');
    });

    // Archives
    Route::prefix('archive')->name('archive.')->group(function () {
        route::get('liste', [ArchiveController::class, 'liste'])->name('liste');
        route::get('index/{id}', [ArchiveController::class, 'index'])->name('index');
        route::get('create', [ArchiveController::class, 'create'])->name('create');
        route::post('store', [ArchiveController::class, 'store'])->name('store');
        route::get('edit/{id}', [ArchiveController::class, 'edit'])->name('edit');
        route::put('update/{id}', [ArchiveController::class, 'update'])->name('update');
        route::get('show/{id}', [ArchiveController::class, 'show'])->name('show');
        route::delete('delete/{id}', [ArchiveController::class, 'destroy'])->name('delete');
        Route::get('/download-image/{id}', [ArchiveController::class, '@downloadImage'])->name('download');
    });
    /**
     * partners routes
     * @model partner employment routes
     * partners financial routes
     * @method route<get, post, put, delete>
     */
    Route::resource('job', JobOfferController::class);

    /**
     * annual budget routes
     * @model annualbudget
     * @method route<get, post, put, delete>
     */
    Route::get('annual-budget/status/{id}/{status}', [AnnualBudgetController::class, 'status'])->name('annual-budget.status');
    Route::resource('annual-budget', AnnualBudgetController::class);
    Route::name('annual-budget.')->group(function () {
        Route::get('establishment/status/{id}/{status}', [AnnualBudgetEstablishmentController::class, 'status'])->name('establishment.status');
        Route::get('establishment/{id}/edit2', [AnnualBudgetEstablishmentController::class, 'edit2'])->name('establishment.edit.2');
        Route::put('establishment/update2/{id}', [AnnualBudgetEstablishmentController::class, 'update2'])->name('establishment.update.2');
        Route::resource('establishment', AnnualBudgetEstablishmentController::class);
    });

    Route::prefix('budget-plans')->name('budget-plans.')->group(function () {

        Route::get('export/{budgetPlan}/export', function (App\Models\BudgetPlan $budgetPlan) {
            return Excel::download($budgetPlan->type == 'c2d' ? new BudgetPlanExport($budgetPlan) : new BudgetPlanExportMem($budgetPlan),  formatTitleBudgetPlan($budgetPlan) . '.xlsx');
        })->name('export');

        Route::get('/', [BudgetPlanController::class, 'index'])->name('index');
        Route::get('/create', [BudgetPlanController::class, 'create'])->name('create');
        Route::post('/', [BudgetPlanController::class, 'store'])->name('store');
        Route::get('/{budgetPlan}', [BudgetPlanController::class, 'show'])->name('show');
        Route::get('/{budgetPlan}/edit', [BudgetPlanController::class, 'edit'])->name('edit');
        Route::put('/{budgetPlan}', [BudgetPlanController::class, 'update'])->name('update');
        Route::delete('/{budgetPlan}', [BudgetPlanController::class, 'destroy'])->name('destroy');

        Route::prefix('budget-plan-components')->name('budget-plan-components.')->group(function () {
            Route::post('/{budgetPlan}', [BudgetPlanComponentController::class, 'store'])->name('store');
            Route::put('/{component}', [BudgetPlanComponentController::class, 'update'])->name('update');
            Route::delete('/{component}', [BudgetPlanComponentController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('budget-plan-sub-components')->name('budget-plan-sub-components.')->group(function () {
            Route::post('/{component}', [BudgetPlanSubComponentController::class, 'store'])->name('store');
            Route::put('/{subComponent}', [BudgetPlanSubComponentController::class, 'update'])->name('update');
            Route::delete('/{subComponent}', [BudgetPlanSubComponentController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('budget-plan-sections')->name('budget-plan-sections.')->group(function () {
            Route::post('/{subComponent}', [BudgetPlanSectionController::class, 'store'])->name('store');
            Route::put('/{section}', [BudgetPlanSectionController::class, 'update'])->name('update');
            Route::delete('/{section}', [BudgetPlanSectionController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('budget-plan-parts')->name('budget-plan-parts.')->group(function () {
            Route::post('/{section}', [BudgetPlanPartController::class, 'store'])->name('store');
            Route::put('/{part}', [BudgetPlanPartController::class, 'update'])->name('update');
            Route::put('/{part}/update_total_execution', [BudgetPlanPartController::class, 'update_total_execution'])->name('update_total_execution');
            Route::delete('/{part}', [BudgetPlanPartController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('budget-plan-activities')->name('budget-plan-activities.')->group(function () {
            Route::post('/{section}', [BudgetPlanActivityController::class, 'store'])->name('store');
            Route::put('/{activity}', [BudgetPlanActivityController::class, 'update'])->name('update');
            Route::delete('/{activity}', [BudgetPlanActivityController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('monitoring')->name('monitoring.')->group(function () {

            Route::get('export/{budgetPlan}', function (App\Models\BudgetPlan $budgetPlan) {
                return Excel::download(new BudgetPlanMonitoringExport($budgetPlan),  'suivi_du_' . formatTitleBudgetPlan($budgetPlan) . '.xlsx') ;
            })->name('export');
        
            Route::get('index', [BudgetPlanMonitoringController::class, 'index'])->name('index');
            Route::get('show/{budgetPlan}', [BudgetPlanMonitoringController::class, 'show'])->name('show');
        });
    });



    /**
     * pointings route
     * @method route<get, post, put>
     */
    Route::get('pointings', [PointingController::class, 'index'])->name('pointing.index');
    Route::get('pointing', [PointingController::class, 'create'])->name('pointing.create');
    Route::post('pointing', [PointingController::class, 'storeOrUpdate'])->name('pointing.store');
    Route::put('pointing', [PointingController::class, 'update'])->name('pointing.edit');


    /**
     * routes
     * @model newcast
     * @model team
     * @model setting
     * @model partner
     * @method route<get, post, put, delete>
     */
    Route::resource('ad', AdController::class);
    Route::resource('new', NewController::class);
    Route::get('team/chief/{id}', [TeamController::class, 'chief'])->name('team.chief');
    Route::resource('team', TeamController::class);
    Route::resource('setting', SettingController::class);
    Route::resource('partner', PartnerController::class);

    Route::prefix('leave')->name('leave.')->group(function () {

        Route::get('list', [LeaveController::class, 'listLeave'])->name('leavelist');
        Route::get('create', [LeaveController::class, 'createLeave'])->name('create');
        Route::post('store', [LeaveController::class, 'storeLeave'])->name('store');
        Route::get('edit/{id}', [LeaveController::class, 'editLeave'])->name('edit');
        Route::post('update/{id}', [LeaveController::class, 'updateLeave'])->name('update');
        Route::get('leave-pdf/{id}', [LeaveController::class, 'leavePdf'])->name('leave-pdf');
        Route::get('delete/leave/{id}', [LeaveController::class, 'deleteLeave'])->name('delete');

        Route::post('leave/search', [LeaveController::class, 'personneleavefilter'])->name('persleaveSearch');
    });

    //Activités Annuelles
    Route::prefix('respo_com')->name('activities.')->group(function () {
        Route::get('create', [ActivitiesController::class, 'createActivities'])->name('create');
        Route::post('/storeActivities', [ActivitiesController::class, 'store'])->name('store');
        Route::get('/activitiesList', [ActivitiesController::class, 'index'])->name('list');
        Route::get('/activities/edit/{id}', [ActivitiesController::class, 'show'])->name('edit');
        Route::get('/activities/view/{id}', [ActivitiesController::class, 'view'])->name('show');
        Route::post('/activities/update/{id}', [ActivitiesController::class, 'update'])->name('update');
        Route::get('delete/activities/{id}', [ActivitiesController::class, 'destroy'])->name('delete');
        Route::get('status/{id}', [ActivitiesController::class, 'status'])->name('statusUpdate');
    });


    /**
     * mails route
     * map by ip
     * @method route<get, post, put>
     */
    Route::get('map/{type}/{ip}', [MailController::class, 'map'])->name('map');
    Route::name('mail.')->prefix('mail')->group(function () {

        Route::get('subscribes', [MailController::class, 'subscribes'])->name('subscribes');
        Route::get('create_mail', [MailController::class, 'create_mail'])->name('create_mail');

        Route::post('send_mail', [MailController::class, 'send_mail'])->name('send_mail');
    });


    // demandes de materiels
    Route::resource('besoins', BesoinController::class);
    Route::post('validatebesoin/{id}', [
        BesoinController::class,
        'validated'
    ])->name('validatebesoin');
    Route::post('refusebesoin/{id}', [
        BesoinController::class,
        'refused'
    ])->name('refusebesoin');
    Route::resource('besoinitems', BesoinitemController::class);
    Route::get('pdf/{id}', [BesoinController::class, 'pdf'])->name('pdf');

    // sessions collectives
    Route::resource('sessioncollectives', SessioncollectiveController::class);
    Route::get('/getCandidats', [SessioncollectiveController::class, 'getCandidats']);
    Route::post(
        '/updatepresence/{sessioncollective}/{candidature}',
        [SessioncollectiveController::class, 'updatepresence']
    )->name('updatepresence');
    Route::get('/listepartenersession', [SessioncollectiveController::class, 'listepartenersession'])->name('listepartenersession');
    Route::get('/listepartenershow/{id}', [SessioncollectiveController::class, 'listepartenershow'])->name('listepartenershow');
    Route::post('/updatestatuspartnercandidat/{candidature}', [
        SessioncollectiveController::class,
        'updatestatuspartnercandidat'
    ])->name('updatestatuspartnercandidat');

    Route::get('/candidaturevalidated', [SessioncollectiveController::class, 'candidaturevalidated'])->name('candidaturevalidated');
    Route::get('/partnercandidaturevalidated', [SessioncollectiveController::class, 'partnercandidaturevalidated'])->name('partnercandidaturevalidated');
    Route::get('/candidaturepresent', [SessioncollectiveController::class, 'candidaturepresent'])->name('candidaturepresent');
    Route::post('/updatecandidatsession/{sessioncollective}/{candidature}', [
        SessioncollectiveController::class,
        'updatecandidatsession'
    ])->name('updatecandidatsession');
    Route::get('/candidatpartner/{candidature}', [
        SessioncollectiveController::class,
        'candidatpartner'
    ])->name('candidatpartner');
    Route::post('/updatecandidatpartner/{candidature}', [
        SessioncollectiveController::class,
        'updatecandidatpartner'
    ])->name('updatecandidatpartner');
    Route::get('/listecandidature', [
        SessioncollectiveController::class,
        'listecandidature'
    ])->name('listecandidature');
    Route::get('/listecandidaturerefuser', [
        SessioncollectiveController::class,
        'listecandidaturerefuser'
    ])->name('listecandidaturerefuser');
    Route::post('/sessioncollectives/assign-partner', [
        SessioncollectiveController::class,
        'assignPartner'
    ])->name('sessioncollectives.assign-partner');
    Route::post('/validatecandidature/{candidature}', [
        SessioncollectiveController::class,
        'validatecandidature'
    ])->name('validatecandidature');

    Route::get('/listecandidatureprovisoire', [
        SessioncollectiveController::class,
        'listecandidatureprovisoire'
    ])->name('listecandidatureprovisoire');
    Route::get('/candidaturepartnerprovisoire', [
        SessioncollectiveController::class,
        'candidaturepartnerprovisoire'
    ])->name('candidaturepartnerprovisoire');
    Route::get('/ouverture_compte/{candidature}', [
        SessioncollectiveController::class,
        'ouverture_compte'
    ])->name('ouverture_compte');
    Route::post('/changecandidatpartner', [
        SessioncollectiveController::class,
        'changecandidatpartner'
    ])->name('changecandidatpartner');

    // profilage
    Route::prefix('profilages')->name('profilage.')->group(function () {

        Route::get('/profilage', [SessioncollectiveController::class, 'profilage'])->name('profilage');
        Route::get('/index_profilage/{cohort}', [SessioncollectiveController::class, 'index_profilage'])->name('index_profilage');
        Route::get('/create_profilage/{cohort}', [SessioncollectiveController::class, 'create_profilage'])->name('create_profilage');
        Route::post('/store_profilage', [SessioncollectiveController::class, 'store_profilage'])->name('store_profilage');
        Route::get('/candidat_profilage/{cohort}', [
            SessioncollectiveController::class,
            'candidat_profilage'
        ])->name('candidat_profilage');
        Route::get('/end_candidat_profile/{cohort}', [SessioncollectiveController::class, 'end_candidat_profile'])->name('end_candidat_profile');
        Route::get('/partenaire_cohort', [SessioncollectiveController::class, 'partenaire_cohort'])->name('partenaire_cohort');
        Route::get('/partenaire_candidat_profilage', [
            SessioncollectiveController::class,
            'partenaire_candidat_profilage'
        ])->name('partenaire_candidat_profilage');
        Route::get('/histories', [
            SessioncollectiveController::class,
            'histories_profilage'
        ])->name('histories');
        Route::get('/partenaire_candidat_profile/{cohort}', [
            SessioncollectiveController::class,
            'partenaire_candidat_profile'
        ])->name('partenaire_candidat_profile');
        Route::post('/end_profilage', [SessioncollectiveController::class, 'end_profilage'])->name('end_profilage');
        Route::post('/mark_candidate_absent', [SessioncollectiveController::class, 'markCandidateAbsent'])->name('mark_candidate_absent');
        Route::get('/candidats_absents', [SessioncollectiveController::class, 'candidatsAbsents'])->name('candidats_absents');
        Route::get('/candidats_refuses', [SessioncollectiveController::class, 'candidatsRefuses'])->name('candidats_refuses');
    });

    // commission validation
    Route::prefix('pre_commission')->name('pre_commission.')->group(function () {

        Route::get('/pending', [PreCommissionController::class, 'pending'])->name('pending');
        Route::get('/in_progress', [PreCommissionController::class, 'in_progress'])->name('in_progress');
        Route::get('/validated', [PreCommissionController::class, 'validated'])->name('validated');
        Route::post('/store', [PreCommissionController::class, 'store'])->name('store');
        Route::post('/refuse', [PreCommissionController::class, 'refuse'])->name('refuse');
    });

    Route::prefix('commissions')->name('commissions.')->group(function () {

        Route::get('/cohorte', [CommissionController::class, 'cohorte'])->name('cohorte');
        Route::get('/avis_cohorte', [CommissionController::class, 'avis_cohorte'])->name('avis_cohorte');
        Route::get('/jury_members', [CommissionController::class, 'jury_members'])->name('jury_members');
        Route::get('/index/{cohort}', [CommissionController::class, 'index'])->name('index');
        Route::get('/create/{cohort}', [CommissionController::class, 'create'])->name('create');
        Route::get('/candidat_commission/{commission}', [CommissionController::class, 'candidat_commission'])->name('candidat_commission');
        Route::get('/candidat_commission_favorable/{cohort}', [CommissionController::class, 'candidat_commission_favorable'])->name('candidat_commission_favorable');
        Route::post('/candidat_opinion/{candidature}', [CommissionController::class, 'candidat_opinion'])->name('candidat_opinion');
        Route::post('/store', [CommissionController::class, 'store'])->name('store');
        Route::post('/decision', [CommissionController::class, 'decision'])->name('decision');
        Route::post('/cr', [CommissionController::class, 'cr'])->name('cr');
        Route::get('/commissionpartner/{cohort}', [CommissionController::class, 'commissionpartner'])->name('commissionpartner');
    });

    // pré-profilage non
    Route::resource('rdvpartners', RdvpartnerController::class);
    Route::get('/listepartner', [RdvpartnerController::class, 'listepartner'])->name('listepartner');
    Route::get('/candidaturepartnerpresent', [
        SessioncollectiveController::class,
        'candidaturepartnerpresent'
    ])->name('candidaturepartnerpresent');

    //consommable
    Route::resource('consommables', ConsommableController::class);
    Route::prefix('consommables')->name('consommables.')->group(function () {});

    //entree stock
    Route::resource('entreestock', EntreestockController::class);
    Route::prefix('entreestock')->name('entreestock.')->group(function () {});



    //TRASH
    Route::name('trash.')->prefix('trash')->group(function () {
        //personals
        Route::get('personals', [TrashController::class, 'personals'])->name('personals');
        Route::put('personal/{id}/restore', [TrashController::class, 'retorePersonal'])->name('restore');

        Route::get('personalbarm', [TrashController::class, 'personals'])->name('personalbarm');
        Route::put('personalbarm/{id}/restore', [TrashController::class, 'retorePersonal'])->name('restore.personalbarm');
    });


    // entretiens candidats entreprise privée
    // Route::resource('entretiens', App\Http\Controllers\EntretienController::class);
    Route::prefix('entretiens')->name('entretiens.')->group(function () {
        Route::get('/candidats/{entretien}', [EntretienController::class, 'candidats'])->name('candidats');
        Route::get('/index/{type}', [EntretienController::class, 'index'])->name('index');
        Route::get('/create/{type}', [EntretienController::class, 'create'])->name('create');
        Route::get('/indexfp/{type}', [EntretienController::class, 'indexfp'])->name('indexfp');
        Route::get('/createfp/{type}', [EntretienController::class, 'createfp'])->name('createfp');
        Route::post('/store', [EntretienController::class, 'store'])->name('store');
        Route::post('/storefp', [EntretienController::class, 'storefp'])->name('storefp');
        Route::post('/presence', [EntretienController::class, 'presence'])->name('presence');
        Route::delete('{id}', [EntretienController::class, 'destroy'])->name('destroy');
        Route::delete('/candidatentretiens/{id}', [EntretienController::class, 'destroy_candidatentretiens'])->name('destroy_candidatentretiens');
    });

    Route::put('/candidatentretiens/{id}/update-comment', [EntretienController::class, 'updateCandidatentretienComment'])->name('candidatentretiens.update-comment');

    // bilancompetences candidats entreprise privée
    // Route::resource('bilancompetences', App\Http\Controllers\BilancompetenceController::class);
    Route::prefix('bilancompetences')->name('bilancompetences.')->group(function () {
        Route::get('/candidats', [BilancompetenceController::class, 'candidats'])->name('candidats');
        Route::get('/candidatsfp', [BilancompetenceController::class, 'candidatsfp'])->name('candidatsfp');
        Route::get('/index/{candidat}', [BilancompetenceController::class, 'index'])->name('index');
        Route::get('/create/{candidat}', [BilancompetenceController::class, 'create'])->name('create');
        Route::post('/store', [BilancompetenceController::class, 'store'])->name('store');
        Route::post('/presence', [BilancompetenceController::class, 'presence'])->name('presence');
        Route::delete('{id}', [BilancompetenceController::class, 'destroy'])->name('destroy');
        Route::put('{id}/update-comment', [BilancompetenceController::class, 'updateComment'])->name('update-comment');
    });

    // entreprise privée
    Route::resource('entreprises', App\Http\Controllers\EntrepriseController::class);

    // formations candidats entreprise privée
    Route::resource('formations', App\Http\Controllers\FormationController::class);
    Route::prefix('formations')->name('formations.')->group(function () {
        Route::post('/presence', [FormationController::class, 'presence'])->name('presence');
        Route::delete('/candidatformations/{id}', [FormationController::class, 'destroy_formations_candidatures'])->name('destroy_formations_candidatures');
    });

    Route::put('/candidatformations/{id}/update-comment', [FormationController::class, 'updateCandidatformationComment'])->name('candidatformations.update-comment');

    // formations candidats entreprise privée
    // Route::resource('candidatformations', App\Http\Controllers\CandidatformationController::class);
    // Route::prefix('candidatformations')->name('candidatformations.')->group(function () {


    // });

    // elaboration cv et lm candidats entreprise privée
    // Route::resource('cvlms', App\Http\Controllers\CvlmController::class);
    Route::prefix('cvlms')->name('cvlms.')->group(function () {
        Route::get('/candidats', [CvlmController::class, 'candidats'])->name('candidats');
        Route::get('/index/{candidat}', [CvlmController::class, 'index'])->name('index');
        Route::get('/create/{candidat}', [CvlmController::class, 'create'])->name('create');
        Route::post('/store', [CvlmController::class, 'store'])->name('store');
        Route::delete('{id}', [CvlmController::class, 'destroy'])->name('destroy');
        Route::put('{id}/update-comment', [CvlmController::class, 'updateComment'])->name('update-comment');
    });

    // preparation entretien d'un candidats entreprise privée
    // Route::resource('prepaentretiens', App\Http\Controllers\PrepaentretienController::class);
    Route::prefix('prepaentretiens')->name('prepaentretiens.')->group(function () {
        Route::get('/candidats', [PrepaentretienController::class, 'candidats'])->name('candidats');
        Route::get('/index/{candidat}', [PrepaentretienController::class, 'index'])->name('index');
        Route::get('/create/{candidat}', [PrepaentretienController::class, 'create'])->name('create');
        Route::post('/store', [PrepaentretienController::class, 'store'])->name('store');
        Route::delete('{id}', [PrepaentretienController::class, 'destroy'])->name('destroy');
        Route::put('{id}/update-comment', [PrepaentretienController::class, 'updateComment'])->name('update-comment');
    });

    // candidature d'un candidat dans une entreprise privée
    // Route::resource('candidatentreprises', App\Http\Controllers\CandidatentrepriseController::class);
    Route::prefix('candidatentreprises')->name('candidatentreprises.')->group(function () {
        Route::get('/candidats', [CandidatentrepriseController::class, 'candidats'])->name('candidats');
        Route::get('/index', [CandidatentrepriseController::class, 'index'])->name('index');
        Route::get('/mise_a_disposition', [CandidatentrepriseController::class, 'mise_a_disposition'])->name('mise_a_disposition');
        Route::post('/store_mise_a_disposition', [CandidatentrepriseController::class, 'store_mise_a_disposition'])->name('store_mise_a_disposition');
        Route::post('/store_candidature_spontannee', [CandidatentrepriseController::class, 'store_candidature_spontannee'])->name('store_candidature_spontannee');
        Route::get('/show/{entreprise}/{date}', [CandidatentrepriseController::class, 'show'])->name('show');
        Route::post('/changestatut', [CandidatentrepriseController::class, 'changestatut'])->name('changestatut');
        Route::post('/end_poste', [CandidatentrepriseController::class, 'end_poste'])->name('end_poste');
        Route::get('/create_candidatentreprise/{candidat}', [CandidatentrepriseController::class, 'create_candidatentreprise'])->name('create_candidatentreprise');
        Route::get('/show_candidatentreprise/{candidat}', [CandidatentrepriseController::class, 'show_candidatentreprise'])->name('show_candidatentreprise');

        Route::delete('{id}', [CandidatentrepriseController::class, 'destroy'])->name('destroy');
        Route::get('/suivie_ep_candidats', [CandidatentrepriseController::class, 'suivie_ep_candidats'])->name('suivie_ep_candidats');
        Route::get('/suivie_fp_candidats', [CandidatentrepriseController::class, 'suivie_fp_candidats'])->name('suivie_fp_candidats');
        Route::put('{id}/update-comment', [CandidatentrepriseController::class, 'updateComment'])->name('update-comment');
    });

    // suivis candidats entreprise privée
    Route::resource('suivis', App\Http\Controllers\SuiviController::class);
    Route::prefix('suivis')->name('suivis.')->group(function () {});

    // soummissions de dossier pour les candidats de fonction publique
    Route::prefix('soumissiondossiers')->name('soumissiondossiers.')->group(function () {
        Route::get('/candidats', [App\Http\Controllers\SoumissiondossierController::class, 'candidats'])->name('candidats');
        Route::get('/index/{candidat}', [App\Http\Controllers\SoumissiondossierController::class, 'index'])->name('index');
        Route::get('/create/{candidat}', [App\Http\Controllers\SoumissiondossierController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\SoumissiondossierController::class, 'store'])->name('store');
        Route::post('/choixfinal', [App\Http\Controllers\SoumissiondossierController::class, 'choixfinal'])->name('choixfinal');
        Route::get('/choixconcours', [App\Http\Controllers\SoumissiondossierController::class, 'choixconcours'])->name('choixconcours');
        Route::delete('{id}', [App\Http\Controllers\SoumissiondossierController::class, 'destroy'])->name('destroy');
    });


    // inscription aux concours des candidats de fonction publique
    Route::prefix('inscriptionconcours')->name('inscriptionconcours.')->group(function () {
        Route::get('/candidats', [App\Http\Controllers\InscriptionconcoursController::class, 'candidats'])->name('candidats');
        Route::get('/index/{candidat}', [App\Http\Controllers\InscriptionconcoursController::class, 'index'])->name('index');
        Route::get('/create/{candidat}', [App\Http\Controllers\InscriptionconcoursController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\InscriptionconcoursController::class, 'store'])->name('store');
        Route::post('/decision', [App\Http\Controllers\InscriptionconcoursController::class, 'decision'])->name('decision');
        Route::post('/affectation', [App\Http\Controllers\InscriptionconcoursController::class, 'affectation'])->name('affectation');
        Route::get('/candidatsadmis', [App\Http\Controllers\InscriptionconcoursController::class, 'candidatsadmis'])->name('candidatsadmis');
        Route::get('/candidatsajournes', [App\Http\Controllers\InscriptionconcoursController::class, 'candidatsajournes'])->name('candidatsajournes');
        Route::delete('{id}', [App\Http\Controllers\InscriptionconcoursController::class, 'destroy'])->name('destroy');
    });

    // demande de lettre de recommandation
    Route::resource('lettresrecommandations', LettrerecommandationController::class);
    Route::prefix('lettresrecommandations')->name('lettresrecommandations.')->group(function () {
        Route::post('/status', [LettrerecommandationController::class, 'status'])->name('status');
    });


    Route::resource('offreemplois', App\Http\Controllers\OffreemploiController::class);
});




Route::fallback(function () {
    return view('error404');
});

Route::view('/permission-denied', 'permission-denied')->name('denied');

// Route::get('/fix-bug', function () {
//     // $candidatures = Candidature::whereIn('id', [43, 47, 48, 49, 50, 51, 52, 53, 54, 55, 57, 58, 59, 60, 64, 68, 69])->select('id', 'session_id', 'cohort_id')->get();
//     // $sessioncollective = Sessioncollective::create([
//     //     'cohort_id' => $candidatures[0]->cohort_id,
//     //     'lieu' => 'LYCEE TECHNIQUE D\'ABIDJAN',
//     //     'date' => '2025-09-01',
//     //     'heure' => '10:00',
//     // ]);

//     // $technicale_partenaires = [4];
//     // $sessioncollective->partenaires()->attach($technicale_partenaires, [
//     //     'type' => 'partner_technique',
//     // ]);

//     // $financial_partenaires = [2];
//     // $sessioncollective->partenaires()->attach($financial_partenaires, [
//     //     'type' => 'partner_financial',
//     // ]);

//     // $sessioncollective->candidatures()->attach($candidatures);

//     $candidatures = Candidature::whereIn('id', [43, 47, 48, 49, 50, 51, 52, 53, 54, 55, 57, 58, 59, 60, 64, 68, 69])->select('id', 'session_id', 'cohort_id')->get();
//     $sessioncollective = Sessioncollective::find(6);

//     $sessioncollective->candidatures()->attach($candidatures, [
//         'presence' => '1',
//         'presence_status' => '1',
//     ]);

//     return 'done';
// });

