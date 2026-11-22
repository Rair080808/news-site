@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <section class="auth-section">
        <div class="container">
            <div class="auth-card">
                <div class="auth-head">
                    <h1>Вход</h1>
                    <p>Войдите, используя логин и пароль</p>
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

                <form method="POST" action="{{ route('login.store') }}" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label for="login">Логин</label>
                        <input type="text" id="login" name="login" class="form-control"
                               value="{{ old('login') }}" placeholder="Ваш логин" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" id="password" name="password" class="form-control"
                               placeholder="Ваш пароль" required>
                    </div>

                    <button type="submit" class="btn btn-accent btn-block">Войти</button>

                    <p class="auth-switch">Нет аккаунта? <a href="{{ route('register') }}">Зарегистрируйтесь</a></p>
                </form>
            </div>
        </div>
    </section>
@endsection