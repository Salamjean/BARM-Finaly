

<li class="menu-item {{ routeActive(['annual-budget.index', 'annual-budget.create', 'annual-budget.show']) }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class='menu-icon tf-icons bx bxs-offer'></i>
        <div>Budget annuel</div>
        @if ($annual_budget > 0)
            @if (can(
                    'assistant-chef-barm|chef-cellule-administration-finance-logistique|chef-cellule-formation-et-insertion|chef-cellule-suivi-evaluation'))
                @if (
                    !App\Models\AnnualBudgetEstablishment::where('chief_id', auth()->id())->whereHas('annualBudget', function ($query) {
                            $query->where('year', date('Y'));
                        })->exists())
                    <div>
                        <div class="notifiere newe">
                            <div class="badgee">
                                <pre> </pre>
                            </div>
                        </div>
                    </div>
                @endif

            @endif
        @endif
    </a>
</li>
<li>
    <ul class="menu-sub">
        @if (can(
                'assistant-chef-barm|chef-cellule-administration-finance-logistique|chef-cellule-formation-et-insertion|chef-cellule-suivi-evaluation'))
            <li class="menu-item {{ routeItem('annual-budget.establishment.index') }}">
                <a href="{{ route('annual-budget.establishment.index') }}" class="menu-link">
                    <div>Voir </div>
                    @if ($annual_budget > 0)
                        @if (
                            !App\Models\AnnualBudgetEstablishment::where('chief_id', auth()->id())->whereHas('annualBudget', function ($query) {
                                    $query->where('year', date('Y'));
                                })->exists())
                            <div class="bg-white p-1 px-2 mx-2 rounded-circle text-black fw-bold"
                                style="font-size: 10px;">
                                {{ $annual_budget }}
                            </div>
                        @endif

                    @endif
                </a>
            </li>
        @endif
        @if (can('responsable-du-patrimoine-et-de-la-logistique|assistant-du-patrimoine-et-de-la-logistique'))
            <li class="menu-item {{ routeItem('annual-budget.create') }}">
                <a href="{{ route('annual-budget.create') }}" class="menu-link">
                    <div>Ajouter </div>
                </a>
            </li>
            <li class="menu-item {{ routeItem('annual-budget.index') }}">
                <a href="{{ route('annual-budget.index') }}" class="menu-link">
                    <div>Historique </div>
                </a>
            </li>
        @endif

    </ul>
</li>

<li class="menu-item {{ routeActive(['mail.subscribes', 'mail.create_mail']) }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class='menu-icon tf-icons bx bx-news'></i>
        <div>Abonnés</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ routeItem('mail.create_mail') }}">
            <a href="{{ route('mail.create_mail') }}" class="menu-link">
                <div>Envoie de mail </div>
            </a>
        </li>
        <li class="menu-item {{ routeItem('mail.subscribes') }}">
            <a href="{{ route('mail.subscribes') }}" class="menu-link">
                <div>Abonnés </div>
            </a>
        </li>

    </ul>
</li>

<li
    class="menu-item {{ url()->current() == route('leave.create') || url()->current() == route('leave.leavelist') ? 'active open' : '' }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class='menu-icon tf-icons bx bx-briefcase'></i>
        <div>Demandes</div>
    </a>
    <ul class="menu-sub">

        <li class="menu-item {{ routeItem('leave.create') }}">
            <a href="{{ route('leave.create') }}" class="menu-link">
                <div>Ajouter </div>
            </a>
        </li>
        <li class="menu-item {{ routeItem('leave.leavelist') }}">
            <a href="{{ route('leave.leavelist') }}" class="menu-link">
                <div>Liste </div>
            </a>
        </li>
    </ul>
</li>


@if (can('admin'))
    <li
        class="menu-item {{ url()->current() == route('role.index') || url()->current() == route('permissions.index') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='menu-icon tf-icons bx bx-check-shield'></i>
            <div data-i18n="Roles & Permissions">Roles & Permissions</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ url()->current() == route('role.index') ? 'active' : '' }}">
                <a href="{{ route('role.index') }}" class="menu-link">
                    <div data-i18n="Roles">Roles</div>
                </a>
            </li>
            <li class="menu-item {{ url()->current() == route('permissions.index') ? 'active' : '' }}">
                <a href="{{ route('permissions.index') }}" class="menu-link">
                    <div data-i18n="Permissions">Permissions</div>
                </a>
            </li>
        </ul>
    </li>
@endif
