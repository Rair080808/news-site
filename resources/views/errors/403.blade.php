@extends('layouts.app')

@section('title', 'Доступ запрещён')

@section('content')
    <section class="section">
        <div class="container">
            <div class="error-card">
                <div class="error-code">403</div>
                <h1>Доступ запрещён</h1>
                <p>У вашей роли (~{{ auth()->user()->role?->name ?? 'гость' }}) нет доступа к этому разделу.</p>

                @php
                    $role = auth()->check() ? auth()->user()->role?->name : null;
                    $canJournalist = in_array($role, ['journalist', 'admin'], true);
                    $canAdmin = ($role === 'admin');
                @endphp

                <div class="footer-auth-links">
                    <a href="{{ route('home') }}" class="btn btn-accent">На главную</a>
                    @if ($canJournalist)
                        <a href="{{ route('journalist') }}" class="btn btn-light">Журналист</a>
                    @endif
                    @if ($canAdmin)
                        <a href="{{ route('admin') }}" class="btn btn-light">Админ</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection