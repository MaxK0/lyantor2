<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ @asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ @asset('/fontawesome/css/all.min.css') }}">
{{--    <link rel="icon" href="{{ @asset('/img/logo.svg') }}">--}}
</head>
<body>
<div id="site">
    <header class="header">
        <div class="container header__container">
            <nav class="header__nav">
                <a class="header__logo" href="{{ route('home') }}">Лянтор</a>

                <button class="header__menu">
                    <img src="{{ @asset('/img/menu.svg') }}" alt="Меню">
                </button>

                <ul class="header__ul">
{{--                    <li>--}}
{{--                        <a href="{{ route('attractions.index') }}" class="link-nav">Развлечение</a>--}}
{{--                    </li>--}}
                    <li>
                        <a href="{{ route('hotels.index') }}" class="link-nav {{ request()->routeIs('hotels.index') ? 'active' : '' }}">Отели</a>

                    </li>
                    <li>
                        <a href="{{ route('attractions.index') }}" class="link-nav {{ request()->routeIs('attractions.index') ? 'active' : '' }}">Достопримечательности</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>

</div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuButton = document.querySelector('.header__menu');
        const headerUl = document.querySelector('.header__ul');

        menuButton.addEventListener('click', function () {
            headerUl.classList.toggle('open');
        });

        document.addEventListener('click', function (event) {
            if (!headerUl.contains(event.target) && !menuButton.contains(event.target)) {
                headerUl.classList.remove('open');
            }
        });
    });
</script>
</html>
