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
                <button class="subscribe-btn">Subscribe</button>
                <button class="icon-btn"><i class="fas fa-play"></i></button>
                <button class="icon-btn"><i class="fas fa-ellipsis-h"></i></button>
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

                <!-- Divider -->
                <div class="article-divider"></div>

                <!-- Cover Image -->
                @if($article->cover_image)
                <figure class="article-figure">
                    <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}">
                    <figcaption>Ilustrasi {{ strtolower($article->category) }}. Foto: Interlude.</figcaption>
                </figure>
                @endif

                <!-- Article Text (SERIF - Playfair Display) -->
                <div class="article-text">
                    {!! $article->content !!}
                </div>

                <!-- Engagement Bar -->
                <div class="engagement-bar">
                    <button class="engage-btn {{ $article->isLikedBy(auth()->user()) ? 'active' : '' }}" 
                            onclick="toggleLike({{ $article->id }}, this)">
                        <i class="{{ $article->isLikedBy(auth()->user()) ? 'fas' : 'far' }} fa-heart"></i>
                        <span>{{ $article->likes_count }}</span>
                    </button>
                    <button class="engage-btn">
                        <i class="far fa-comment"></i>
                        <span>{{ $article->comments_count }}</span>
                    </button>
                    <button class="engage-btn">
                        <i class="fas fa-retweet"></i>
                        <span>1.2K</span>
                    </button>
                    <button class="engage-btn">
                        <i class="far fa-share-square"></i>
                    </button>
                </div>

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

        .engage-btn i {
            font-size: 20px;
        }

        .engage-btn span {
            font-size: 15px;
            font-weight: 600;
        }

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
        }
    </style>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        async function toggleLike(articleId, button) {
            try {
                const response = await fetch(`/articles/${articleId}/like`, {
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
    </script>
</x-app-layout>