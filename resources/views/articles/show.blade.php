<x-app-layout>
    <article class="article-page">
        
        <!-- TOP NAVBAR -->
        <nav class="article-topbar">
            <a href="{{ route('dashboard') }}" class="close-btn">
                <i class="fas fa-times"></i>
            </a>
            <div class="topbar-center">
                <div class="topbar-avatar" style="background: linear-gradient(135deg, #FF8C5A, #FB4D00);">
                    {{ substr($article->user->name, 0, 1) }}
                </div>
            </div>
            <div class="topbar-right">
                @if(auth()->id() === $article->user_id)
                    <a href="{{ route('articles.edit', $article) }}" class="edit-article-btn"><i class="fas fa-pen"></i> Edit artikel</a>
                @endif
                <button type="button" class="icon-btn {{ $isBookmarked ? 'active' : '' }}" onclick="toggleBookmark(@js(route('articles.bookmark', $article)))" aria-label="Simpan artikel">
                    <i class="{{ $isBookmarked ? 'fas' : 'far' }} fa-bookmark"></i>
                </button>
                <button type="button" class="icon-btn" onclick="shareArticle()" aria-label="Bagikan artikel">
                    <i class="fas fa-share-nodes"></i>
                </button>
            </div>
        </nav>

        <!-- ARTICLE CONTENT -->
        <div class="article-body">
            <div class="article-inner">
                
                <!-- Category -->
                <div class="article-category">{{ $article->category }}</div>

                <!-- Title (SANS-SERIF) -->
                <h1 class="article-title">{{ $article->title }}</h1>

                <!-- Excerpt -->
                @if($article->excerpt)
                <p class="article-excerpt">{{ $article->excerpt }}</p>
                @endif

                <!-- Author -->
                <div class="article-author">
                    <div class="author-avatar" style="background: linear-gradient(135deg, #FF8C5A, #FB4D00);">
                        {{ substr($article->user->name, 0, 1) }}
                    </div>
                    <div class="author-details">
                        <span class="author-name">{{ strtoupper($article->user->name) }}</span>
                        <span class="article-date">
                            {{ $article->created_at->locale('id')->isoFormat('MMM DD, YYYY') }}
                        </span>
                    </div>
                </div>

                <div class="article-meta-row">
                    <span><i class="far fa-clock"></i> {{ $article->reading_time }} menit baca</span>
                    <span><i class="far fa-eye"></i> {{ number_format($article->views_count) }} dibaca</span>
                    @if($article->is_featured)
                        <span class="featured-note"><i class="fas fa-sparkles"></i> Pilihan Interlude</span>
                    @endif
                </div>

                <!-- Divider -->
                <div class="article-divider"></div>

                <!-- Cover Image -->
                @if($hasCoverImage)
                <figure class="article-figure">
                    <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}">
                    <figcaption>Ilustrasi {{ strtolower($article->category) }}.</figcaption>
                </figure>
                @else
                    <div class="article-visual-placeholder" role="img" aria-label="Ilustrasi {{ $article->category }}">
                        <i class="fas fa-book-open"></i>
                        <span>{{ $article->category }}</span>
                    </div>
                @endif

                <!-- Article Text (SERIF - Playfair Display) -->
                <div class="article-text">
                    {!! $article->content !!}
                </div>

                <!-- Engagement Bar -->
                <div class="engagement-bar">
                        <button type="button" class="engage-btn {{ $isLiked ? 'active' : '' }}" 
                            onclick="toggleLike(@js(route('articles.like', $article)), this)">
                        <i class="{{ $isLiked ? 'fas' : 'far' }} fa-heart"></i>
                        <span>{{ $article->likes_count }}</span>
                    </button>
                    <button type="button" class="engage-btn" onclick="document.getElementById('commentContent').focus()">
                        <i class="far fa-comment"></i>
                        <span>{{ $article->comments_count }}</span>
                    </button>
                    <button type="button" class="engage-btn {{ $isBookmarked ? 'active' : '' }}" onclick="toggleBookmark(@js(route('articles.bookmark', $article)))">
                        <i class="{{ $isBookmarked ? 'fas' : 'far' }} fa-bookmark"></i>
                        <span>Simpan</span>
                    </button>
                    <button type="button" class="engage-btn" onclick="shareArticle()">
                        <i class="fas fa-share-nodes"></i>
                        <span>Bagikan</span>
                    </button>
                </div>

                <section class="article-followup" aria-labelledby="conversation-heading">
                    <div class="followup-heading">
                        <div>
                            <span class="section-kicker">Ruang percakapan</span>
                            <h2 id="conversation-heading">Apa yang kamu pelajari dari cerita ini?</h2>
                        </div>
                        <span class="comment-count">{{ $article->comments->count() }} komentar</span>
                    </div>

                    @if(session('success'))
                        <div class="comment-success" role="status"><i class="fas fa-circle-check"></i> {{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('articles.comments.store', $article) }}" class="comment-form">
                        @csrf
                        <label for="commentContent">Bagikan refleksimu</label>
                        <textarea id="commentContent" name="content" rows="3" maxlength="2000" placeholder="Apa yang paling mengena dari cerita ini?" required>{{ old('content') }}</textarea>
                        @error('content')
                            <span class="comment-error">{{ $message }}</span>
                        @enderror
                        <div class="comment-form-footer">
                            <span>Masuk sebagai {{ auth()->user()->name }}</span>
                            <button type="submit">Kirim komentar <i class="fas fa-arrow-right"></i></button>
                        </div>
                    </form>

                    <div class="comment-list">
                        @forelse($article->comments as $comment)
                            <div class="comment-item">
                                <div class="comment-avatar">{{ substr($comment->user->name, 0, 1) }}</div>
                                <div class="comment-copy">
                                    <div class="comment-byline">
                                        <strong>{{ $comment->user->name }}</strong>
                                        <time datetime="{{ $comment->created_at->toIso8601String() }}">{{ $comment->created_at->locale('id')->diffForHumans() }}</time>
                                    </div>
                                    <p>{{ $comment->content }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="comment-empty">
                                <i class="far fa-comment-dots"></i>
                                <p>Belum ada percakapan. Jadilah yang pertama membagikan refleksimu.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                @if($relatedArticles->isNotEmpty())
                    <section class="related-section" aria-labelledby="related-heading">
                        <div class="followup-heading">
                            <div>
                                <span class="section-kicker">Lanjut membaca</span>
                                <h2 id="related-heading">Cerita lain dari topik {{ $article->category }}</h2>
                            </div>
                        </div>
                        <div class="related-grid">
                            @foreach($relatedArticles as $relatedArticle)
                                <a href="{{ route('articles.show', $relatedArticle->slug) }}" class="related-card">
                                    <span class="related-category">{{ $relatedArticle->category }}</span>
                                    <h3>{{ $relatedArticle->title }}</h3>
                                    <span class="related-author">{{ $relatedArticle->user->name }} · {{ $relatedArticle->reading_time }} menit</span>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

            </div>
        </div>

    </article>

    <style>
        .article-page {
            background: var(--white);
            min-height: 100vh;
        }

        /* TOP NAVBAR */
        .article-topbar {
            position: sticky;
            top: 0;
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 100;
        }

        .close-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brown);
            text-decoration: none;
            font-size: 16px;
            transition: 0.2s;
        }

        .close-btn:hover {
            background: var(--cream);
        }

        .topbar-center {
            display: flex;
            align-items: center;
        }

        .topbar-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            color: var(--white);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .subscribe-btn {
            padding: 10px 20px;
            background: var(--tangelo);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: 0.2s;
        }

        .subscribe-btn:hover {
            background: #e04400;
        }

        .edit-article-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 999px;
            color: var(--brown);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        .edit-article-btn:hover { border-color: var(--tangelo); color: var(--tangelo); }

        .icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brown);
            cursor: pointer;
            font-size: 14px;
            transition: 0.2s;
        }

        .icon-btn:hover {
            background: var(--cream);
        }

        .icon-btn.active { border-color: var(--tangelo); color: var(--tangelo); }

        /* ARTICLE BODY */
        .article-body {
            max-width: 680px;
            margin: 0 auto;
            padding: 60px 24px 100px;
        }

        .article-inner {
            max-width: 680px;
        }

        .article-category {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--tangelo);
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        /* JUDUL - SANS-SERIF (DM Sans) */
        .article-title {
            font-family: 'DM Sans', sans-serif;
            font-size: 40px;
            font-weight: 700;
            line-height: 1.2;
            color: var(--brown);
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }

        .article-excerpt {
            font-size: 20px;
            line-height: 1.6;
            color: var(--text-soft);
            margin-bottom: 32px;
            font-weight: 400;
        }

        .article-author {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 40px;
        }

        .article-meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 18px;
            margin: -22px 0 32px 62px;
            color: var(--text-soft);
            font-size: 13px;
        }

        .article-meta-row span { display: inline-flex; align-items: center; gap: 6px; }
        .article-meta-row i { color: var(--tangelo); }
        .article-meta-row .featured-note { color: var(--brown); font-weight: 700; }

        .author-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            color: var(--white);
        }

        .author-details {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .author-name {
            font-weight: 700;
            font-size: 14px;
            color: var(--brown);
            letter-spacing: 0.5px;
        }

        .article-date {
            font-size: 13px;
            color: var(--text-soft);
        }

        .article-divider {
            height: 1px;
            background: var(--border);
            margin-bottom: 48px;
        }

        /* FIGURE */
        .article-figure {
            margin: 0 0 48px;
        }

        .article-figure img {
            width: 100%;
            border-radius: 4px;
            display: block;
        }

        .article-figure figcaption {
            text-align: center;
            font-size: 14px;
            color: var(--text-soft);
            margin-top: 12px;
            font-style: italic;
        }

        .article-visual-placeholder {
            display: flex;
            min-height: 260px;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 48px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--linen), var(--blue));
            color: var(--brown);
            font-size: 14px;
            font-weight: 800;
        }

        .article-visual-placeholder i { color: var(--tangelo); font-size: 28px; }

        /* ARTICLE TEXT - SERIF (Playfair Display) - TETAP SAMA */
        .article-text {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            line-height: 1.8;
            color: #2C2C2C;
        }

        .article-text p {
            margin-bottom: 28px;
        }

        /* Heading dalam artikel - SERIF (Playfair Display) */
        .article-text h2 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            margin: 40px 0 20px;
            color: var(--brown);
            line-height: 1.3;
        }

        .article-text h3 {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            margin: 32px 0 16px;
            color: var(--brown);
        }

        .article-text strong,
        .article-text b {
            font-weight: 700;
        }

        .article-text em,
        .article-text i {
            font-style: italic;
        }

        .article-text u {
            text-decoration: underline;
        }

        .article-text blockquote {
            border-left: 4px solid var(--tangelo);
            padding: 16px 24px;
            margin: 32px 0;
            font-style: italic;
            color: var(--text-soft);
            background: var(--linen);
            border-radius: 0 8px 8px 0;
        }

        .article-text blockquote p {
            margin-bottom: 0;
        }

        .article-text ul,
        .article-text ol {
            margin: 24px 0;
            padding-left: 32px;
        }

        .article-text li {
            margin: 12px 0;
            line-height: 1.7;
        }

        .article-text hr {
            border: none;
            border-top: 1px solid var(--border);
            margin: 40px 0;
        }

        /* ENGAGEMENT BAR */
        .engagement-bar {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 20px 0;
            margin-top: 48px;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .engage-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: none;
            border: none;
            color: var(--text-soft);
            font-size: 16px;
            cursor: pointer;
            padding: 10px 16px;
            border-radius: 8px;
            transition: 0.2s;
            font-family: 'DM Sans', sans-serif;
        }

        .engage-btn:hover {
            background: var(--cream);
            color: var(--tangelo);
        }

        .engage-btn.active {
            color: var(--tangelo);
        }

        .engage-btn.active i { color: var(--tangelo); }

        .engage-btn i {
            font-size: 20px;
        }

        .engage-btn span {
            font-size: 15px;
            font-weight: 600;
        }

        .article-followup,
        .related-section {
            margin-top: 64px;
            padding-top: 32px;
            border-top: 1px solid var(--border);
        }

        .followup-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .section-kicker,
        .related-category {
            color: var(--tangelo);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        .followup-heading h2 {
            max-width: 480px;
            margin: 7px 0 0;
            color: var(--brown);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 24px;
            line-height: 1.25;
        }

        .comment-count { color: var(--text-soft); font-size: 13px; white-space: nowrap; }
        .comment-list { display: grid; gap: 18px; }
        .comment-success { display: flex; align-items: center; gap: 7px; margin-bottom: 16px; padding: 11px 13px; border-radius: 12px; background: #e4f4ed; color: #226d4e; font-size: 13px; }
        .comment-form { display: grid; gap: 9px; margin-bottom: 24px; padding: 16px; border: 1px solid var(--border); border-radius: 16px; background: var(--white); }
        .comment-form label { color: var(--brown); font-size: 13px; font-weight: 800; }
        .comment-form textarea { width: 100%; box-sizing: border-box; resize: vertical; padding: 12px; border: 1px solid var(--border); border-radius: 11px; background: var(--cream); color: var(--brown); font: 14px/1.55 'DM Sans', sans-serif; outline: none; }
        .comment-form textarea:focus { border-color: var(--tangelo); box-shadow: 0 0 0 3px rgba(251, 77, 0, .1); }
        .comment-form-footer { display: flex; align-items: center; justify-content: space-between; gap: 12px; color: var(--text-soft); font-size: 11px; }
        .comment-form-footer button { display: inline-flex; align-items: center; gap: 7px; padding: 9px 13px; border: 0; border-radius: 999px; background: var(--brown); color: var(--white); font: 800 12px 'DM Sans', sans-serif; cursor: pointer; }
        .comment-form-footer button:hover { background: var(--tangelo); }
        .comment-error { color: #b42318; font-size: 12px; }
        .comment-item { display: flex; gap: 12px; padding: 16px; border-radius: 16px; background: var(--cream); }
        .comment-avatar { flex: 0 0 36px; height: 36px; display: grid; place-items: center; border-radius: 50%; background: var(--blue); color: var(--brown); font-weight: 800; }
        .comment-copy { min-width: 0; }
        .comment-byline { display: flex; align-items: baseline; gap: 9px; flex-wrap: wrap; }
        .comment-byline strong { color: var(--brown); font-size: 14px; }
        .comment-byline time { color: var(--text-soft); font-size: 12px; }
        .comment-copy p { margin: 5px 0 0; color: var(--text-soft); font-size: 14px; line-height: 1.6; }
        .comment-empty { padding: 24px; border: 1px dashed var(--border); border-radius: 16px; color: var(--text-soft); text-align: center; }
        .comment-empty i { color: var(--tangelo); font-size: 24px; }
        .comment-empty p { margin: 8px 0 0; font-size: 14px; }
        .related-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; }
        .related-card { display: flex; min-height: 150px; flex-direction: column; justify-content: space-between; gap: 14px; padding: 18px; border: 1px solid var(--border); border-radius: 16px; background: var(--white); text-decoration: none; transition: transform .2s ease, border-color .2s ease, background .2s ease; }
        .related-card:hover { transform: translateY(-3px); border-color: var(--tangelo); background: var(--linen); }
        .related-card h3 { margin: 0; color: var(--brown); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; line-height: 1.35; }
        .related-author { color: var(--text-soft); font-size: 12px; }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .article-body {
                padding: 40px 20px 80px;
            }

            .article-title {
                font-size: 28px;
            }

            .article-excerpt {
                font-size: 17px;
            }

            .article-text {
                font-size: 18px;
            }

            .article-text h2 {
                font-size: 24px;
            }

            .article-text h3 {
                font-size: 20px;
            }

            .subscribe-btn {
                display: none;
            }

            .edit-article-btn { padding: 9px 11px; font-size: 12px; }

            .article-meta-row { margin-left: 0; }
            .followup-heading { align-items: flex-start; flex-direction: column; gap: 8px; }
            .related-grid { grid-template-columns: 1fr; }
            .engagement-bar { gap: 4px; justify-content: space-between; }
            .engage-btn { gap: 5px; padding: 9px 7px; font-size: 13px; }
            .engage-btn i { font-size: 17px; }
            .engage-btn span { font-size: 12px; }
            .comment-form-footer { align-items: flex-start; flex-direction: column; }
            .comment-form-footer button { width: 100%; justify-content: center; }
        }
    </style>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        async function toggleLike(url, button) {
            try {
            const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    const icon = button.querySelector('i');
                    const count = button.querySelector('span');
                    if (data.liked) {
                        button.classList.add('active');
                        icon.className = 'fas fa-heart';
                    } else {
                        button.classList.remove('active');
                        icon.className = 'far fa-heart';
                    }
                    if (count) count.textContent = data.count;
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        async function toggleBookmark(url) {
            try {
            const response = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                });
                const data = await response.json();
                if (data.success) {
                    document.querySelectorAll('[onclick*="toggleBookmark"]').forEach((button) => {
                        button.classList.toggle('active', data.bookmarked);
                        const icon = button.querySelector('i');
                        if (icon) icon.className = `${data.bookmarked ? 'fas' : 'far'} fa-bookmark`;
                    });
                }
            } catch (error) {
                console.error('Bookmark error:', error);
            }
        }

        async function shareArticle() {
            const shareData = {
                title: @js($article->title),
                text: @js($article->excerpt ?: 'Baca cerita ini di Interlude.'),
                url: window.location.href
            };

            try {
                if (navigator.share) {
                    await navigator.share(shareData);
                    return;
                }

                await navigator.clipboard.writeText(window.location.href);
                alert('Tautan artikel berhasil disalin.');
            } catch (error) {
                if (error.name !== 'AbortError') console.error('Share error:', error);
            }
        }
    </script>
</x-app-layout>