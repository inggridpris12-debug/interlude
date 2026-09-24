<x-app-layout>
    <main class="my-work-page">
        <header class="my-work-header">
            <div>
                <span class="my-work-kicker"><i class="fas fa-layer-group"></i> Ruang penulis</span>
                <h1>Kelola karya kamu.</h1>
                <p>Edit, publikasikan ulang, atau hapus cerita yang pernah kamu bagikan di Interlude.</p>
            </div>
            <a href="{{ route('articles.create') }}" class="new-work-button"><i class="fas fa-plus"></i> Tulis karya baru</a>
        </header>

        @if(session('success'))
            <div class="work-alert" role="status"><i class="fas fa-circle-check"></i> {{ session('success') }}</div>
        @endif

        <section class="work-toolbar">
            <div>
                <strong>{{ $articles->total() }}</strong> karya tersimpan
            </div>
            <a href="{{ route('dashboard') }}"><i class="fas fa-arrow-left"></i> Kembali ke beranda</a>
        </section>

        @if($articles->isNotEmpty())
            <div class="work-list">
                @foreach($articles as $article)
                    <article class="work-item">
                        <div class="work-cover">
                            @if($article->cover_image)
                                <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}">
                            @else
                                <span><i class="fas fa-book-open"></i></span>
                            @endif
                        </div>

                        <div class="work-content">
                            <div class="work-meta">
                                <span class="work-category">{{ $article->category }}</span>
                                <span class="work-status {{ $article->is_published ? 'is-published' : 'is-draft' }}">
                                    <i class="fas {{ $article->is_published ? 'fa-globe' : 'fa-file-pen' }}"></i>
                                    {{ $article->is_published ? 'Dipublikasikan' : 'Draft' }}
                                </span>
                            </div>
                            <h2>{{ $article->title }}</h2>
                            <p>{{ Str::limit($article->excerpt ?: strip_tags($article->content), 150) }}</p>
                            <div class="work-stats">
                                <span><i class="far fa-clock"></i> {{ $article->reading_time }} menit baca</span>
                                <span><i class="far fa-eye"></i> {{ number_format($article->views_count) }}</span>
                                <span><i class="far fa-heart"></i> {{ $article->likes_count }}</span>
                                <span><i class="far fa-comment"></i> {{ $article->comments_count }}</span>
                            </div>
                        </div>

                        <div class="work-actions">
                            <a href="{{ route('articles.edit', $article) }}" class="work-edit-button"><i class="fas fa-pen"></i> Edit</a>
                            @if($article->is_published)
                                <a href="{{ route('articles.show', $article->slug) }}" class="work-view-button" aria-label="Lihat {{ $article->title }}"><i class="fas fa-arrow-up-right-from-square"></i></a>
                            @endif
                            <form method="POST" action="{{ route('articles.destroy', $article) }}" onsubmit="return confirm('Hapus karya ini secara permanen? Aksi ini tidak dapat dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="work-delete-button" aria-label="Hapus {{ $article->title }}"><i class="fas fa-trash-can"></i></button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="work-pagination">{{ $articles->links() }}</div>
        @else
            <section class="work-empty">
                <span class="empty-mark"><i class="fas fa-feather-pointed"></i></span>
                <h2>Belum ada karya di sini.</h2>
                <p>Mulai dari satu pengalaman kecil yang mungkin membantu mahasiswa lain.</p>
                <a href="{{ route('articles.create') }}" class="new-work-button"><i class="fas fa-pen-nib"></i> Tulis pengalaman</a>
            </section>
        @endif
    </main>

    <style>
        .my-work-page { min-height: 100vh; padding: 52px 5% 100px; background: #f9f7f4; }
        .my-work-header, .work-toolbar, .work-list, .work-empty, .work-pagination, .work-alert { width: min(1080px, 100%); margin-right: auto; margin-left: auto; }
        .my-work-header { display: flex; align-items: end; justify-content: space-between; gap: 28px; padding-bottom: 34px; border-bottom: 1px solid var(--border); }
        .my-work-kicker { color: var(--tangelo); font-size: 11px; font-weight: 800; letter-spacing: 1.3px; text-transform: uppercase; }
        .my-work-header h1 { margin: 10px 0 0; color: var(--brown); font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(34px, 5vw, 56px); letter-spacing: -1.8px; line-height: 1.05; }
        .my-work-header p { max-width: 560px; margin: 14px 0 0; color: var(--text-soft); font-size: 16px; line-height: 1.6; }
        .new-work-button { display: inline-flex; align-items: center; justify-content: center; gap: 8px; flex-shrink: 0; padding: 12px 17px; border-radius: 999px; background: var(--brown); color: #fff; font-size: 13px; font-weight: 800; text-decoration: none; }
        .new-work-button:hover { background: var(--tangelo); }
        .work-alert { display: flex; align-items: center; gap: 8px; margin-top: 22px; padding: 12px 15px; border-radius: 12px; background: #e4f4ed; color: #226d4e; font-size: 13px; }
        .work-toolbar { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 24px 0 16px; color: var(--text-soft); font-size: 13px; }
        .work-toolbar strong { color: var(--brown); font-size: 20px; }
        .work-toolbar a { color: var(--brown); font-weight: 800; text-decoration: none; }
        .work-toolbar a:hover { color: var(--tangelo); }
        .work-list { display: grid; gap: 12px; }
        .work-item { display: grid; grid-template-columns: 150px minmax(0, 1fr) auto; align-items: center; gap: 20px; padding: 15px; border: 1px solid var(--border); border-radius: 20px; background: #fff; transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease; }
        .work-item:hover { transform: translateY(-2px); border-color: rgba(251, 77, 0, .4); box-shadow: 0 12px 22px rgba(73, 38, 29, .08); }
        .work-cover { width: 150px; height: 112px; overflow: hidden; border-radius: 13px; background: linear-gradient(135deg, #cae7f7, #ffede3); }
        .work-cover img { width: 100%; height: 100%; object-fit: cover; }
        .work-cover span { display: grid; width: 100%; height: 100%; place-items: center; color: rgba(73, 38, 29, .55); font-size: 28px; }
        .work-content { min-width: 0; }
        .work-meta { display: flex; align-items: center; flex-wrap: wrap; gap: 8px; }
        .work-category, .work-status { display: inline-flex; align-items: center; gap: 5px; border-radius: 999px; padding: 5px 9px; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .3px; }
        .work-category { background: #fff0e9; color: #9e2b10; }
        .work-status { background: #f4f0ed; color: #75635b; }
        .work-status.is-published { background: #e4f4ed; color: #226d4e; }
        .work-content h2 { overflow: hidden; margin: 10px 0 5px; color: var(--brown); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 19px; text-overflow: ellipsis; white-space: nowrap; }
        .work-content p { overflow: hidden; max-width: 640px; margin: 0; color: var(--text-soft); font-size: 13px; line-height: 1.5; text-overflow: ellipsis; white-space: nowrap; }
        .work-stats { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 12px; color: #927f76; font-size: 11px; }
        .work-stats i { margin-right: 3px; color: var(--tangelo); }
        .work-actions { display: flex; align-items: center; gap: 7px; }
        .work-edit-button, .work-view-button, .work-delete-button { display: inline-flex; align-items: center; justify-content: center; min-height: 34px; border: 1px solid var(--border); border-radius: 999px; background: #fff; color: var(--brown); font-size: 12px; font-weight: 800; text-decoration: none; cursor: pointer; }
        .work-edit-button { gap: 6px; padding: 0 12px; }
        .work-view-button, .work-delete-button { width: 34px; }
        .work-edit-button:hover, .work-view-button:hover { border-color: var(--tangelo); color: var(--tangelo); }
        .work-delete-button { color: #a33128; }
        .work-delete-button:hover { border-color: #a33128; background: #fff0ee; }
        .work-actions form { margin: 0; }
        .work-pagination { margin-top: 24px; }
        .work-empty { display: grid; justify-items: center; margin-top: 16px; padding: 70px 24px; border: 1px dashed var(--border); border-radius: 20px; text-align: center; }
        .empty-mark { display: grid; width: 54px; height: 54px; place-items: center; border-radius: 50%; background: var(--blue); color: var(--brown); font-size: 22px; }
        .work-empty h2 { margin: 16px 0 6px; color: var(--brown); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 21px; }
        .work-empty p { margin: 0 0 18px; color: var(--text-soft); font-size: 14px; }

        @media (max-width: 760px) {
            .my-work-page { padding: 34px 4% 80px; }
            .my-work-header { align-items: flex-start; flex-direction: column; gap: 20px; }
            .work-item { grid-template-columns: 86px minmax(0, 1fr); gap: 13px; }
            .work-cover { width: 86px; height: 86px; }
            .work-content h2 { font-size: 16px; white-space: normal; }
            .work-content p { white-space: normal; }
            .work-actions { grid-column: 1 / -1; justify-content: flex-end; padding-top: 5px; border-top: 1px solid #eee6e1; }
        }

        @media (max-width: 430px) {
            .work-toolbar { align-items: flex-start; flex-direction: column; }
            .work-stats { gap: 8px; }
        }
    </style>
</x-app-layout>
