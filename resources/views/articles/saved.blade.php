<x-app-layout>
    <main class="saved-page">
        <header class="saved-header">
            <div>
                <span class="saved-kicker"><i class="fas fa-bookmark"></i> Koleksi pribadi</span>
                <h1>Artikel tersimpan.</h1>
                <p>Simpan cerita yang ingin kamu baca lagi saat punya waktu dan ruang untuk menyerapnya.</p>
            </div>
            <a href="{{ route('explore') }}" class="saved-explore-link"><i class="fas fa-compass"></i> Jelajahi cerita</a>
        </header>

        <section class="saved-toolbar">
            <strong>{{ $bookmarks->total() }}</strong> bacaan tersimpan
        </section>

        @if($bookmarks->isNotEmpty())
            <div class="saved-list">
                @foreach($bookmarks as $bookmark)
                    @php($article = $bookmark->article)
                    @if($article)
                        <article class="saved-item">
                            <div class="saved-cover">
                                @if($article->cover_image)
                                    <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}">
                                @else
                                    <span><i class="fas fa-book-open"></i></span>
                                @endif
                            </div>
                            <div class="saved-content">
                                <span class="saved-category">{{ $article->category }}</span>
                                <h2>{{ $article->title }}</h2>
                                <p>{{ Str::limit($article->excerpt ?: strip_tags($article->content), 150) }}</p>
                                <div class="saved-meta">
                                    <span>{{ $article->user->name }}</span>
                                    <span>·</span>
                                    <span>{{ $article->reading_time }} menit baca</span>
                                </div>
                            </div>
                            <div class="saved-actions">
                                @if($article->is_published)
                                    <a href="{{ route('articles.show', $article->slug) }}" class="saved-read-button">Baca <i class="fas fa-arrow-right"></i></a>
                                @else
                                    <span class="saved-unavailable">Belum tersedia</span>
                                @endif
                            </div>
                        </article>
                    @endif
                @endforeach
            </div>

            <div class="saved-pagination">{{ $bookmarks->links() }}</div>
        @else
            <section class="saved-empty">
                <span class="saved-empty-icon"><i class="far fa-bookmark"></i></span>
                <h2>Belum ada artikel tersimpan.</h2>
                <p>Temukan cerita yang ingin kamu simpan dari halaman Jelajahi.</p>
                <a href="{{ route('explore') }}" class="saved-explore-link"><i class="fas fa-compass"></i> Mulai menjelajah</a>
            </section>
        @endif
    </main>

    <style>
        .saved-page { min-height: 100vh; padding: 52px 5% 100px; background: #f9f7f4; }
        .saved-header, .saved-toolbar, .saved-list, .saved-empty, .saved-pagination { width: min(1080px, 100%); margin-right: auto; margin-left: auto; }
        .saved-header { display: flex; align-items: end; justify-content: space-between; gap: 28px; padding-bottom: 34px; border-bottom: 1px solid var(--border); }
        .saved-kicker { color: var(--tangelo); font-size: 11px; font-weight: 800; letter-spacing: 1.3px; text-transform: uppercase; }
        .saved-header h1 { margin: 10px 0 0; color: var(--brown); font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(34px, 5vw, 56px); letter-spacing: -1.8px; line-height: 1.05; }
        .saved-header p { max-width: 560px; margin: 14px 0 0; color: var(--text-soft); font-size: 16px; line-height: 1.6; }
        .saved-explore-link { display: inline-flex; align-items: center; gap: 8px; flex-shrink: 0; padding: 11px 15px; border: 1px solid var(--border); border-radius: 999px; background: #fff; color: var(--brown); font-size: 13px; font-weight: 800; text-decoration: none; }
        .saved-explore-link:hover { border-color: var(--tangelo); color: var(--tangelo); }
        .saved-toolbar { padding: 24px 0 16px; color: var(--text-soft); font-size: 13px; }
        .saved-toolbar strong { color: var(--brown); font-size: 20px; }
        .saved-list { display: grid; gap: 12px; }
        .saved-item { display: grid; grid-template-columns: 150px minmax(0, 1fr) auto; align-items: center; gap: 20px; padding: 15px; border: 1px solid var(--border); border-radius: 20px; background: #fff; transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease; }
        .saved-item:hover { transform: translateY(-2px); border-color: rgba(251, 77, 0, .4); box-shadow: 0 12px 22px rgba(73, 38, 29, .08); }
        .saved-cover { width: 150px; height: 112px; overflow: hidden; border-radius: 13px; background: linear-gradient(135deg, #cae7f7, #ffede3); }
        .saved-cover img { width: 100%; height: 100%; object-fit: cover; }
        .saved-cover span { display: grid; width: 100%; height: 100%; place-items: center; color: rgba(73, 38, 29, .55); font-size: 28px; }
        .saved-content { min-width: 0; }
        .saved-category { color: #9e2b10; font-size: 10px; font-weight: 800; letter-spacing: .3px; text-transform: uppercase; }
        .saved-content h2 { overflow: hidden; margin: 9px 0 5px; color: var(--brown); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 19px; text-overflow: ellipsis; white-space: nowrap; }
        .saved-content p { overflow: hidden; max-width: 640px; margin: 0; color: var(--text-soft); font-size: 13px; line-height: 1.5; text-overflow: ellipsis; white-space: nowrap; }
        .saved-meta { display: flex; gap: 7px; margin-top: 12px; color: #927f76; font-size: 11px; }
        .saved-read-button { display: inline-flex; align-items: center; gap: 7px; padding: 9px 12px; border-radius: 999px; background: var(--brown); color: #fff; font-size: 12px; font-weight: 800; text-decoration: none; }
        .saved-read-button:hover { background: var(--tangelo); }
        .saved-unavailable { color: #927f76; font-size: 11px; }
        .saved-pagination { margin-top: 24px; }
        .saved-empty { display: grid; justify-items: center; margin-top: 16px; padding: 70px 24px; border: 1px dashed var(--border); border-radius: 20px; text-align: center; }
        .saved-empty-icon { display: grid; width: 54px; height: 54px; place-items: center; border-radius: 50%; background: var(--blue); color: var(--brown); font-size: 22px; }
        .saved-empty h2 { margin: 16px 0 6px; color: var(--brown); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 21px; }
        .saved-empty p { margin: 0 0 18px; color: var(--text-soft); font-size: 14px; }

        @media (max-width: 760px) {
            .saved-page { padding: 34px 4% 80px; }
            .saved-header { align-items: flex-start; flex-direction: column; gap: 20px; }
            .saved-item { grid-template-columns: 86px minmax(0, 1fr); gap: 13px; }
            .saved-cover { width: 86px; height: 86px; }
            .saved-content h2 { font-size: 16px; white-space: normal; }
            .saved-content p { white-space: normal; }
            .saved-actions { grid-column: 1 / -1; justify-content: flex-end; padding-top: 5px; border-top: 1px solid #eee6e1; }
        }
    </style>
</x-app-layout>
