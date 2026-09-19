@php
    $gradients = [
        'Penelitian' => 'linear-gradient(135deg, #FFE5E0 0%, #FFB8A8 100%)',
        'Tugas Kuliah' => 'linear-gradient(135deg, #B8DDF5 0%, #7BB8E8 100%)',
        'Magang' => 'linear-gradient(135deg, #D4F5E0 0%, #7DD3A8 100%)',
        'Organisasi' => 'linear-gradient(135deg, #E8D4FF 0%, #C4A8FF 100%)',
        'Tips Belajar' => 'linear-gradient(135deg, #FFF4D4 0%, #FFD97D 100%)',
        'Kehidupan Kampus' => 'linear-gradient(135deg, #FFE5F0 0%, #FFB8D4 100%)',
    ];
    $getGradient = fn($cat) => $gradients[$cat] ?? 'linear-gradient(135deg, #FFE5E0 0%, #CAE7F7 100%)';
@endphp

<x-app-layout>
    <div class="dashboard-wrapper">
        
        <!-- HEADER -->
        <header class="dashboard-header">
            <div class="header-top">
                <div class="header-content">
                    <div class="header-left">
                        <h1 class="greeting">Selamat datang, {{ explode(' ', Auth::user()->name)[0] }}.</h1>
                        <p class="subheading">Temukan cerita dan pengetahuan dari mahasiswa lain.</p>
                    </div>
                </div>
            </div>

            <!-- Search Bar dengan Button -->
            <div class="search-section">
                <div class="search-wrapper">
                    <input type="text" placeholder="Cari artikel, topik, atau penulis..." class="search-input">
                    <button class="search-btn">
                        <i class="fas fa-search"></i>
                        <span>Cari</span>
                    </button>
                </div>
            </div>

            <!-- Topic Chips -->
            <div class="topics-section">
                <div class="topics-scroll">
                    @foreach($categories as $category)
                        <a href="#" class="topic-chip">{{ $category }}</a>
                    @endforeach
                </div>
            </div>
        </header>

        <!-- MAIN LAYOUT -->
        <div class="main-layout">
            
            <!-- FEED COLUMN -->
            <div class="feed-column">
                
                <!-- Featured Article -->
                @if($featuredArticle)
                <a href="{{ route('articles.show', $featuredArticle->slug) }}" class="featured-link">
                    <article class="featured-card">
                        <div class="featured-image-wrapper">
                            @if($featuredArticle->cover_image)
                                <img src="{{ asset('storage/' . $featuredArticle->cover_image) }}" alt="{{ $featuredArticle->title }}" class="featured-image">
                            @else
                                <div class="featured-image placeholder">
                                    <div class="placeholder-bg" style="background: {{ $getGradient($featuredArticle->category) }};">
                                        <i class="fas fa-image"></i>
                                    </div>
                                </div>
                            @endif
                            <div class="featured-overlay">
                                <div class="featured-content">
                                    <div class="featured-tag-row">
                                        <span class="featured-badge">PILIHAN UNTUKMU</span>
                                        <span class="featured-category">{{ $featuredArticle->category }}</span>
                                    </div>
                                    <h2 class="featured-title">{{ $featuredArticle->title }}</h2>
                                    <div class="featured-footer">
                                        <div class="featured-author">
                                            <div class="author-avatar avatar-featured" style="background: linear-gradient(135deg, #FF8C5A, #FB4D00);">
                                                {{ substr($featuredArticle->user->name, 0, 1) }}
                                            </div>
                                            <div class="author-info">
                                                <span class="author-name">{{ $featuredArticle->user->name }}</span>
                                                <span class="author-meta">{{ $featuredArticle->reading_time }} menit baca</span>
                                            </div>
                                        </div>
                                        <span class="read-more">
                                            Baca <i class="fas fa-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </a>
                @endif

                <!-- Articles List (1 KOLOM) -->
                <div class="articles-list">
                    @forelse($articles as $article)
                        <a href="{{ route('articles.show', $article->slug) }}" class="article-link">
                            <article class="article-card {{ !$article->cover_image ? 'no-cover' : '' }}">
                                
                                @if($article->cover_image)
                                    <!-- Card dengan Cover Image -->
                                    <div class="card-image-wrapper">
                                        <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}" class="card-image">
                                        <div class="card-overlay">
                                            <div class="overlay-content">
                                                <h3 class="card-title-overlay">{{ $article->title }}</h3>
                                                <div class="card-stats">
                                                    <span class="stat-item"><i class="far fa-heart"></i> {{ $article->likes_count }}</span>
                                                    <span class="stat-item"><i class="far fa-comment"></i> {{ $article->comments_count }}</span>
                                                    <span class="stat-item"><i class="fas fa-share"></i> {{ rand(1, 2) }}K</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Card Tanpa Cover - Stats sama -->
                                    <div class="card-content-no-cover">
                                        <div class="card-header">
                                            <div class="author-avatar" style="background: {{ $loop->iteration % 4 === 0 ? 'linear-gradient(135deg, #FF8C5A, #FB4D00)' : ($loop->iteration % 4 === 1 ? 'linear-gradient(135deg, #7BB8E8, #4A90E2)' : ($loop->iteration % 4 === 2 ? 'linear-gradient(135deg, #7DD3A8, #2D8B5E)' : 'linear-gradient(135deg, #C4A8FF, #8B5CF6)')) }};">
                                                {{ substr($article->user->name, 0, 1) }}
                                            </div>
                                            <div class="author-info">
                                                <span class="author-name">{{ $article->user->name }}</span>
                                            </div>
                                        </div>
                                        <h3 class="card-title">{{ $article->title }}</h3>
                                        <span class="card-category">{{ $article->category }}</span>
                                        <p class="card-excerpt">{{ Str::limit($article->excerpt, 100) }}</p>
                                        <div class="card-stats">
                                            <span class="stat-item"><i class="far fa-heart"></i> {{ $article->likes_count }}</span>
                                            <span class="stat-item"><i class="far fa-comment"></i> {{ $article->comments_count }}</span>
                                            <span class="stat-item"><i class="fas fa-share"></i> {{ rand(1, 2) }}K</span>
                                        </div>
                                    </div>
                                @endif
                            </article>
                        </a>
                    @empty
                        <div class="empty-state">
                            <i class="far fa-newspaper"></i>
                            <h3>Belum ada cerita</h3>
                            <p>Jadilah yang pertama berbagi pengalaman di Interlude.</p>
                            <a href="{{ route('articles.create') }}" class="btn-primary">
                                <i class="fas fa-pen"></i> Tulis Artikel
                            </a>
                        </div>
                    @endforelse
                </div>

                @if($articles->hasPages())
                    <div class="pagination">
                        {{ $articles->links() }}
                    </div>
                @endif
            </div>

            <!-- SIDEBAR -->
            <aside class="sidebar-column">
                
                <!-- Recommended Writers -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Penulis yang mungkin kamu suka</h3>
                    <div class="writers-grid">
                        @forelse($recommendedWriters as $writer)
                            <div class="writer-item">
                                <div class="writer-avatar" style="background: {{ $loop->iteration % 3 === 0 ? '#4A90E2' : ($loop->iteration % 3 === 1 ? '#8B5CF6' : '#FF8C5A') }};">
                                    {{ substr($writer->name, 0, 1) }}
                                </div>
                                <div class="writer-info">
                                    <span class="writer-name">{{ $writer->name }}</span>
                                </div>
                                <button class="follow-btn" onclick="event.preventDefault(); event.stopPropagation(); toggleFollow({{ $writer->id }}, this)">Ikuti</button>
                            </div>
                        @empty
                            <p class="sidebar-empty">Belum ada penulis untuk ditampilkan.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Trending -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Sedang banyak dibaca</h3>
                    <div class="trending-list">
                        @forelse($trendingArticles as $index => $trend)
                            <a href="{{ route('articles.show', $trend->slug) }}" class="trending-item">
                                <span class="trending-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <div class="trending-info">
                                    <span class="trending-title">{{ $trend->title }}</span>
                                </div>
                            </a>
                        @empty
                            <p class="sidebar-empty">Belum ada artikel trending.</p>
                        @endforelse
                    </div>
                </div>

            </aside>
        </div>
    </div>

    <style>
        :root {
            --brown: #49261D;
            --tangelo: #FB4D00;
            --cream: #FFFAF6;
            --linen: #FFEDE3;
            --text-soft: #705D55;
            --border: #E9DCD4;
            --white: #FFFFFF;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--cream);
            color: var(--brown);
        }

        .dashboard-wrapper {
            max-width: 1280px;
            margin: 0 auto;
            padding: 40px 5% 80px;
        }

        /* HEADER - UPDATED FONT */
        .dashboard-header {
            margin-bottom: 48px;
        }

        .header-top {
            margin-bottom: 24px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 40px;
        }

        .header-left {
            flex: 1;
        }

        .greeting {
            font-family: 'Playfair Display', serif;
            font-size: clamp(40px, 5vw, 64px);
            font-weight: 900;
            color: var(--brown);
            letter-spacing: -2px;
            line-height: 1.05;
            margin-bottom: 8px;
        }

        .subheading {
            font-size: 17px;
            color: var(--text-soft);
            line-height: 1.6;
        }

        /* SEARCH SECTION */
        .search-section {
            margin-bottom: 32px;
        }

        .search-wrapper {
            display: flex;
            gap: 12px;
            max-width: 700px;
        }

        .search-input {
            flex: 1;
            height: 56px;
            padding: 0 24px;
            border: 1.5px solid var(--border);
            border-radius: 50px;
            background: var(--white);
            font-size: 16px;
            font-family: inherit;
            outline: none;
            transition: 0.2s;
        }

        .search-input:focus {
            border-color: var(--tangelo);
            box-shadow: 0 0 0 4px rgba(251, 77, 0, 0.08);
        }

        .search-input::placeholder {
            color: #B0A098;
        }

        .search-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 28px;
            height: 56px;
            background: var(--brown);
            color: var(--white);
            border: none;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            font-family: inherit;
            white-space: nowrap;
        }

        .search-btn:hover {
            background: var(--tangelo);
            transform: translateY(-2px);
        }

        .search-btn i {
            font-size: 16px;
        }

        /* TOPICS */
        .topics-section {
            margin-bottom: 48px;
        }

        .topics-scroll {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding-bottom: 4px;
            scrollbar-width: none;
        }

        .topics-scroll::-webkit-scrollbar {
            display: none;
        }

        .topic-chip {
            padding: 12px 24px;
            background: var(--linen);
            border-radius: 50px;
            font-size: 15px;
            font-weight: 600;
            color: var(--brown);
            white-space: nowrap;
            transition: 0.2s;
            text-decoration: none;
        }

        .topic-chip:hover {
            background: var(--tangelo);
            color: var(--white);
            transform: translateY(-2px);
        }

        /* MAIN LAYOUT */
        .main-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 48px;
            align-items: start;
        }

        /* FEATURED CARD */
        .featured-link {
            text-decoration: none;
            display: block;
        }

        .featured-card {
            margin-bottom: 48px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(73, 38, 29, 0.15);
            transition: 0.25s;
        }

        .featured-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 70px rgba(73, 38, 29, 0.2);
        }

        .featured-image-wrapper {
            position: relative;
            height: 480px;
        }

        .featured-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .placeholder-bg {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 80px;
            color: rgba(73, 38, 29, 0.2);
        }

        .featured-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(73, 38, 29, 0.95) 0%, rgba(73, 38, 29, 0.6) 50%, transparent 100%);
            padding: 80px 40px 40px;
        }

        .featured-content {
            color: var(--white);
        }

        .featured-tag-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .featured-badge {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            color: var(--white);
            text-transform: uppercase;
            padding: 8px 16px;
            background: var(--tangelo);
            border-radius: 20px;
        }

        .featured-category {
            font-size: 13px;
            font-weight: 600;
            color: var(--white);
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
        }

        .featured-title {
            font-family: 'DM Sans', sans-serif;
            font-size: 40px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 32px;
            letter-spacing: -0.5px;
        }

        .featured-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .featured-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-featured {
            width: 48px;
            height: 48px;
            font-size: 18px;
            color: var(--white);
        }

        .featured-author .author-name {
            color: var(--white);
            font-size: 16px;
            font-weight: 600;
        }

        .featured-author .author-meta {
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
        }

        .read-more {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: var(--tangelo);
            color: var(--white);
            border-radius: 30px;
            font-size: 15px;
            font-weight: 600;
            transition: 0.2s;
        }

        .featured-card:hover .read-more {
            background: var(--white);
            color: var(--brown);
        }

        /* ARTICLES LIST (1 KOLOM) */
        .articles-list {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .article-link {
            text-decoration: none;
            display: block;
        }

        .article-card {
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(73, 38, 29, 0.06);
            transition: 0.25s;
        }

        .article-card:hover {
            box-shadow: 0 8px 30px rgba(73, 38, 29, 0.12);
            transform: translateY(-4px);
        }

        /* Card dengan Cover */
        .card-image-wrapper {
            position: relative;
            height: 320px;
            overflow: hidden;
        }

        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.3s;
        }

        .article-card:hover .card-image {
            transform: scale(1.05);
        }

        .card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(73, 38, 29, 0.92) 0%, rgba(73, 38, 29, 0.5) 60%, transparent 100%);
            padding: 80px 24px 24px;
            color: var(--white);
        }

        .card-title-overlay {
            font-family: 'DM Sans', sans-serif;
            font-size: 24px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 16px;
            letter-spacing: -0.3px;
        }

        /* Card Tanpa Cover */
        .card-content-no-cover {
            padding: 28px;
        }

        .card-content-no-cover .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .card-content-no-cover .author-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            color: var(--white);
        }

        .card-content-no-cover .author-name {
            font-weight: 600;
            font-size: 15px;
            color: var(--brown);
        }

        .card-content-no-cover .card-title {
            font-family: 'DM Sans', sans-serif;
            font-size: 24px;
            font-weight: 700;
            line-height: 1.3;
            color: var(--brown);
            margin-bottom: 12px;
            letter-spacing: -0.3px;
        }

        .article-card:hover .card-content-no-cover .card-title {
            color: var(--tangelo);
        }

        .card-content-no-cover .card-category {
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            color: var(--tangelo);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .card-content-no-cover .card-excerpt {
            font-size: 15px;
            line-height: 1.6;
            color: var(--text-soft);
            margin-bottom: 20px;
        }

        /* Stats bar (seragam untuk semua card) */
        .card-stats {
            display: flex;
            gap: 20px;
            font-size: 14px;
            color: var(--text-soft);
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }

        .card-overlay .card-stats {
            border-top: none;
            padding-top: 0;
            color: var(--white);
        }

        .card-stats .stat-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .card-stats .stat-item i {
            font-size: 15px;
        }

        /* SIDEBAR */
        .sidebar-column {
            position: sticky;
            top: 40px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .sidebar-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
        }

        .sidebar-title {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--brown);
            margin-bottom: 20px;
        }

        .writers-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .writer-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 8px;
        }

        .writer-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 20px;
            color: var(--white);
        }

        .writer-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--brown);
        }

        .follow-btn {
            padding: 8px 20px;
            background: var(--tangelo);
            color: var(--white);
            border: none;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            font-family: inherit;
        }

        .follow-btn:hover {
            background: var(--brown);
        }

        .trending-list {
            display: flex;
            flex-direction: column;
        }

        .trending-item {
            display: flex;
            gap: 16px;
            padding: 16px 0;
            border-bottom: 1px solid var(--border);
            text-decoration: none;
            transition: 0.2s;
        }

        .trending-item:last-child {
            border-bottom: none;
        }

        .trending-item:hover .trending-title {
            color: var(--tangelo);
        }

        .trending-number {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 800;
            color: var(--border);
            min-width: 32px;
        }

        .trending-info {
            flex: 1;
        }

        .trending-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--brown);
            line-height: 1.4;
            transition: 0.2s;
        }

        .sidebar-empty {
            font-size: 13px;
            color: var(--text-soft);
            text-align: center;
            padding: 20px 0;
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 80px 40px;
            background: var(--white);
            border: 2px dashed var(--border);
            border-radius: 16px;
        }

        .empty-state i {
            font-size: 64px;
            color: var(--border);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--text-soft);
            margin-bottom: 24px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: var(--tangelo);
            color: var(--white);
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-primary:hover {
            background: var(--brown);
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .main-layout {
                grid-template-columns: 1fr;
            }
            .sidebar-column {
                position: static;
                display: grid;
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .dashboard-wrapper { padding: 24px 5% 60px; }
            .greeting { font-size: clamp(32px, 8vw, 48px); }
            .header-content { flex-direction: column; }
            .search-wrapper { flex-direction: column; }
            .search-btn { justify-content: center; }
            .featured-image-wrapper { height: 360px; }
            .featured-title { font-size: 28px; }
            .card-image-wrapper { height: 240px; }
            .card-content-no-cover .card-title { font-size: 20px; }
            .card-title-overlay { font-size: 20px; }
            .sidebar-column { grid-template-columns: 1fr; }
        }
    </style>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        async function toggleFollow(userId, button) {
            try {
                const response = await fetch(`/users/${userId}/follow`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                });
                const data = await response.json();
                if (data.success) {
                    if (data.following) {
                        button.textContent = 'Mengikuti';
                        button.style.background = 'var(--white)';
                        button.style.color = 'var(--brown)';
                        button.style.border = '1.5px solid var(--border)';
                    } else {
                        button.textContent = 'Ikuti';
                        button.style.background = 'var(--tangelo)';
                        button.style.color = 'var(--white)';
                        button.style.border = 'none';
                    }
                }
            } catch (error) { console.error('Error:', error); }
        }
    </script>
</x-app-layout>