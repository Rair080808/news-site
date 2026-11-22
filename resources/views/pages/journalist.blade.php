@extends('layouts.app')

@section('title', 'Журналист — написание статей')

@section('content')
    <section class="page-banner">
        <div class="container">
            <nav class="breadcrumbs" aria-label="Хлебные крошки">
                <a href="{{ route('home') }}">Главная</a>
                <span class="sep">→</span>
                <span>Журналист</span>
            </nav>
            <h1>Рабочий стол журналиста</h1>
            <p class="banner-sub">Напишите статью — после сохранения она будет опубликована на главной странице и в своей категории.</p>
        </div>
    </section>

    <section class="section">
        <div class="container journalist-layout">

            {{-- Форма создания статьи --}}
            <div class="panel article-form-panel">
                <div class="panel-head">
                    <h2>Новая статья</h2>
                    <span class="panel-hint">Поля, отмеченные *, обязательны</span>
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

                <form action="{{ route('journalist.store') }}" method="post" class="article-form">
                    @csrf

                    {{-- Заголовок --}}
                    <div class="form-group">
                        <label for="heading">Заголовок статьи *</label>
                        <input type="text" id="heading" name="heading" class="form-control"
                               value="{{ old('heading') }}"
                               placeholder="Например: «Учёные открыли новую экзопланету»" required>
                    </div>

                    {{-- Категория --}}
                    <div class="form-group">
                        <label for="category_id">Категория *</label>
                        <select id="category_id" name="category_id" class="form-control" required>
                            <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Выберите категорию…</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Аннотация (необязательно) --}}
                    <div class="form-group">
                        <label for="excerpt">Краткая аннотация</label>
                        <textarea id="excerpt" name="excerpt" class="form-control" rows="2"
                                  placeholder="2–3 предложения для ленты новостей (необязательно)">{{ old('excerpt') }}</textarea>
                    </div>

                    {{-- Полный текст статьи --}}
                    <div class="form-group">
                        <label for="text">Текст статьи *</label>
                        <textarea id="text" name="text" class="form-control editor-area" rows="12"
                                  placeholder="Полный текст новости…" required>{{ old('text') }}</textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-accent">Опубликовать статью</button>
                    </div>
                </form>
            </div>

            {{-- Мои статьи --}}
            <aside class="panel my-articles-panel">
                <div class="panel-head">
                    <h2>Мои статьи</h2>
                    <span class="panel-hint">{{ $myTexts->count() }} публикаций</span>
                </div>

                @if ($myTexts->count() > 0)
                    <ul class="my-articles">
                        @foreach ($myTexts as $text)
                            <li class="my-article">
                                <div class="my-article-info">
                                    <span class="status-dot published"></span>
                                    <div>
                                        <strong>{{ $text->heading }}</strong>
                                        <small>{{ $text->category->name }} ·
                                            {{ $text->created_at->translatedFormat('d.m.Y') }}</small>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">У вас пока нет статей. Напишите первую!</p>
                @endif

                <div class="panel-note">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                    Статья сохраняется в базу данных и сразу публикуется на главной странице и в выбранной категории.
                </div>
            </aside>
        </div>
    </section>
@endsection