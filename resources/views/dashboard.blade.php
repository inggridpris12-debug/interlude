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

                <nav class="feed-tabs" aria-label="Filter beranda">
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
                        <i class="fas fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="home-alert home-alert--error">
                        <i class="fas fa-circle-exclamation"></i>

                        <div>
                            <strong>Belum bisa dikirim.</strong>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    </div>
                @endif


                {{-- =========================================================
                     TWITTER-LIKE COMPOSER
                ========================================================== --}}
                <section class="thread-composer">

                    <div class="composer-row">

                        <div class="composer-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>


                        <form
                            method="POST"
                            action="{{ route('threads.store') }}"
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

                        </form>

                    </div>

                </section>


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

                                <article class="thread-card">

                                    <div class="thread-card-top">

                                        <div class="thread-author">

                                            <div class="feed-avatar">
                                                {{ strtoupper(substr($thread->user->name, 0, 1)) }}
                                            </div>

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
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="thread-more"
                                                        aria-label="Hapus utasan"
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


                                    <div class="thread-actions">

                                        <button
                                            type="button"
                                            class="thread-action {{ $liked ? 'is-active' : '' }}"
                                            data-thread-like
                                            data-url="{{ route('threads.like', $thread) }}"
                                        >
                                            <i class="{{ $liked ? 'fas' : 'far' }} fa-heart"></i>
                                            <span data-like-count>{{ $thread->likes_count }}</span>
                                        </button>


                                        <button
                                            type="button"
                                            class="thread-action"
                                            data-toggle-discussion="{{ $thread->id }}"
                                        >
                                            <i class="far fa-comment"></i>
                                            <span>{{ $thread->replies_count }}</span>
                                        </button>


                                        <button
                                            type="button"
                                            class="thread-action"
                                            data-share-thread
                                        >
                                            <i class="fas fa-arrow-up-from-bracket"></i>
                                            <span>Bagikan</span>
                                        </button>


                                        <button
                                            type="button"
                                            class="thread-action thread-action--push {{ $bookmarked ? 'is-active' : '' }}"
                                            data-thread-bookmark
                                            data-url="{{ route('threads.bookmark', $thread) }}"
                                            aria-label="Simpan utasan"
                                        >
                                            <i class="{{ $bookmarked ? 'fas' : 'far' }} fa-bookmark"></i>
                                        </button>

                                    </div>


                                    {{-- =================================================
                                         COMMENTS + NESTED REPLIES
                                    ================================================== --}}
                                    <section
                                        class="thread-discussion"
                                        id="threadDiscussion{{ $thread->id }}"
                                        hidden
                                    >

                                        <form
                                            method="POST"
                                            action="{{ route('threads.replies.store', $thread) }}"
                                            class="thread-comment-form"
                                        >
                                            @csrf

                                            <div class="comment-form-avatar">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </div>

                                            <div>
                                                <textarea
                                                    name="body"
                                                    rows="2"
                                                    maxlength="280"
                                                    placeholder="Tulis komentar..."
                                                    required
                                                ></textarea>

                                                <div class="comment-form-footer">
                                                    <span>Maks. 280 karakter</span>

                                                    <button type="submit">
                                                        Balas
                                                    </button>
                                                </div>
                                            </div>

                                        </form>


                                        <div class="comments-list">

                                            @forelse($thread->topLevelReplies as $reply)

                                                @include('threads._reply', [
                                                    'reply' => $reply,
                                                    'thread' => $thread,
                                                    'level' => 0,
                                                ])

                                            @empty

                                                <div class="comment-empty">
                                                    Belum ada komentar. Mulai percakapan.
                                                </div>

                                            @endforelse

                                        </div>

                                    </section>

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

                                                <div class="feed-avatar feed-avatar--small">
                                                    {{ strtoupper(substr($article->user->name, 0, 1)) }}
                                                </div>

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
                                                <p>
                                                    {{ Str::limit($article->excerpt, 170) }}
                                                </p>
                                            @endif


                                            <div class="feed-article-meta">
                                                <span>
                                                    <i class="far fa-clock"></i>
                                                    {{ $article->reading_time }} menit
                                                </span>

                                                <span>
                                                    <i class="far fa-heart"></i>
                                                    {{ $article->likes_count }}
                                                </span>

                                                <span>
                                                    <i class="far fa-comment"></i>
                                                    {{ $article->comments_count }}
                                                </span>

                                                <span>
                                                    <i class="far fa-eye"></i>
                                                    {{ $article->views_count }}
                                                </span>
                                            </div>

                                        </div>


                                        <div class="feed-article-cover">

                                            @if($article->cover_image)
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

                            @endif

                        @empty

                            <div class="feed-empty">

                                <div class="feed-empty-icon">
                                    @if($feed === 'podcast')
                                        <i class="fas fa-headphones"></i>
                                    @elseif($feed === 'mengikuti')
                                        <i class="fas fa-user-group"></i>
                                    @else
                                        <i class="far fa-message"></i>
                                    @endif
                                </div>

                                <h2>
                                    @if($feed === 'podcast')
                                        Feed podcast belum tersedia.
                                    @elseif($feed === 'mengikuti')
                                        Belum ada konten dari akun yang kamu ikuti.
                                    @else
                                        Belum ada konten di sini.
                                    @endif
                                </h2>

                                <p>
                                    @if($feed === 'podcast')
                                        Backend podcast belum tersambung ke Beranda.
                                    @elseif($feed === 'mengikuti')
                                        Ikuti penulis lain atau mulai dari tab Untukmu.
                                    @else
                                        Jadilah yang pertama membagikan utasan.
                                    @endif
                                </p>

                            </div>

                        @endforelse

                    </div>

                </section>

            </section>


            <aside class="home-sidebar">

                <section class="sidebar-card">

                    <div class="sidebar-heading">
                        <div>
                            <span>Temukan orang baru</span>
                            <h2>Penulis untukmu</h2>
                        </div>

                        <i class="fas fa-user-group"></i>
                    </div>


                    <div class="writer-list">

                        @forelse($recommendedWriters as $writer)

                            <div class="writer-row">

                                <div class="writer-info">

                                    <div class="writer-avatar">
                                        {{ strtoupper(substr($writer->name, 0, 1)) }}
                                    </div>

                                    <div>
                                        <strong>{{ $writer->name }}</strong>
                                        <span>{{ $writer->articles_count }} artikel</span>
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
                            <p class="sidebar-empty">
                                Belum ada rekomendasi penulis.
                            </p>
                        @endforelse

                    </div>

                </section>


                <section class="sidebar-card">

                    <div class="sidebar-heading">
                        <div>
                            <span>Lagi ramai</span>
                            <h2>Banyak dibaca</h2>
                        </div>

                        <i class="fas fa-arrow-trend-up"></i>
                    </div>


                    <div class="trending-list">

                        @forelse($trendingArticles as $index => $article)

                            <a
                                href="{{ route('articles.show', $article->slug) }}"
                                class="trend-row"
                            >
                                <span class="trend-no">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </span>

                                <div>
                                    <strong>{{ $article->title }}</strong>

                                    <span>
                                        {{ number_format($article->views_count) }}
                                        dibaca
                                    </span>
                                </div>
                            </a>

                        @empty
                            <p class="sidebar-empty">
                                Belum ada artikel yang sedang ramai.
                            </p>
                        @endforelse

                    </div>

                </section>

            </aside>

        </div>

    </main>


    <style>
        :root {
            --home-brown: #49261D;
            --home-brown-dark: #30120A;
            --home-orange: #FB4D00;
            --home-blue: #CAE7F7;
            --home-linen: #FFEDE3;
            --home-cream: #FDFAF7;
            --home-white: #FFFFFF;
            --home-text: #1C1B19;
            --home-muted: #705D55;
            --home-border: #E8DCD6;
            --home-soft: #F7F2EE;
        }

        .home-feed-page,
        .home-feed-page * {
            box-sizing: border-box;
        }

        .home-feed-page {
            min-height: 100vh;
            padding: 34px 5% 90px;
            background:
                radial-gradient(
                    circle at 93% 5%,
                    rgba(202, 231, 247, .34),
                    transparent 24%
                ),
                linear-gradient(
                    180deg,
                    #FDFAF7,
                    #FFFCF9
                );
            color: var(--home-text);
            font-family: 'DM Sans', sans-serif;
        }

        .home-shell {
            width: min(1280px, 100%);
            margin: 0 auto;
            display: grid;
            grid-template-columns: minmax(0, 1fr) 330px;
            gap: 28px;
            align-items: start;
        }

        .home-main {
            min-width: 0;
        }

        /* TABS */
        .feed-tabs {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 6px;
            overflow-x: auto;
            border: 1px solid var(--home-border);
            border-radius: 999px;
            background: rgba(255,255,255,.84);
            box-shadow: 0 8px 26px rgba(73,38,29,.04);
            scrollbar-width: none;
        }

        .feed-tabs::-webkit-scrollbar {
            display: none;
        }

        .feed-tab {
            flex: 0 0 auto;
            min-height: 40px;
            padding: 10px 18px;
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            color: var(--home-muted);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        .feed-tab:hover {
            color: var(--home-brown);
            background: var(--home-linen);
        }

        .feed-tab.is-active {
            background: var(--home-brown);
            color: white;
            box-shadow: 0 7px 18px rgba(73,38,29,.14);
        }

        /* ALERT */
        .home-alert {
            margin-top: 16px;
            padding: 13px 15px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            border-radius: 16px;
            font-size: 13px;
        }

        .home-alert--success {
            background: #E5F4EC;
            color: #27684F;
        }

        .home-alert--error {
            background: #FFF0ED;
            color: #9A2A17;
        }

        .home-alert--error div {
            display: grid;
            gap: 2px;
        }

        /* COMPOSER */
        .thread-composer {
            margin-top: 18px;
            padding: 20px 22px;
            border: 1px solid var(--home-border);
            border-radius: 25px;
            background: var(--home-white);
            box-shadow: 0 12px 34px rgba(73,38,29,.055);
        }

        .composer-row {
            display: grid;
            grid-template-columns: 44px minmax(0, 1fr);
            gap: 13px;
        }

        .composer-avatar,
        .feed-avatar,
        .writer-avatar,
        .comment-avatar,
        .comment-form-avatar {
            display: grid;
            place-items: center;
            border-radius: 50%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            color: var(--home-brown);
            background: var(--home-blue);
        }

        .composer-avatar {
            width: 44px;
            height: 44px;
            font-size: 14px;
        }

        .composer-form {
            min-width: 0;
        }

        .composer-form > textarea {
            width: 100%;
            min-height: 90px;
            resize: vertical;
            padding: 8px 4px 14px;
            border: 0;
            outline: 0;
            background: transparent;
            color: var(--home-text);
            font: 500 17px/1.55 'DM Sans', sans-serif;
        }

        .composer-form > textarea::placeholder {
            color: #9D8981;
        }

        .composer-meta {
            display: flex;
            align-items: center;
            gap: 9px;
            flex-wrap: wrap;
            padding: 12px 0;
            border-top: 1px solid var(--home-border);
        }

        .composer-meta label {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .composer-meta label > span {
            color: #9A8780;
            font-size: 10px;
            font-weight: 700;
        }

        .composer-meta select {
            height: 34px;
            padding: 0 10px;
            border: 1px solid var(--home-border);
            border-radius: 999px;
            outline: 0;
            background: var(--home-soft);
            color: var(--home-brown);
            font: 700 10px 'DM Sans', sans-serif;
        }

        .composer-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            padding-top: 2px;
        }

        .thread-counter {
            color: #98847D;
            font-size: 11px;
        }

        .post-thread-btn {
            min-height: 40px;
            padding: 0 18px;
            border: 0;
            border-radius: 999px;
            background: var(--home-brown);
            color: white;
            cursor: pointer;
            font: 800 12px 'Plus Jakarta Sans', sans-serif;
        }

        .post-thread-btn:hover {
            background: var(--home-orange);
        }

        /* STREAM */
        .stream {
            padding-top: 32px;
        }

        .stream-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            padding: 0 2px 14px;
        }

        .stream-kicker,
        .sidebar-heading span,
        .article-type {
            color: var(--home-orange);
            font: 800 10px 'Plus Jakarta Sans', sans-serif;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .stream-heading h1 {
            margin: 6px 0 0;
            color: var(--home-brown-dark);
            font: 800 29px/1.2 'Plus Jakarta Sans', sans-serif;
            letter-spacing: -.9px;
        }

        .stream-heading > a {
            color: var(--home-brown);
            font-size: 11px;
            font-weight: 800;
            text-decoration: none;
        }

        .stream-heading > a:hover {
            color: var(--home-orange);
        }

        .stream-heading > a i {
            margin-left: 6px;
        }

        .stream-list {
            display: grid;
            gap: 16px;
        }

        /* THREAD */
        .thread-card,
        .feed-article-card {
            border: 1px solid var(--home-border);
            border-radius: 25px;
            background: var(--home-white);
            box-shadow: 0 10px 32px rgba(73,38,29,.045);
        }

        .thread-card {
            padding: 21px 22px;
        }

        .thread-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
        }

        .thread-author,
        .article-byline,
        .writer-info {
            display: flex;
            align-items: center;
        }

        .thread-author {
            gap: 10px;
        }

        .feed-avatar {
            width: 40px;
            height: 40px;
            flex: 0 0 40px;
            font-size: 12px;
        }

        .feed-avatar--small {
            width: 34px;
            height: 34px;
            flex-basis: 34px;
            font-size: 10px;
        }

        .thread-author > div:last-child,
        .article-byline > div:last-child {
            display: grid;
            gap: 2px;
        }

        .thread-author strong,
        .article-byline strong {
            color: var(--home-brown);
            font-size: 13px;
        }

        .thread-author span,
        .article-byline span {
            color: var(--home-muted);
            font-size: 11px;
        }

        .thread-top-actions {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .thread-topic {
            padding: 6px 9px;
            border-radius: 999px;
            background: var(--home-linen);
            color: var(--home-brown);
            font: 800 9px 'Plus Jakarta Sans', sans-serif;
        }

        .thread-more {
            width: 31px;
            height: 31px;
            display: grid;
            place-items: center;
            border: 0;
            border-radius: 50%;
            background: transparent;
            color: #9A8780;
            cursor: pointer;
        }

        .thread-more:hover {
            color: #B42318;
            background: #FFF0ED;
        }

        .thread-body {
            padding: 18px 2px 17px 50px;
            color: #332D2A;
            font-size: 16px;
            line-height: 1.68;
            white-space: pre-wrap;
        }

        .thread-actions {
            display: flex;
            align-items: center;
            gap: 3px;
            padding-top: 12px;
            border-top: 1px solid var(--home-border);
        }

        .thread-action {
            min-height: 36px;
            padding: 0 10px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 0;
            border-radius: 999px;
            background: transparent;
            color: var(--home-muted);
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
        }

        .thread-action:hover {
            color: var(--home-orange);
            background: var(--home-soft);
        }

        .thread-action.is-active {
            color: var(--home-orange);
        }

        .thread-action--push {
            margin-left: auto;
        }

        /* DISCUSSION */
        .thread-discussion {
            margin-top: 12px;
            padding-top: 15px;
            border-top: 1px solid var(--home-border);
        }

        .thread-comment-form {
            display: grid;
            grid-template-columns: 34px minmax(0,1fr);
            gap: 10px;
            margin-bottom: 18px;
        }

        .comment-form-avatar {
            width: 34px;
            height: 34px;
            font-size: 10px;
        }

        .thread-comment-form textarea,
        .nested-reply-form textarea {
            width: 100%;
            resize: vertical;
            padding: 10px 12px;
            border: 1px solid var(--home-border);
            border-radius: 13px;
            outline: 0;
            background: var(--home-soft);
            color: var(--home-text);
            font: 13px/1.55 'DM Sans', sans-serif;
        }

        .thread-comment-form textarea:focus,
        .nested-reply-form textarea:focus {
            border-color: rgba(251,77,0,.38);
            background: white;
        }

        .comment-form-footer,
        .nested-reply-footer {
            margin-top: 7px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .comment-form-footer span,
        .nested-reply-footer span {
            color: #9C8880;
            font-size: 9px;
        }

        .comment-form-footer button,
        .nested-reply-footer button {
            padding: 7px 12px;
            border: 0;
            border-radius: 999px;
            background: var(--home-brown);
            color: white;
            cursor: pointer;
            font-size: 10px;
            font-weight: 800;
        }

        .comments-list {
            display: grid;
        }

        .comment-node {
            margin-left: calc(var(--reply-depth) * 28px);
            display: grid;
            grid-template-columns: 32px minmax(0,1fr);
            gap: 9px;
        }

        .comment-rail {
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        .comment-avatar {
            width: 30px;
            height: 30px;
            flex: 0 0 30px;
            font-size: 9px;
            background: var(--home-linen);
        }

        .comment-line {
            width: 2px;
            flex: 1;
            min-height: 20px;
            margin-top: 5px;
            border-radius: 999px;
            background: var(--home-border);
        }

        .comment-content {
            min-width: 0;
            padding: 3px 0 13px;
        }

        .comment-byline {
            display: flex;
            align-items: baseline;
            gap: 7px;
            flex-wrap: wrap;
        }

        .comment-byline strong {
            color: var(--home-brown);
            font-size: 11px;
        }

        .comment-byline span {
            color: #9C8981;
            font-size: 9px;
        }

        .comment-content > p {
            margin: 4px 0 5px;
            color: #443B37;
            font-size: 12px;
            line-height: 1.55;
            white-space: pre-wrap;
        }

        .comment-reply-btn {
            padding: 3px 6px;
            border: 0;
            border-radius: 999px;
            background: transparent;
            color: var(--home-muted);
            cursor: pointer;
            font-size: 9px;
            font-weight: 700;
        }

        .comment-reply-btn:hover {
            color: var(--home-orange);
            background: var(--home-soft);
        }

        .nested-reply-form {
            margin: 8px 0 4px;
            padding: 10px;
            border-radius: 13px;
            background: var(--home-soft);
        }

        .nested-reply-form textarea {
            background: white;
        }

        .comment-children {
            margin-top: 8px;
        }

        .comment-empty {
            padding: 16px;
            border-radius: 14px;
            background: var(--home-soft);
            color: var(--home-muted);
            font-size: 11px;
            text-align: center;
        }

        /* ARTICLE */
        .feed-article-link {
            color: inherit;
            text-decoration: none;
        }

        .feed-article-card {
            display: grid;
            grid-template-columns: minmax(0,1fr) 190px;
            gap: 24px;
            padding: 22px;
            transition: .22s ease;
        }

        .feed-article-link:hover .feed-article-card {
            transform: translateY(-2px);
            box-shadow: 0 16px 40px rgba(73,38,29,.08);
        }

        .feed-article-copy {
            min-width: 0;
        }

        .article-byline {
            gap: 9px;
            margin-bottom: 16px;
        }

        .article-type {
            display: inline-block;
            margin-bottom: 7px;
        }

        .feed-article-card h2 {
            margin: 0;
            color: var(--home-brown-dark);
            font: 800 23px/1.26 'Plus Jakarta Sans', sans-serif;
            letter-spacing: -.6px;
        }

        .feed-article-link:hover h2 {
            color: var(--home-orange);
        }

        .feed-article-card p {
            margin: 9px 0 0;
            color: var(--home-muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .feed-article-meta {
            margin-top: 17px;
            display: flex;
            flex-wrap: wrap;
            gap: 13px;
            color: #8E7A73;
            font-size: 11px;
        }

        .feed-article-meta span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .feed-article-cover {
            width: 190px;
            height: 155px;
            align-self: center;
        }

        .feed-article-cover img,
        .feed-article-placeholder {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 19px;
        }

        .feed-article-placeholder {
            display: grid;
            place-items: center;
            align-content: center;
            gap: 8px;
            color: var(--home-brown);
            text-align: center;
        }

        .feed-article-placeholder i {
            font-size: 25px;
        }

        .feed-article-placeholder span {
            max-width: 125px;
            font-size: 10px;
            font-weight: 800;
        }

        /* SIDEBAR */
        .home-sidebar {
            position: sticky;
            top: 112px;
            display: grid;
            gap: 16px;
        }

        .sidebar-card {
            padding: 20px;
            border: 1px solid var(--home-border);
            border-radius: 23px;
            background: rgba(255,255,255,.88);
            box-shadow: 0 10px 30px rgba(73,38,29,.04);
        }

        .sidebar-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 17px;
        }

        .sidebar-heading h2 {
            margin: 5px 0 0;
            color: var(--home-brown-dark);
            font: 800 20px 'Plus Jakarta Sans', sans-serif;
            letter-spacing: -.5px;
        }

        .sidebar-heading > i {
            color: #A9CFE2;
            font-size: 18px;
        }

        .writer-list,
        .trending-list {
            display: grid;
            gap: 5px;
        }

        .writer-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 9px 0;
        }

        .writer-info {
            min-width: 0;
            gap: 9px;
        }

        .writer-avatar {
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
            font-size: 11px;
            background: var(--home-linen);
        }

        .writer-info > div:last-child {
            min-width: 0;
            display: grid;
            gap: 1px;
        }

        .writer-info strong {
            overflow: hidden;
            color: var(--home-brown);
            font-size: 12px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .writer-info span {
            color: var(--home-muted);
            font-size: 10px;
        }

        .follow-btn {
            flex: 0 0 auto;
            padding: 7px 11px;
            border: 0;
            border-radius: 999px;
            background: var(--home-brown);
            color: white;
            cursor: pointer;
            font-size: 10px;
            font-weight: 800;
        }

        .follow-btn:hover {
            background: var(--home-orange);
        }

        .trend-row {
            display: grid;
            grid-template-columns: 29px minmax(0,1fr);
            gap: 9px;
            padding: 11px 0;
            border-top: 1px solid var(--home-border);
            color: inherit;
            text-decoration: none;
        }

        .trend-row:first-child {
            border-top: 0;
        }

        .trend-no {
            color: #C8B6AF;
            font: 800 15px 'Plus Jakarta Sans', sans-serif;
        }

        .trend-row > div {
            display: grid;
            gap: 4px;
        }

        .trend-row strong {
            color: var(--home-brown);
            font-size: 12px;
            line-height: 1.42;
        }

        .trend-row:hover strong {
            color: var(--home-orange);
        }

        .trend-row span:last-child {
            color: var(--home-muted);
            font-size: 9px;
        }

        .sidebar-empty {
            margin: 0;
            color: var(--home-muted);
            font-size: 11px;
        }

        /* EMPTY */
        .feed-empty {
            padding: 55px 24px;
            display: grid;
            justify-items: center;
            border: 1px dashed var(--home-border);
            border-radius: 24px;
            background: rgba(255,255,255,.56);
            text-align: center;
        }

        .feed-empty-icon {
            width: 55px;
            height: 55px;
            display: grid;
            place-items: center;
            border-radius: 18px;
            background: var(--home-linen);
            color: var(--home-brown);
            font-size: 20px;
        }

        .feed-empty h2 {
            margin: 17px 0 5px;
            color: var(--home-brown-dark);
            font: 800 20px 'Plus Jakarta Sans', sans-serif;
        }

        .feed-empty p {
            max-width: 430px;
            margin: 0;
            color: var(--home-muted);
            font-size: 12px;
            line-height: 1.55;
        }

        @media (max-width: 1040px) {
            .home-shell {
                grid-template-columns: 1fr;
            }

            .home-sidebar {
                position: static;
                grid-template-columns: repeat(2, minmax(0,1fr));
            }
        }

        @media (max-width: 700px) {
            .home-feed-page {
                padding: 22px 16px 70px;
            }

            .feed-tabs {
                border-radius: 18px;
            }

            .thread-composer,
            .thread-card {
                padding: 17px;
                border-radius: 21px;
            }

            .stream-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .stream-heading h1 {
                font-size: 25px;
            }

            .thread-body {
                padding-left: 0;
            }

            .feed-article-card {
                grid-template-columns: minmax(0,1fr) 100px;
                gap: 14px;
                padding: 17px;
                border-radius: 21px;
            }

            .feed-article-cover {
                width: 100px;
                height: 100px;
            }

            .feed-article-card h2 {
                font-size: 18px;
            }

            .feed-article-card p {
                display: none;
            }

            .feed-article-meta span:nth-child(n+2) {
                display: none;
            }

            .home-sidebar {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .composer-row {
                grid-template-columns: 36px minmax(0,1fr);
            }

            .composer-avatar {
                width: 36px;
                height: 36px;
                font-size: 11px;
            }

            .composer-meta {
                align-items: stretch;
                flex-direction: column;
            }

            .composer-meta label {
                justify-content: space-between;
            }

            .thread-card-top {
                align-items: flex-start;
                flex-direction: column;
            }

            .thread-top-actions {
                width: 100%;
                justify-content: space-between;
            }

            .thread-actions {
                justify-content: space-between;
            }

            .thread-action {
                padding-inline: 8px;
            }

            .thread-action span {
                display: none;
            }

            .thread-action--push {
                margin-left: 0;
            }

            .comment-node {
                margin-left: calc(min(var(--reply-depth), 2) * 16px);
            }
        }
    </style>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrfMeta = document.querySelector(
                'meta[name="csrf-token"]'
            );

            const csrfToken = csrfMeta
                ? csrfMeta.content
                : '';

            // Composer counter
            const threadBody =
                document.getElementById('threadBody');

            const threadCounter =
                document.getElementById('threadCounter');

            function syncThreadCounter() {
                if (
                    threadBody
                    && threadCounter
                ) {
                    threadCounter.textContent =
                        threadBody.value.length;
                }
            }

            if (threadBody) {
                threadBody.addEventListener(
                    'input',
                    syncThreadCounter
                );

                syncThreadCounter();
            }


            // Like
            document
                .querySelectorAll('[data-thread-like]')
                .forEach(function (button) {

                    button.addEventListener(
                        'click',
                        async function () {
                            const url =
                                button.dataset.url;

                            if (!url || !csrfToken) {
                                return;
                            }

                            try {
                                const response =
                                    await fetch(url, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type':
                                                'application/json',
                                            'X-CSRF-TOKEN':
                                                csrfToken,
                                            'Accept':
                                                'application/json'
                                        }
                                    });

                                const data =
                                    await response.json();

                                if (!data.success) {
                                    return;
                                }

                                button.classList.toggle(
                                    'is-active',
                                    data.liked
                                );

                                const icon =
                                    button.querySelector('i');

                                const count =
                                    button.querySelector(
                                        '[data-like-count]'
                                    );

                                if (icon) {
                                    icon.className =
                                        `${data.liked ? 'fas' : 'far'} fa-heart`;
                                }

                                if (count) {
                                    count.textContent =
                                        data.count;
                                }
                            } catch (error) {
                                console.error(
                                    'Thread like error:',
                                    error
                                );
                            }
                        }
                    );
                });


            // Bookmark
            document
                .querySelectorAll(
                    '[data-thread-bookmark]'
                )
                .forEach(function (button) {

                    button.addEventListener(
                        'click',
                        async function () {
                            const url =
                                button.dataset.url;

                            if (!url || !csrfToken) {
                                return;
                            }

                            try {
                                const response =
                                    await fetch(url, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type':
                                                'application/json',
                                            'X-CSRF-TOKEN':
                                                csrfToken,
                                            'Accept':
                                                'application/json'
                                        }
                                    });

                                const data =
                                    await response.json();

                                if (!data.success) {
                                    return;
                                }

                                button.classList.toggle(
                                    'is-active',
                                    data.bookmarked
                                );

                                const icon =
                                    button.querySelector('i');

                                if (icon) {
                                    icon.className =
                                        `${data.bookmarked ? 'fas' : 'far'} fa-bookmark`;
                                }
                            } catch (error) {
                                console.error(
                                    'Thread bookmark error:',
                                    error
                                );
                            }
                        }
                    );
                });


            // Toggle comments
            document
                .querySelectorAll(
                    '[data-toggle-discussion]'
                )
                .forEach(function (button) {

                    button.addEventListener(
                        'click',
                        function () {
                            const id =
                                button.dataset
                                    .toggleDiscussion;

                            const discussion =
                                document.getElementById(
                                    `threadDiscussion${id}`
                                );

                            if (!discussion) return;

                            discussion.hidden =
                                !discussion.hidden;

                            if (!discussion.hidden) {
                                const textarea =
                                    discussion.querySelector(
                                        '.thread-comment-form textarea'
                                    );

                                if (textarea) {
                                    textarea.focus();
                                }
                            }
                        }
                    );
                });


            // Toggle reply to a comment
            document
                .querySelectorAll(
                    '[data-toggle-comment-reply]'
                )
                .forEach(function (button) {

                    button.addEventListener(
                        'click',
                        function () {
                            const id =
                                button.dataset
                                    .toggleCommentReply;

                            const form =
                                document.getElementById(
                                    `commentReply${id}`
                                );

                            if (!form) return;

                            form.hidden = !form.hidden;

                            if (!form.hidden) {
                                const textarea =
                                    form.querySelector(
                                        'textarea'
                                    );

                                if (textarea) {
                                    textarea.focus();
                                }
                            }
                        }
                    );
                });


            // Share
            document
                .querySelectorAll('[data-share-thread]')
                .forEach(function (button) {

                    button.addEventListener(
                        'click',
                        async function () {
                            try {
                                if (navigator.share) {
                                    await navigator.share({
                                        title:
                                            'Utas Interlude',
                                        url:
                                            window.location.href
                                    });

                                    return;
                                }

                                await navigator.clipboard
                                    .writeText(
                                        window.location.href
                                    );

                                alert(
                                    'Tautan halaman berhasil disalin.'
                                );
                            } catch (error) {
                                if (
                                    error.name !== 'AbortError'
                                ) {
                                    console.error(
                                        'Share error:',
                                        error
                                    );
                                }
                            }
                        }
                    );
                });


            window.toggleFollow =
                async function (
                    userId,
                    button
                ) {
                    if (!csrfToken || !button) {
                        return;
                    }

                    const originalText =
                        button.textContent.trim();

                    button.disabled = true;

                    try {
                        const response =
                            await fetch(
                                `/users/${userId}/follow`,
                                {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type':
                                            'application/json',
                                        'X-CSRF-TOKEN':
                                            csrfToken,
                                        'Accept':
                                            'application/json'
                                    }
                                }
                            );

                        const data =
                            await response.json();

                        if (data.success) {
                            if (data.following) {
                                button.textContent =
                                    'Mengikuti';

                                button.style.background =
                                    '#FFFFFF';

                                button.style.color =
                                    '#49261D';

                                button.style.border =
                                    '1px solid #E8DCD6';
                            } else {
                                button.textContent =
                                    'Ikuti';

                                button.style.background =
                                    '#49261D';

                                button.style.color =
                                    '#FFFFFF';

                                button.style.border =
                                    '0';
                            }
                        } else {
                            button.textContent =
                                originalText;
                        }
                    } catch (error) {
                        button.textContent =
                            originalText;

                        console.error(
                            'Follow error:',
                            error
                        );
                    } finally {
                        button.disabled = false;
                    }
                };
        });
    </script>

</x-app-layout>
