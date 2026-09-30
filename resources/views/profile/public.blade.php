<x-app-layout>
    <main class="public-profile-page">
        <div class="public-profile-shell">

            <section class="profile-hero-card">
                <div class="profile-banner">
                    <div class="banner-orb orb-one"></div>
                    <div class="banner-orb orb-two"></div>
                </div>

                <div class="profile-main-row">
                    <div class="profile-avatar-xl">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <div class="profile-primary-copy">
                        <div class="profile-title-row">
                            <div>
                                <h1>{{ $user->name }}</h1>
                                <p>Mahasiswa Interlude · berbagi pengalaman, catatan, dan insight.</p>
                            </div>

                            <div class="profile-actions">
                                @if($isOwnProfile)
                                    <a class="profile-action secondary" href="{{ route('profile.edit') }}">
                                        <i class="far fa-pen-to-square"></i>
                                        Edit profil
                                    </a>
                                @else
                                    <button
                                        type="button"
                                        class="profile-action primary {{ $isFollowing ? 'is-following' : '' }}"
                                        id="publicFollowButton"
                                        data-url="{{ route('users.follow', $user) }}"
                                    >
                                        <i class="fas {{ $isFollowing ? 'fa-user-check' : 'fa-user-plus' }}"></i>
                                        <span>{{ $isFollowing ? 'Mengikuti' : 'Ikuti' }}</span>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="profile-network-stats">
                            <span>
                                <strong id="publicFollowerCount">{{ number_format($user->followers_count) }}</strong>
                                pengikut
                            </span>
                            <span>
                                <strong>{{ number_format($user->following_count) }}</strong>
                                mengikuti
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            <div class="profile-layout">
                <section class="profile-main-column">
                    <article class="profile-section-card about-card">
                        <div class="profile-section-heading">
                            <div>
                                <span class="section-kicker">Tentang</span>
                                <h2>Profil aktivitas</h2>
                            </div>
                            <i class="far fa-address-card"></i>
                        </div>

                        <p>
                            {{ $user->name }} aktif berbagi di Interlude melalui
                            {{ $user->published_articles_count }} artikel,
                            {{ $user->published_podcasts_count }} podcast, dan
                            {{ $user->public_threads_count }} utas publik.
                        </p>
                    </article>

                    <article class="profile-section-card activity-card">
                        <div class="profile-section-heading">
                            <div>
                                <span class="section-kicker">Aktivitas</span>
                                <h2>Postingan terbaru</h2>
                            </div>
                            <i class="fas fa-layer-group"></i>
                        </div>

                        <div class="activity-list">
                            @forelse($activities as $activity)
                                @php
                                    $item = $activity['item'];
                                    $type = $activity['type'];
                                @endphp

                                @if($type === 'article')
                                    <a class="activity-row" href="{{ route('articles.show', $item->slug) }}">
                                        <div class="activity-icon article-icon">
                                            <i class="far fa-file-lines"></i>
                                        </div>
                                        <div class="activity-copy">
                                            <span class="activity-type">Artikel · {{ $item->category ?? 'Cerita' }}</span>
                                            <strong>{{ $item->title }}</strong>
                                            <small>{{ optional($item->published_at)->locale('id')->diffForHumans() }}</small>
                                        </div>
                                        <i class="fas fa-arrow-right activity-arrow"></i>
                                    </a>
                                @elseif($type === 'podcast')
                                    <a class="activity-row" href="{{ route('podcasts.show', $item) }}">
                                        <div class="activity-icon podcast-icon">
                                            <i class="fas {{ $item->media_type === 'video' ? 'fa-video' : 'fa-headphones' }}"></i>
                                        </div>
                                        <div class="activity-copy">
                                            <span class="activity-type">
                                                {{ $item->media_type === 'video' ? 'Video Podcast' : 'Audio Podcast' }}
                                                · {{ $item->category ?: 'Podcast' }}
                                            </span>
                                            <strong>{{ $item->title }}</strong>
                                            <small>{{ optional($item->published_at)->locale('id')->diffForHumans() }}</small>
                                        </div>
                                        <i class="fas fa-arrow-right activity-arrow"></i>
                                    </a>
                                @else
                                    <a class="activity-row" href="{{ route('threads.show', $item) }}">
                                        <div class="activity-icon thread-icon">
                                            <i class="far fa-message"></i>
                                        </div>
                                        <div class="activity-copy">
                                            <span class="activity-type">Utas{{ $item->topic ? ' · '.$item->topic : '' }}</span>
                                            <strong>{{ \Illuminate\Support\Str::limit($item->body, 105) }}</strong>
                                            <small>{{ optional($item->created_at)->locale('id')->diffForHumans() }}</small>
                                        </div>
                                        <i class="fas fa-arrow-right activity-arrow"></i>
                                    </a>
                                @endif
                            @empty
                                <div class="profile-empty-state">
                                    <i class="far fa-folder-open"></i>
                                    <strong>Belum ada aktivitas publik.</strong>
                                    <span>Konten yang dipublikasikan akan tampil di sini.</span>
                                </div>
                            @endforelse
                        </div>
                    </article>
                </section>

                <aside class="profile-side-column">
                    <section class="profile-section-card profile-overview-card">
                        <span class="section-kicker">Ringkasan</span>
                        <h2>Kontribusi di Interlude</h2>

                        <div class="overview-grid">
                            <div>
                                <strong>{{ number_format($user->published_articles_count) }}</strong>
                                <span>Artikel</span>
                            </div>
                            <div>
                                <strong>{{ number_format($user->published_podcasts_count) }}</strong>
                                <span>Podcast</span>
                            </div>
                            <div>
                                <strong>{{ number_format($user->public_threads_count) }}</strong>
                                <span>Utas</span>
                            </div>
                        </div>
                    </section>

                    <section class="profile-section-card profile-note-card">
                        <div class="note-icon"><i class="fas fa-seedling"></i></div>
                        <h3>Belajar dari sesama mahasiswa.</h3>
                        <p>
                            Profil publik Interlude menampilkan karya dan aktivitas yang memang dibagikan secara publik.
                        </p>
                    </section>
                </aside>
            </div>

        </div>
    </main>

    <style>
        .public-profile-page,
        .public-profile-page * {
            box-sizing: border-box;
        }

        .public-profile-page {
            --brown:#49261D;
            --brown-dark:#30120A;
            --orange:#FB4D00;
            --blue:#CAE7F7;
            --linen:#FFEDE3;
            --cream:#FDFAF7;
            --border:#E8DCD6;
            --muted:#705D55;
            min-height:100vh;
            padding:34px 5% 90px;
            background:
                radial-gradient(circle at 95% 4%, rgba(202,231,247,.42), transparent 24%),
                var(--cream);
            font-family:'DM Sans',sans-serif;
            color:var(--brown-dark);
        }

        .public-profile-shell {
            width:min(1100px,100%);
            margin:0 auto;
        }

        .profile-hero-card,
        .profile-section-card {
            background:#fff;
            border:1px solid var(--border);
            box-shadow:0 12px 34px rgba(73,38,29,.05);
        }

        .profile-hero-card {
            overflow:hidden;
            border-radius:28px;
        }

        .profile-banner {
            position:relative;
            height:175px;
            overflow:hidden;
            background:linear-gradient(135deg,var(--blue),#EAF6FC 45%,var(--linen));
        }

        .banner-orb {
            position:absolute;
            border-radius:999px;
            filter:blur(1px);
        }

        .orb-one {
            width:250px;
            height:250px;
            right:8%;
            top:-120px;
            background:rgba(251,77,0,.14);
        }

        .orb-two {
            width:190px;
            height:190px;
            left:10%;
            bottom:-130px;
            background:rgba(255,255,255,.75);
        }

        .profile-main-row {
            display:grid;
            grid-template-columns:120px minmax(0,1fr);
            gap:24px;
            padding:0 30px 28px;
        }

        .profile-avatar-xl {
            width:112px;
            height:112px;
            margin-top:-56px;
            position:relative;
            z-index:2;
            display:grid;
            place-items:center;
            border:6px solid #fff;
            border-radius:50%;
            background:var(--brown);
            color:#fff;
            font:800 30px 'Plus Jakarta Sans',sans-serif;
            box-shadow:0 8px 20px rgba(48,18,10,.16);
        }

        .profile-primary-copy {
            min-width:0;
            padding-top:22px;
        }

        .profile-title-row {
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:20px;
        }

        .profile-title-row h1 {
            margin:0;
            font:800 clamp(28px,4vw,39px)/1.08 'Plus Jakarta Sans',sans-serif;
            letter-spacing:-1.2px;
            color:var(--brown-dark);
        }

        .profile-title-row p {
            margin:8px 0 0;
            color:var(--muted);
            font-size:13px;
            line-height:1.6;
        }

        .profile-actions {
            flex:0 0 auto;
        }

        .profile-action {
            min-height:40px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:7px;
            padding:0 15px;
            border-radius:999px;
            border:1px solid var(--brown);
            font-size:11px;
            font-weight:800;
            cursor:pointer;
            text-decoration:none;
            transition:.2s;
        }

        .profile-action.primary {
            background:var(--brown);
            color:#fff;
        }

        .profile-action.primary:hover {
            background:var(--orange);
            border-color:var(--orange);
        }

        .profile-action.primary.is-following {
            background:#fff;
            color:var(--brown);
        }

        .profile-action.secondary {
            background:#fff;
            color:var(--brown);
        }

        .profile-network-stats {
            display:flex;
            flex-wrap:wrap;
            gap:20px;
            margin-top:18px;
            color:var(--muted);
            font-size:11px;
        }

        .profile-network-stats strong {
            color:var(--brown);
            font-size:13px;
        }

        .profile-layout {
            display:grid;
            grid-template-columns:minmax(0,1fr) 310px;
            gap:20px;
            margin-top:20px;
            align-items:start;
        }

        .profile-main-column,
        .profile-side-column {
            display:grid;
            gap:20px;
        }

        .profile-section-card {
            border-radius:24px;
            padding:24px;
        }

        .profile-section-heading {
            display:flex;
            justify-content:space-between;
            gap:16px;
            align-items:flex-start;
            margin-bottom:18px;
        }

        .section-kicker {
            color:var(--orange);
            font:800 9px 'Plus Jakarta Sans',sans-serif;
            letter-spacing:.1em;
            text-transform:uppercase;
        }

        .profile-section-heading h2,
        .profile-overview-card h2 {
            margin:5px 0 0;
            color:var(--brown-dark);
            font:800 21px 'Plus Jakarta Sans',sans-serif;
            letter-spacing:-.5px;
        }

        .profile-section-heading > i {
            color:var(--orange);
            font-size:19px;
        }

        .about-card > p {
            margin:0;
            color:var(--muted);
            font-size:13px;
            line-height:1.8;
        }

        .activity-list {
            display:grid;
        }

        .activity-row {
            display:grid;
            grid-template-columns:44px minmax(0,1fr) 18px;
            gap:12px;
            align-items:center;
            padding:15px 0;
            border-top:1px solid var(--border);
            text-decoration:none;
            color:inherit;
        }

        .activity-row:first-child {
            border-top:0;
            padding-top:0;
        }

        .activity-row:last-child {
            padding-bottom:0;
        }

        .activity-icon {
            width:44px;
            height:44px;
            display:grid;
            place-items:center;
            border-radius:14px;
            font-size:16px;
        }

        .article-icon { background:var(--linen); color:var(--orange); }
        .podcast-icon { background:var(--blue); color:#17333F; }
        .thread-icon { background:#F1EAFB; color:#593B82; }

        .activity-copy {
            min-width:0;
            display:grid;
            gap:4px;
        }

        .activity-type {
            color:var(--orange);
            font-size:8px;
            font-weight:800;
            text-transform:uppercase;
            letter-spacing:.05em;
        }

        .activity-copy strong {
            color:var(--brown);
            font-size:12px;
            line-height:1.45;
        }

        .activity-copy small {
            color:var(--muted);
            font-size:9px;
        }

        .activity-arrow {
            color:#B8A49B;
            font-size:13px;
        }

        .activity-row:hover .activity-arrow,
        .activity-row:hover .activity-copy strong {
            color:var(--orange);
        }

        .overview-grid {
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:8px;
            margin-top:18px;
        }

        .overview-grid > div {
            padding:14px 8px;
            border-radius:16px;
            background:#F8F3EF;
            text-align:center;
        }

        .overview-grid strong {
            display:block;
            color:var(--brown);
            font:800 19px 'Plus Jakarta Sans',sans-serif;
        }

        .overview-grid span {
            display:block;
            margin-top:3px;
            color:var(--muted);
            font-size:9px;
        }

        .profile-note-card {
            background:var(--brown);
            color:#fff;
        }

        .note-icon {
            width:42px;
            height:42px;
            display:grid;
            place-items:center;
            border-radius:14px;
            background:rgba(255,255,255,.12);
            color:var(--blue);
        }

        .profile-note-card h3 {
            margin:16px 0 8px;
            font:800 18px/1.3 'Plus Jakarta Sans',sans-serif;
        }

        .profile-note-card p {
            margin:0;
            color:rgba(255,255,255,.68);
            font-size:11px;
            line-height:1.7;
        }

        .profile-empty-state {
            padding:34px 10px 14px;
            text-align:center;
            color:var(--muted);
        }

        .profile-empty-state i {
            display:block;
            margin-bottom:10px;
            color:var(--blue);
            font-size:28px;
        }

        .profile-empty-state strong,
        .profile-empty-state span {
            display:block;
        }

        .profile-empty-state strong {
            color:var(--brown);
            font-size:12px;
        }

        .profile-empty-state span {
            margin-top:4px;
            font-size:10px;
        }

        @media(max-width:820px) {
            .profile-layout {
                grid-template-columns:1fr;
            }

            .profile-side-column {
                grid-template-columns:1fr 1fr;
            }
        }

        @media(max-width:620px) {
            .public-profile-page {
                padding:20px 14px 70px;
            }

            .profile-banner {
                height:130px;
            }

            .profile-main-row {
                grid-template-columns:1fr;
                padding:0 20px 22px;
            }

            .profile-avatar-xl {
                width:92px;
                height:92px;
                margin-top:-46px;
                font-size:25px;
            }

            .profile-primary-copy {
                padding-top:0;
            }

            .profile-title-row {
                flex-direction:column;
            }

            .profile-action {
                width:100%;
            }

            .profile-actions {
                width:100%;
            }

            .profile-side-column {
                grid-template-columns:1fr;
            }

            .overview-grid {
                grid-template-columns:repeat(3,1fr);
            }
        }
    </style>

    @if(! $isOwnProfile)
        <script>
            (() => {
                const button = document.getElementById('publicFollowButton');
                const count = document.getElementById('publicFollowerCount');
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

                if (!button) return;

                button.addEventListener('click', async () => {
                    button.disabled = true;

                    try {
                        const response = await fetch(button.dataset.url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (!response.ok || !data.success) {
                            throw new Error(data.message || 'Follow gagal');
                        }

                        button.classList.toggle('is-following', !!data.following);
                        button.querySelector('span').textContent = data.following ? 'Mengikuti' : 'Ikuti';

                        const icon = button.querySelector('i');
                        icon.className = data.following
                            ? 'fas fa-user-check'
                            : 'fas fa-user-plus';

                        if (count) count.textContent = Number(data.count || 0).toLocaleString('id-ID');
                    } catch (error) {
                        console.error('Follow profile error:', error);
                    } finally {
                        button.disabled = false;
                    }
                });
            })();
        </script>
    @endif
</x-app-layout>
