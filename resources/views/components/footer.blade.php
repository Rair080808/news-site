@php
    // Роли для отображения разделов в подвале (как в шапке)
    $role = auth()->check() ? auth()->user()->role?->name : null;
    $canJournalist = in_array($role, ['journalist', 'admin'], true);
    $canAdmin = ($role === 'admin');
@endphp

<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-col footer-about">
            <a href="{{ route('home') }}" class="logo logo-footer">
                <span class="logo-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                    </svg>
                </span>
                <strong>Научный прогресс</strong>
            </a>
            <p>Новостной портал о достижениях науки и технологий: космос, ИТ, медицина и физика.</p>
        </div>

        <div class="footer-col">
            <h4>Разделы</h4>
            <ul>
                <li><a href="{{ route('home') }}">Главная</a></li>
                <li><a href="{{ route('category', 'technology') }}">Технологии</a></li>
                @if ($canJournalist)
                    <li><a href="{{ route('journalist') }}">Журналист</a></li>
                @endif
                @if ($canAdmin)
                    <li><a href="{{ route('admin') }}">Админ</a></li>
                @endif
            </ul>
        </div>

        <div class="footer-col">
            <h4>Контакты</h4>
            <ul>
                <li>г. Москва, пр-т Мира, 1</li>
                <li><a href="mailto:info@progress.ru">info@progress.ru</a></li>
                <li><a href="tel:+70000000000">+7 (000) 000-00-00</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Вход для авторов</h4>
            <p>Регистрация и вход только по логину и паролю.</p>
            <div class="footer-auth-links">
                @auth
                    <span class="text-muted">Вы вошли как {{ auth()->user()->login }}
                        (роль: {{ auth()->user()->role?->name }})</span>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light btn-sm">Войти</a>
                    <a href="{{ route('register') }}" class="btn btn-accent btn-sm">Регистрация</a>
                @endauth
            </div>
        </div>
    </div>

    <div class="container footer-bottom">
        <span>© {{ date('Y') }} «Научный прогресс». Лабораторная работа №1 — вёрстка разделов.</span>
        <span class="footer-made">Сделано на Laravel</span>
    </div>
</footer>