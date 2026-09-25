@php
    $gradients = [
        'Penelitian' => 'linear-gradient(135deg, #CAE7F7 0%, #EAF7FD 100%)',
        'Tugas Kuliah' => 'linear-gradient(135deg, #FFEDE3 0%, #FFD9C8 100%)',
        'Magang' => 'linear-gradient(135deg, #DFF4E8 0%, #BFE7D0 100%)',
        'Organisasi' => 'linear-gradient(135deg, #EEE4FF 0%, #D7C5FF 100%)',
        'Tips Belajar' => 'linear-gradient(135deg, #FFF5CF 0%, #FFE49A 100%)',
        'Kehidupan Kampus' => 'linear-gradient(135deg, #FFE9F1 0%, #FFD1E0 100%)',
    ];

    $getGradient = fn($cat) => $gradients[$cat] ?? 'linear-gradient(135deg, #CAE7F7 0%, #FFEDE3 100%)';
@endphp

<x-app-layout>
    @once
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    @endonce

    <div class="interlude-dashboard">
        <div class="dashboard-shell">

            {{-- =========================================================
                 TOP / GREETING
            ========================================================== --}}
            <section class="dashboard-hero">
                <div class="hero-copy">
                    <span class="eyebrow">
                        <span class="eyebrow-dot"></span>
                        Ruang bacamu hari ini
                    </span>

                    <h1>
                        Selamat datang,
                        <span>{{ explode(' ', Auth::user()->name)[0] }}.</span>
                    </h1>

                    <p>
                        Temukan pengalaman, catatan, dan cerita dari mahasiswa lain yang mungkin sedang kamu butuhkan.
                    </p>
                </div>

                <a href="{{ route('articles.create') }}" class="write-cta">
                    <i class="fas fa-pen-nib"></i>
                    <span>Tulis pengalaman</span>
                </a>
            </section>

            {{-- =========================================================
                 SEARCH
            ========================================================== --}}
            <section class="search-block">
                <form method="GET" action="{{ route('explore') }}" class="search-form">
                    <i class="fas fa-search search-icon"></i>

                    <input
                        id="dashboard-search"
                        name="q"
                        type="search"
                        value="{{ request('q') }}"
                        placeholder="Cari artikel, topik, atau penulis..."
                        aria-label="Cari artikel, topik, atau penulis"
                    >

                    <button type="submit">
                        <span>Cari</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>

                <p class="search-hint">
                    <i class="far fa-lightbulb"></i>
                    Coba cari “magang pertama”, “skripsi”, atau nama penulis.
                </p>
            </section>

            {{-- =========================================================
                 CATEGORY FILTER
            ========================================================== --}}
            <section class="topic-strip" aria-label="Kategori artikel">
                <a href="{{ route('explore') }}" class="topic-chip topic-chip--active">Semua</a>

                @foreach($categories as $category)
                    <a href="{{ route('explore', ['category' => $category]) }}" class="topic-chip">
                        {{ $category }}
                    </a>
                @endforeach
            </section>

            {{-- =========================================================
                 FEATURED + SIDEBAR BENTO
            ========================================================== --}}
            <section class="dashboard-bento">
                <div class="main-column">
                    <div class="section-heading section-heading--compact">
                        <div>
                            <span class="section-kicker">Dikurasi untukmu</span>
                            <h2>Cerita yang mungkin sedang kamu cari</h2>
                        </div>

                        <a href="{{ route('explore') }}" class="section-link">
                            Lihat semua
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    @if($featuredArticle)
                        <a href="{{ route('articles.show', $featuredArticle->slug) }}" class="featured-link">
                            <article class="featured-card">
                                <div class="featured-copy">
                                    <div class="featured-topline">
                                        <div class="featured-tags">
                                            <span class="featured-badge">Pilihan untukmu</span>
                                            <span class="featured-category">{{ $featuredArticle->category }}</span>
                                        </div>

                                        <span class="featured-bookmark" aria-hidden="true">
                                            <i class="far fa-bookmark"></i>
                                        </span>
                                    </div>

                                    <div class="featured-main-copy">
                                        <h3>{{ $featuredArticle->title }}</h3>

                                        @if(!empty($featuredArticle->excerpt))
                                            <p>{{ Str::limit($featuredArticle->excerpt, 150) }}</p>
                                        @endif
                                    </div>

                                    <div class="featured-footer">
                                        <div class="author-row">
                                            <div class="avatar avatar--featured">
                                                {{ strtoupper(substr($featuredArticle->user->name, 0, 1)) }}
                                            </div>

                                            <div>
                                                <strong>{{ $featuredArticle->user->name }}</strong>
                                                <span>{{ $featuredArticle->reading_time }} menit baca</span>
                                            </div>
                                        </div>

                                        <span class="featured-read">
                                            Baca sekarang
                                            <i class="fas fa-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="featured-visual-wrap">
                                    <div class="featured-orb featured-orb--one"></div>
                                    <div class="featured-orb featured-orb--two"></div>

                                    <div class="featured-cover-card">
                                        @if($featuredArticle->cover_image)
                                            <img
                                                src="{{ asset('storage/' . $featuredArticle->cover_image) }}"
                                                alt="{{ $featuredArticle->title }}"
                                            >
                                        @else
                                            <div class="featured-placeholder" style="background: {{ $getGradient($featuredArticle->category) }};">
                                                <i class="far fa-file-alt"></i>
                                                <span>{{ $featuredArticle->category }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        </a>
                    @else
                        <div class="featured-empty">
                            <div class="featured-empty-icon"><i class="far fa-newspaper"></i></div>
                            <div>
                                <h3>Belum ada cerita pilihan.</h3>
                                <p>Cerita terbaru akan muncul di sini setelah ada artikel yang dipublikasikan.</p>
                            </div>
                        </div>
                    @endif
                </div>

                <aside class="side-column">
                    {{-- Recommended writers --}}
                    <div class="side-card writers-card">
                        <div class="side-card-heading">
                            <div>
                                <span class="side-kicker">Temukan orang baru</span>
                                <h3>Penulis untukmu</h3>
                            </div>
                            <i class="fas fa-user-friends side-heading-icon"></i>
                        </div>

                        <div class="writer-list">
                            @forelse($recommendedWriters as $writer)
                                <div class="writer-row">
                                    <div class="writer-profile">
                                        <div class="avatar writer-avatar">
                                            {{ strtoupper(substr($writer->name, 0, 1)) }}
                                        </div>

                                        <div class="writer-copy">
                                            <strong>{{ $writer->name }}</strong>
                                            <span>Mahasiswa Interlude</span>
                                        </div>
                                    </div>

                                    <button
                                        type="button"
                                        class="follow-btn"
                                        onclick="toggleFollow({{ $writer->id }}, this)"
                                    >
                                        Ikuti
                                    </button>
                                </div>
                            @empty
                                <div class="side-empty">Belum ada penulis untuk ditampilkan.</div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Trending --}}
                    <div class="side-card trending-card">
                        <div class="side-card-heading">
                            <div>
                                <span class="side-kicker">Lagi ramai</span>
                                <h3>Banyak dibaca</h3>
                            </div>
                            <i class="fas fa-chart-line side-heading-icon"></i>
                        </div>

                        <div class="trending-list">
                            @forelse($trendingArticles as $index => $trend)
                                <a href="{{ route('articles.show', $trend->slug) }}" class="trending-row">
                                    <span class="trend-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="trend-title">{{ $trend->title }}</span>
                                    <i class="fas fa-arrow-up-right-from-square trend-arrow"></i>
                                </a>
                            @empty
                                <div class="side-empty">Belum ada artikel trending.</div>
                            @endforelse
                        </div>
                    </div>
                </aside>
            </section>

            {{-- =========================================================
                 ARTICLE FEED
            ========================================================== --}}
            <section class="latest-section">
                <div class="section-heading">
                    <div>
                        <span class="section-kicker">Terbaru di Interlude</span>
                        <h2>Cerita dari mahasiswa lain</h2>
                        <p>Catatan pengalaman yang bisa kamu baca, simpan, dan buka lagi kapan pun.</p>
                    </div>
                </div>

                <div class="article-grid">
                    @forelse($articles as $article)
                        <a href="{{ route('articles.show', $article->slug) }}" class="article-link">
                            <article class="article-card">
                                <div class="article-cover">
                                    @if($article->cover_image)
                                        <img
                                            src="{{ asset('storage/' . $article->cover_image) }}"
                                            alt="{{ $article->title }}"
                                        >
                                    @else
                                        <div class="article-placeholder" style="background: {{ $getGradient($article->category) }};">
                                            <span class="placeholder-category">{{ $article->category }}</span>
                                            <i class="far fa-file-lines"></i>
                                        </div>
                                    @endif

                                    <span class="article-category">{{ $article->category }}</span>
                                </div>

                                <div class="article-body">
                                    <div class="article-author">
                                        <div class="avatar article-avatar">
                                            {{ strtoupper(substr($article->user->name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <strong>{{ $article->user->name }}</strong>
                                            <span>{{ $article->reading_time }} menit baca</span>
                                        </div>
                                    </div>

                                    <h3>{{ $article->title }}</h3>

                                    @if(!empty($article->excerpt))
                                        <p>{{ Str::limit($article->excerpt, 115) }}</p>
                                    @endif

                                    <div class="article-meta">
                                        <span><i class="far fa-heart"></i> {{ $article->likes_count }}</span>
                                        <span><i class="far fa-comment"></i> {{ $article->comments_count }}</span>
                                        <span><i class="far fa-eye"></i> {{ $article->views_count }}</span>

                                        <span class="article-arrow">
                                            Baca
                                            <i class="fas fa-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </article>
                        </a>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon"><i class="far fa-newspaper"></i></div>
                            <h3>Belum ada cerita</h3>
                            <p>Jadilah yang pertama berbagi pengalaman di Interlude.</p>
                            <a href="{{ route('articles.create') }}" class="empty-cta">
                                <i class="fas fa-pen"></i>
                                Tulis Artikel
                            </a>
                        </div>
                    @endforelse
                </div>

                @if($articles->hasPages())
                    <div class="pagination-wrap">
                        {{ $articles->links() }}
                    </div>
                @endif
            </section>

            {{-- =========================================================
                 BOTTOM CTA
            ========================================================== --}}
            <section class="contribution-banner">
                <div class="contribution-icon">
                    <i class="fas fa-pen-nib"></i>
                </div>

                <div class="contribution-copy">
                    <span class="section-kicker">Giliran ceritamu</span>
                    <h2>Punya sesuatu yang kamu pelajari minggu ini?</h2>
                    <p>Bagikan prosesnya. Pengalaman kecilmu mungkin sedang dicari mahasiswa lain.</p>
                </div>

                <a href="{{ route('articles.create') }}" class="contribution-cta">
                    Mulai menulis
                    <i class="fas fa-arrow-right"></i>
                </a>
            </section>
        </div>
    </div>

    <style>
        :root {
            --interlude-brown: #49261D;
            --interlude-brown-dark: #30120A;
            --interlude-orange: #FB4D00;
            --interlude-orange-dark: #D44000;
            --interlude-blue: #CAE7F7;
            --interlude-blue-dim: #AECBDa;
            --interlude-linen: #FFEDE3;
            --interlude-cream: #FDFAF7;
            --interlude-white: #FFFFFF;
            --interlude-text: #1C1B19;
            --interlude-muted: #6F605B;
            --interlude-border: #E7DAD4;
            --interlude-soft: #F6F0EC;
        }

        .interlude-dashboard,
        .interlude-dashboard * {
            box-sizing: border-box;
        }

        .interlude-dashboard {
            width: 100%;
            min-height: 100vh;
            background:
                radial-gradient(circle at 88% 6%, rgba(202, 231, 247, .42) 0, transparent 27%),
                linear-gradient(180deg, #FDFAF7 0%, #FFFCF9 100%);
            color: var(--interlude-text);
            font-family: 'DM Sans', sans-serif;
        }

        .dashboard-shell {
            width: min(1280px, calc(100% - 40px));
            margin: 0 auto;
            padding: 54px 0 80px;
        }

        .dashboard-hero {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 40px;
            padding-bottom: 30px;
        }

        .hero-copy {
            max-width: 760px;
        }

        .eyebrow,
        .section-kicker,
        .side-kicker {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--interlude-orange);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.15px;
            text-transform: uppercase;
        }

        .eyebrow {
            padding: 7px 11px;
            border-radius: 999px;
            background: #FFDCD1;
            color: #8A2707;
        }

        .eyebrow-dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: var(--interlude-orange);
            box-shadow: 0 0 0 4px rgba(251, 77, 0, .10);
        }

        .hero-copy h1 {
            margin: 18px 0 10px;
            color: var(--interlude-brown-dark);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(42px, 5.3vw, 68px);
            font-weight: 800;
            letter-spacing: -3px;
            line-height: 1.02;
        }

        .hero-copy h1 span {
            color: var(--interlude-brown);
        }

        .hero-copy p {
            max-width: 650px;
            margin: 0;
            color: var(--interlude-muted);
            font-size: 17px;
            line-height: 1.7;
        }

        .write-cta,
        .contribution-cta,
        .empty-cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border-radius: 999px;
            text-decoration: none;
            transition: .2s ease;
        }

        .write-cta {
            flex-shrink: 0;
            padding: 14px 20px;
            background: var(--interlude-orange);
            color: white;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 800;
            box-shadow: 0 12px 28px rgba(251, 77, 0, .18);
        }

        .write-cta:hover {
            transform: translateY(-2px);
            background: var(--interlude-brown);
            color: white;
        }

        .search-block {
            max-width: 820px;
            margin-bottom: 20px;
        }

        .search-form {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 7px 8px 7px 20px;
            border: 1px solid var(--interlude-border);
            border-radius: 999px;
            background: white;
            box-shadow: 0 10px 30px rgba(73, 38, 29, .05);
        }

        .search-icon {
            color: var(--interlude-orange);
            font-size: 15px;
        }

        .search-form input {
            width: 100%;
            min-width: 0;
            height: 48px;
            border: 0;
            outline: 0;
            background: transparent;
            color: var(--interlude-text);
            font-family: inherit;
            font-size: 15px;
        }

        .search-form input::placeholder {
            color: #AE9D95;
        }

        .search-form button {
            height: 46px;
            padding: 0 22px;
            border: 0;
            border-radius: 999px;
            background: var(--interlude-brown);
            color: white;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: .2s ease;
            white-space: nowrap;
        }

        .search-form button:hover {
            background: var(--interlude-orange);
        }

        .search-form button i {
            margin-left: 8px;
        }

        .search-hint {
            display: flex;
            align-items: center;
            gap: 6px;
            margin: 9px 0 0 18px;
            color: #8B7A73;
            font-size: 11px;
        }

        .search-hint i {
            color: var(--interlude-orange);
        }

        .topic-strip {
            display: flex;
            align-items: center;
            gap: 9px;
            overflow-x: auto;
            padding: 2px 0 36px;
            scrollbar-width: none;
        }

        .topic-strip::-webkit-scrollbar {
            display: none;
        }

        .topic-chip {
            flex: 0 0 auto;
            padding: 10px 16px;
            border: 1px solid var(--interlude-border);
            border-radius: 999px;
            background: rgba(255,255,255,.72);
            color: var(--interlude-brown);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            transition: .2s ease;
        }

        .topic-chip:hover,
        .topic-chip--active {
            border-color: var(--interlude-brown);
            background: var(--interlude-brown);
            color: white;
            transform: translateY(-1px);
        }

        .dashboard-bento {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 335px;
            gap: 22px;
            align-items: start;
        }

        .section-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 22px;
        }

        .section-heading--compact {
            margin-bottom: 16px;
        }

        .section-heading h2 {
            margin: 7px 0 0;
            color: var(--interlude-brown-dark);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -1px;
            line-height: 1.18;
        }

        .section-heading p {
            max-width: 640px;
            margin: 8px 0 0;
            color: var(--interlude-muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .section-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--interlude-brown);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 11px;
            font-weight: 800;
            text-decoration: none;
            white-space: nowrap;
        }

        .section-link:hover {
            color: var(--interlude-orange);
        }

        .featured-link,
        .article-link {
            display: block;
            color: inherit;
            text-decoration: none;
        }

        .featured-card {
            position: relative;
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(240px, .65fr);
            min-height: 470px;
            overflow: hidden;
            border-radius: 34px;
            background: var(--interlude-blue);
            box-shadow: 0 18px 50px rgba(73, 38, 29, .08);
            transition: .28s ease;
        }

        .featured-link:hover .featured-card {
            transform: translateY(-3px);
            box-shadow: 0 26px 65px rgba(73, 38, 29, .12);
        }

        .featured-copy {
            position: relative;
            z-index: 3;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 34px;
        }

        .featured-topline,
        .featured-footer,
        .featured-tags,
        .author-row,
        .article-author,
        .article-meta,
        .side-card-heading,
        .writer-row,
        .writer-profile {
            display: flex;
            align-items: center;
        }

        .featured-topline,
        .featured-footer,
        .side-card-heading,
        .writer-row {
            justify-content: space-between;
        }

        .featured-tags {
            gap: 8px;
            flex-wrap: wrap;
        }

        .featured-badge,
        .featured-category,
        .article-category,
        .placeholder-category {
            display: inline-flex;
            align-items: center;
            width: fit-content;
            border-radius: 999px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .45px;
            text-transform: uppercase;
        }

        .featured-badge {
            padding: 7px 11px;
            background: var(--interlude-brown);
            color: white;
        }

        .featured-category {
            padding: 7px 11px;
            background: rgba(255,255,255,.78);
            color: var(--interlude-brown);
        }

        .featured-bookmark {
            display: inline-flex;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: rgba(255,255,255,.82);
            color: var(--interlude-brown);
        }

        .featured-main-copy {
            max-width: 600px;
            padding: 38px 0 28px;
        }

        .featured-main-copy h3 {
            margin: 0;
            color: var(--interlude-brown-dark);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(35px, 4vw, 52px);
            font-weight: 800;
            letter-spacing: -2.2px;
            line-height: 1.03;
        }

        .featured-main-copy p {
            max-width: 520px;
            margin: 16px 0 0;
            color: #5D514D;
            font-size: 14px;
            line-height: 1.65;
        }

        .author-row,
        .article-author,
        .writer-profile {
            gap: 11px;
        }

        .avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            border-radius: 999px;
            background: var(--interlude-brown);
            color: white;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
        }

        .avatar--featured {
            width: 38px;
            height: 38px;
            font-size: 12px;
        }

        .author-row strong,
        .article-author strong {
            display: block;
            color: var(--interlude-brown);
            font-size: 12px;
        }

        .author-row span,
        .article-author span {
            display: block;
            margin-top: 2px;
            color: var(--interlude-muted);
            font-size: 10px;
        }

        .featured-read {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--interlude-brown);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 11px;
            font-weight: 800;
        }

        .featured-visual-wrap {
            position: relative;
            min-height: 100%;
        }

        .featured-orb {
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
        }

        .featured-orb--one {
            width: 310px;
            height: 310px;
            top: -70px;
            right: -100px;
            background: rgba(255, 222, 211, .85);
        }

        .featured-orb--two {
            width: 220px;
            height: 220px;
            bottom: -90px;
            left: -70px;
            background: rgba(255,255,255,.55);
        }

        .featured-cover-card {
            position: absolute;
            z-index: 2;
            width: min(88%, 245px);
            aspect-ratio: .76;
            right: 28px;
            bottom: -18px;
            overflow: hidden;
            border: 8px solid rgba(255,255,255,.72);
            border-radius: 26px;
            background: white;
            box-shadow: 0 22px 45px rgba(48,18,10,.13);
            transform: rotate(3deg);
            transition: .3s ease;
        }

        .featured-link:hover .featured-cover-card {
            transform: rotate(0deg) translateY(-4px);
        }

        .featured-cover-card img,
        .article-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .featured-placeholder,
        .article-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 14px;
            color: var(--interlude-brown);
            text-align: center;
        }

        .featured-placeholder i {
            font-size: 44px;
            opacity: .38;
        }

        .featured-placeholder span {
            max-width: 120px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px;
            font-weight: 800;
        }

        .featured-empty {
            display: flex;
            align-items: center;
            gap: 18px;
            min-height: 240px;
            padding: 36px;
            border: 1px dashed var(--interlude-border);
            border-radius: 30px;
            background: rgba(255,255,255,.65);
        }

        .featured-empty-icon,
        .empty-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: var(--interlude-blue);
            color: var(--interlude-brown);
        }

        .featured-empty-icon {
            width: 56px;
            height: 56px;
            flex: 0 0 auto;
        }

        .featured-empty h3 {
            margin: 0 0 4px;
            color: var(--interlude-brown);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 18px;
        }

        .featured-empty p {
            margin: 0;
            color: var(--interlude-muted);
            font-size: 13px;
        }

        .side-column {
            display: flex;
            flex-direction: column;
            gap: 18px;
            padding-top: 55px;
        }

        .side-card {
            padding: 22px;
            border: 1px solid var(--interlude-border);
            border-radius: 28px;
            background: rgba(255,255,255,.90);
            box-shadow: 0 10px 34px rgba(73,38,29,.04);
        }

        .side-card-heading {
            gap: 18px;
            margin-bottom: 18px;
        }

        .side-card-heading h3 {
            margin: 4px 0 0;
            color: var(--interlude-brown-dark);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 19px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .side-heading-icon {
            color: #B8D8E9;
            font-size: 18px;
        }

        .writer-list {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .writer-row {
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid #F0E7E2;
        }

        .writer-row:last-child {
            border-bottom: 0;
        }

        .writer-avatar,
        .article-avatar {
            width: 38px;
            height: 38px;
            font-size: 11px;
        }

        .writer-copy {
            min-width: 0;
        }

        .writer-copy strong {
            display: block;
            overflow: hidden;
            color: var(--interlude-brown);
            font-size: 11px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .writer-copy span {
            display: block;
            margin-top: 2px;
            color: var(--interlude-muted);
            font-size: 9px;
        }

        .follow-btn {
            flex: 0 0 auto;
            padding: 7px 12px;
            border: 0;
            border-radius: 999px;
            background: var(--interlude-brown);
            color: white;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 9px;
            font-weight: 800;
            cursor: pointer;
            transition: .2s ease;
        }

        .follow-btn:hover {
            background: var(--interlude-orange);
        }

        .trending-list {
            display: flex;
            flex-direction: column;
        }

        .trending-row {
            display: grid;
            grid-template-columns: 34px minmax(0, 1fr) 14px;
            gap: 10px;
            align-items: start;
            padding: 14px 0;
            border-bottom: 1px solid #F0E7E2;
            color: inherit;
            text-decoration: none;
        }

        .trending-row:last-child {
            border-bottom: 0;
        }

        .trend-number {
            color: #D8C8C1;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .trend-title {
            color: var(--interlude-brown);
            font-size: 11px;
            font-weight: 700;
            line-height: 1.45;
            transition: .2s ease;
        }

        .trend-arrow {
            margin-top: 3px;
            color: #C3B0A8;
            font-size: 9px;
        }

        .trending-row:hover .trend-title,
        .trending-row:hover .trend-arrow {
            color: var(--interlude-orange);
        }

        .side-empty {
            padding: 14px 0;
            color: var(--interlude-muted);
            font-size: 11px;
            text-align: center;
        }

        .latest-section {
            padding-top: 72px;
        }

        .article-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .article-card {
            height: 100%;
            overflow: hidden;
            border: 1px solid var(--interlude-border);
            border-radius: 26px;
            background: white;
            box-shadow: 0 10px 32px rgba(73, 38, 29, .04);
            transition: .28s ease;
        }

        .article-link:hover .article-card {
            transform: translateY(-4px);
            box-shadow: 0 20px 45px rgba(73, 38, 29, .09);
        }

        .article-cover {
            position: relative;
            height: 200px;
            overflow: hidden;
            background: var(--interlude-soft);
        }

        .article-cover img {
            transition: .4s ease;
        }

        .article-link:hover .article-cover img {
            transform: scale(1.035);
        }

        .article-placeholder i {
            font-size: 36px;
            opacity: .25;
        }

        .placeholder-category {
            padding: 7px 10px;
            background: rgba(255,255,255,.72);
            color: var(--interlude-brown);
        }

        .article-category {
            position: absolute;
            top: 14px;
            left: 14px;
            padding: 7px 10px;
            background: rgba(255,255,255,.92);
            color: var(--interlude-brown);
            box-shadow: 0 4px 15px rgba(73,38,29,.05);
        }

        .article-body {
            padding: 20px;
        }

        .article-author {
            margin-bottom: 16px;
        }

        .article-body h3 {
            margin: 0;
            color: var(--interlude-brown-dark);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 19px;
            font-weight: 800;
            letter-spacing: -.55px;
            line-height: 1.28;
            transition: .2s ease;
        }

        .article-link:hover .article-body h3 {
            color: var(--interlude-orange);
        }

        .article-body > p {
            margin: 10px 0 0;
            color: var(--interlude-muted);
            font-size: 12px;
            line-height: 1.65;
        }

        .article-meta {
            gap: 14px;
            margin-top: 18px;
            padding-top: 15px;
            border-top: 1px solid #EFE6E1;
            color: #88756D;
            font-size: 10px;
        }

        .article-meta span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .article-arrow {
            margin-left: auto;
            color: var(--interlude-brown);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
        }

        .empty-state {
            grid-column: 1 / -1;
            padding: 70px 30px;
            border: 1px dashed var(--interlude-border);
            border-radius: 28px;
            background: rgba(255,255,255,.7);
            text-align: center;
        }

        .empty-icon {
            width: 62px;
            height: 62px;
            margin: 0 auto 18px;
            font-size: 22px;
        }

        .empty-state h3 {
            margin: 0;
            color: var(--interlude-brown);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 21px;
        }

        .empty-state p {
            margin: 8px 0 20px;
            color: var(--interlude-muted);
            font-size: 13px;
        }

        .empty-cta {
            padding: 11px 16px;
            background: var(--interlude-brown);
            color: white;
            font-size: 11px;
            font-weight: 800;
        }

        .empty-cta:hover {
            background: var(--interlude-orange);
            color: white;
        }

        .pagination-wrap {
            margin-top: 34px;
        }

        .contribution-banner {
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            gap: 22px;
            align-items: center;
            margin-top: 70px;
            padding: 28px 30px;
            border-radius: 30px;
            background: var(--interlude-linen);
        }

        .contribution-icon {
            display: flex;
            width: 58px;
            height: 58px;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: white;
            color: var(--interlude-orange);
            font-size: 18px;
        }

        .contribution-copy h2 {
            margin: 5px 0 4px;
            color: var(--interlude-brown-dark);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -.65px;
        }

        .contribution-copy p {
            margin: 0;
            color: var(--interlude-muted);
            font-size: 12px;
        }

        .contribution-cta {
            padding: 12px 17px;
            background: var(--interlude-orange);
            color: white;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .contribution-cta:hover {
            background: var(--interlude-brown);
            color: white;
            transform: translateY(-1px);
        }

        @media (max-width: 1080px) {
            .dashboard-bento {
                grid-template-columns: 1fr;
            }

            .side-column {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                padding-top: 0;
            }

            .article-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 820px) {
            .dashboard-shell {
                width: min(100% - 30px, 1280px);
                padding-top: 36px;
            }

            .dashboard-hero {
                align-items: flex-start;
                flex-direction: column;
                gap: 20px;
            }

            .hero-copy h1 {
                font-size: clamp(40px, 9vw, 58px);
                letter-spacing: -2px;
            }

            .write-cta {
                align-self: flex-start;
            }

            .featured-card {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .featured-visual-wrap {
                min-height: 280px;
            }

            .featured-cover-card {
                width: 180px;
                right: 30px;
                bottom: 20px;
            }

            .side-column {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .dashboard-shell {
                width: min(100% - 24px, 1280px);
                padding: 26px 0 60px;
            }

            .hero-copy h1 {
                font-size: 40px;
                line-height: 1.07;
            }

            .hero-copy p {
                font-size: 14px;
            }

            .write-cta {
                width: 100%;
            }

            .search-form {
                padding-left: 15px;
            }

            .search-form button {
                width: 46px;
                padding: 0;
                font-size: 0;
            }

            .search-form button i {
                margin: 0;
                font-size: 12px;
            }

            .search-hint {
                margin-left: 4px;
                line-height: 1.5;
            }

            .topic-strip {
                padding-bottom: 28px;
            }

            .section-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 9px;
            }

            .section-heading h2 {
                font-size: 24px;
            }

            .featured-copy {
                padding: 24px;
            }

            .featured-main-copy {
                padding: 34px 0 24px;
            }

            .featured-main-copy h3 {
                font-size: 34px;
                letter-spacing: -1.4px;
            }

            .featured-footer {
                align-items: flex-start;
                flex-direction: column;
                gap: 15px;
            }

            .featured-visual-wrap {
                min-height: 250px;
            }

            .featured-cover-card {
                width: 155px;
                right: 24px;
                bottom: 22px;
            }

            .latest-section {
                padding-top: 50px;
            }

            .article-grid {
                grid-template-columns: 1fr;
            }

            .article-cover {
                height: 190px;
            }

            .contribution-banner {
                grid-template-columns: 1fr;
                padding: 24px;
            }

            .contribution-cta {
                width: 100%;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta ? csrfMeta.content : '';

            window.toggleFollow = async function (userId, button) {
                if (!csrfToken || !button) return;

                const originalText = button.textContent.trim();
                button.disabled = true;

                try {
                    const response = await fetch(`/users/${userId}/follow`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        if (data.following) {
                            button.textContent = 'Mengikuti';
                            button.style.background = '#FFFFFF';
                            button.style.color = '#49261D';
                            button.style.border = '1px solid #E7DAD4';
                        } else {
                            button.textContent = 'Ikuti';
                            button.style.background = '#49261D';
                            button.style.color = '#FFFFFF';
                            button.style.border = '0';
                        }
                    } else {
                        button.textContent = originalText;
                    }
                } catch (error) {
                    console.error('Follow error:', error);
                    button.textContent = originalText;
                } finally {
                    button.disabled = false;
                }
            };
        });
    </script>
</x-app-layout>
