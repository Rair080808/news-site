@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
    <section class="auth-section">
        <div class="container">
            <div class="auth-card">
                <div class="auth-head">
                    <h1>Регистрация</h1>
                    <p>Регистрация выполняется только по логину и паролю</p>
                </div>

                @if ($errors->any())
                    <div class="form-errors">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label for="login">Логин</label>
                        <input type="text" id="login" name="login" class="form-control"
                               value="{{ old('login') }}" placeholder="Придумайте логин" required autofocus>
                        <small class="form-hint">Минимум 3 символа. Логин должен быть уникальным.</small>
                    </div>

                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" id="password" name="password" class="form-control"
                               placeholder="Придумайте пароль" required>
                        <small class="form-hint">Минимум 4 символа. Пароль хранится в базе в зашифрованном виде.</small>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Подтверждение пароля</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control" placeholder="Повторите пароль" required>
                    </div>

                    <button type="submit" class="btn btn-accent btn-block">Зарегистрироваться</button>

                    <p class="auth-switch">Уже есть аккаунт? <a href="{{ route('login') }}">Войдите</a></p>
                </form>
            </div>
        </div>
    </section>
@endsection