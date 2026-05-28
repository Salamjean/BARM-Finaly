<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('assets/css/time.css')}}">
    <link rel="icon" type="image/x-icon" href="{{ asset(setting('app_logo')) }}" />

    <title>POINTAGE</title>
</head>
<body>

    <div class="moment">{{ auth()->user()->fullName()  }} | {{ ucfirst(strtolower('Votre ' . $moment)) }}</div>
    <div>
        <div class="clock-container">
            <div class="clock-col">
                <p class="clock-day clock-timer">
                </p>
                <p class="clock-label">
                    JOURS
                </p>
            </div>
            <div class="clock-col">
                <p class="clock-hours clock-timer">
                </p>
                <p class="clock-label">
                    HEURES
                </p>
            </div>
            <div class="clock-col">
                <p class="clock-minutes clock-timer">
                </p>
                <p class="clock-label">
                    Minutes
                </p>
            </div>
            <div class="clock-col">
                <p class="clock-seconds clock-timer">
                </p>
                <p class="clock-label">
                    Secondes
                </p>
            </div>
        </div>
    </div>

    <form action="{{ route('pointing.store') }}" method="post">
        @method('POST')
        @csrf
        <button class="button-89" role="button">POINTER</button>
    </form>

    <script src="{{ asset('assets/js/moment.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () =>
            requestAnimationFrame(updateTime)
        )

        function updateTime() {
            moment.locale('fr');
            document.documentElement.style.setProperty('--timer-day', "'" + moment().format("ddd") + "'");
            document.documentElement.style.setProperty('--timer-hours', "'" + moment().format("k") + "'");
            document.documentElement.style.setProperty('--timer-minutes', "'" + moment().format("mm") + "'");
            document.documentElement.style.setProperty('--timer-seconds', "'" + moment().format("ss") + "'");
            requestAnimationFrame(updateTime);
        }
    </script>

    @include('partials.script.sweetalert')

</body>
</html>
