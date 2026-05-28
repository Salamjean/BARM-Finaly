<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Region;
use App\Models\Setting;
use App\Models\Village;
use App\Models\Pointing;
use App\Models\Profilage;
use App\Models\Department;
use App\Models\Candidature;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Auth;

function setting(string $element = 'app_name'): string
{
    $config = Setting::whereName($element)->first();
    if ($config)
        return $config->value;
    return '';
}

function public_helper($item)
{

    if($item == 'auto-emploi')
        return Candidature::where('orientation', 'auto-emploi')->count();
    elseif($item == 'fonction-public')
        return Candidature::where('orientation', 'fonction-public')->count();
    elseif($item == 'entreprise-privee')
        return Candidature::where('orientation', 'entreprise-privee')->count();

    return;
}

function formatTitleBudgetPlan($budgetPlan)
{
    $string =  $budgetPlan->name . '_' . $budgetPlan->year;

    $string = strtoupper($string);

    $string = preg_replace('/[^A-Z0-9]/', '_', $string);

    $string = preg_replace('/_+/', '_', $string);

    $string = trim($string, '_');

    return $string;
}

function domain_orientation(): array
{

    return [
        'Agro-pastorale',
        'Artisanat',
        'Commerce',
        'Prestation de services',
    ];
}

function saveByEnv(): string
{
    return config('app.env') == 'production' ? 'public/' : '';
}

function regions()
{
    $regions = Region::orderBy('name')->get()->pluck('name', 'id')->toArray();
    $departments = Department::orderBy('name')->get()->pluck('name', 'id')->toArray();
    $villages = Village::orderBy('name')->get()->pluck('name', 'id')->toArray();

    return [
        'regions' => $regions,
        'departments' => $departments,
        'villages' => $villages,
    ];
}

function convertImageToBase64($path)
{
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    return 'data:image/' . $type . ';base64,' . base64_encode($data);
}

function generateSlug(string $title): string
{
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $title);
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');
    $slug = strtolower($slug);
    return (string)$slug;
}

function deleteSpace(string $character): string
{
    return str_replace(' ', '', $character);
}

function chartMonthFrensh($date)
{
    $carbon = Carbon::parse($date)->locale('fr_FR');
    $date_fr = $carbon->isoFormat('MMMM YYYY');
    return $date_fr;
}

function chartDayFrensh($date)
{
    $carbon = Carbon::parse($date)->locale('fr_FR');
    $date_fr = $carbon->isoFormat('D/M');
    return $date_fr;
}

function pointingStatus(): string
{

    $date_current = date('Y-m-d');
    $hour_current = date('H:i');
    $moment = ($hour_current < '12:00') ? 'start_from' : 'end_to';

    if (!Pointing::where('date', $date_current)->wherePersonalId(auth()->id())->exists())
        return $moment;

    $pointing = Pointing::where('date', $date_current)->wherePersonalId(auth()->id())->first();

    if ($pointing->status == 'finished' || $pointing->end_to)
        return 'finished';

    if ($pointing->status == 'in_progress' && $pointing->start_from > '12:00')
        return 'end_to';

    if ($pointing->status == 'in_progress' && $pointing->start_from < '12:00')
        return 'in_progress';

    return $moment;
}

function routeActive($route): string
{

    $class = 'active open';

    if (is_array($route)) {
        foreach ($route as $key => $value) {
            if (request()->routeIs($value))
                return $class;
        }
    } elseif (request()->routeIs($route))
        return $class;
    return '';
}

function routeItem($route): string
{
    $class = 'item-link-sidebar';

    if (request()->routeIs($route))
        return $class;
    return '';
}

function generateRandomString(int $length = 10): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function statusBudget(string $status, string $type = 'budget')
{
    if ($type === 'budget')
        switch ($status) {

            case 'launch':
                return 'Lancement';
            case 'negotiation':
                return 'En cours';
            case 'finished':
                return 'Terminer';
            default:
                return $status;
        }
    else {
        switch ($status) {
            case 'new':
                return 'En attente';
            case 'verification':
                return 'Reçu';
            case 'finished':
                return 'Approuver';
            default:
                return $status;
        }
    }
}

