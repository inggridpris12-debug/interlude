<x-app-layout>
    @php
        $categoryGradients = [
            'Penelitian' => 'linear-gradient(135deg, #CAE7F7, #8FC6DE)',
            'Tugas Kuliah' => 'linear-gradient(135deg, #FFEDE3, #FFB89D)',
            'Magang' => 'linear-gradient(135deg, #D8F1E4, #93D1AE)',
            'Organisasi' => 'linear-gradient(135deg, #FFF0C7, #F2C96D)',
            'Tips Belajar' => 'linear-gradient(135deg, #EAE4FA, #BFB0E8)',
            'Kehidupan Kampus' => 'linear-gradient(135deg, #F9DCE8, #E8A9C2)',
        ];
    @endphp

    <main class="explore-page">
        <section class="explore-hero">
            <div class="explore-hero-copy">
                <span class="explore-kicker"><i class="fas fa-compass"></i> Ruang jelajah</span>
                <h1>Temukan cerita yang sedang kamu butuhkan.</h1>
                <p>Jelajahi pengalaman mahasiswa lain berdasarkan topik, penulis, atau pertanyaan yang sedang ada di kepalamu.</p>
            </div>
            <div class="explore-hero-note">
                <span class="note-mark">“</span>
                <p>Setiap proses punya sesuatu untuk dibagikan.</p>
            </div>
        </section>

        <section class="explore-controls" aria-label="Filter artikel">
            <form method="GET" action="{{ route('explore') }}" class="explore-search-form">
                <label for="explore-search">Cari cerita</label>
                <div class="explore-search-field">
                    <i class="fas fa-search"></i>
                    <input id="explore-search" name="q" type="search" value="{{ $search }}" placeholder="Judul, topik, atau nama penulis...">
                    @if($search !== '')
                        <a href="{{ route('explore', $selectedCategory ? ['category' => $selectedCategory] : []) }}" aria-label="Hapus pencarian"><i class="fas fa-times"></i></a>
                    @endif
                    <button type="submit">Cari</button>
                </div>
            </form>

            <div class="explore-categories">
                <span class="filter-label">Pilih topik</span>
                <div class="category-chips">
                    <a href="{{ route('explore', $search !== '' ? ['q' => $search] : []) }}" class="category-chip {{ !$selectedCategory ? 'is-active' : '' }}">Semua cerita</a>
                    @foreach($categories as $category)
                        <a href="{{ route('explore', array_filter(['q' => $search, 'category' => $category])) }}" class="category-chip {{ $selectedCategory === $category ? 'is-active' : '' }}">{{ $category }}</a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="explore-results" aria-labelledby="explore-results-title">
            <div class="results-heading">
                <div>
                    <span class="explore-kicker">Dari komunitas Interlude</span>
                    <h2 id="explore-results-title">{{ $articles->total() }} cerita untuk dijelajahi</h2>
                </div>
                @if($search !== '' || $selectedCategory)
                    <p class="active-filter">Filter aktif: <strong>{{ $search !== '' ? '“' . $search . '”' : $selectedCategory }}</strong></p>
                @endif
            </div>

            @if($articles->isNotEmpty())
                <div class="explore-grid">
                    @foreach($articles as $article)
                        <a href="{{ route('articles.show', $article->slug) }}" class="explore-card">
                            <div class="explore-card-visual">
                                @if($article->cover_image)
                                    <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}">
                                @else
                                    <div class="explore-card-placeholder" style="background: {{ $categoryGradients[$article->category] ?? 'linear-gradient(135deg, #FFEDE3, #CAE7F7)' }};">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                @endif
                                <span class="explore-card-category">{{ $article->category }}</span>
                            </div>
                            <div class="explore-card-body">
                                <div class="explore-card-author">
                                    <span class="mini-avatar">{{ substr($article->user->name, 0, 1) }}</span>
                                    <span>{{ $article->user->name }}</span>
                                    <span class="dot-separator">·</span>
                                    <span>{{ $article->reading_time }} menit</span>
                                </div>
                                <h3>{{ $article->title }}</h3>
                                <p>{{ Str::limit($article->excerpt ?: strip_tags($article->content), 118) }}</p>
                                <div class="explore-card-footer">
                                    <span><i class="far fa-heart"></i> {{ $article->likes_count }}</span>
                                    <span><i class="far fa-comment"></i> {{ $article->comments_count }}</span>
                                    <span class="read-label">Baca <i class="fas fa-arrow-right"></i></span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="explore-pagination">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="explore-empty">
                    <span class="empty-icon"><i class="fas fa-compass"></i></span>
                    <h3>Belum menemukan cerita yang cocok.</h3>
                    <p>Coba kata kunci lain atau kembali melihat semua topik di Interlude.</p>
                    <a href="{{ route('explore') }}">Lihat semua cerita <i class="fas fa-arrow-right"></i></a>
                </div>
            @endif
        </section>
    </main>

    <style>
        .explore-page {
            min-height: 100vh;
            padding: 54px 5% 100px;
            background: var(--cream);
        }

        .explore-hero,
        .explore-controls,
        .explore-results {
            width: min(1180px, 100%);
            margin: 0 auto;
        }

        .explore-hero {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 260px;
            align-items: end;
            gap: 40px;
            padding: 12px 0 42px;
            border-bottom: 1px solid var(--border);
        }

        .explore-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--tangelo);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        .explore-hero h1 {
            max-width: 720px;
            margin: 12px 0 0;
            color: var(--brown);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(34px, 5vw, 62px);
            letter-spacing: -2.2px;
            line-height: 1.04;
        }

        .explore-hero-copy p {
            max-width: 630px;
            margin: 20px 0 0;
            color: var(--text-soft);
            font-size: 17px;
            line-height: 1.7;
        }

        .explore-hero-note {
            padding: 20px;
            border-radius: 20px;
            background: var(--blue);
            color: var(--brown);
            transform: rotate(2deg);
        }

        .note-mark { display: block; font-family: Georgia, serif; font-size: 42px; line-height: .7; }
        .explore-hero-note p { margin: 10px 0 0; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-weight: 700; line-height: 1.35; }

        .explore-controls { display: grid; gap: 24px; padding: 30px 0 42px; }
        .explore-search-form { display: grid; gap: 9px; max-width: 760px; }
        .explore-search-form label, .filter-label { color: var(--brown); font-size: 13px; font-weight: 800; }
        .explore-search-field { display: flex; align-items: center; gap: 12px; min-height: 54px; padding: 5px 7px 5px 17px; border: 1px solid var(--border); border-radius: 999px; background: var(--white); }
        .explore-search-field > i { color: var(--tangelo); }
        .explore-search-field input { min-width: 0; flex: 1; border: 0; outline: 0; background: transparent; color: var(--brown); font: 15px 'DM Sans', sans-serif; }
        .explore-search-field input::placeholder { color: #A89890; }
        .explore-search-field a { color: var(--text-soft); }
        .explore-search-field button { padding: 11px 20px; border: 0; border-radius: 999px; background: var(--brown); color: var(--white); font: 700 13px 'DM Sans', sans-serif; cursor: pointer; }
        .explore-search-field button:hover { background: var(--tangelo); }
        .explore-categories { display: grid; gap: 11px; }
        .category-chips { display: flex; flex-wrap: wrap; gap: 8px; }
        .category-chip { padding: 9px 14px; border: 1px solid var(--border); border-radius: 999px; background: var(--white); color: var(--text-soft); font-size: 13px; font-weight: 700; text-decoration: none; }
        .category-chip:hover, .category-chip.is-active { border-color: var(--brown); background: var(--brown); color: var(--white); }

        .results-heading { display: flex; align-items: end; justify-content: space-between; gap: 20px; margin-bottom: 22px; }
        .results-heading h2 { margin: 8px 0 0; color: var(--brown); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 26px; letter-spacing: -.8px; }
        .active-filter { margin: 0; color: var(--text-soft); font-size: 13px; }
        .explore-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; }
        .explore-card { overflow: hidden; border: 1px solid var(--border); border-radius: 20px; background: var(--white); text-decoration: none; transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
        .explore-card:hover { transform: translateY(-5px); border-color: rgba(251, 77, 0, .45); box-shadow: 0 16px 28px rgba(73, 38, 29, .1); }
        .explore-card-visual { position: relative; height: 178px; overflow: hidden; }
        .explore-card-visual img, .explore-card-placeholder { width: 100%; height: 100%; object-fit: cover; }
        .explore-card-placeholder { display: grid; place-items: center; color: rgba(73, 38, 29, .6); font-size: 34px; }
        .explore-card-category { position: absolute; left: 14px; bottom: 14px; padding: 6px 10px; border-radius: 999px; background: rgba(255, 250, 246, .9); color: var(--brown); font-size: 10px; font-weight: 800; letter-spacing: .7px; text-transform: uppercase; }
        .explore-card-body { display: grid; gap: 12px; padding: 18px; }
        .explore-card-author { display: flex; align-items: center; gap: 7px; color: var(--text-soft); font-size: 12px; }
        .mini-avatar { display: grid; width: 25px; height: 25px; place-items: center; border-radius: 50%; background: var(--linen); color: var(--brown); font-size: 11px; font-weight: 800; }
        .dot-separator { color: var(--border); }
        .explore-card h3 { margin: 0; color: var(--brown); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 18px; line-height: 1.3; }
        .explore-card p { min-height: 44px; margin: 0; color: var(--text-soft); font-size: 14px; line-height: 1.55; }
        .explore-card-footer { display: flex; align-items: center; gap: 13px; padding-top: 11px; border-top: 1px solid var(--border); color: var(--text-soft); font-size: 12px; }
        .explore-card-footer i { color: var(--tangelo); }
        .read-label { margin-left: auto; color: var(--brown); font-weight: 800; }
        .explore-pagination { margin-top: 28px; }
        .explore-pagination nav { display: flex; justify-content: center; }
        .explore-empty { display: grid; justify-items: center; padding: 70px 24px; border: 1px dashed var(--border); border-radius: 20px; text-align: center; }
        .empty-icon { display: grid; width: 52px; height: 52px; place-items: center; border-radius: 50%; background: var(--blue); color: var(--brown); font-size: 22px; }
        .explore-empty h3 { margin: 18px 0 6px; color: var(--brown); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; }
        .explore-empty p { margin: 0; color: var(--text-soft); font-size: 14px; }
        .explore-empty a { margin-top: 18px; color: var(--tangelo); font-size: 14px; font-weight: 800; text-decoration: none; }

        @media (max-width: 850px) {
            .explore-hero { grid-template-columns: 1fr; gap: 24px; }
            .explore-hero-note { max-width: 280px; }
            .explore-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 560px) {
            .explore-page { padding: 32px 4% 80px; }
            .explore-hero h1 { font-size: 36px; letter-spacing: -1.3px; }
            .explore-hero-copy p { font-size: 15px; }
            .results-heading { align-items: flex-start; flex-direction: column; }
            .explore-grid { grid-template-columns: 1fr; }
            .explore-card-visual { height: 200px; }
            .explore-search-field { gap: 8px; padding-left: 13px; }
            .explore-search-field button { padding: 11px 15px; }
        }
    </style>
</x-app-layout>
