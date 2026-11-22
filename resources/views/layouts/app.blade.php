<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Научный прогресс') — Научный прогресс</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @php
        // Определяем активный раздел по имени текущего маршрута
        $active = request()->route()?->getName() ?? 'home';
    @endphp

    {{-- Шапка сайта вынесена в отдельный компонент (components/header.blade.php) --}}
    <x-header :active="$active" />

    <main class="site-main">
        @if (session('notice'))
            <div class="flash-notice" role="status">
                <span class="flash-icon" aria-hidden="true">✔</span>
                {{ session('notice') }}
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Подвал сайта вынесен в отдельный компонент (components/footer.blade.php) --}}
    <x-footer />

    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>