function statusCandidature(string $status, string $type = 'text')
{
    if ($type === 'text')
        switch ($status) {

            case 'pending':
                return 'Nouvelle';
            case 'in_progress':
                return 'En cours';
            case 'missing':
                return 'Abscent';
            case 'search_financial_partner':
                return 'En recherche de partenaire financier';
            case 'finish':
                return 'Terminer';
            case 'refused':
                return 'Refuser';
            case 'rejected':
                return 'Rejeter';
            case 'accepted':
                return 'Approuver';
            default:
                return $status;
        }
    elseif ($type === 'css') {
        $style = 'style="color: ';
        switch ($status) {
            case 'pending':
                return $style . '#965000"';
            case 'missing':
                return $style . '#965000"';
            case 'refused':
                return $style . '#FF0037"';
            case 'rejected':
                return $style . '#FF0037"';
            case 'accepted':
                return $style . '#007E3F"';
            case 'in_progress':
                return $style . '#00457E"';
            case 'search_financial_partner':
                return $style . '#047A83"';
            case 'finish':
                return $style . '#007E3F"';
            default:
                return '';
        }
    } elseif ($type === 'orientation')
        switch ($status) {

            case 'auto-emploi':
                return 'AUTO EMPLOI';
            case 'fonction-publique':
                return 'FONCTION PUBLIQUE & POLICE';
            case 'entreprise-privee':
                return 'ENTREPRISE PRIVEE';
            default:
                return $status;
        }
    else
        return '';
}

function stepCandidature(string $status, string $type = 'text'): string
{
    if ($type === 'text')
        switch ($status) {
            case '1':
                return 'En Etat civil';
            case '2':
                return 'En Situation matrimoniale';
            case '3':
                return 'En Situation professionnelle';
            case '4':
                return 'En Projet professionnel';
            case '5':
                return 'En Condition de départ';
            case '6':
                return 'En Accident/Maladie';
            case '7':
                return 'En Insertion des pièces jointes';
            case 'pending':
                return 'En attente d\'approbation';
            case 'completed':
                return 'Approuvé';
            default:
                return $status;
        }
    elseif ($type === 'css') {
        $style = 'style="color: ';
        switch ($status) {
            case '1':
                return $style . '#FF0000"';
            case '2':
                return $style . '#FF3300"';
            case '3':
                return $style . '#FF6600"';
            case '4':
                return $style . '#FF9900"';
            case '5':
                return $style . '#FFCC00"';
            case '6':
                return $style . '#FFFF00 "';
            case '7':
                return $style . '#8AE404"';
            case 'pending':
                return $style . '#53CE02"';
            case 'completed':
                return $style . '#00FF00 "';
            default:
                return '';
        }
    } else
        return '';
}

function status(string $status, string $type = 'text'): string
{
    if ($type === 'text')
        switch ($status) {
            case 'init':
                return 'En attente';
            case 'enable':
                return 'activé';
            case 'disable':
                return 'desactivé';
            case 'in_progress':
                return 'En cours';
            case 'finished':
                return 'Terminer';
            case 'accepted':
                return 'Validée';
            case 'approved':
                return 'Validée';
            case 'pending':
                return 'En attente';
            case 'refused':
                return 'Refusée';
            case 'cancelled':
                return 'Refusée';
            case 'cancel':
                return 'Annulée';
            case 'paid':
                return 'Soldé';
            case 'nopaid':
                return 'Pas soldé';

            default:
                return $status;
        }
    elseif ($type === 'css')
        switch ($status) {
            case 'init':
                return 'text-warning';
            case 'enable':
                return ' text-success';
            case 'disable':
                return ' text-danger';
            case 'in_progress':
                return 'text-info';
            case 'finished':
                return 'text-success';
            case 'accepted':
                return 'text-success';
            case 'approved':
                return 'text-success';
            case 'pending':
                return 'text-info';
            case 'refused':
                return 'text-danger';
            case 'cancel':
                return 'text-danger';
            case 'cancelled':
                return 'text-danger';

            case 'paid':
                return 'text-success';
            case 'nopaid':
                return 'text-danger';

            default:
                return '';
        }
    else
        return '';
}

