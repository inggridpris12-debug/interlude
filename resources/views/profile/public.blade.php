<x-app-layout>
    @php
        $tabs = [
            'activity' => ['Aktivitas', 'fa-solid fa-wave-square'],
            'articles' => ['Artikel', 'fa-regular fa-file-lines'],
            'podcasts' => ['Podcast', 'fa-solid fa-podcast'],
            'threads' => ['Utas', 'fa-regular fa-comment-dots'],
            'liked' => ['Disukai', 'fa-regular fa-heart'],
            'about' => ['Tentang', 'fa-regular fa-address-card'],
        ];

        $usernameDisplay = $user->username ? '@' . $user->username : '@interlude' . $user->id;
        $headlineParts = array_filter([$user->major, $user->university]);
        $headline = count($headlineParts) ? implode(' · ', $headlineParts) : 'Mahasiswa Interlude';
    @endphp

    <main class="profile-page">
        <div class="profile-shell">
            @if(session('profile_success'))
                <div class="profile-alert">{{ session('profile_success') }}</div>
            @endif

            @if($errors->any())
                <div class="profile-alert profile-alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <section class="profile-hero">
                <div class="profile-cover-wrap">
                    <x-user-cover :user="$user" />
                    <div class="profile-cover-shade"></div>

                    @if($isOwnProfile)
                        <button type="button" class="cover-edit-button" onclick="openProfileDialog('coverDialog')">
                            <i class="fa-regular fa-pen-to-square"></i>
                            Ubah sampul
                        </button>
                    @endif
                </div>

                <div class="profile-identity-area">
                    <div class="identity-top-row">
                        <div class="profile-avatar-stack">
                            <div class="profile-avatar-ring">
                                <x-user-avatar :user="$user" :size="132" />
                            </div>

                            @if($isOwnProfile)
                                <button type="button" class="avatar-edit-button" onclick="openProfileDialog('avatarDialog')" aria-label="Ubah foto profil">
                                    <i class="fa-solid fa-camera"></i>
                                </button>
                            @endif
                        </div>

                        <div class="profile-actions">
                            @if($isOwnProfile)
                                <button type="button" class="profile-primary-button" onclick="openProfileDialog('detailsDialog')">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                    Edit profil
                                </button>
                            @else
                                <button
                                    type="button"
                                    class="profile-primary-button {{ $isFollowing ? 'is-following' : '' }}"
                                    id="profileFollowButton"
                                    onclick="toggleProfileFollow({{ $user->id }}, this)"
                                >
                                    <i class="fa-solid {{ $isFollowing ? 'fa-check' : 'fa-user-plus' }}"></i>
                                    <span>{{ $isFollowing ? 'Mengikuti' : 'Ikuti' }}</span>
                                </button>
                            @endif

                            <button type="button" class="profile-secondary-button" onclick="shareProfile()">
                                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                Bagikan profil
                            </button>
                        </div>
                    </div>

                    <div class="profile-name-row">
                        <div>
                            <h1>{{ $user->name }}</h1>
                            <p class="profile-username">{{ $usernameDisplay }}</p>
                        </div>
                    </div>

                    <p class="profile-headline">{{ $headline }}</p>

                    @if($user->bio)
                        <p class="profile-bio">{{ $user->bio }}</p>
                    @else
                        <p class="profile-bio profile-bio-muted">
                            {{ $isOwnProfile ? 'Tambahkan bio singkat supaya orang lain lebih mudah mengenalmu.' : 'Belum ada bio.' }}
                        </p>
                    @endif

                    <div class="profile-meta-row">
                        @if($user->location)
                            <span><i class="fa-solid fa-location-dot"></i>{{ $user->location }}</span>
                        @endif
                        @if($user->university)
                            <span><i class="fa-solid fa-building-columns"></i>{{ $user->university }}</span>
                        @endif
                        @if($user->major)
                            <span><i class="fa-solid fa-graduation-cap"></i>{{ $user->major }}</span>
                        @endif
                    </div>

                    <div class="profile-network-row">
                        <a href="#">{{ number_format($user->followers_count) }} Pengikut</a>
                        <span>·</span>
                        <a href="#">{{ number_format($user->following_count) }} Mengikuti</a>
                    </div>
                </div>

                <nav class="profile-tabs" aria-label="Bagian profil">
                    @foreach($tabs as $key => [$label, $icon])
                        <a
                            href="{{ route('users.show', ['user' => $user, 'tab' => $key]) }}"
                            class="profile-tab {{ $tab === $key ? 'active' : '' }}"
                        >
                            <i class="{{ $icon }}"></i>
                            <span>{{ $label }}</span>
                        </a>
                    @endforeach
                </nav>
            </section>

            <div class="profile-grid">
                <section class="profile-main-column">
                    @if($tab === 'activity')
                        <div class="profile-section-heading">
                            <div>
                                <span>Jejak terbaru</span>
                                <h2>Aktivitas</h2>
                            </div>
                        </div>

                        <div class="profile-feed">
                            @forelse($activities as $activity)
                                @php($item = $activity['item'])

                                @if($activity['type'] === 'article')
                                    <a href="{{ route('articles.show', $item->slug) }}" class="activity-card">
                                        <div class="activity-icon article"><i class="fa-regular fa-file-lines"></i></div>
                                        <div class="activity-copy">
                                            <span class="activity-kicker">Mempublikasikan artikel</span>
                                            <h3>{{ $item->title }}</h3>
                                            @if($item->excerpt)<p>{{ \Illuminate\Support\Str::limit($item->excerpt, 145) }}</p>@endif
                                            <div class="activity-meta">{{ optional($item->published_at)->locale('id')->diffForHumans() ?? 'Baru saja' }} · {{ $item->likes_count ?? 0 }} suka</div>
                                        </div>
                                    </a>
                                @elseif($activity['type'] === 'podcast')
                                    <a href="{{ route('podcasts.show', $item) }}" class="activity-card">
                                        <div class="activity-icon podcast"><i class="fa-solid {{ $item->media_type === 'video' ? 'fa-circle-play' : 'fa-headphones' }}"></i></div>
                                        <div class="activity-copy">
                                            <span class="activity-kicker">Merilis {{ $item->media_type === 'video' ? 'video podcast' : 'audio podcast' }}</span>
                                            <h3>{{ $item->title }}</h3>
                                            @if($item->description)<p>{{ \Illuminate\Support\Str::limit($item->description, 145) }}</p>@endif
                                            <div class="activity-meta">{{ optional($item->published_at)->locale('id')->diffForHumans() ?? 'Baru saja' }} · {{ $item->likes_count ?? 0 }} suka</div>
                                        </div>
                                    </a>
                                @else
                                    <a href="{{ route('threads.show', $item) }}" class="activity-card">
                                        <div class="activity-icon thread"><i class="fa-regular fa-comment-dots"></i></div>
                                        <div class="activity-copy">
                                            <span class="activity-kicker">Membuat utas{{ $item->topic ? ' · ' . $item->topic : '' }}</span>
                                            <h3>{{ \Illuminate\Support\Str::limit($item->body, 95) }}</h3>
                                            <div class="activity-meta">{{ optional($item->created_at)->locale('id')->diffForHumans() ?? 'Baru saja' }} · {{ $item->likes_count ?? 0 }} suka</div>
                                        </div>
                                    </a>
                                @endif
                            @empty
                                <div class="profile-empty">Belum ada aktivitas publik.</div>
                            @endforelse
                        </div>

                    @elseif($tab === 'articles')
                        <div class="profile-section-heading"><div><span>Karya tulis</span><h2>Artikel</h2></div></div>
                        <div class="profile-content-grid">
                            @forelse($articles as $article)
                                <a href="{{ route('articles.show', $article->slug) }}" class="content-card">
                                    <span class="content-type"><i class="fa-regular fa-file-lines"></i> Artikel</span>
                                    <h3>{{ $article->title }}</h3>
                                    @if($article->excerpt)<p>{{ \Illuminate\Support\Str::limit($article->excerpt, 120) }}</p>@endif
                                    <div class="content-meta">{{ $article->likes_count ?? 0 }} suka · {{ $article->comments_count ?? 0 }} komentar</div>
                                </a>
                            @empty
                                <div class="profile-empty">Belum ada artikel yang dipublikasikan.</div>
                            @endforelse
                        </div>

                    @elseif($tab === 'podcasts')
                        <div class="profile-section-heading"><div><span>Ruang dengar</span><h2>Podcast</h2></div></div>
                        <div class="profile-content-grid">
                            @forelse($podcasts as $podcast)
                                <a href="{{ route('podcasts.show', $podcast) }}" class="content-card">
                                    <span class="content-type"><i class="fa-solid {{ $podcast->media_type === 'video' ? 'fa-circle-play' : 'fa-headphones' }}"></i> {{ ucfirst($podcast->media_type) }} Podcast</span>
                                    <h3>{{ $podcast->title }}</h3>
                                    @if($podcast->description)<p>{{ \Illuminate\Support\Str::limit($podcast->description, 120) }}</p>@endif
                                    <div class="content-meta">{{ $podcast->likes_count ?? 0 }} suka · {{ $podcast->views_count ?? 0 }} kunjungan</div>
                                </a>
                            @empty
                                <div class="profile-empty">Belum ada podcast yang dipublikasikan.</div>
                            @endforelse
                        </div>

                    @elseif($tab === 'threads')
                        <div class="profile-section-heading"><div><span>Percakapan</span><h2>Utas</h2></div></div>
                        <div class="profile-feed">
                            @forelse($threads as $thread)
                                <a href="{{ route('threads.show', $thread) }}" class="activity-card">
                                    <div class="activity-icon thread"><i class="fa-regular fa-comment-dots"></i></div>
                                    <div class="activity-copy">
                                        <span class="activity-kicker">{{ $thread->topic ?: 'Utas' }}</span>
                                        <h3>{{ \Illuminate\Support\Str::limit($thread->body, 120) }}</h3>
                                        <div class="activity-meta">{{ $thread->likes_count ?? 0 }} suka · {{ $thread->replies_count ?? 0 }} balasan</div>
                                    </div>
                                </a>
                            @empty
                                <div class="profile-empty">Belum ada utas publik.</div>
                            @endforelse
                        </div>

                    @elseif($tab === 'liked')
                        <div class="profile-section-heading"><div><span>Jejak apresiasi</span><h2>Disukai</h2></div></div>

                        @if(!$canSeeLikes)
                            <div class="profile-empty"><i class="fa-solid fa-lock"></i> Aktivitas suka disembunyikan oleh pemilik profil.</div>
                        @else
                            <div class="profile-feed">
                                @forelse($likedItems as $liked)
                                    @php($item = $liked['item'])

                                    @if($liked['type'] === 'article')
                                        <a href="{{ route('articles.show', $item->slug) }}" class="activity-card liked-card">
                                            <div class="activity-icon liked"><i class="fa-solid fa-heart"></i></div>
                                            <div class="activity-copy"><span class="activity-kicker">Menyukai artikel</span><h3>{{ $item->title }}</h3><div class="activity-meta">oleh {{ optional($item->user)->name ?? 'Mahasiswa Interlude' }}</div></div>
                                        </a>
                                    @elseif($liked['type'] === 'podcast')
                                        <a href="{{ route('podcasts.show', $item) }}" class="activity-card liked-card">
                                            <div class="activity-icon liked"><i class="fa-solid fa-heart"></i></div>
                                            <div class="activity-copy"><span class="activity-kicker">Menyukai podcast</span><h3>{{ $item->title }}</h3><div class="activity-meta">oleh {{ optional($item->user)->name ?? 'Mahasiswa Interlude' }}</div></div>
                                        </a>
                                    @else
                                        <a href="{{ route('threads.show', $item) }}" class="activity-card liked-card">
                                            <div class="activity-icon liked"><i class="fa-solid fa-heart"></i></div>
                                            <div class="activity-copy"><span class="activity-kicker">Menyukai utas</span><h3>{{ \Illuminate\Support\Str::limit($item->body, 110) }}</h3><div class="activity-meta">oleh {{ optional($item->user)->name ?? 'Mahasiswa Interlude' }}</div></div>
                                        </a>
                                    @endif
                                @empty
                                    <div class="profile-empty">Belum ada konten yang disukai.</div>
                                @endforelse
                            </div>
                        @endif

                    @else
                        <div class="profile-section-heading"><div><span>Mengenal lebih dekat</span><h2>Tentang</h2></div></div>
                        <div class="about-panel">
                            <div class="about-row"><span>Bio</span><p>{{ $user->bio ?: 'Belum ditambahkan.' }}</p></div>
                            <div class="about-row"><span>Universitas</span><p>{{ $user->university ?: 'Belum ditambahkan.' }}</p></div>
                            <div class="about-row"><span>Program studi</span><p>{{ $user->major ?: 'Belum ditambahkan.' }}</p></div>
                            <div class="about-row"><span>Lokasi</span><p>{{ $user->location ?: 'Belum ditambahkan.' }}</p></div>
                            <div class="about-row"><span>Aktivitas suka</span><p>{{ $user->show_likes_on_profile ? 'Ditampilkan di profil.' : 'Disembunyikan dari pengunjung profil.' }}</p></div>
                        </div>
                    @endif
                </section>

                <aside class="profile-side-column">
                    <section class="profile-side-card">
                        <span class="side-eyebrow">Tentang</span>
                        <h3>{{ $user->name }}</h3>
                        <p>{{ $user->bio ?: 'Mahasiswa Interlude yang sedang membangun jejak karya dan berbagi hal yang dipelajari.' }}</p>
                    </section>

                    <section class="profile-side-card">
                        <span class="side-eyebrow">Kontribusi</span>
                        <div class="stat-grid">
                            <div><strong>{{ $user->published_articles_count }}</strong><span>Artikel</span></div>
                            <div><strong>{{ $user->published_podcasts_count }}</strong><span>Podcast</span></div>
                            <div><strong>{{ $user->public_threads_count }}</strong><span>Utas</span></div>
                            <div><strong>{{ $user->followers_count }}</strong><span>Pengikut</span></div>
                        </div>
                    </section>
                </aside>
            </div>
        </div>
    </main>

    @if($isOwnProfile)
        <dialog class="profile-dialog" id="avatarDialog">
            <div class="dialog-card">
                <div class="dialog-head"><div><span>Personalisasi</span><h3>Foto profil</h3></div><button type="button" onclick="closeProfileDialog('avatarDialog')"><i class="fa-solid fa-xmark"></i></button></div>

                <form method="POST" action="{{ route('profile.avatar.update') }}" class="dialog-section">
                    @csrf
                    <input type="hidden" name="avatar_mode" value="preset">
                    <h4>Pilih avatar Interlude</h4>
                    <div class="avatar-preset-grid">
                        @foreach(['botticelli','linen','tangelo','sage','chocolate'] as $preset)
                            <label class="avatar-preset-option">
                                <input type="radio" name="avatar_preset" value="{{ $preset }}" {{ ($user->profile_avatar_preset ?: 'botticelli') === $preset ? 'checked' : '' }}>
                                <span class="avatar-preset-swatch avatar-preset-{{ $preset }}">{{ strtoupper(mb_substr($user->name,0,1)) }}</span>
                                <small>{{ ucfirst($preset) }}</small>
                            </label>
                        @endforeach
                    </div>
                    <button class="dialog-primary" type="submit">Gunakan avatar Interlude</button>
                </form>

                <div class="dialog-divider"></div>

                <form method="POST" action="{{ route('profile.avatar.update') }}" enctype="multipart/form-data" class="dialog-section">
                    @csrf
                    <input type="hidden" name="avatar_mode" value="upload">
                    <h4>Upload foto sendiri</h4>
                    <p>JPG, PNG, atau WEBP. Maksimal 5 MB.</p>
                    <input class="dialog-file" type="file" name="profile_photo" accept="image/jpeg,image/png,image/webp" required>
                    <button class="dialog-primary" type="submit">Upload foto</button>
                </form>

                @if($user->profile_photo)
                    <form method="POST" action="{{ route('profile.avatar.remove') }}" class="dialog-remove-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus foto upload & kembali ke avatar Interlude</button>
                    </form>
                @endif
            </div>
        </dialog>

        <dialog class="profile-dialog" id="coverDialog">
            <div class="dialog-card dialog-card-wide">
                <div class="dialog-head"><div><span>Personalisasi</span><h3>Sampul profil</h3></div><button type="button" onclick="closeProfileDialog('coverDialog')"><i class="fa-solid fa-xmark"></i></button></div>

                <form method="POST" action="{{ route('profile.cover.update') }}" class="dialog-section">
                    @csrf
                    <input type="hidden" name="cover_mode" value="preset">
                    <h4>Pilih sampul Interlude</h4>
                    <div class="cover-preset-grid">
                        @foreach([
                            'jeda-blue' => 'Jeda Blue',
                            'linen-wave' => 'Linen Wave',
                            'tangelo-dawn' => 'Tangelo Dawn',
                            'brown-study' => 'Brown Study',
                            'sage-notes' => 'Sage Notes',
                        ] as $preset => $label)
                            <label class="cover-preset-option">
                                <input type="radio" name="cover_preset" value="{{ $preset }}" {{ ($user->cover_preset ?: 'jeda-blue') === $preset ? 'checked' : '' }}>
                                <span class="cover-preset-swatch cover-preset-{{ $preset }}"></span>
                                <small>{{ $label }}</small>
                            </label>
                        @endforeach
                    </div>
                    <button class="dialog-primary" type="submit">Gunakan sampul Interlude</button>
                </form>

                <div class="dialog-divider"></div>

                <form method="POST" action="{{ route('profile.cover.update') }}" enctype="multipart/form-data" class="dialog-section">
                    @csrf
                    <input type="hidden" name="cover_mode" value="upload">
                    <h4>Upload sampul sendiri</h4>
                    <p>Rasio lebar disarankan 3:1. JPG, PNG, atau WEBP. Maksimal 8 MB.</p>
                    <input class="dialog-file" type="file" name="cover_image" accept="image/jpeg,image/png,image/webp" required>
                    <button class="dialog-primary" type="submit">Upload sampul</button>
                </form>

                @if($user->cover_image)
                    <form method="POST" action="{{ route('profile.cover.remove') }}" class="dialog-remove-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus sampul upload & kembali ke sampul Interlude</button>
                    </form>
                @endif
            </div>
        </dialog>

        <dialog class="profile-dialog" id="detailsDialog">
            <form method="POST" action="{{ route('profile.details.update') }}" class="dialog-card dialog-card-wide">
                @csrf
                @method('PATCH')
                <div class="dialog-head"><div><span>Profil publik</span><h3>Edit profil</h3></div><button type="button" onclick="closeProfileDialog('detailsDialog')"><i class="fa-solid fa-xmark"></i></button></div>

                <div class="details-form-grid">
                    <label><span>Username</span><input type="text" name="username" value="{{ old('username', $user->username) }}" placeholder="na_jaemin"></label>
                    <label><span>Universitas</span><input type="text" name="university" value="{{ old('university', $user->university) }}" placeholder="Universitas Airlangga"></label>
                    <label><span>Program studi</span><input type="text" name="major" value="{{ old('major', $user->major) }}" placeholder="Ilmu Informasi dan Perpustakaan"></label>
                    <label><span>Lokasi</span><input type="text" name="location" value="{{ old('location', $user->location) }}" placeholder="Surabaya, Indonesia"></label>
                    <label class="details-full"><span>Bio</span><textarea name="bio" rows="4" maxlength="500" placeholder="Ceritakan sedikit tentang dirimu...">{{ old('bio', $user->bio) }}</textarea></label>
                    <label class="privacy-toggle details-full"><input type="hidden" name="show_likes_on_profile" value="0"><input type="checkbox" name="show_likes_on_profile" value="1" {{ old('show_likes_on_profile', $user->show_likes_on_profile) ? 'checked' : '' }}><span><strong>Tampilkan konten yang disukai</strong><small>Kalau dimatikan, tab Disukai tidak terlihat isinya bagi pengunjung lain.</small></span></label>
                </div>

                <button class="dialog-primary" type="submit">Simpan perubahan</button>
            </form>
        </dialog>
    @endif

    <style>
        :root{--p-brown:#49261D;--p-brown-dark:#30120A;--p-orange:#FB4D00;--p-blue:#CAE7F7;--p-linen:#FFEDE3;--p-cream:#FFFAF6;--p-muted:#74615B;--p-border:#E9DCD4;--p-white:#fff}
        .profile-page{background:var(--p-cream);min-height:100vh;padding:34px 0 80px}.profile-shell{width:min(1180px,calc(100% - 34px));margin:0 auto}.profile-alert{padding:13px 16px;border-radius:14px;background:#E5F5EA;color:#21583A;font-weight:700;margin-bottom:16px}.profile-alert-error{background:#FFF0EC;color:#9A2C0A}.profile-hero{background:#fff;border:1px solid var(--p-border);border-radius:30px;overflow:hidden;box-shadow:0 18px 45px rgba(73,38,29,.06)}.profile-cover-wrap{height:255px;position:relative;overflow:hidden}.profile-cover-shade{position:absolute;inset:0;background:linear-gradient(to top,rgba(48,18,10,.20),transparent 50%);pointer-events:none}.cover-edit-button{position:absolute;right:20px;top:20px;display:inline-flex;align-items:center;gap:8px;border:1px solid rgba(255,255,255,.65);background:rgba(255,255,255,.88);backdrop-filter:blur(12px);color:var(--p-brown);padding:10px 14px;border-radius:999px;font-weight:800;cursor:pointer}.profile-identity-area{padding:0 34px 28px}.identity-top-row{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;margin-top:-66px}.profile-avatar-stack{position:relative;z-index:4}.profile-avatar-ring{width:144px;height:144px;border-radius:999px;background:#fff;padding:6px;box-shadow:0 12px 30px rgba(73,38,29,.13);display:flex;align-items:center;justify-content:center}.avatar-edit-button{position:absolute;right:4px;bottom:8px;width:38px;height:38px;border-radius:999px;background:var(--p-orange);color:#fff;display:flex;align-items:center;justify-content:center;border:4px solid #fff;cursor:pointer}.profile-actions{display:flex;gap:9px;flex-wrap:wrap;padding-bottom:4px}.profile-primary-button,.profile-secondary-button{border:0;border-radius:999px;padding:11px 16px;display:inline-flex;align-items:center;gap:8px;font-weight:800;cursor:pointer}.profile-primary-button{background:var(--p-orange);color:#fff}.profile-primary-button.is-following{background:var(--p-brown)}.profile-secondary-button{background:var(--p-linen);color:var(--p-brown)}.profile-name-row{margin-top:22px}.profile-name-row h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:34px;line-height:1.08;color:var(--p-brown);margin:0}.profile-username{color:var(--p-muted);margin:5px 0 0;font-weight:700}.profile-headline{font-size:17px;color:var(--p-brown);font-weight:700;margin:13px 0 0}.profile-bio{max-width:760px;color:#594944;line-height:1.7;margin:10px 0 0}.profile-bio-muted{color:#9A8882}.profile-meta-row,.profile-network-row{display:flex;align-items:center;gap:16px;flex-wrap:wrap;margin-top:13px;color:var(--p-muted);font-size:13px}.profile-meta-row span{display:inline-flex;align-items:center;gap:6px}.profile-meta-row i{color:var(--p-orange)}.profile-network-row{font-weight:800}.profile-network-row a{color:var(--p-brown);text-decoration:none}.profile-tabs{display:flex;overflow-x:auto;border-top:1px solid var(--p-border);background:#FFFCFA;padding:0 22px}.profile-tab{padding:15px 16px;display:inline-flex;align-items:center;gap:7px;text-decoration:none;color:var(--p-muted);font-weight:800;font-size:13px;border-bottom:3px solid transparent;white-space:nowrap}.profile-tab.active{color:var(--p-orange);border-bottom-color:var(--p-orange)}.profile-grid{display:grid;grid-template-columns:minmax(0,1fr) 310px;gap:24px;margin-top:24px}.profile-main-column,.profile-side-column{min-width:0}.profile-side-column{display:flex;flex-direction:column;gap:18px}.profile-section-heading{display:flex;justify-content:space-between;align-items:end;margin-bottom:14px}.profile-section-heading span,.side-eyebrow{font-size:11px;text-transform:uppercase;letter-spacing:.12em;color:var(--p-orange);font-weight:900}.profile-section-heading h2,.profile-side-card h3{font-family:'Plus Jakarta Sans',sans-serif;color:var(--p-brown);margin:3px 0 0}.profile-feed{display:flex;flex-direction:column;gap:12px}.activity-card{display:flex;gap:15px;padding:19px;background:#fff;border:1px solid var(--p-border);border-radius:20px;text-decoration:none;color:inherit;transition:.2s}.activity-card:hover,.content-card:hover{transform:translateY(-2px);box-shadow:0 14px 28px rgba(73,38,29,.07);border-color:rgba(251,77,0,.25)}.activity-icon{width:45px;height:45px;border-radius:14px;display:flex;align-items:center;justify-content:center;flex:0 0 45px}.activity-icon.article{background:var(--p-linen);color:var(--p-orange)}.activity-icon.podcast{background:var(--p-blue);color:var(--p-brown)}.activity-icon.thread{background:#E8F4EC;color:#37624A}.activity-icon.liked{background:#FFF0EC;color:#E34D2B}.activity-copy{min-width:0}.activity-kicker,.content-type{color:var(--p-orange);font-size:11px;text-transform:uppercase;letter-spacing:.07em;font-weight:900}.activity-copy h3,.content-card h3{font-family:'Plus Jakarta Sans',sans-serif;color:var(--p-brown);font-size:17px;line-height:1.35;margin:5px 0}.activity-copy p,.content-card p{color:var(--p-muted);font-size:13px;line-height:1.6;margin:0}.activity-meta,.content-meta{font-size:12px;color:#9A8882;margin-top:9px}.profile-content-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}.content-card{background:#fff;border:1px solid var(--p-border);border-radius:20px;padding:19px;text-decoration:none;color:inherit;transition:.2s}.profile-side-card{background:#fff;border:1px solid var(--p-border);border-radius:22px;padding:20px}.profile-side-card p{color:var(--p-muted);font-size:13px;line-height:1.7;margin:8px 0 0}.stat-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:14px}.stat-grid div{padding:14px;border-radius:15px;background:#FFF8F3}.stat-grid strong{display:block;font-family:'Plus Jakarta Sans',sans-serif;color:var(--p-brown);font-size:20px}.stat-grid span{font-size:11px;color:var(--p-muted)}.about-panel{background:#fff;border:1px solid var(--p-border);border-radius:22px;overflow:hidden}.about-row{display:grid;grid-template-columns:150px 1fr;gap:20px;padding:17px 20px;border-bottom:1px solid var(--p-border)}.about-row:last-child{border-bottom:0}.about-row>span{font-weight:800;color:var(--p-brown)}.about-row p{margin:0;color:var(--p-muted);line-height:1.65}.profile-empty{background:#fff;border:1px dashed var(--p-border);border-radius:20px;padding:32px;color:var(--p-muted);text-align:center}.profile-dialog{border:0;padding:0;border-radius:24px;width:min(560px,calc(100% - 30px));max-height:88vh;overflow:auto;box-shadow:0 30px 80px rgba(48,18,10,.25);margin:auto}.profile-dialog::backdrop{background:rgba(48,18,10,.45);backdrop-filter:blur(3px)}.dialog-card{background:#fff;padding:24px}.dialog-card-wide{width:100%}.dialog-head{display:flex;align-items:flex-start;justify-content:space-between;gap:20px;margin-bottom:20px}.dialog-head span{font-size:10px;text-transform:uppercase;letter-spacing:.12em;color:var(--p-orange);font-weight:900}.dialog-head h3{font-family:'Plus Jakarta Sans',sans-serif;color:var(--p-brown);font-size:24px;margin:2px 0 0}.dialog-head button{width:36px;height:36px;border-radius:999px;background:var(--p-linen);color:var(--p-brown);cursor:pointer}.dialog-section{display:flex;flex-direction:column;gap:13px}.dialog-section h4{margin:0;color:var(--p-brown)}.dialog-section p{margin:0;color:var(--p-muted);font-size:12px}.dialog-divider{height:1px;background:var(--p-border);margin:22px 0}.avatar-preset-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:8px}.avatar-preset-option,.cover-preset-option{cursor:pointer;text-align:center}.avatar-preset-option input,.cover-preset-option input{position:absolute;opacity:0;pointer-events:none}.avatar-preset-swatch{width:58px;height:58px;border-radius:999px;display:flex;align-items:center;justify-content:center;margin:0 auto 6px;font-weight:900;border:3px solid transparent}.avatar-preset-option input:checked+.avatar-preset-swatch,.cover-preset-option input:checked+.cover-preset-swatch{border-color:var(--p-orange);box-shadow:0 0 0 3px rgba(251,77,0,.10)}.avatar-preset-botticelli{background:linear-gradient(135deg,#CAE7F7,#8FC6DE);color:#49261D}.avatar-preset-linen{background:linear-gradient(135deg,#FFEDE3,#FFCBB7);color:#49261D}.avatar-preset-tangelo{background:linear-gradient(135deg,#FB4D00,#FF8C5A);color:#fff}.avatar-preset-sage{background:linear-gradient(135deg,#DDF4E7,#9FD0B3);color:#315B43}.avatar-preset-chocolate{background:linear-gradient(135deg,#49261D,#7D4A3D);color:#fff}.avatar-preset-option small,.cover-preset-option small{display:block;color:var(--p-muted);font-size:10px}.cover-preset-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:10px}.cover-preset-swatch{height:78px;display:block;border-radius:14px;border:3px solid transparent;margin-bottom:5px}.cover-preset-jeda-blue{background:linear-gradient(135deg,#CAE7F7,#FFEDE3)}.cover-preset-linen-wave{background:radial-gradient(circle at 20% 30%,rgba(251,77,0,.25) 0 16%,transparent 17%),linear-gradient(135deg,#FFF8F4,#FFEDE3)}.cover-preset-tangelo-dawn{background:linear-gradient(120deg,#FB4D00,#FF9B70,#FFD6C4)}.cover-preset-brown-study{background:linear-gradient(135deg,#30120A,#49261D,#7D4A3D)}.cover-preset-sage-notes{background:linear-gradient(135deg,#DDF4E7,#B9DEC7,#CAE7F7)}.dialog-file{padding:12px;background:#FFF8F3;border:1px dashed var(--p-border);border-radius:14px}.dialog-primary{align-self:flex-start;padding:11px 16px;border:0;border-radius:999px;background:var(--p-orange);color:#fff;font-weight:800;cursor:pointer}.dialog-remove-form{margin-top:15px}.dialog-remove-form button{background:transparent;color:#A03A1B;text-decoration:underline;cursor:pointer}.details-form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}.details-form-grid label{display:flex;flex-direction:column;gap:6px}.details-form-grid label>span{font-size:12px;font-weight:800;color:var(--p-brown)}.details-form-grid input[type=text],.details-form-grid textarea{border:1px solid var(--p-border);border-radius:14px;padding:12px 13px;outline:none;background:#FFFCFA;color:var(--p-brown)}.details-full{grid-column:1/-1}.privacy-toggle{flex-direction:row!important;align-items:flex-start;gap:10px!important;padding:14px;border-radius:14px;background:#FFF8F3}.privacy-toggle input[type=checkbox]{margin-top:4px}.privacy-toggle span{display:block}.privacy-toggle small{display:block;font-weight:500;color:var(--p-muted);margin-top:3px}.details-form-grid+.dialog-primary{margin-top:18px}
        @media(max-width:850px){.profile-cover-wrap{height:205px}.profile-identity-area{padding:0 20px 22px}.identity-top-row{align-items:flex-start;flex-direction:column}.profile-actions{margin-left:150px;margin-top:-50px}.profile-grid{grid-template-columns:1fr}.profile-side-column{display:grid;grid-template-columns:1fr 1fr}.profile-content-grid{grid-template-columns:1fr}}
        @media(max-width:600px){.profile-page{padding-top:18px}.profile-shell{width:min(100% - 20px,1180px)}.profile-cover-wrap{height:165px}.profile-avatar-ring{width:116px;height:116px}.profile-avatar-ring .interlude-user-avatar{width:104px!important;height:104px!important}.identity-top-row{margin-top:-55px}.profile-actions{margin:10px 0 0;width:100%}.profile-primary-button,.profile-secondary-button{flex:1;justify-content:center}.profile-name-row{margin-top:16px}.profile-name-row h1{font-size:28px}.profile-tabs{padding:0 8px}.profile-tab{padding:13px 12px}.profile-side-column{grid-template-columns:1fr}.about-row{grid-template-columns:1fr;gap:5px}.avatar-preset-grid{grid-template-columns:repeat(3,1fr)}.details-form-grid{grid-template-columns:1fr}.details-full{grid-column:auto}.cover-edit-button{top:12px;right:12px;padding:8px 11px;font-size:12px}}
    </style>

    <script>
        const profileCsrf = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

        function openProfileDialog(id) {
            const dialog = document.getElementById(id);
            if (dialog && typeof dialog.showModal === 'function') dialog.showModal();
        }

        function closeProfileDialog(id) {
            const dialog = document.getElementById(id);
            if (dialog) dialog.close();
        }

        document.querySelectorAll('.profile-dialog').forEach((dialog) => {
            dialog.addEventListener('click', (event) => {
                if (event.target === dialog) dialog.close();
            });
        });

        async function toggleProfileFollow(userId, button) {
            const icon = button.querySelector('i');
            const label = button.querySelector('span');
            button.disabled = true;

            try {
                const response = await fetch(`{{ url('/users') }}/${userId}/follow`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': profileCsrf,
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) throw new Error('Follow request failed');
                const data = await response.json();

                button.classList.toggle('is-following', data.following);
                label.textContent = data.following ? 'Mengikuti' : 'Ikuti';
                icon.className = data.following ? 'fa-solid fa-check' : 'fa-solid fa-user-plus';
            } catch (error) {
                console.error(error);
            } finally {
                button.disabled = false;
            }
        }

        async function shareProfile() {
            const shareData = { title: @json($user->name . ' di Interlude'), url: window.location.href };
            if (navigator.share) {
                try { await navigator.share(shareData); return; } catch (e) {}
            }
            try {
                await navigator.clipboard.writeText(window.location.href);
                alert('Tautan profil disalin.');
            } catch (e) {
                prompt('Salin tautan profil:', window.location.href);
            }
        }
    </script>
</x-app-layout>
