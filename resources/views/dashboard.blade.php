@php
    $feedTabs = [
        'untukmu' => 'Untukmu',
        'mengikuti' => 'Mengikuti',
        'utas' => 'Utas',
        'artikel' => 'Artikel',
        'podcast' => 'Podcast',
    ];

    $gradients = [
        'Penelitian' => 'linear-gradient(135deg, #CAE7F7 0%, #EAF7FD 100%)',
        'Tugas Kuliah' => 'linear-gradient(135deg, #FFEDE3 0%, #FFD9C8 100%)',
        'Magang' => 'linear-gradient(135deg, #DFF4E8 0%, #BFE7D0 100%)',
        'Organisasi' => 'linear-gradient(135deg, #EEE4FF 0%, #D7C5FF 100%)',
        'Tips Belajar' => 'linear-gradient(135deg, #FFF5CF 0%, #FFE49A 100%)',
        'Kehidupan Kampus' => 'linear-gradient(135deg, #FFE9F1 0%, #FFD1E0 100%)',
    ];

    $getGradient = fn ($category) => $gradients[$category]
        ?? 'linear-gradient(135deg, #CAE7F7 0%, #FFEDE3 100%)';
@endphp

<x-app-layout>

    @once
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap"
            rel="stylesheet"
        >
    @endonce

    <main class="home-feed-page">
        <div class="home-shell">

            <section class="home-main">

                <nav class="feed-tabs">
                    @foreach($feedTabs as $key => $label)
                        <a
                            href="{{ route('dashboard', ['feed' => $key]) }}"
                            class="feed-tab {{ $feed === $key ? 'is-active' : '' }}"
                        >
                            {{ $label }}
                        </a>
                    @endforeach
                </nav>

                @if(session('success'))
                    <div class="home-alert home-alert--success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="home-alert home-alert--error">
                        {{ $errors->first() }}
                    </div>
                @endif


                {{-- COMPOSER --}}
                <section class="thread-composer">
                    <div class="composer-row">

                        <x-user-avatar :user="Auth::user()" :size="44" class="composer-avatar" />

                        <form
                            method="POST"
                            action="{{ route('threads.store') }}"
                            enctype="multipart/form-data"
                            id="threadComposerForm"
                            class="composer-form"
                        >
                            @csrf

                            <textarea
                                id="threadBody"
                                name="body"
                                maxlength="280"
                                rows="3"
                                placeholder="Apa yang sedang kamu pikirkan atau pelajari hari ini?"
                                required
                            >{{ old('body') }}</textarea>

                            <div
                                id="composerPreview"
                                class="composer-preview"
                                hidden
                            ></div>

                            <div class="composer-meta">
                                <label>
                                    <span>Topik</span>

                                    <select name="topic">
                                        <option value="">Tanpa topik</option>

                                        @foreach($categories as $category)
                                            <option
                                                value="{{ $category }}"
                                                {{ old('topic') === $category ? 'selected' : '' }}
                                            >
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>

                                <label>
                                    <span>Audiens</span>

                                    <select name="visibility">
                                        <option
                                            value="public"
                                            {{ old('visibility', 'public') === 'public' ? 'selected' : '' }}
                                        >
                                            Semua mahasiswa
                                        </option>

                                        <option
                                            value="followers"
                                            {{ old('visibility') === 'followers' ? 'selected' : '' }}
                                        >
                                            Hanya pengikut
                                        </option>
                                    </select>
                                </label>
                            </div>

                            <div class="composer-footer">

                                <div class="composer-tools">

                                    <label class="composer-tool" title="Foto / GIF">
                                        <i class="far fa-image"></i>

                                        <input
                                            id="composerImages"
                                            type="file"
                                            name="images[]"
                                            accept="image/*,.gif"
                                            multiple
                                        >
                                    </label>

                                    <label class="composer-tool" title="Video">
                                        <i class="fas fa-video"></i>

                                        <input
                                            id="composerVideo"
                                            type="file"
                                            name="video"
                                            accept="video/mp4,video/webm,video/quicktime"
                                        >
                                    </label>

                                    <label class="composer-tool" title="Audio / voice note">
                                        <i class="fas fa-headphones"></i>

                                        <input
                                            id="composerAudio"
                                            type="file"
                                            name="audio"
                                            accept="audio/*"
                                        >
                                    </label>

                                    <label class="composer-tool" title="Dokumen">
                                        <i class="fas fa-paperclip"></i>

                                        <input
                                            id="composerFiles"
                                            type="file"
                                            name="files[]"
                                            accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt"
                                            multiple
                                        >
                                    </label>

                                    <button
                                        type="button"
                                        class="composer-tool"
                                        data-open-composer-modal="linkModal"
                                        title="Tautan"
                                        aria-label="Tambahkan tautan"
                                    >
                                        <i class="fas fa-link"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="composer-tool"
                                        data-open-composer-modal="pollModal"
                                        title="Polling"
                                        aria-label="Buat polling"
                                    >
                                        <i class="fas fa-chart-simple"></i>
                                    </button>

                                </div>

                                <div class="composer-submit">
                                    <span class="thread-counter">
                                        <strong id="threadCounter">0</strong>/280
                                    </span>

                                    <button
                                        type="submit"
                                        class="post-thread-btn"
                                    >
                                        Posting
                                    </button>
                                </div>

                            </div>


                            {{-- =====================================================
                                 POPUP LINK
                            ====================================================== --}}
                            <div
                                id="linkModal"
                                class="composer-modal"
                                hidden
                                aria-hidden="true"
                            >
                                <div
                                    class="composer-modal-backdrop"
                                    data-close-composer-modal
                                ></div>

                                <div
                                    class="composer-modal-dialog composer-modal-dialog--small"
                                    role="dialog"
                                    aria-modal="true"
                                    aria-labelledby="linkModalTitle"
                                >
                                    <div class="composer-modal-head">
                                        <div>
                                            <span class="composer-modal-kicker">
                                                Tautan
                                            </span>

                                            <h3 id="linkModalTitle">
                                                Tambahkan tautan
                                            </h3>
                                        </div>

                                        <button
                                            type="button"
                                            class="composer-modal-close"
                                            data-close-composer-modal
                                            aria-label="Tutup"
                                        >
                                            <i class="fas fa-xmark"></i>
                                        </button>
                                    </div>

                                    <div class="composer-modal-body">

                                        <label class="composer-modal-field">
                                            <span>URL</span>

                                            <div class="composer-modal-input">
                                                <i class="fas fa-link"></i>

                                                <input
                                                    id="composerLinkInput"
                                                    type="url"
                                                    name="link"
                                                    placeholder="https://..."
                                                    value="{{ old('link') }}"
                                                >
                                            </div>
                                        </label>

                                        <p class="composer-modal-help">
                                            Tempel artikel, jurnal, website, atau sumber lain yang ingin kamu bagikan.
                                        </p>

                                    </div>

                                    <div class="composer-modal-footer">

                                        <button
                                            type="button"
                                            class="modal-secondary-btn"
                                            data-clear-link
                                        >
                                            Hapus
                                        </button>

                                        <button
                                            type="button"
                                            class="modal-primary-btn"
                                            data-save-composer-modal
                                        >
                                            Tambahkan
                                        </button>

                                    </div>
                                </div>
                            </div>


                            {{-- =====================================================
                                 POPUP POLLING
                            ====================================================== --}}
                            <div
                                id="pollModal"
                                class="composer-modal"
                                hidden
                                aria-hidden="true"
                            >
                                <div
                                    class="composer-modal-backdrop"
                                    data-close-composer-modal
                                ></div>

                                <div
                                    class="composer-modal-dialog"
                                    role="dialog"
                                    aria-modal="true"
                                    aria-labelledby="pollModalTitle"
                                >
                                    <div class="composer-modal-head">
                                        <div>
                                            <span class="composer-modal-kicker">
                                                Polling
                                            </span>

                                            <h3 id="pollModalTitle">
                                                Buat polling
                                            </h3>
                                        </div>

                                        <button
                                            type="button"
                                            class="composer-modal-close"
                                            data-close-composer-modal
                                            aria-label="Tutup"
                                        >
                                            <i class="fas fa-xmark"></i>
                                        </button>
                                    </div>

                                    <div class="composer-modal-body">

                                        <label class="composer-modal-field">
                                            <span>Pertanyaan</span>

                                            <input
                                                id="pollQuestionInput"
                                                type="text"
                                                name="poll_question"
                                                maxlength="180"
                                                placeholder="Tanyakan sesuatu..."
                                                value="{{ old('poll_question') }}"
                                            >
                                        </label>

                                        <div class="composer-modal-field">
                                            <span>Pilihan jawaban</span>

                                            <div class="modal-poll-options">

                                                @for($i = 0; $i < 4; $i++)
                                                    <div class="modal-poll-option">

                                                        <span>{{ $i + 1 }}</span>

                                                        <input
                                                            type="text"
                                                            name="poll_options[]"
                                                            maxlength="100"
                                                            placeholder="Pilihan {{ $i + 1 }}{{ $i > 1 ? ' (opsional)' : '' }}"
                                                            value="{{ old('poll_options.' . $i) }}"
                                                            data-poll-option
                                                        >

                                                    </div>
                                                @endfor

                                            </div>
                                        </div>

                                        <p class="composer-modal-help">
                                            Isi minimal 2 pilihan. Maksimal 4 pilihan jawaban.
                                        </p>

                                    </div>

                                    <div class="composer-modal-footer">

                                        <button
                                            type="button"
                                            class="modal-secondary-btn"
                                            data-clear-poll
                                        >
                                            Hapus polling
                                        </button>

                                        <button
                                            type="button"
                                            class="modal-primary-btn"
                                            data-save-composer-modal
                                        >
                                            Simpan polling
                                        </button>

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </section>


                {{-- FEED --}}
                <section class="stream">

                    <div class="stream-heading">
                        <div>
                            <span class="stream-kicker">
                                {{ $feedTabs[$feed] ?? 'Untukmu' }}
                            </span>

                            <h1>
                                @switch($feed)
                                    @case('mengikuti')
                                        Dari orang yang kamu ikuti
                                        @break
                                    @case('utas')
                                        Utas terbaru
                                        @break
                                    @case('artikel')
                                        Artikel terbaru
                                        @break
                                    @case('podcast')
                                        Podcast
                                        @break
                                    @default
                                        Pilihan untukmu
                                @endswitch
                            </h1>
                        </div>

                        <a href="{{ route('explore') }}">
                            Jelajahi
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <div class="stream-list">

                        @forelse($feedItems as $feedItem)

                            @if($feedItem['type'] === 'thread')

                                @php
                                    $thread = $feedItem['item'];
                                    $liked = $thread->isLikedBy(Auth::user());
                                    $bookmarked = $thread->isBookmarkedBy(Auth::user());
                                @endphp

                                <article
                                    class="thread-card clickable-thread"
                                    data-thread-url="{{ route('threads.show', $thread) }}"
                                >

                                    <div class="thread-card-top">

                                        <div class="thread-author">
                                            <x-user-avatar :user="$thread->user" :size="42" class="feed-avatar" />

                                            <div>
                                                <strong>{{ $thread->user->name }}</strong>

                                                <span>
                                                    {{ $thread->created_at->locale('id')->diffForHumans() }}
                                                    ·
                                                    {{ $thread->visibility === 'followers' ? 'Pengikut' : 'Publik' }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="thread-top-actions">
                                            @if($thread->topic)
                                                <span class="thread-topic">
                                                    {{ $thread->topic }}
                                                </span>
                                            @endif

                                            @if($thread->user_id === Auth::id())
                                                <form
                                                    method="POST"
                                                    action="{{ route('threads.destroy', $thread) }}"
                                                    onsubmit="return confirm('Hapus utasan ini?')"
                                                    data-stop-thread-click
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="thread-more"
                                                    >
                                                        <i class="far fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="thread-body">
                                        {{ $thread->body }}
                                    </div>

                                    @if($thread->attachments->isNotEmpty())
                                        <div class="thread-attachments-wrap">
                                            @include('threads.partials.attachments', [
                                                'attachments' => $thread->attachments,
                                            ])
                                        </div>
                                    @endif

                                    @if($thread->poll)
                                        @include('threads.partials.poll', [
                                            'thread' => $thread,
                                            'poll' => $thread->poll,
                                        ])
                                    @endif

                                    <div class="thread-actions" data-stop-thread-click>

                                        <button
                                            type="button"
                                            class="thread-action {{ $liked ? 'is-active' : '' }}"
                                            data-thread-like
                                            data-url="{{ route('threads.like', $thread) }}"
                                        >
                                            <i class="{{ $liked ? 'fas' : 'far' }} fa-heart"></i>
                                            <span data-like-count>{{ $thread->likes_count }}</span>
                                        </button>

                                        <a
                                            href="{{ route('threads.show', $thread) }}#discussion"
                                            class="thread-action"
                                        >
                                            <i class="far fa-comment"></i>
                                            <span>{{ $thread->replies_count }}</span>
                                        </a>

                                        <button
                                            type="button"
                                            class="thread-action"
                                            data-share-url="{{ route('threads.show', $thread) }}"
                                        >
                                            <i class="fas fa-arrow-up-from-bracket"></i>
                                            <span>Bagikan</span>
                                        </button>

                                        <button
                                            type="button"
                                            class="thread-action thread-action--push {{ $bookmarked ? 'is-active' : '' }}"
                                            data-thread-bookmark
                                            data-url="{{ route('threads.bookmark', $thread) }}"
                                        >
                                            <i class="{{ $bookmarked ? 'fas' : 'far' }} fa-bookmark"></i>
                                        </button>

                                    </div>

                                </article>

                            @elseif($feedItem['type'] === 'article')

                                @php
                                    $article = $feedItem['item'];
                                @endphp

                                <a
                                    href="{{ route('articles.show', $article->slug) }}"
                                    class="feed-article-link"
                                >
                                    <article class="feed-article-card">

                                        <div class="feed-article-copy">

                                            <div class="article-byline">
                                                <x-user-avatar :user="$article->user" :size="34" class="feed-avatar feed-avatar--small" />

                                                <div>
                                                    <strong>{{ $article->user->name }}</strong>

                                                    <span>
                                                        {{ optional($article->published_at)->locale('id')->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>

                                            <span class="article-type">
                                                Artikel · {{ $article->category }}
                                            </span>

                                            <h2>{{ $article->title }}</h2>

                                            @if($article->excerpt)
                                                <p>{{ Str::limit($article->excerpt, 170) }}</p>
                                            @endif

                                            <div class="feed-article-meta">
                                                <span>{{ $article->reading_time }} menit</span>
                                                <span>♡ {{ $article->likes_count }}</span>
                                                <span>💬 {{ $article->comments_count }}</span>
                                                <span>◉ {{ $article->views_count }}</span>
                                            </div>
                                        </div>

                                        <div class="feed-article-cover">
                                            @if($article->cover_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($article->cover_image))
                                                <img
                                                    src="{{ asset('storage/' . $article->cover_image) }}"
                                                    alt="{{ $article->title }}"
                                                >
                                            @else
                                                <div
                                                    class="feed-article-placeholder"
                                                    style="background: {{ $getGradient($article->category) }};"
                                                >
                                                    <i class="far fa-file-lines"></i>
                                                    <span>{{ $article->category }}</span>
                                                </div>
                                            @endif
                                        </div>

                                    </article>
                                </a>

                            @elseif($feedItem['type'] === 'podcast')

                                @php
                                    $podcast = $feedItem['item'];
                                    $podcastVisual = $podcast->thumbnail_image ?: $podcast->cover_image;
                                @endphp

                                <a
                                    href="{{ route('podcasts.show', $podcast) }}"
                                    class="feed-podcast-link"
                                >
                                    <article class="feed-podcast-card">

                                        <div class="feed-podcast-visual">
                                            @if($podcastVisual)
                                                <img
                                                    src="{{ asset('storage/' . $podcastVisual) }}"
                                                    alt="{{ $podcast->title }}"
                                                >
                                            @else
                                                <div class="feed-podcast-placeholder">
                                                    <i class="fas {{ $podcast->media_type === 'video' ? 'fa-video' : 'fa-microphone' }}"></i>
                                                </div>
                                            @endif

                                            <span class="feed-podcast-format">
                                                <i class="fas {{ $podcast->media_type === 'video' ? 'fa-video' : 'fa-headphones' }}"></i>
                                                {{ $podcast->media_type === 'video' ? 'Video Podcast' : 'Audio Podcast' }}
                                            </span>
                                        </div>

                                        <div class="feed-podcast-copy">
                                            <div class="article-byline">
                                                <x-user-avatar :user="$podcast->user" :size="34" class="feed-avatar feed-avatar--small" />

                                                <div>
                                                    <strong>{{ $podcast->user->name }}</strong>
                                                    <span>{{ optional($podcast->published_at)->locale('id')->diffForHumans() }}</span>
                                                </div>
                                            </div>

                                            <span class="article-type podcast-type">
                                                Podcast · {{ $podcast->category ?: 'Umum' }}
                                            </span>

                                            <h2>{{ $podcast->title }}</h2>

                                            @if($podcast->description)
                                                <p>{{ Str::limit(strip_tags($podcast->description), 170) }}</p>
                                            @endif

                                            <div class="feed-podcast-meta">
                                                <span>◉ {{ number_format($podcast->views_count ?? 0) }}</span>
                                                <span>♡ {{ $podcast->likes_count ?? 0 }}</span>
                                                <span>💬 {{ $podcast->comments_count ?? 0 }}</span>
                                            </div>
                                        </div>

                                    </article>
                                </a>

                            @endif

                        @empty

                            <div class="feed-empty">
                                <h2>
                                    {{ $feed === 'podcast'
                                        ? 'Belum ada podcast yang dipublikasikan.'
                                        : 'Belum ada konten di sini.' }}
                                </h2>

                                <p>
                                    {{ $feed === 'podcast'
                                        ? 'Podcast baru akan muncul di sini setelah dipublikasikan.'
                                        : 'Mulai berbagi utas atau ikuti penulis lain.' }}
                                </p>
                            </div>

                        @endforelse

                    </div>
                </section>
            </section>


            {{-- SIDEBAR --}}
            <aside class="home-sidebar">

                {{-- Penulis untukmu --}}
                <section class="sidebar-card">
                    <div class="sidebar-heading">
                        <div>
                            <span>Temukan orang baru</span>
                            <h2>Penulis untukmu</h2>
                        </div>
                    </div>

                    <div class="writer-list">
                        @forelse($recommendedWriters as $writer)
                            <div class="person-row">
                                <a href="{{ route('users.show', $writer) }}" class="person-main" aria-label="Lihat profil {{ $writer->name }}">
                                    <x-user-avatar :user="$writer" :size="42" class="writer-avatar" />
                                    <div class="person-copy">
                                        <strong>{{ $writer->name }}</strong>
                                        <span>{{ ($writer->published_articles_count ?? 0) + ($writer->published_podcasts_count ?? 0) }} karya</span>
                                    </div>
                                </a>

                                <button type="button" class="follow-btn" data-url="{{ route('users.follow', $writer) }}" onclick="toggleFollow(this.dataset.url, this)">Ikuti</button>
                            </div>
                        @empty
                            <p class="sidebar-empty">Belum ada rekomendasi penulis.</p>
                        @endforelse
                    </div>
                </section>

                {{-- Teman untukmu --}}
                <section class="sidebar-card">
                    <div class="sidebar-heading">
                        <div>
                            <span>Mungkin kamu kenal</span>
                            <h2>Teman untukmu</h2>
                        </div>
                    </div>

                    <div class="writer-list">
                        @forelse($friendCandidates as $friend)
                            <div class="person-row">
                                <a href="{{ route('users.show', $friend) }}" class="person-main" aria-label="Lihat profil {{ $friend->name }}">
                                    <x-user-avatar :user="$friend" :size="42" class="writer-avatar friend-avatar" />
                                    <div class="person-copy">
                                        <strong>{{ $friend->name }}</strong>
                                        <span>
                                            @if(($friend->mutual_count ?? 0) > 0)
                                                {{ $friend->mutual_count }} koneksi yang sama
                                            @else
                                                {{ $friend->followers_count ?? 0 }} pengikut
                                            @endif
                                        </span>
                                    </div>
                                </a>

                                <button type="button" class="follow-btn" data-url="{{ route('users.follow', $friend) }}" onclick="toggleFollow(this.dataset.url, this)">Ikuti</button>
                            </div>
                        @empty
                            <p class="sidebar-empty">Belum ada rekomendasi teman baru.</p>
                        @endforelse
                    </div>
                </section>

                {{-- Artikel + podcast paling sering dikunjungi --}}
                <section class="sidebar-card popular-card">
                    <div class="sidebar-heading">
                        <div>
                            <span>Lagi ramai</span>
                            <h2>Sering dikunjungi</h2>
                        </div>
                    </div>

                    <div class="trending-list">
                        @forelse($trendingContent as $index => $trend)
                            @php
                                $popularItem = $trend['item'];
                                $popularType = $trend['type'];
                            @endphp

                            <a href="{{ $popularType === 'podcast' ? route('podcasts.show', $popularItem) : route('articles.show', $popularItem->slug) }}" class="trend-row">
                                <span class="trend-no">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <div class="trend-copy">
                                    <strong>{{ $popularItem->title }}</strong>
                                    <span class="trend-meta">
                                        @if($popularType === 'podcast')
                                            <span class="trend-type"><i class="fas {{ $popularItem->media_type === 'video' ? 'fa-video' : 'fa-headphones' }}"></i>{{ $popularItem->media_type === 'video' ? 'Video Podcast' : 'Audio Podcast' }}</span>
                                            · {{ number_format($trend['views']) }} tontonan
                                        @else
                                            <span class="trend-type"><i class="far fa-file-lines"></i>Artikel</span>
                                            · {{ number_format($trend['views']) }} dibaca
                                        @endif
                                    </span>
                                </div>
                            </a>
                        @empty
                            <p class="sidebar-empty">Belum ada konten yang sering dikunjungi.</p>
                        @endforelse
                    </div>
                </section>

            </aside>
        </div>


        @if(isset($recentHistory) && $recentHistory->isNotEmpty())
            @php
                $latestHistory = $recentHistory->first();
                $latestItem = $latestHistory['item'];
                $latestType = $latestHistory['type'];

                $latestUrl = $latestType === 'podcast'
                    ? route('podcasts.show', $latestItem)
                    : route('articles.show', $latestItem->slug);

                $latestMediaLabel = $latestType === 'podcast'
                    ? ($latestItem->media_type === 'video' ? 'Video Podcast' : 'Audio Podcast')
                    : 'Artikel';

                $latestActionLabel = $latestType === 'podcast'
                    ? ($latestItem->media_type === 'video' ? 'Tonton lagi' : 'Dengarkan lagi')
                    : 'Baca lagi';

                $latestImage = $latestType === 'podcast'
                    ? ($latestItem->thumbnail_image ?: $latestItem->cover_image)
                    : $latestItem->cover_image;
            @endphp

            <aside class="history-floating" id="historyFloating" aria-label="Riwayat konten terakhir">
                <div class="history-summary">
                    <div class="history-summary-main">
                        <div class="history-cover">
                            @if($latestImage)
                                <img src="{{ asset('storage/' . $latestImage) }}" alt="{{ $latestItem->title }}">
                            @else
                                <span class="history-cover-icon">
                                    <i class="{{ $latestType === 'podcast' ? ($latestItem->media_type === 'video' ? 'fas fa-video' : 'fas fa-headphones') : 'far fa-file-lines' }}"></i>
                                </span>
                            @endif
                        </div>

                        <div class="history-summary-copy">
                            <span class="history-kicker">Terakhir kamu buka</span>
                            <strong>{{ \Illuminate\Support\Str::limit($latestItem->title, 46) }}</strong>
                            <span>{{ $latestMediaLabel }} · {{ optional($latestHistory['viewed_at'])->locale('id')->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="history-summary-actions">
                        <a href="{{ $latestUrl }}" class="history-resume-btn">
                            {{ $latestActionLabel }}
                            <i class="fas fa-arrow-right"></i>
                        </a>

                        <button
                            type="button"
                            class="history-expand-btn"
                            id="historyExpandButton"
                            aria-controls="historyPanel"
                            aria-expanded="false"
                            title="Lihat riwayat terbaru"
                        >
                            <i class="fas fa-chevron-up"></i>
                        </button>
                    </div>
                </div>

                <div class="history-panel" id="historyPanel" hidden>
                    <div class="history-panel-head">
                        <div>
                            <span>Aktivitas terbaru</span>
                            <h3>Riwayatmu</h3>
                        </div>

                        <button type="button" id="historyCloseButton" aria-label="Tutup riwayat">
                            <i class="fas fa-xmark"></i>
                        </button>
                    </div>

                    <div class="history-list">
                        @foreach($recentHistory as $historyEntry)
                            @php
                                $historyItem = $historyEntry['item'];
                                $historyType = $historyEntry['type'];

                                $historyUrl = $historyType === 'podcast'
                                    ? route('podcasts.show', $historyItem)
                                    : route('articles.show', $historyItem->slug);

                                $historyLabel = $historyType === 'podcast'
                                    ? ($historyItem->media_type === 'video' ? 'Video Podcast' : 'Audio Podcast')
                                    : 'Artikel';

                                $historyImage = $historyType === 'podcast'
                                    ? ($historyItem->thumbnail_image ?: $historyItem->cover_image)
                                    : $historyItem->cover_image;
                            @endphp

                            <a href="{{ $historyUrl }}" class="history-list-item">
                                <div class="history-list-cover">
                                    @if($historyImage)
                                        <img src="{{ asset('storage/' . $historyImage) }}" alt="{{ $historyItem->title }}">
                                    @else
                                        <span>
                                            <i class="{{ $historyType === 'podcast' ? ($historyItem->media_type === 'video' ? 'fas fa-video' : 'fas fa-headphones') : 'far fa-file-lines' }}"></i>
                                        </span>
                                    @endif
                                </div>

                                <div class="history-list-copy">
                                    <span>{{ $historyLabel }}</span>
                                    <strong>{{ \Illuminate\Support\Str::limit($historyItem->title, 52) }}</strong>
                                    <small>{{ optional($historyEntry['viewed_at'])->locale('id')->diffForHumans() }}</small>
                                </div>

                                <i class="fas fa-arrow-up-right-from-square history-list-arrow"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        @endif

    </main>


    <style>
        :root {
            --home-brown:#49261D;
            --home-brown-dark:#30120A;
            --home-orange:#FB4D00;
            --home-blue:#CAE7F7;
            --home-linen:#FFEDE3;
            --home-cream:#FDFAF7;
            --home-white:#FFFFFF;
            --home-text:#1C1B19;
            --home-muted:#705D55;
            --home-border:#E8DCD6;
            --home-soft:#F7F2EE;
        }

        .home-feed-page,.home-feed-page *{box-sizing:border-box}
        .home-feed-page{
            min-height:100vh;
            padding:34px 5% 90px;
            background:linear-gradient(180deg,#FDFAF7,#FFFCF9);
            color:var(--home-text);
            font-family:'DM Sans',sans-serif;
        }
        .home-shell{
            width:min(1280px,100%);
            margin:auto;
            display:grid;
            grid-template-columns:minmax(0,1fr) 330px;
            gap:28px;
            align-items:start;
        }
        .home-main{min-width:0}
        .feed-tabs{
            display:flex;
            gap:7px;
            padding:6px;
            overflow:auto;
            border:1px solid var(--home-border);
            border-radius:999px;
            background:#fff;
        }
        .feed-tab{
            flex:0 0 auto;
            padding:10px 18px;
            border-radius:999px;
            color:var(--home-muted);
            font:700 13px 'Plus Jakarta Sans',sans-serif;
            text-decoration:none;
        }
        .feed-tab.is-active{background:var(--home-brown);color:#fff}
        .home-alert{margin-top:14px;padding:12px 14px;border-radius:14px;font-size:12px}
        .home-alert--success{background:#E5F4EC;color:#27684F}
        .home-alert--error{background:#FFF0ED;color:#9A2A17}

        .thread-composer,.thread-card,.feed-article-card,.sidebar-card{
            border:1px solid var(--home-border);
            background:#fff;
            box-shadow:0 10px 30px rgba(73,38,29,.045);
        }
        .thread-composer{margin-top:18px;padding:20px 22px;border-radius:25px}
        .composer-row{display:grid;grid-template-columns:44px minmax(0,1fr);gap:13px}
        .composer-avatar,.feed-avatar,.writer-avatar{
            display:grid;place-items:center;border-radius:50%;
            background:var(--home-blue);color:var(--home-brown);
            font:800 12px 'Plus Jakarta Sans',sans-serif;
        }
        .composer-avatar{width:44px;height:44px}
        .composer-form>textarea{
            width:100%;min-height:90px;resize:vertical;
            padding:8px 4px 14px;border:0;outline:0;background:transparent;
            color:var(--home-text);font:500 17px/1.55 'DM Sans',sans-serif;
        }
        .composer-preview{
            margin:6px 0 11px;padding:10px;display:flex;flex-wrap:wrap;gap:7px;
            border-radius:14px;background:var(--home-soft);
        }
        .preview-chip{
            max-width:220px;padding:7px 9px;display:inline-flex;align-items:center;gap:6px;
            border-radius:999px;background:#fff;color:var(--home-muted);font-size:10px;
        }
        .preview-chip span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
        /* LINK + POLLING POPUP */
        .composer-modal[hidden]{
            display:none !important;
        }

        .composer-modal{
            position:fixed;
            inset:0;
            z-index:5000;
            display:grid;
            place-items:center;
            padding:20px;
        }

        .composer-modal-backdrop{
            position:absolute;
            inset:0;
            background:rgba(48,18,10,.30);
            backdrop-filter:blur(5px);
            -webkit-backdrop-filter:blur(5px);
        }

        .composer-modal-dialog{
            position:relative;
            z-index:1;
            width:min(560px,100%);
            max-height:calc(100vh - 40px);
            overflow:auto;
            border:1px solid var(--home-border);
            border-radius:24px;
            background:#fff;
            box-shadow:0 28px 80px rgba(48,18,10,.20);
            animation:composerModalIn .18s ease-out;
        }

        .composer-modal-dialog--small{
            width:min(500px,100%);
        }

        @keyframes composerModalIn{
            from{
                opacity:0;
                transform:translateY(8px) scale(.985);
            }
            to{
                opacity:1;
                transform:translateY(0) scale(1);
            }
        }

        .composer-modal-head{
            padding:20px 22px 16px;
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:18px;
            border-bottom:1px solid var(--home-border);
        }

        .composer-modal-kicker{
            display:block;
            margin-bottom:4px;
            color:var(--home-orange);
            font:800 9px 'Plus Jakarta Sans',sans-serif;
            letter-spacing:1px;
            text-transform:uppercase;
        }

        .composer-modal-head h3{
            margin:0;
            color:var(--home-brown-dark);
            font:800 21px/1.2 'Plus Jakarta Sans',sans-serif;
            letter-spacing:-.5px;
        }

        .composer-modal-close{
            width:36px;
            height:36px;
            flex:0 0 36px;
            display:grid;
            place-items:center;
            border:0;
            border-radius:50%;
            background:var(--home-soft);
            color:var(--home-brown);
            cursor:pointer;
        }

        .composer-modal-close:hover{
            background:var(--home-linen);
            color:var(--home-orange);
        }

        .composer-modal-body{
            padding:20px 22px;
            display:grid;
            gap:16px;
        }

        .composer-modal-field{
            display:grid;
            gap:7px;
        }

        .composer-modal-field>span{
            color:var(--home-brown);
            font-size:11px;
            font-weight:800;
        }

        .composer-modal-field>input,
        .composer-modal-input{
            width:100%;
            min-height:44px;
            border:1px solid var(--home-border);
            border-radius:13px;
            background:var(--home-soft);
        }

        .composer-modal-field>input{
            padding:0 13px;
            outline:0;
            color:var(--home-text);
            font:500 12px 'DM Sans',sans-serif;
        }

        .composer-modal-input{
            padding:0 13px;
            display:flex;
            align-items:center;
            gap:9px;
        }

        .composer-modal-input i{
            color:var(--home-orange);
            font-size:12px;
        }

        .composer-modal-input input{
            min-width:0;
            flex:1;
            height:42px;
            border:0;
            outline:0;
            background:transparent;
            color:var(--home-text);
            font:500 12px 'DM Sans',sans-serif;
        }

        .composer-modal-field>input:focus,
        .composer-modal-input:focus-within{
            border-color:rgba(251,77,0,.38);
            background:#fff;
            box-shadow:0 0 0 4px rgba(251,77,0,.06);
        }

        .modal-poll-options{
            display:grid;
            gap:8px;
        }

        .modal-poll-option{
            min-height:44px;
            padding:0 12px;
            display:grid;
            grid-template-columns:25px minmax(0,1fr);
            align-items:center;
            gap:8px;
            border:1px solid var(--home-border);
            border-radius:13px;
            background:var(--home-soft);
        }

        .modal-poll-option>span{
            width:24px;
            height:24px;
            display:grid;
            place-items:center;
            border-radius:50%;
            background:var(--home-linen);
            color:var(--home-brown);
            font-size:9px;
            font-weight:800;
        }

        .modal-poll-option input{
            width:100%;
            height:42px;
            border:0;
            outline:0;
            background:transparent;
            color:var(--home-text);
            font:500 12px 'DM Sans',sans-serif;
        }

        .composer-modal-help{
            margin:0;
            color:#907D75;
            font-size:10px;
            line-height:1.55;
        }

        .composer-modal-footer{
            padding:14px 22px 20px;
            display:flex;
            align-items:center;
            justify-content:flex-end;
            gap:8px;
        }

        .modal-secondary-btn,
        .modal-primary-btn{
            min-height:39px;
            padding:0 15px;
            border-radius:999px;
            cursor:pointer;
            font:800 11px 'Plus Jakarta Sans',sans-serif;
        }

        .modal-secondary-btn{
            border:1px solid var(--home-border);
            background:#fff;
            color:var(--home-muted);
        }

        .modal-secondary-btn:hover{
            background:var(--home-soft);
            color:var(--home-brown);
        }

        .modal-primary-btn{
            border:0;
            background:var(--home-brown);
            color:#fff;
        }

        .modal-primary-btn:hover{
            background:var(--home-orange);
        }

        .composer-tool.has-value{
            background:var(--home-linen);
            color:var(--home-brown);
        }

        @media(max-width:560px){
            .composer-modal{
                align-items:end;
                padding:0;
            }

            .composer-modal-dialog,
            .composer-modal-dialog--small{
                width:100%;
                max-height:86vh;
                border-radius:24px 24px 0 0;
                border-bottom:0;
            }
        }

        .composer-meta{display:flex;gap:9px;flex-wrap:wrap;padding:12px 0;border-top:1px solid var(--home-border)}
        .composer-meta label{display:flex;align-items:center;gap:6px}
        .composer-meta label>span{font-size:10px;color:#9A8780;font-weight:700}
        .composer-meta select{
            height:34px;padding:0 10px;border:1px solid var(--home-border);border-radius:999px;
            background:var(--home-soft);color:var(--home-brown);font-size:10px;font-weight:700;
        }
        .composer-footer{display:flex;align-items:center;justify-content:space-between;gap:14px}
        .composer-tools{display:flex;align-items:center;gap:3px}
        .composer-tool{
            width:36px;height:36px;display:grid;place-items:center;border:0;border-radius:50%;
            background:transparent;color:var(--home-orange);cursor:pointer;
        }
        .composer-tool:hover{background:var(--home-linen)}
        .composer-tool input{display:none}
        .composer-submit{display:flex;align-items:center;gap:11px}
        .thread-counter{font-size:11px;color:#98847D}
        .post-thread-btn{
            min-height:40px;padding:0 18px;border:0;border-radius:999px;
            background:var(--home-brown);color:#fff;font-weight:800;cursor:pointer;
        }

        .stream{padding-top:32px}
        .stream-heading{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;padding-bottom:14px}
        .stream-kicker,.sidebar-heading span,.article-type{
            color:var(--home-orange);font:800 10px 'Plus Jakarta Sans',sans-serif;
            letter-spacing:1px;text-transform:uppercase;
        }
        .stream-heading h1{margin:6px 0 0;font:800 29px 'Plus Jakarta Sans',sans-serif;color:var(--home-brown-dark)}
        .stream-heading>a{font-size:11px;font-weight:800;color:var(--home-brown);text-decoration:none}
        .stream-list{display:grid;gap:16px}

        .thread-card{padding:21px 22px;border-radius:25px}
        .clickable-thread{cursor:pointer;transition:.2s}
        .clickable-thread:hover{transform:translateY(-2px);box-shadow:0 16px 42px rgba(73,38,29,.08)}
        .thread-card-top,.thread-author,.article-byline,.writer-info,.thread-actions{display:flex;align-items:center}
        .thread-card-top{justify-content:space-between;align-items:flex-start;gap:14px}
        .thread-author{gap:10px}
        .feed-avatar{width:40px;height:40px;flex:0 0 40px}
        .feed-avatar--small{width:34px;height:34px;flex-basis:34px}
        .thread-author>div:last-child,.article-byline>div:last-child{display:grid;gap:2px}
        .thread-author strong,.article-byline strong{font-size:13px;color:var(--home-brown)}
        .thread-author span,.article-byline span{font-size:11px;color:var(--home-muted)}
        .thread-top-actions{display:flex;align-items:center;gap:7px}
        .thread-topic{padding:6px 9px;border-radius:999px;background:var(--home-linen);font-size:9px;font-weight:800;color:var(--home-brown)}
        .thread-more{width:31px;height:31px;border:0;border-radius:50%;background:transparent;color:#9A8780;cursor:pointer}
        .thread-body{padding:18px 2px 8px 50px;font-size:16px;line-height:1.68;white-space:pre-wrap}
        .thread-attachments-wrap,.thread-card>.thread-poll{margin-left:50px}
        .thread-actions{gap:3px;padding-top:12px;margin-top:13px;border-top:1px solid var(--home-border)}
        .thread-action{
            min-height:36px;padding:0 10px;display:inline-flex;align-items:center;gap:6px;
            border:0;border-radius:999px;background:transparent;color:var(--home-muted);
            cursor:pointer;font-size:12px;font-weight:600;text-decoration:none;
        }
        .thread-action:hover,.thread-action.is-active{color:var(--home-orange);background:var(--home-soft)}
        .thread-action--push{margin-left:auto}

        .attachment-images{display:grid;gap:3px;overflow:hidden;border-radius:18px;background:#F2ECE8}
        .attachment-images--1{grid-template-columns:1fr}
        .attachment-images--2,.attachment-images--4,.attachment-images--3{grid-template-columns:repeat(2,minmax(0,1fr))}
        .attachment-images--3 .attachment-image-link:first-child{grid-row:span 2}
        .attachment-image-link{min-height:150px;overflow:hidden}
        .attachment-image-link img{width:100%;height:100%;min-height:150px;max-height:430px;object-fit:cover;display:block}
        .attachment-video{margin-top:10px;overflow:hidden;border-radius:18px;background:#1D1917}
        .attachment-video video{width:100%;max-height:480px;display:block}
        .attachment-audio{margin-top:10px;padding:13px;border:1px solid var(--home-border);border-radius:17px;background:var(--home-soft)}
        .attachment-audio-title{margin-bottom:9px;display:flex;gap:8px;color:var(--home-brown);font-size:11px;font-weight:700}
        .attachment-audio audio{width:100%;height:38px}
        .attachment-file,.attachment-link-card{
            margin-top:9px;padding:12px;display:grid;grid-template-columns:39px minmax(0,1fr) auto;
            align-items:center;gap:10px;border:1px solid var(--home-border);border-radius:15px;
            background:var(--home-soft);color:inherit;text-decoration:none;
        }
        .attachment-file-icon,.attachment-link-icon{
            width:39px;height:39px;display:grid;place-items:center;border-radius:12px;background:var(--home-linen);color:var(--home-brown)
        }
        .attachment-file-copy,.attachment-link-copy{min-width:0;display:grid;gap:2px}
        .attachment-file-copy strong,.attachment-link-copy strong{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:11px}
        .attachment-file-copy span,.attachment-link-copy span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:9px;color:var(--home-muted)}

        .thread-poll{margin-top:13px;padding:14px;border:1px solid var(--home-border);border-radius:18px;background:var(--home-soft)}
        .thread-poll-question{display:block;margin-bottom:10px;font-size:13px;color:var(--home-brown-dark)}
        .thread-poll-options{display:grid;gap:7px}
        .poll-option{
            position:relative;width:100%;min-height:39px;overflow:hidden;padding:0 12px;
            display:flex;align-items:center;justify-content:space-between;gap:12px;border:1px solid var(--home-border);
            border-radius:11px;background:#fff;color:var(--home-brown);cursor:pointer;text-align:left;
        }
        .poll-option-fill{position:absolute;inset:0 auto 0 0;background:rgba(202,231,247,.72)}
        .poll-option-label,.poll-option-percent{position:relative;z-index:1;font-size:10px;font-weight:700}
        .thread-poll-total{display:block;margin-top:9px;font-size:9px;color:var(--home-muted)}

        .feed-article-link{color:inherit;text-decoration:none}
        .feed-article-card{display:grid;grid-template-columns:minmax(0,1fr) 190px;gap:24px;padding:22px;border-radius:25px}
        .article-byline{gap:9px;margin-bottom:16px}
        .article-type{display:inline-block;margin-bottom:7px}
        .feed-article-card h2{margin:0;font:800 23px/1.26 'Plus Jakarta Sans',sans-serif;color:var(--home-brown-dark)}
        .feed-article-card p{margin:9px 0 0;font-size:13px;line-height:1.6;color:var(--home-muted)}
        .feed-article-meta{margin-top:17px;display:flex;flex-wrap:wrap;gap:13px;font-size:11px;color:#8E7A73}
        .feed-article-cover{width:190px;height:155px;align-self:center}
        .feed-article-cover img,.feed-article-placeholder{width:100%;height:100%;object-fit:cover;border-radius:19px}
        .feed-article-placeholder{display:grid;place-items:center;text-align:center;color:var(--home-brown)}

        .feed-podcast-link{color:inherit;text-decoration:none}
        .feed-podcast-card{display:grid;grid-template-columns:220px minmax(0,1fr);gap:22px;padding:20px;border-radius:25px;background:#fff}
        .feed-podcast-visual{position:relative;width:220px;aspect-ratio:16/9;align-self:center;overflow:hidden;border-radius:19px;background:linear-gradient(135deg,var(--home-brown),#17333F)}
        .feed-podcast-visual img{width:100%;height:100%;object-fit:cover;transition:.25s}
        .feed-podcast-card:hover .feed-podcast-visual img{transform:scale(1.035)}
        .feed-podcast-placeholder{width:100%;height:100%;display:grid;place-items:center;color:#fff;font-size:28px}
        .feed-podcast-format{position:absolute;left:10px;bottom:10px;display:inline-flex;align-items:center;gap:6px;padding:7px 9px;border-radius:999px;background:rgba(48,18,10,.82);color:#fff;font-size:8px;font-weight:800;text-transform:uppercase;letter-spacing:.4px}
        .feed-podcast-copy{min-width:0;display:flex;flex-direction:column;justify-content:center}
        .feed-podcast-card h2{margin:0;font:800 23px/1.26 'Plus Jakarta Sans',sans-serif;color:var(--home-brown-dark)}
        .feed-podcast-card p{margin:9px 0 0;font-size:13px;line-height:1.6;color:var(--home-muted)}
        .podcast-type{color:var(--home-orange)}
        .feed-podcast-meta{margin-top:17px;display:flex;flex-wrap:wrap;gap:13px;font-size:11px;color:#8E7A73}

        .home-sidebar{position:sticky;top:112px;display:grid;gap:16px}
        .sidebar-card{padding:20px;border-radius:23px}
        .sidebar-heading h2{margin:5px 0 0;font:800 20px 'Plus Jakarta Sans',sans-serif;color:var(--home-brown-dark)}
        .writer-list,.trending-list{display:grid;gap:4px}
        .person-row{display:grid;grid-template-columns:minmax(0,1fr) auto;align-items:center;gap:10px;padding:9px 0;border-top:1px solid var(--home-border)}
        .person-row:first-child{border-top:0}
        .person-main{min-width:0;display:flex;align-items:center;gap:9px;color:inherit;text-decoration:none;border-radius:12px;transition:.18s}
        .person-main:hover .person-copy strong{color:var(--home-orange)}
        .writer-avatar{width:36px;height:36px;flex:0 0 36px;display:grid;place-items:center;border-radius:50%;background:var(--home-linen);color:var(--home-brown);font:800 11px 'Plus Jakarta Sans',sans-serif}
        .friend-avatar{background:var(--home-blue)}
        .person-copy{min-width:0;display:grid;gap:2px}
        .person-copy strong{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:12px;color:var(--home-brown);transition:.18s}
        .person-copy span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:9px;color:var(--home-muted)}
        .follow-btn{padding:7px 11px;border:0;border-radius:999px;background:var(--home-brown);color:#fff;font-size:10px;font-weight:800;cursor:pointer;transition:.18s}
        .follow-btn:hover{background:var(--home-orange)}
        .follow-btn.is-following{background:#fff;color:var(--home-brown);box-shadow:inset 0 0 0 1px var(--home-border)}
        .follow-btn:disabled{opacity:.55;cursor:wait}
        .popular-card{background:linear-gradient(180deg,#fff 0%,#FFFBF8 100%)}
        .trend-row{display:grid;grid-template-columns:29px minmax(0,1fr);gap:9px;padding:11px 0;border-top:1px solid var(--home-border);text-decoration:none;color:inherit}
        .trend-row:first-child{border-top:0}
        .trend-no{font:800 15px 'Plus Jakarta Sans',sans-serif;color:#C8B6AF}
        .trend-copy{min-width:0;display:grid;gap:4px}
        .trend-row strong{font-size:12px;line-height:1.4;color:var(--home-brown);transition:.18s}
        .trend-row:hover strong{color:var(--home-orange)}
        .trend-meta{font-size:9px;color:var(--home-muted)}
        .trend-type{display:inline-flex;align-items:center;gap:4px;color:var(--home-muted)}
        .trend-type i{font-size:9px;color:var(--home-orange)}
        .sidebar-empty{font-size:11px;color:var(--home-muted)}
        .feed-empty{padding:55px 24px;border:1px dashed var(--home-border);border-radius:24px;text-align:center;background:#fff}

        @media(max-width:1040px){
            .home-shell{grid-template-columns:1fr}
            .home-sidebar{position:static;grid-template-columns:repeat(2,minmax(0,1fr))}
        }
        @media(max-width:700px){
            .home-feed-page{padding:22px 16px 70px}
            .composer-footer{align-items:flex-start;flex-direction:column}
            .composer-submit{width:100%;justify-content:flex-end}
            .poll-input-grid{grid-template-columns:1fr}
            .thread-body,.thread-attachments-wrap,.thread-card>.thread-poll{margin-left:0;padding-left:0}
            .stream-heading{align-items:flex-start;flex-direction:column}
            .feed-article-card{grid-template-columns:minmax(0,1fr) 100px;gap:14px;padding:17px}
            .feed-article-cover{width:100px;height:100px}
            .feed-article-card p{display:none}
            .feed-podcast-card{grid-template-columns:110px minmax(0,1fr);gap:14px;padding:15px}
            .feed-podcast-visual{width:110px}
            .feed-podcast-card h2{font-size:17px}
            .feed-podcast-card p{display:none}
            .feed-podcast-format{left:6px;bottom:6px;padding:5px 7px;font-size:7px}
            .home-sidebar{grid-template-columns:1fr}
        }


        /* =========================================================
           FLOATING RIWAYAT TERAKHIR
        ========================================================= */
        .history-floating{
            position:fixed;
            right:24px;
            bottom:22px;
            z-index:3500;
            width:min(390px,calc(100vw - 32px));
            font-family:'DM Sans',sans-serif;
        }

        .history-summary,
        .history-panel{
            border:1px solid rgba(73,38,29,.14);
            background:rgba(255,255,255,.97);
            box-shadow:0 20px 55px rgba(73,38,29,.18);
            backdrop-filter:blur(16px);
            -webkit-backdrop-filter:blur(16px);
        }

        .history-summary{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            padding:12px;
            border-radius:22px;
        }

        .history-summary-main{
            min-width:0;
            display:flex;
            align-items:center;
            gap:11px;
        }

        .history-cover,
        .history-list-cover{
            overflow:hidden;
            flex:0 0 auto;
            background:linear-gradient(135deg,var(--home-blue),var(--home-linen));
            color:var(--home-brown);
        }

        .history-cover{
            width:50px;
            height:50px;
            border-radius:15px;
        }

        .history-cover img,
        .history-list-cover img{
            width:100%;
            height:100%;
            object-fit:cover;
        }

        .history-cover-icon,
        .history-list-cover>span{
            width:100%;
            height:100%;
            display:grid;
            place-items:center;
        }

        .history-cover-icon{font-size:17px}

        .history-summary-copy{
            min-width:0;
            display:flex;
            flex-direction:column;
            gap:2px;
        }

        .history-kicker{
            color:var(--home-orange)!important;
            font:800 9px/1.2 'Plus Jakarta Sans',sans-serif!important;
            letter-spacing:.09em;
            text-transform:uppercase;
        }

        .history-summary-copy strong{
            max-width:180px;
            overflow:hidden;
            text-overflow:ellipsis;
            white-space:nowrap;
            color:var(--home-brown);
            font:800 12px/1.35 'Plus Jakarta Sans',sans-serif;
        }

        .history-summary-copy>span:last-child{
            color:var(--home-muted);
            font-size:9px;
        }

        .history-summary-actions{
            flex:0 0 auto;
            display:flex;
            align-items:center;
            gap:6px;
        }

        .history-resume-btn{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:9px 11px;
            border-radius:999px;
            background:var(--home-brown);
            color:#fff;
            text-decoration:none;
            font:800 9px 'Plus Jakarta Sans',sans-serif;
            transition:.2s ease;
        }

        .history-resume-btn:hover{
            background:var(--home-orange);
            transform:translateY(-1px);
        }

        .history-expand-btn,
        .history-panel-head button{
            display:grid;
            place-items:center;
            border:0;
            cursor:pointer;
        }

        .history-expand-btn{
            width:34px;
            height:34px;
            border-radius:50%;
            background:var(--home-soft);
            color:var(--home-brown);
            transition:.2s ease;
        }

        .history-expand-btn:hover{background:var(--home-blue)}
        .history-expand-btn i{transition:transform .2s ease}
        .history-expand-btn.is-open i{transform:rotate(180deg)}

        .history-panel{
            margin-bottom:10px;
            border-radius:24px;
            overflow:hidden;
            transform-origin:bottom right;
            animation:historyPanelIn .16s ease-out;
        }

        .history-panel[hidden]{display:none!important}

        @keyframes historyPanelIn{
            from{opacity:0;transform:translateY(8px) scale(.985)}
            to{opacity:1;transform:translateY(0) scale(1)}
        }

        .history-panel-head{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            padding:18px 18px 13px;
            border-bottom:1px solid var(--home-border);
            background:linear-gradient(135deg,#fff,var(--home-cream));
        }

        .history-panel-head span{
            display:block;
            margin-bottom:3px;
            color:var(--home-orange);
            font:800 9px 'Plus Jakarta Sans',sans-serif;
            letter-spacing:.09em;
            text-transform:uppercase;
        }

        .history-panel-head h3{
            margin:0;
            color:var(--home-brown);
            font:800 17px 'Plus Jakarta Sans',sans-serif;
        }

        .history-panel-head button{
            width:34px;
            height:34px;
            border-radius:50%;
            background:var(--home-soft);
            color:var(--home-brown);
        }

        .history-list{
            max-height:360px;
            overflow:auto;
            padding:7px 10px 10px;
        }

        .history-list-item{
            display:grid;
            grid-template-columns:44px minmax(0,1fr) auto;
            align-items:center;
            gap:10px;
            padding:10px 8px;
            border-radius:16px;
            color:inherit;
            text-decoration:none;
            transition:.18s ease;
        }

        .history-list-item:hover{background:var(--home-soft)}

        .history-list-cover{
            width:44px;
            height:44px;
            border-radius:13px;
        }

        .history-list-copy{
            min-width:0;
            display:flex;
            flex-direction:column;
            gap:2px;
        }

        .history-list-copy>span{
            color:var(--home-orange);
            font:800 8px 'Plus Jakarta Sans',sans-serif;
            letter-spacing:.06em;
            text-transform:uppercase;
        }

        .history-list-copy strong{
            overflow:hidden;
            text-overflow:ellipsis;
            white-space:nowrap;
            color:var(--home-brown);
            font:700 11px/1.35 'Plus Jakarta Sans',sans-serif;
        }

        .history-list-copy small{
            color:var(--home-muted);
            font-size:9px;
        }

        .history-list-arrow{
            color:#B7A59E;
            font-size:11px;
        }

        @media(max-width:640px){
            .history-floating{
                right:12px;
                bottom:12px;
                width:calc(100vw - 24px);
            }

            .history-summary-copy strong{max-width:140px}
            .history-resume-btn{padding:9px;font-size:0}
            .history-resume-btn i{font-size:11px}
        }

    </style>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken =
                document.querySelector('meta[name="csrf-token"]')?.content || '';

            const threadBody = document.getElementById('threadBody');
            const threadCounter = document.getElementById('threadCounter');

            const syncCounter = () => {
                if (threadBody && threadCounter) {
                    threadCounter.textContent = threadBody.value.length;
                }
            };

            threadBody?.addEventListener('input', syncCounter);
            syncCounter();

            /*
            |--------------------------------------------------------------------------
            | LINK + POLLING POPUP
            |--------------------------------------------------------------------------
            */
            const composerModals =
                document.querySelectorAll(
                    '.composer-modal'
                );

            const linkInput =
                document.getElementById(
                    'composerLinkInput'
                );

            const pollQuestion =
                document.getElementById(
                    'pollQuestionInput'
                );

            const pollOptions =
                document.querySelectorAll(
                    '[data-poll-option]'
                );

            const linkTool =
                document.querySelector(
                    '[data-open-composer-modal="linkModal"]'
                );

            const pollTool =
                document.querySelector(
                    '[data-open-composer-modal="pollModal"]'
                );

            function syncComposerToolState() {
                if (linkTool) {
                    linkTool.classList.toggle(
                        'has-value',
                        Boolean(
                            linkInput?.value.trim()
                        )
                    );
                }

                if (pollTool) {
                    const hasQuestion =
                        Boolean(
                            pollQuestion?.value.trim()
                        );

                    const filledOptions =
                        Array.from(pollOptions)
                            .filter(
                                input =>
                                    input.value.trim() !== ''
                            )
                            .length;

                    pollTool.classList.toggle(
                        'has-value',
                        hasQuestion
                            && filledOptions >= 2
                    );
                }
            }

            function closeComposerModal(modal) {
                if (!modal) return;

                modal.hidden = true;
                modal.setAttribute(
                    'aria-hidden',
                    'true'
                );

                document.body.style.overflow = '';

                syncComposerToolState();
            }

            function openComposerModal(modal) {
                if (!modal) return;

                composerModals.forEach(other => {
                    if (other !== modal) {
                        other.hidden = true;

                        other.setAttribute(
                            'aria-hidden',
                            'true'
                        );
                    }
                });

                modal.hidden = false;

                modal.setAttribute(
                    'aria-hidden',
                    'false'
                );

                document.body.style.overflow =
                    'hidden';

                requestAnimationFrame(() => {
                    modal.querySelector('input')
                        ?.focus();
                });
            }

            document
                .querySelectorAll(
                    '[data-open-composer-modal]'
                )
                .forEach(button => {
                    button.addEventListener(
                        'click',
                        () => {
                            openComposerModal(
                                document.getElementById(
                                    button.dataset
                                        .openComposerModal
                                )
                            );
                        }
                    );
                });

            document
                .querySelectorAll(
                    '[data-close-composer-modal]'
                )
                .forEach(button => {
                    button.addEventListener(
                        'click',
                        () => {
                            closeComposerModal(
                                button.closest(
                                    '.composer-modal'
                                )
                            );
                        }
                    );
                });

            document
                .querySelectorAll(
                    '[data-save-composer-modal]'
                )
                .forEach(button => {
                    button.addEventListener(
                        'click',
                        () => {
                            closeComposerModal(
                                button.closest(
                                    '.composer-modal'
                                )
                            );
                        }
                    );
                });

            document
                .querySelector('[data-clear-link]')
                ?.addEventListener(
                    'click',
                    () => {
                        if (linkInput) {
                            linkInput.value = '';
                        }

                        closeComposerModal(
                            document.getElementById(
                                'linkModal'
                            )
                        );
                    }
                );

            document
                .querySelector('[data-clear-poll]')
                ?.addEventListener(
                    'click',
                    () => {
                        if (pollQuestion) {
                            pollQuestion.value = '';
                        }

                        pollOptions.forEach(
                            input => {
                                input.value = '';
                            }
                        );

                        closeComposerModal(
                            document.getElementById(
                                'pollModal'
                            )
                        );
                    }
                );

            document.addEventListener(
                'keydown',
                event => {
                    if (event.key !== 'Escape') {
                        return;
                    }

                    const openModal =
                        document.querySelector(
                            '.composer-modal:not([hidden])'
                        );

                    if (openModal) {
                        closeComposerModal(
                            openModal
                        );
                    }
                }
            );

            linkInput?.addEventListener(
                'input',
                syncComposerToolState
            );

            pollQuestion?.addEventListener(
                'input',
                syncComposerToolState
            );

            pollOptions.forEach(input => {
                input.addEventListener(
                    'input',
                    syncComposerToolState
                );
            });

            syncComposerToolState();


            const preview = document.getElementById('composerPreview');

            const fileInputs = [
                document.getElementById('composerImages'),
                document.getElementById('composerVideo'),
                document.getElementById('composerAudio'),
                document.getElementById('composerFiles'),
            ].filter(Boolean);

            const renderPreview = () => {
                const files = [];

                fileInputs.forEach(input => {
                    Array.from(input.files || [])
                        .forEach(file => files.push(file));
                });

                preview.innerHTML = '';

                if (!files.length) {
                    preview.hidden = true;
                    return;
                }

                files.forEach(file => {
                    const chip = document.createElement('span');
                    chip.className = 'preview-chip';
                    chip.innerHTML =
                        '<i class="fas fa-paperclip"></i><span></span>';

                    chip.querySelector('span').textContent = file.name;
                    preview.appendChild(chip);
                });

                preview.hidden = false;
            };

            fileInputs.forEach(
                input => input.addEventListener('change', renderPreview)
            );

            document
                .querySelectorAll('.clickable-thread')
                .forEach(card => {
                    card.addEventListener('click', event => {
                        if (
                            event.target.closest(
                                'button,a,form,input,select,textarea,video,audio,[data-stop-thread-click]'
                            )
                        ) {
                            return;
                        }

                        if (card.dataset.threadUrl) {
                            window.location.href =
                                card.dataset.threadUrl;
                        }
                    });
                });

            document
                .querySelectorAll('[data-thread-like]')
                .forEach(button => {
                    button.addEventListener('click', async () => {
                        const response = await fetch(
                            button.dataset.url,
                            {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                }
                            }
                        );

                        const data = await response.json();

                        if (!data.success) return;

                        button.classList.toggle(
                            'is-active',
                            data.liked
                        );

                        button.querySelector('i').className =
                            `${data.liked ? 'fas' : 'far'} fa-heart`;

                        button.querySelector(
                            '[data-like-count]'
                        ).textContent = data.count;
                    });
                });

            document
                .querySelectorAll('[data-thread-bookmark]')
                .forEach(button => {
                    button.addEventListener('click', async () => {
                        const response = await fetch(
                            button.dataset.url,
                            {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                }
                            }
                        );

                        const data = await response.json();

                        if (!data.success) return;

                        button.classList.toggle(
                            'is-active',
                            data.bookmarked
                        );

                        button.querySelector('i').className =
                            `${data.bookmarked ? 'fas' : 'far'} fa-bookmark`;
                    });
                });

            document
                .querySelectorAll('[data-share-url]')
                .forEach(button => {
                    button.addEventListener('click', async () => {
                        const url = button.dataset.shareUrl;

                        if (navigator.share) {
                            await navigator.share({
                                title: 'Utas Interlude',
                                url
                            });
                            return;
                        }

                        await navigator.clipboard.writeText(url);
                        alert('Tautan utas berhasil disalin.');
                    });
                });

            window.toggleFollow =
                async function (url, button) {
                    if (!csrfToken || !button || !url) return;

                    const originalText = button.textContent.trim();
                    button.disabled = true;

                    try {
                        const response = await fetch(
                            url,
                            {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                }
                            }
                        );

                        const data = await response.json();

                        if (!response.ok || !data.success) {
                            throw new Error(data.message || 'Follow request failed');
                        }

                        button.textContent = data.following ? 'Mengikuti' : 'Ikuti';
                        button.classList.toggle('is-following', !!data.following);
                    } catch (error) {
                        console.error('Follow error:', error);
                        button.textContent = originalText;
                    } finally {
                        button.disabled = false;
                    }
                };
        });


        // =========================================================
        // FLOATING HISTORY
        // =========================================================
        const historyFloating = document.getElementById('historyFloating');
        const historyPanel = document.getElementById('historyPanel');
        const historyExpandButton = document.getElementById('historyExpandButton');
        const historyCloseButton = document.getElementById('historyCloseButton');

        function setHistoryPanel(open) {
            if (!historyPanel || !historyExpandButton) return;

            historyPanel.hidden = !open;
            historyExpandButton.classList.toggle('is-open', open);
            historyExpandButton.setAttribute('aria-expanded', open ? 'true' : 'false');
        }

        if (historyExpandButton) {
            historyExpandButton.addEventListener('click', function () {
                setHistoryPanel(historyPanel?.hidden ?? true);
            });
        }

        if (historyCloseButton) {
            historyCloseButton.addEventListener('click', function () {
                setHistoryPanel(false);
            });
        }

        document.addEventListener('click', function (event) {
            if (
                historyFloating
                && historyPanel
                && !historyPanel.hidden
                && !historyFloating.contains(event.target)
            ) {
                setHistoryPanel(false);
            }
        });

    </script>

</x-app-layout>
