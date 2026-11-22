@extends('layouts.app')

@section('title', 'Категория: ' . $category->name)

@section('content')
    {{-- Шапка раздела категории --}}
    <section class="page-banner category-banner">
        <div class="container">
            <nav class="breadcrumbs" aria-label="Хлебные крошки">
                <a href="{{ route('home') }}">Главная</a>
                <span class="sep">→</span>
                <span>Категория</span>
            </nav>
            <h1>Категория: {{ $category->name }}</h1>
            <p class="banner-sub">Статьи этой категории из базы данных.</p>
            <div class="category-tabs">
                @foreach ($categories as $cat)
                    <a href="{{ route('category', $cat->slug) }}"
                       class="tab {{ $category->id === $cat->id ? 'active' : '' }}">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-head">
                <h2>Новости категории «{{ $category->name }}»</h2>
                <p class="section-sub">Найдено: {{ $texts->total() }} публикаций</p>
            </div>

            @if ($texts->count() > 0)
                <div class="news-grid">
                    @foreach ($texts as $text)
                        <x-news-card :text="$text" />
                    @endforeach
                </div>

                <div class="pagination-wrap">
                    {{ $texts->links('partials.pagination') }}
                </div>
            @else
                <div class="empty-state">В этой категории пока нет опубликованных новостей.</div>
            @endif
        </div>
    </section>
@endsection