function dateFr($date, $type = 'dayMonthYear')
{
    $carbon = Carbon::parse($date)->locale('fr_FR');

    if (!$date)
        return '';

    if ($type == 'standard')
        $date_fr = $carbon->isoFormat('ddd D MMMM YYYY');
    elseif ($type == 'hour')
        $date_fr = $carbon->isoFormat('HH:mm');
    elseif ($type == 'year')
        $date_fr = $carbon->isoFormat('YYYY');
    elseif ($type == 'day')
        $date_fr = $carbon->isoFormat('dddd');
    elseif ($type == 'monthYear')
        $date_fr = $carbon->isoFormat('MMMM YYYY');
    elseif ($type == 'dayMonthYear')
        $date_fr = $carbon->isoFormat('DD/MM/Y');
    elseif ($type == 'letter')
        $date_fr = $carbon->isoFormat('dddd D MMMM YYYY');
    elseif ($type == 'complet')
        $date_fr = $carbon->isoFormat('DD/MM/Y à HH:mm');

    return $date_fr;
}

function amount($price, $currency = false)
{
    if ($currency)
        return number_format($price, 0, 0, ' ') . ' FCFA';
    else
        return number_format($price, 0, 0, ' ');
}
//Authorized
function roleFr(string $role): string
{
    switch ($role) {
        case 'ADMIN':
            return 'Administrateur';
        case 'CANDIDAT':
            return 'Adhérent';
        case 'PARTNER':
            return 'Parténaire';
        default:
            return $role;
    }
}

function controllerPersonal($user = 'me')
{
    if ($user == 'me')
        $user = auth()->user();
    $permissions = $user->permissions->pluck('name');
    $controller = false;
    $jobName = [];
    foreach ($permissions as $permission) {
        if (in_array($permission, CHIEFS)) {
            $controller = true;
            $jobName[] = $permission;
        }
    }

    if (!$controller)
        abort(404);


    $rolePermission =  RolePermission::whereHas('permission', function ($query) use ($jobName) {
        $query->where('name', $jobName[0]);
    })->first();

    if (!$rolePermission)
        abort(404);

    return $rolePermission;
}

function permissionFr(string $role): string
{
    switch ($role) {
        case 'PARTNER TECHNICAL':
            return 'Parténaire technique';
        case 'PARTNER EMPLOYMENT':
            return 'Parténaire chargé d\'emploi';
        case 'PARTNER FINANCIAL':
            return 'Parténaire financier';
        default:
            return $role;
    }
}

function disbursementPendingCountByUser(string $element = 'pre_disbursement')
{

    $adherents = Candidature::where([
        // ['pre_disbursement', true],
        ['disbursement', true],
        ['post_monitored', false],
    ]);

    if ($element == 'pv_credit') {
        $query = Candidature::with('user')
            ->where('credit_committee', true)
            ->doesntHave('creditCommittee');
        $partenaire = auth()->user()->partenaire ?? null;
        if ($partenaire) {
            $query->where('partner_financial_id', $partenaire->id);
        }
        return $query->count();
    }

    if ($element == 'ten_percent')
        return Candidature::with('user')
            ->where('credit_committee', true)
            ->where('ten_percent', false)
            ->whereHas('creditCommittee', function ($query) {
                $query->where('status', 'finished');
            })
            ->count();

    if ($element != 'pre_disbursement')
        $adherents = $adherents->whereHas('selfEmploymentMonitoredPayment', function ($query) {
            $query->where('account_opening', true)->where('open_disbursement', false);
        });
    else
        $adherents = $adherents->whereHas('selfEmploymentMonitoredPayment', function ($query) {
            $query->where('account_opening', true)->where('open_disbursement', true);
        });

    if (can('partner-technical'))
        return $adherents = $adherents->where('partner_technical_id', auth()->user()->partenaire->id)->count();
    elseif (can('partner-financial'))
        return $adherents = $adherents->where('partner_financial_id', auth()->user()->partenaire->id)->count();
    else
        return $adherents = $adherents->count();
}



/**
 * ============================================================
 * NOTIFICATIONS POINT FOCAL
 * ============================================================
 */

/**
 * Nombre total de profilages organisés (badge informatif sur l'onglet Profilages).
 * Pour le point focal : filtrés par les cohortes liées à leur ville.
 * Pour les autres rôles : tous les profilages.
 */
function focalPointProfilageCount(): int
{
    if (!Auth::check()) return 0;

    return Profilage::count();
}

/**
 * Nombre de candidats présents à une session collective dont la présence
 * n'a pas encore été traitée/mise à jour (action requise sur "Candidats présents aux sessions").
 * Filtré par ville_barm pour le point focal.
 */
