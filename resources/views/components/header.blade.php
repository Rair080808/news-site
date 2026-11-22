@props(['active' => ''])

@php
    // Роль текущего пользователя (если авторизован)
    $userRole = auth()->check() ? auth()->user()->role?->name : null;
    // Разрешения на разделы по ролям
    $canJournalist = in_array($userRole, ['journalist', 'admin'], true);
    $canAdmin = ($userRole === 'admin');
@endphp

<header class="site-header">
    <div class="container header-inner">
        <a href="{{ route('home') }}" class="logo" aria-label="На главную">
            <span class="logo-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                </svg>
            </span>
            <span class="logo-text">
                <strong>Научный прогресс</strong>
                <small>новости науки и технологий</small>
            </span>
        </a>

        <nav class="main-nav" aria-label="Основная навигация">
            {{-- Главная и Категория доступны всем --}}
            <a href="{{ route('home') }}" class="{{ $active === 'home' ? 'active' : '' }}">Главная</a>
            <a href="{{ route('category', 'technology') }}" class="{{ $active === 'category' ? 'active' : '' }}">Технологии</a>

            {{-- Журналист — журналистам и админам --}}
            @if ($canJournalist)
                <a href="{{ route('journalist') }}" class="{{ $active === 'journalist' ? 'active' : '' }}">Журналист</a>
            @endif

            {{-- Админ — только админам --}}
            @if ($canAdmin)
                <a href="{{ route('admin') }}" class="{{ $active === 'admin' ? 'active' : '' }}">Админ</a>
            @endif
        </nav>

        <div class="header-actions">
            @auth
                <span class="user-chip" title="Ваша роль: {{ $userRole }}">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
                    {{ auth()->user()->login }}
                    <span class="role-badge">{{ $userRole }}</span>
                </span>
                <form method="POST" action="{{ route('logout') }}" class="header-logout-form">
                    @csrf
                    <button type="submit" class="btn btn-light btn-sm">Выйти</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-light btn-sm">Войти</a>
                <a href="{{ route('register') }}" class="btn btn-accent btn-sm">Регистрация</a>
            @endauth
        </div>
    </div>
</header>