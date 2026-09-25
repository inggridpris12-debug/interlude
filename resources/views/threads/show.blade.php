<x-app-layout>

    @once
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap"
            rel="stylesheet"
        >
    @endonce

    @php
        $liked = $thread->isLikedBy(Auth::user());
        $bookmarked = $thread->isBookmarkedBy(Auth::user());
    @endphp

    <main class="thread-detail-page">
        <div class="thread-detail-shell">

            <header class="thread-detail-header">
                <a
                    href="{{ url()->previous() }}"
                    class="thread-back"
                >
                    <i class="fas fa-arrow-left"></i>
                </a>

                <div>
                    <h1>Utas</h1>
                    <span>Percakapan di Interlude</span>
                </div>
            </header>

            @if(session('success'))
                <div class="thread-success">
                    {{ session('success') }}
                </div>
            @endif

            <article class="thread-main-card">

                <div class="thread-main-author">
                    <div class="detail-avatar">
                        {{ strtoupper(substr($thread->user->name, 0, 1)) }}
                    </div>

                    <div>
                        <strong>{{ $thread->user->name }}</strong>

                        <span>
                            {{ $thread->created_at->locale('id')->translatedFormat('d M Y · H:i') }}
                        </span>
                    </div>

                    @if($thread->topic)
                        <span class="detail-topic">
                            {{ $thread->topic }}
                        </span>
                    @endif
                </div>

                <div class="thread-main-body">
                    {{ $thread->body }}
                </div>

                @if($thread->attachments->isNotEmpty())
                    <div class="thread-detail-attachments">
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

                <div class="thread-detail-stats">
                    <span>
                        <strong>{{ $thread->likes_count }}</strong>
                        suka
                    </span>

                    <span>
                        <strong>{{ $thread->replies_count }}</strong>
                        balasan
                    </span>
                </div>

                <div class="thread-detail-actions">

                    <button
                        type="button"
                        class="detail-action {{ $liked ? 'is-active' : '' }}"
                        data-thread-like
                        data-url="{{ route('threads.like', $thread) }}"
                    >
                        <i class="{{ $liked ? 'fas' : 'far' }} fa-heart"></i>
                        <span data-like-count>{{ $thread->likes_count }}</span>
                    </button>

                    <a
                        href="#discussion"
                        class="detail-action"
                    >
                        <i class="far fa-comment"></i>
                        Balas
                    </a>

                    <button
                        type="button"
                        class="detail-action"
                        data-share-url="{{ route('threads.show', $thread) }}"
                    >
                        <i class="fas fa-arrow-up-from-bracket"></i>
                        Bagikan
                    </button>

                    <button
                        type="button"
                        class="detail-action detail-action--push {{ $bookmarked ? 'is-active' : '' }}"
                        data-thread-bookmark
                        data-url="{{ route('threads.bookmark', $thread) }}"
                    >
                        <i class="{{ $bookmarked ? 'fas' : 'far' }} fa-bookmark"></i>
                    </button>

                </div>
            </article>


            <section
                class="discussion"
                id="discussion"
            >
                <div class="discussion-title">
                    <span>Percakapan</span>
                    <h2>Balasan</h2>
                </div>

                <form
                    method="POST"
                    action="{{ route('threads.replies.store', $thread) }}"
                    enctype="multipart/form-data"
                    class="main-reply-form"
                >
                    @csrf

                    <div class="detail-avatar detail-avatar--small">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>

                    <div class="main-reply-fields">

                        <textarea
                            name="body"
                            rows="3"
                            maxlength="280"
                            placeholder="Posting balasanmu..."
                            required
                        ></textarea>

                        <div class="reply-attachment-row">

                            <label title="Foto / GIF">
                                <i class="far fa-image"></i>

                                <input
                                    type="file"
                                    name="reply_images[]"
                                    accept="image/*,.gif"
                                    multiple
                                >
                            </label>

                            <label title="Dokumen">
                                <i class="fas fa-paperclip"></i>

                                <input
                                    type="file"
                                    name="reply_files[]"
                                    accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt"
                                    multiple
                                >
                            </label>

                            <label title="Video">
                                <i class="fas fa-video"></i>

                                <input
                                    type="file"
                                    name="reply_video"
                                    accept="video/mp4,video/webm,video/quicktime"
                                >
                            </label>

                            <label title="Audio">
                                <i class="fas fa-headphones"></i>

                                <input
                                    type="file"
                                    name="reply_audio"
                                    accept="audio/*"
                                >
                            </label>

                            <input
                                class="reply-link-input"
                                type="url"
                                name="reply_link"
                                placeholder="Tempel link..."
                            >

                            <button type="submit">
                                Balas
                            </button>
                        </div>
                    </div>
                </form>

                <div class="detail-comments">
                    @forelse($thread->topLevelReplies as $reply)

                        @include('threads.partials.reply', [
                            'reply' => $reply,
                            'thread' => $thread,
                            'level' => 0,
                        ])

                    @empty

                        <div class="detail-empty">
                            Belum ada balasan. Jadilah yang pertama memulai percakapan.
                        </div>

                    @endforelse
                </div>
            </section>
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

        .thread-detail-page,.thread-detail-page *{box-sizing:border-box}
        .thread-detail-page{
            min-height:100vh;
            padding:34px 18px 90px;
            background:#FDFAF7;
            color:var(--home-text);
            font-family:'DM Sans',sans-serif;
        }
        .thread-detail-shell{width:min(760px,100%);margin:auto}
        .thread-detail-header{display:flex;align-items:center;gap:14px;margin-bottom:17px}
        .thread-back{
            width:42px;height:42px;display:grid;place-items:center;
            border:1px solid var(--home-border);border-radius:50%;
            background:#fff;color:var(--home-brown);text-decoration:none;
        }
        .thread-detail-header h1{
            margin:0;color:var(--home-brown-dark);
            font:800 23px 'Plus Jakarta Sans',sans-serif;
        }
        .thread-detail-header span{font-size:10px;color:var(--home-muted)}
        .thread-success{margin-bottom:13px;padding:11px 13px;border-radius:13px;background:#E5F4EC;color:#27684F;font-size:11px}

        .thread-main-card{
            padding:24px;border:1px solid var(--home-border);border-radius:25px;
            background:#fff;box-shadow:0 12px 35px rgba(73,38,29,.05);
        }
        .thread-main-author{display:flex;align-items:center;gap:10px}
        .detail-avatar,.comment-avatar{
            display:grid;place-items:center;border-radius:50%;
            background:var(--home-blue);color:var(--home-brown);
            font:800 12px 'Plus Jakarta Sans',sans-serif;
        }
        .detail-avatar{width:44px;height:44px;flex:0 0 44px}
        .detail-avatar--small{width:36px;height:36px;flex-basis:36px;font-size:10px}
        .thread-main-author>div:nth-child(2){display:grid;gap:2px}
        .thread-main-author strong{font-size:13px;color:var(--home-brown)}
        .thread-main-author span{font-size:10px;color:var(--home-muted)}
        .detail-topic{
            margin-left:auto;padding:6px 9px;border-radius:999px;
            background:var(--home-linen);color:var(--home-brown)!important;
            font-size:9px!important;font-weight:800;
        }
        .thread-main-body{padding:20px 0 13px;font-size:18px;line-height:1.7;white-space:pre-wrap}
        .thread-detail-stats{
            margin-top:18px;padding:11px 0;display:flex;gap:17px;
            border-top:1px solid var(--home-border);border-bottom:1px solid var(--home-border);
            font-size:10px;color:var(--home-muted);
        }
        .thread-detail-actions{padding-top:10px;display:flex;align-items:center;gap:4px}
        .detail-action{
            min-height:38px;padding:0 11px;display:inline-flex;align-items:center;gap:6px;
            border:0;border-radius:999px;background:transparent;color:var(--home-muted);
            cursor:pointer;font-size:11px;font-weight:700;text-decoration:none;
        }
        .detail-action:hover,.detail-action.is-active{color:var(--home-orange);background:var(--home-soft)}
        .detail-action--push{margin-left:auto}

        .attachment-images{display:grid;gap:3px;overflow:hidden;border-radius:18px;background:#F2ECE8}
        .attachment-images--1{grid-template-columns:1fr}
        .attachment-images--2,.attachment-images--4,.attachment-images--3{grid-template-columns:repeat(2,minmax(0,1fr))}
        .attachment-images--3 .attachment-image-link:first-child{grid-row:span 2}
        .attachment-image-link{min-height:150px;overflow:hidden}
        .attachment-image-link img{width:100%;height:100%;min-height:150px;max-height:430px;object-fit:cover;display:block}
        .attachment-video{margin-top:10px;overflow:hidden;border-radius:18px;background:#1D1917}
        .attachment-video video{width:100%;max-height:480px;display:block}
        .attachment-audio{margin-top:10px;padding:13px;border:1px solid var(--home-border);border-radius:17px;background:var(--home-soft)}
        .attachment-audio-title{margin-bottom:9px;display:flex;gap:8px;font-size:11px;font-weight:700;color:var(--home-brown)}
        .attachment-audio audio{width:100%;height:38px}
        .attachment-file,.attachment-link-card{
            margin-top:9px;padding:12px;display:grid;grid-template-columns:39px minmax(0,1fr) auto;
            align-items:center;gap:10px;border:1px solid var(--home-border);border-radius:15px;
            background:var(--home-soft);color:inherit;text-decoration:none;
        }
        .attachment-file-icon,.attachment-link-icon{
            width:39px;height:39px;display:grid;place-items:center;border-radius:12px;
            background:var(--home-linen);color:var(--home-brown);
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

        .discussion{margin-top:26px}
        .discussion-title span{font:800 9px 'Plus Jakarta Sans',sans-serif;letter-spacing:1px;text-transform:uppercase;color:var(--home-orange)}
        .discussion-title h2{margin:4px 0 13px;font:800 23px 'Plus Jakarta Sans',sans-serif;color:var(--home-brown-dark)}
        .main-reply-form{
            padding:16px;display:grid;grid-template-columns:36px minmax(0,1fr);
            gap:10px;border:1px solid var(--home-border);border-radius:19px;background:#fff;
        }
        .main-reply-fields textarea,.nested-reply-form textarea{
            width:100%;resize:vertical;padding:10px 11px;border:0;outline:0;
            border-radius:11px;background:var(--home-soft);font:12px/1.55 'DM Sans',sans-serif;
        }
        .reply-attachment-row{margin-top:8px;display:flex;align-items:center;gap:5px;flex-wrap:wrap}
        .reply-attachment-row label{
            width:32px;height:32px;display:grid;place-items:center;border-radius:50%;
            color:var(--home-orange);cursor:pointer;
        }
        .reply-attachment-row label:hover{background:var(--home-linen)}
        .reply-attachment-row label input{display:none}
        .reply-link-input{
            min-width:150px;height:32px;flex:1;padding:0 9px;
            border:1px solid var(--home-border);border-radius:999px;outline:0;font-size:10px;
        }
        .reply-attachment-row>button,.nested-reply-footer button{
            height:32px;padding:0 12px;border:0;border-radius:999px;
            background:var(--home-brown);color:#fff;cursor:pointer;font-size:10px;font-weight:800;
        }
        .detail-comments{margin-top:18px;padding-top:6px}
        .comment-node{
            margin-left:calc(var(--reply-depth) * 28px);
            display:grid;grid-template-columns:32px minmax(0,1fr);gap:9px;
        }
        .comment-rail{display:flex;align-items:center;flex-direction:column}
        .comment-avatar{width:30px;height:30px;flex:0 0 30px;background:var(--home-linen);font-size:9px}
        .comment-line{width:2px;flex:1;min-height:20px;margin-top:5px;border-radius:999px;background:var(--home-border)}
        .comment-content{min-width:0;padding:3px 0 15px}
        .comment-byline{display:flex;align-items:baseline;gap:7px;flex-wrap:wrap}
        .comment-byline strong{font-size:11px;color:var(--home-brown)}
        .comment-byline span{font-size:9px;color:#9C8981}
        .comment-content>p{margin:4px 0 5px;font-size:12px;line-height:1.55;white-space:pre-wrap}
        .comment-reply-btn{
            padding:3px 6px;border:0;border-radius:999px;background:transparent;
            color:var(--home-muted);cursor:pointer;font-size:9px;font-weight:700;
        }
        .nested-reply-form{margin:8px 0 4px;padding:10px;border-radius:13px;background:var(--home-soft)}
        .nested-reply-footer{margin-top:7px;display:flex;align-items:center;justify-content:space-between;gap:10px}
        .nested-reply-footer span{font-size:9px;color:#9C8880}
        .comment-children{margin-top:8px}
        .detail-empty{padding:20px;border-radius:15px;background:var(--home-soft);font-size:11px;color:var(--home-muted);text-align:center}

        @media(max-width:600px){
            .thread-main-card{padding:18px}
            .thread-main-body{font-size:16px}
            .comment-node{margin-left:calc(min(var(--reply-depth), 2) * 15px)}
            .main-reply-form{grid-template-columns:1fr}
            .main-reply-form>.detail-avatar{display:none}
        }
    </style>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken =
                document.querySelector('meta[name="csrf-token"]')?.content || '';

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
                .querySelectorAll('[data-toggle-comment-reply]')
                .forEach(button => {
                    button.addEventListener('click', () => {
                        const form =
                            document.getElementById(
                                `commentReply${button.dataset.toggleCommentReply}`
                            );

                        if (!form) return;

                        form.hidden = !form.hidden;

                        if (!form.hidden) {
                            form.querySelector('textarea')?.focus();
                        }
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
        });
    </script>

</x-app-layout>
