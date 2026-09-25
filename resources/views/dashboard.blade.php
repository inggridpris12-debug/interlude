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

                        <div class="composer-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

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

                            <div
                                id="linkPanel"
                                class="composer-extra-panel"
                                hidden
                            >
                                <i class="fas fa-link"></i>

                                <input
                                    type="url"
                                    name="link"
                                    placeholder="Tempel tautan di sini..."
                                    value="{{ old('link') }}"
                                >
                            </div>

                            <div
                                id="pollPanel"
                                class="composer-poll-panel"
                                hidden
                            >
                                <input
                                    type="text"
                                    name="poll_question"
                                    maxlength="180"
                                    placeholder="Pertanyaan polling..."
                                    value="{{ old('poll_question') }}"
                                >

                                <div class="poll-input-grid">
                                    @for($i = 0; $i < 4; $i++)
                                        <input
                                            type="text"
                                            name="poll_options[]"
                                            maxlength="100"
                                            placeholder="Pilihan {{ $i + 1 }}{{ $i > 1 ? ' (opsional)' : '' }}"
                                            value="{{ old('poll_options.' . $i) }}"
                                        >
                                    @endfor
                                </div>
                            </div>

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
                                        data-toggle-extra="linkPanel"
                                        title="Tautan"
                                    >
                                        <i class="fas fa-link"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="composer-tool"
                                        data-toggle-extra="pollPanel"
                                        title="Polling"
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
                                <h2>
                                    {{ $feed === 'podcast'
                                        ? 'Feed podcast belum tersedia.'
                                        : 'Belum ada konten di sini.' }}
                                </h2>

                                <p>
                                    {{ $feed === 'podcast'
                                        ? 'Backend podcast belum tersambung ke Beranda.'
                                        : 'Mulai berbagi utas atau ikuti penulis lain.' }}
                                </p>
                            </div>

                        @endforelse

                    </div>
                </section>
            </section>


            {{-- SIDEBAR --}}
            <aside class="home-sidebar">

                <section class="sidebar-card">
                    <div class="sidebar-heading">
                        <div>
                            <span>Temukan orang baru</span>
                            <h2>Penulis untukmu</h2>
                        </div>
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
                            <p class="sidebar-empty">Belum ada rekomendasi penulis.</p>
                        @endforelse
                    </div>
                </section>


                <section class="sidebar-card">
                    <div class="sidebar-heading">
                        <div>
                            <span>Lagi ramai</span>
                            <h2>Banyak dibaca</h2>
                        </div>
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
                                    <span>{{ number_format($article->views_count) }} dibaca</span>
                                </div>
                            </a>
                        @empty
                            <p class="sidebar-empty">Belum ada artikel yang sedang ramai.</p>
                        @endforelse
                    </div>
                </section>

            </aside>
        </div>
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
        .composer-extra-panel,.composer-poll-panel{
            margin:8px 0 12px;padding:12px;border:1px solid var(--home-border);
            border-radius:15px;background:var(--home-soft);
        }
        .composer-extra-panel{display:grid;grid-template-columns:20px minmax(0,1fr);gap:8px;align-items:center}
        .composer-extra-panel input,.composer-poll-panel input{
            width:100%;height:38px;padding:0 11px;border:1px solid var(--home-border);
            border-radius:10px;background:#fff;outline:0;font-size:11px;
        }
        .composer-poll-panel{display:grid;gap:9px}
        .poll-input-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:7px}
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

        .home-sidebar{position:sticky;top:112px;display:grid;gap:16px}
        .sidebar-card{padding:20px;border-radius:23px}
        .sidebar-heading h2{margin:5px 0 0;font:800 20px 'Plus Jakarta Sans',sans-serif;color:var(--home-brown-dark)}
        .writer-list,.trending-list{display:grid;gap:5px}
        .writer-row{display:flex;justify-content:space-between;align-items:center;gap:10px;padding:9px 0}
        .writer-info{gap:9px;min-width:0}
        .writer-avatar{width:36px;height:36px;flex:0 0 36px;background:var(--home-linen)}
        .writer-info>div:last-child{display:grid;gap:1px}
        .writer-info strong{font-size:12px;color:var(--home-brown)}
        .writer-info span{font-size:10px;color:var(--home-muted)}
        .follow-btn{padding:7px 11px;border:0;border-radius:999px;background:var(--home-brown);color:#fff;font-size:10px;font-weight:800;cursor:pointer}
        .trend-row{display:grid;grid-template-columns:29px minmax(0,1fr);gap:9px;padding:11px 0;border-top:1px solid var(--home-border);text-decoration:none;color:inherit}
        .trend-row:first-child{border-top:0}
        .trend-no{font:800 15px 'Plus Jakarta Sans',sans-serif;color:#C8B6AF}
        .trend-row>div{display:grid;gap:4px}
        .trend-row strong{font-size:12px;color:var(--home-brown)}
        .trend-row span:last-child{font-size:9px;color:var(--home-muted)}
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
            .home-sidebar{grid-template-columns:1fr}
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

            document
                .querySelectorAll('[data-toggle-extra]')
                .forEach(button => {
                    button.addEventListener('click', () => {
                        const panel =
                            document.getElementById(
                                button.dataset.toggleExtra
                            );

                        if (panel) {
                            panel.hidden = !panel.hidden;
                        }
                    });
                });

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
                async function (userId, button) {
                    if (!csrfToken || !button) return;

                    const response = await fetch(
                        `/users/${userId}/follow`,
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

                    if (data.success) {
                        button.textContent =
                            data.following
                                ? 'Mengikuti'
                                : 'Ikuti';
                    }
                };
        });
    </script>

</x-app-layout>
