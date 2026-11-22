@props(['text'])

<article class="news-card">
    <div class="news-card-img news-img-cat-{{ $text->category->slug }}" role="img" aria-label="Иллюстрация новости">
        <span class="news-card-cat">{{ $text->category->name }}</span>
    </div>
    <div class="news-card-body">
        <div class="news-card-meta">
            <time datetime="{{ $text->created_at->toDateString() }}">{{ $text->created_at->translatedFormat('d F Y') }}</time>
            @if ($text->user)
                <span class="news-card-author">{{ $text->user->login }}</span>
            @endif
        </div>
        <h3 class="news-card-title">
            <a href="#">{{ $text->heading }}</a>
        </h3>
        <p class="news-card-excerpt">{{ $text->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($text->text), 130) }}</p>
        <div class="news-card-foot">
            <span class="news-card-category">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20.59 13.41 12 22H2v-10l8.59-8.59a2 2 0 0 1 2.83 0l7.17 7.17a2 2 0 0 1 0 2.83z"/><path d="M7 7h.01"/></svg>
                {{ $text->category->name }}
            </span>
            <a href="#" class="news-card-link">Читать далее →</a>
        </div>
    </div>
</article>