function focalPointCandidatsPresentCount(): int
{
    if (!Auth::check()) return 0;

    $query = Candidature::where('resignation', '0')
        ->where('death', '0')
        ->where('orientation', 'auto-emploi')
        ->whereNotNull('session_id')
        ->where('session_collective', '1')
        ->where('status', 'pending');

    if (Auth::user()->roles->first()?->name === 'POINTS FOCAUX') {
        $villeBarm = Auth::user()->personnel?->ville_barm;
        if ($villeBarm) {
            $query->whereHas('createdBy.personnel', function ($q) use ($villeBarm) {
                $q->where('ville_barm', '=', $villeBarm);
            });
        }
    }

    return $query->count();
}

/**
 * Nombre de candidats (step=completed, auto-emploi, en session) non encore profilés
 * (sans partenaire technique assigné). Action requise sur "Liste des candidats profilés".
 * Filtré par ville_barm pour le point focal.
 */
function focalPointCandidatsNonProfilesCount(): int
{
    if (!Auth::check()) return 0;

    $query = Candidature::whereStep('completed')
        ->where('resignation', '0')
        ->where('death', '0')
        ->where('orientation', 'auto-emploi')
        ->whereNotNull('session_id')
        ->whereNull('partner_technical_id');

    if (Auth::user()->roles->first()?->name === 'POINTS FOCAUX') {
        $villeBarm = Auth::user()->personnel?->ville_barm;
        if ($villeBarm) {
            $query->whereHas('createdBy.personnel', function ($q) use ($villeBarm) {
                $q->where('ville_barm', '=', $villeBarm);
            });
        }
    }

    return $query->count();
}

/**
 * Nombre de dossiers en attente de la saisie de la zone du point focal
 * (pa=1, pa_decision=0, focal_point_area=null). Action requise sur "Plan d'affaire".
 * Filtré par ville_barm pour le point focal.
 */
function focalPointPlanAffaireCount(): int
{
    if (!Auth::check()) return 0;

    $query = Candidature::where('resignation', '0')
        ->where('death', '0')
        ->where('orientation', 'auto-emploi')
        ->where('pa', '1')
        ->where('pa_decision', '0')
        ->whereNotNull('partner_financial_id')
        ->whereNull('focal_point_area');

    if (Auth::user()->roles->first()?->name === 'POINTS FOCAUX') {
        $villeBarm = Auth::user()->personnel?->ville_barm;
        if ($villeBarm) {
            $query->where(function ($q) use ($villeBarm) {
                // Candidats dont la zone attendue correspond à la ville du point focal
                $q->whereHas('createdBy.personnel', function ($qq) use ($villeBarm) {
                    $qq->where('ville_barm', '=', $villeBarm);
                });
            });
        }
    }

    return $query->count();
}

function dateFormat(string $dateTime)
{
    $date = Carbon::parse($dateTime);

    if ($date->diffInDays() > 1) {
        return "Il y a " . $date->diffInDays() . " jour(s)";
    }
    return $date->diffForHumans();
}

function role(): string
{
    if (Auth::user()->roles[0])
        return Auth::user()->roles[0]->slug;
    else
        return '';
}

// function userPermissions(User $user = null): array
function userPermissions(?User $user = null)
{
    if ($user) {
        $slugs = [];
        foreach ($user->permissions as $perm)
            $slugs[] = $perm->slug;
        return $slugs;
    }

    if (Auth::user()->permissions) {
        $slugs = [];
        foreach (Auth::user()->permissions as $perm)
            $slugs[] = $perm->slug;
        return $slugs;
    } else
        return [];
}

function authPermission(string $permissions)
{

    $authorized = false;
    $permissions = explode("|", $permissions);

    foreach ($permissions as $permission) {
        if (in_array($permission, userPermissions()))
            $authorized = true;
    }

    if (!$authorized)
        abort(401);
}

function can(string $permissions, ?User $user = null)
{

    $authorized = false;
    $permissions = explode("|", $permissions);

    foreach ($permissions as $permission) {
        if (!$user) {
            if (in_array($permission, userPermissions()))
                $authorized = true;
        } else {
            if (in_array($permission, userPermissions($user)))
                $authorized = true;
        }
    }

    return $authorized;
}
