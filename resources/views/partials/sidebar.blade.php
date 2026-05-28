<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme"
    @if (role() == 'candidat') style="background-color:#001B63 !important;" @endif>
    <div class="app-brand demo ">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <a href="/" class="app-brand-link">
                    <img src="{{ asset(setting('app_logo')) }}" alt="" width="25" height="25"
                        srcset="">
                </a>
            </span>
            <small class="app-brand-text demo menu-text ms-2">BARM</small>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
            <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-divider mt-0  ">
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <!-- Tableau de bord -->

        <li class="menu-item {{ routeActive('dashboard') }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <box-icon type='solid' name='bowl-rice'></box-icon>
                <div data-i18n="Tableau de bord">Tableau de bord</div>
            </a>
        </li>



        {{-- SIDEBARS SÉPARÉES PAR TYPE D'UTILISATEUR --}}
        @include('partials.sidebar.formation-insertion')
        @include('partials.sidebar.point-focal')
        @include('partials.sidebar.suivi-evaluation')
        @include('partials.sidebar.chef-barm')
        @include('partials.sidebar.partners')
        @include('partials.sidebar.responsable-systemes')




    </ul>
</aside>
<style>
    .notifiere {
        position: relative;
        display: inline-block;
    }

    .grey-text {
        color: rgba(240, 238, 238, 0.466);
        font-size: 15px;
        padding-left: 13px;
        padding-top: 10px;
        font-style: italic;
        text-decoration: underline;
    }


    .badgee {
        position: absolute;
        top: -10px;
        left: 14px;
        padding: 0 5px;
        font-size: 10px;
        line-height: 14px;
        height: 14px;
        background: #EF476F;
        color: #FFF;
        border-radius: 11px;
        white-space: nowrap;
    }


    .notifiere.newe .badgee {
        animation: pulse 2s ease-out;
        animation-iteration-count: infinite;
    }

    @keyframes pulse {
        40% {
            transform: scale3d(1, 1, 1);
        }

        50% {
            transform: scale3d(1.3, 1.3, 1.3);
        }

        55% {
            transform: scale3d(1, 1, 1);
        }

        60% {
            transform: scale3d(1.3, 1.3, 1.3);
        }

        65% {
            transform: scale3d(1, 1, 1);
        }
    }

    /* Styles pour les sections collapsibles */
    .section-collapsible .section-header {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .section-collapsible .section-icon {
        transition: transform 0.3s ease;
        font-size: 18px;
    }

    .section-collapsible.open .section-icon {
        transform: rotate(90deg);
    }

    .section-content {
        transition: all 0.3s ease;
        overflow: hidden;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fonction pour gérer les sections collapsibles
        const sectionHeaders = document.querySelectorAll('.section-header');

        sectionHeaders.forEach(header => {
            header.addEventListener('click', function(e) {
                e.preventDefault();

                const parentLi = this.closest('.section-collapsible');
                const sectionContent = parentLi.querySelector('.section-content');

                // Toggle la classe 'open' sur le parent
                parentLi.classList.toggle('open');

                // Toggle l'affichage du contenu
                if (sectionContent.style.display === 'none' || !sectionContent.style.display) {
                    sectionContent.style.display = 'block';
                } else {
                    sectionContent.style.display = 'none';
                }
            });
        });

        // Sauvegarder l'état des sections dans localStorage
        sectionHeaders.forEach((header, index) => {
            const sectionKey = `section-${index}`;
            const savedState = localStorage.getItem(sectionKey);

            if (savedState === 'open') {
                const parentLi = header.closest('.section-collapsible');
                const sectionContent = parentLi.querySelector('.section-content');
                parentLi.classList.add('open');
                sectionContent.style.display = 'block';
            }

            header.addEventListener('click', function() {
                const parentLi = this.closest('.section-collapsible');
                const isOpen = parentLi.classList.contains('open');
                localStorage.setItem(sectionKey, isOpen ? 'open' : 'closed');
            });
        });
    });
</script>
