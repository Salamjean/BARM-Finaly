<?php

namespace App\Providers;

use App\Models\AnnualBudget;
use App\Models\Candidature;
use App\Models\Commissioncandidat;
use App\Models\Informations;
use App\Models\Leave;
use App\Models\SelfEmploymentMonitoredPayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
public function boot(): void
{
    Schema::defaultStringLength(191);

    view()->composer('partials.sidebar', function ($view) {
        $dat = Carbon::today();
        $view->with([
            'validation_pending' => Candidature::whereHas('choiceFinal')->where('status', 'pending')->count(),
            'validation_refused' => Candidature::whereStatus('refused')->count(),
            'leave_pending' => Leave::where('status', 'En attente')->count(),
            'annual_budget' => AnnualBudget::where('year', date('Y'))->where('status', 'launch')->count(),

            'favorable_opinion_pending_count' => Candidature::where('pa_decision', true)->where('favorable_opinion', false)->count(),
            'account_opening_pending_count' => SelfEmploymentMonitoredPayment::where('account_opening', false)->count(),
            'authorization_approved_pending_count' => SelfEmploymentMonitoredPayment::where('account_opening', true)->where('authorization_approved', false)->count(),

            'adherents_commission_pending_count' => DB::table('commissioncandidats')->whereNull('decision')->count(),

            'focal_point_area_count' => Candidature::with(['user', 'partnerTechnical.user'])
                ->orderByDESC('created_at')
                ->where('resignation', '0')
                ->where('death', '0')
                ->where('orientation', 'auto-emploi')
                ->where('pa', '1')
                ->where('pa_decision', '0')
                ->whereNotNull('partner_financial_id')
                ->whereNull('focal_point_area')
                ->count(),
        ]);
    });

    view()->composer('partials.header', function ($view) {
        $view->with([
            'informations' => Informations::first(),
            'infos' => Informations::where('status', 1)->get(),
        ]);
    });
}
}
