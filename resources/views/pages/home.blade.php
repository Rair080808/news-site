@extends('layouts.app')

@section('title', 'Главная — все новости')

@section('content')
    {{-- Блок-обложка главной страницы --}}
    <section class="hero">
        <div class="container hero-inner">
            <div class="hero-text">
                <span class="hero-badge">Портал о науке</span>
                <h1>Новости научного прогресса</h1>
                <p>Космос, технологии, медицина и физика — главные достижения современной науки в одном месте.</p>
                <div class="hero-actions">
                    <a href="{{ route('category', 'technology') }}" class="btn btn-accent">Категория «Технологии»</a>
                    <a href="{{ route('journalist') }}" class="btn btn-light">Написать статью</a>
                </div>
            </div>
            <div class="hero-stats">
                <div class="stat"><strong>{{ $texts->total() }}</strong><span>новостей</span></div>
                <div class="stat"><strong>{{ $categories->count() }}</strong><span>категорий</span></div>
                <div class="stat"><strong>24/7</strong><span>обновление</span></div>
            </div>
        </div>
    </section>

    {{-- Все опубликованные статьи из базы данных --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Все новости</h2>
                <p class="section-sub">Опубликованные статьи, от новых к старым</p>
            </div>

            @if ($texts->count() > 0)
                <div class="news-grid">
                    @foreach ($texts as $text)
                        <x-news-card :text="$text" />
                    @endforeach
                </div>

                {{-- Пагинация --}}
                <div class="pagination-wrap">
                    {{ $texts->links('partials.pagination') }}
                </div>
            @else
                <div class="empty-state">Новостей пока нет. Загляните позже!</div>
            @endif
        </div>
    </section>
@endsection