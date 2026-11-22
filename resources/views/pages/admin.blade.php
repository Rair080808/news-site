@extends('layouts.app')

@section('title', 'Админ — управление сайтом')

@section('content')
    <section class="page-banner">
        <div class="container">
            <nav class="breadcrumbs" aria-label="Хлебные крошки">
                <a href="{{ route('home') }}">Главная</a>
                <span class="sep">→</span>
                <span>Админ</span>
            </nav>
            <h1>Панель администратора</h1>
            <p class="banner-sub">Управление статьями и ролями пользователей. Доступ — только администраторам (Middleware role:admin).</p>
        </div>
    </section>

    <section class="section">
        <div class="container admin-layout">

            {{-- Управление статьями --}}
            <div class="panel">
                <div class="panel-head">
                    <h2>Статьи сайта</h2>
                    <span class="panel-hint">{{ $texts->count() }} публикаций</span>
                </div>

                <div class="table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Заголовок</th>
                                <th>Категория</th>
                                <th>Автор</th>
                                <th>Статус</th>
                                <th class="th-actions">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($texts as $text)
                                <tr>
                                    <td class="table-id">{{ $text->id }}</td>
                                    <td class="table-title">{{ $text->heading }}</td>
                                    <td><span class="tag">{{ $text->category->name }}</span></td>
                                    <td>{{ $text->user->login }}</td>
                                    <td>
                                        <span class="status-pill {{ $text->is_published ? 'published' : 'draft' }}">
                                            {{ $text->is_published ? 'Опубликована' : 'Черновик' }}
                                        </span>
                                    </td>
                                    <td class="td-actions">
                                        <form action="#" method="post" class="inline-form" title="Редактировать">
                                            @csrf
                                            <button type="submit" class="btn-icon" aria-label="Редактировать">
                                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 3a2.8 2.8 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                            </button>
                                        </form>
                                        <form action="#" method="post" class="inline-form" title="Заблокировать/разблокировать">
                                            @csrf
                                            <button type="submit" class="btn-icon warn" aria-label="Заблокировать">
                                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                            </button>
                                        </form>
                                        <form action="#" method="post" class="inline-form" title="Удалить статью">
                                            @csrf
                                            <button type="submit" class="btn-icon danger" aria-label="Удалить">
                                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Управление ролями пользователей --}}
            <div class="panel">
                <div class="panel-head">
                    <h2>Роли пользователей</h2>
                    <span class="panel-hint">Форма изменения роли пользователя</span>
                </div>

                <form action="#" method="post" class="role-form">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="user">Пользователь *</label>
                            <select id="user" name="user_id" class="form-control" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->login }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="role">Новая роль *</label>
                            <select id="role" name="role_id" class="form-control" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group form-group-submit">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-accent">Изменить роль</button>
                        </div>
                    </div>
                </form>

                <div class="table-wrap users-table-wrap">
                    <table class="admin-table users-table">
                        <thead>
                            <tr>
                                <th>Пользователь</th>
                                <th>E-mail / логин</th>
                                <th>Роль</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="table-title">{{ $user->login }}</td>
                                    <td>{{ $user->login }}@progress.ru</td>
                                    <td><span class="role-pill">{{ $user->role->name }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
@endsection