<x-app-layout>
    @php
        $quoteCoverUrl = $hasCoverImage
            ? asset('storage/' . $article->cover_image)
            : null;

        $defaultQuote = trim(
            $article->excerpt
                ?: \Illuminate\Support\Str::limit(
                    trim(strip_tags($article->content)),
                    200
                )
        );
    @endphp

    <article
        class="article-page"
        id="articleReader"
        data-reader-font="serif"
        data-reader-theme="light"
        data-reader-spacing="normal"
    >

        @include('articles.partials.article-topbar', ['article' => $article, 'isBookmarked' => $isBookmarked])

        @include('articles.partials.reader-settings')

        @include('articles.partials.article-body', ['article' => $article, 'isLiked' => $isLiked, 'isBookmarked' => $isBookmarked, 'hasCoverImage' => $hasCoverImage, 'relatedArticles' => $relatedArticles])

        @include('articles.partials.quote-share', ['article' => $article, 'quoteCoverUrl' => $quoteCoverUrl, 'defaultQuote' => $defaultQuote])
    </article>

    @include('articles.partials.article-styles')

    @include('articles.partials.article-scripts', ['article' => $article, 'quoteCoverUrl' => $quoteCoverUrl, 'defaultQuote' => $defaultQuote])
</x-app-layout>
