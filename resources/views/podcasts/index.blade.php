<x-app-layout>
<style>
.podcast-hub{
    --paper:#FDF8F4;
    --white:#FFFFFF;
    --cream:#F8F3EF;
    --cream-2:#F2EDE9;
    --line:#E5D8D2;
    --brown:#49261D;
    --brown-2:#30120A;
    --orange:#FB4D00;
    --orange-soft:#FFDBD0;
    --blue:#CAE7F7;
    --blue-dark:#17333F;
    --muted:#76635D;
    min-height:100vh;
    background:var(--paper);
    color:var(--brown-2);
    font-family:'DM Sans',sans-serif;
}
.ph-shell{width:min(1180px,calc(100% - 34px));margin:auto;padding:34px 0 76px}
.ph-top{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;margin-bottom:22px}
.ph-kicker{display:flex;align-items:center;gap:7px;color:var(--orange);font:800 10px 'Plus Jakarta Sans';letter-spacing:1.2px;text-transform:uppercase}
.ph-top h1{margin:7px 0 6px;font:800 clamp(34px,5vw,54px)/1.03 'Plus Jakarta Sans';letter-spacing:-2px}
.ph-top p{margin:0;max-width:640px;color:var(--muted);font-size:13px;line-height:1.65}
.ph-create{flex:0 0 auto;min-height:44px;padding:0 19px;display:inline-flex;align-items:center;gap:8px;border-radius:999px;background:var(--orange);color:#fff;text-decoration:none;font:800 11px 'Plus Jakarta Sans';box-shadow:0 9px 25px rgba(251,77,0,.16)}

.ph-modebar{display:flex;justify-content:space-between;align-items:center;gap:16px;padding:10px 12px;border:1px solid var(--line);border-radius:20px;background:rgba(255,255,255,.78);box-shadow:0 8px 30px rgba(73,38,29,.04)}
.ph-modes{display:flex;gap:5px}.ph-mode{padding:10px 15px;border-radius:999px;color:var(--muted);text-decoration:none;font:800 10px 'Plus Jakarta Sans';display:flex;align-items:center;gap:7px}.ph-mode.active{background:var(--brown);color:#fff}.ph-mode em{font-style:normal;opacity:.62;font-size:8px}
.ph-mode-note{color:var(--muted);font-size:9px}

.ph-filters{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:12px;margin:18px 0 30px}
.ph-search{position:relative}.ph-search input{width:100%;box-sizing:border-box;height:48px;padding:0 48px 0 43px;border:1px solid var(--line);border-radius:15px;background:#fff;color:var(--brown-2);outline:none;font:500 11px 'DM Sans'}.ph-search i{position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#9A8882}
.ph-filter-row{display:flex;gap:7px;align-items:center}.ph-filter-row select,.ph-filter-row button{height:48px;border:1px solid var(--line);border-radius:15px;background:#fff;color:var(--brown);padding:0 14px;font:700 10px 'DM Sans'}.ph-filter-row button{background:var(--brown);color:#fff;cursor:pointer}

.ph-category-row{display:flex;gap:7px;overflow-x:auto;padding-bottom:4px;margin-top:-17px;margin-bottom:30px;scrollbar-width:none}.ph-category-row::-webkit-scrollbar{display:none}.ph-category{white-space:nowrap;padding:8px 12px;border:1px solid var(--line);border-radius:999px;background:#fff;color:var(--muted);text-decoration:none;font-size:9px;font-weight:700}.ph-category.active{border-color:var(--orange);background:var(--orange-soft);color:#842500}

.ph-feature-wrap{margin-bottom:40px}.ph-section-label{color:var(--orange);font:800 9px 'Plus Jakarta Sans';letter-spacing:1.05px;text-transform:uppercase}.ph-section-title{margin:5px 0 15px;font:800 26px 'Plus Jakarta Sans';letter-spacing:-.8px}
.ph-feature{display:grid;grid-template-columns:minmax(0,.95fr) minmax(0,1.05fr);min-height:350px;overflow:hidden;border:1px solid var(--line);border-radius:27px;background:#fff;box-shadow:0 15px 45px rgba(73,38,29,.07)}
.ph-feature-media{position:relative;min-height:350px;background:linear-gradient(145deg,var(--blue),#E9E7E3);overflow:hidden}.ph-feature-media img{width:100%;height:100%;object-fit:cover}.ph-feature-media.video::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,transparent 50%,rgba(48,18,10,.42))}
.ph-feature-badge{position:absolute;left:16px;top:16px;z-index:2;padding:7px 10px;border-radius:999px;background:rgba(255,255,255,.94);color:var(--brown);font:800 8px 'Plus Jakarta Sans';text-transform:uppercase;letter-spacing:.7px}
.ph-feature-play{position:absolute;z-index:3;left:50%;top:50%;transform:translate(-50%,-50%);width:62px;height:62px;border-radius:50%;display:grid;place-items:center;background:var(--orange);color:#fff;text-decoration:none;box-shadow:0 12px 28px rgba(251,77,0,.27);font-size:18px}
.ph-audio-cover{position:absolute;inset:34px;display:grid;place-items:center}.ph-audio-art{width:min(260px,76%);aspect-ratio:1;border-radius:26px;overflow:hidden;background:var(--brown);box-shadow:0 24px 46px rgba(73,38,29,.2)}.ph-audio-art img{width:100%;height:100%;object-fit:cover}.ph-audio-art-fallback{width:100%;height:100%;display:grid;place-items:center;color:#fff;font-size:52px;background:linear-gradient(145deg,var(--brown),var(--blue-dark))}
.ph-feature-info{padding:36px;display:flex;flex-direction:column;justify-content:center}.ph-feature-type{display:flex;align-items:center;gap:7px;color:var(--orange);font:800 9px 'Plus Jakarta Sans';text-transform:uppercase;letter-spacing:.9px}.ph-feature-info h2{margin:10px 0 10px;font:800 clamp(27px,4vw,42px)/1.06 'Plus Jakarta Sans';letter-spacing:-1.4px}.ph-feature-info p{margin:0;color:var(--muted);font-size:12px;line-height:1.72}.ph-meta{display:flex;flex-wrap:wrap;gap:9px;margin-top:17px;color:#8B7871;font-size:9px}.ph-feature-cta{margin-top:22px;width:max-content;padding:12px 17px;border-radius:999px;background:var(--brown);color:#fff;text-decoration:none;font:800 10px 'Plus Jakarta Sans';display:flex;align-items:center;gap:8px}
.ph-wave{height:44px;display:flex;align-items:center;gap:3px;margin-top:21px}.ph-wave span{width:4px;border-radius:999px;background:var(--orange);opacity:.75}

.ph-results-head{display:flex;align-items:end;justify-content:space-between;gap:16px;margin-bottom:15px}.ph-results-head h2{margin:5px 0 0;font:800 26px 'Plus Jakarta Sans';letter-spacing:-.8px}.ph-results-head span:last-child{color:var(--muted);font-size:9px}
.ph-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:15px}
.ph-card{border:1px solid var(--line);border-radius:21px;background:#fff;overflow:hidden;text-decoration:none;color:inherit;transition:.18s ease}.ph-card:hover{transform:translateY(-2px);box-shadow:0 13px 34px rgba(73,38,29,.07)}
.ph-video-card{display:grid;grid-template-columns:215px minmax(0,1fr);min-height:152px}.ph-video-thumb{position:relative;min-height:152px;background:linear-gradient(145deg,#DCEEF8,#DAD5D1);overflow:hidden}.ph-video-thumb img{width:100%;height:100%;object-fit:cover}.ph-video-thumb .play{position:absolute;left:14px;bottom:14px;width:38px;height:38px;border-radius:50%;display:grid;place-items:center;background:var(--orange);color:#fff}.ph-duration{position:absolute;right:10px;bottom:10px;padding:4px 7px;border-radius:999px;background:rgba(48,18,10,.78);color:#fff;font-size:8px;font-weight:800}
.ph-card-body{padding:17px;min-width:0}.ph-card-label{display:flex;align-items:center;justify-content:space-between;gap:10px;color:var(--orange);font:800 8px 'Plus Jakarta Sans';text-transform:uppercase;letter-spacing:.7px}.ph-card h3{margin:8px 0 7px;font:800 16px/1.28 'Plus Jakarta Sans';letter-spacing:-.35px}.ph-card p{margin:0;color:var(--muted);font-size:9.5px;line-height:1.55}.ph-card-foot{display:flex;justify-content:space-between;gap:10px;margin-top:13px;padding-top:11px;border-top:1px solid #F0E8E4;color:#8B7871;font-size:8px}
.ph-audio-card{display:grid;grid-template-columns:142px minmax(0,1fr);min-height:142px}.ph-audio-thumb{position:relative;background:linear-gradient(145deg,var(--blue),var(--orange-soft));padding:14px}.ph-audio-thumb-inner{width:100%;height:100%;border-radius:17px;overflow:hidden;background:var(--brown);display:grid;place-items:center;color:#fff;font-size:30px}.ph-audio-thumb img{width:100%;height:100%;object-fit:cover}.ph-audio-play{position:absolute;right:9px;bottom:9px;width:34px;height:34px;border-radius:50%;display:grid;place-items:center;background:var(--orange);color:#fff;border:3px solid #fff}
.ph-empty{grid-column:1/-1;padding:55px 20px;border:1px dashed #D8C7C0;border-radius:24px;background:#fff;text-align:center}.ph-empty i{font-size:25px;color:var(--orange)}.ph-empty h3{font:800 17px 'Plus Jakarta Sans';margin:10px 0 4px}.ph-empty p{margin:0;color:var(--muted);font-size:10px}

.ph-series{margin-top:44px}.ph-series-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}.ph-series-card{padding:20px;min-height:120px;border-radius:20px;background:var(--brown);color:#fff}.ph-series-card:nth-child(2n){background:var(--blue-dark)}.ph-series-card:nth-child(3n){background:#A94728}.ph-series-card small{opacity:.65;font-size:8px;text-transform:uppercase;font-weight:800}.ph-series-card h3{margin:10px 0 5px;font:800 17px 'Plus Jakarta Sans'}.ph-series-card p{margin:0;opacity:.66;font-size:9px;line-height:1.5}
.ph-pagination{margin-top:25px}

@media(max-width:900px){
 .ph-feature{grid-template-columns:1fr}.ph-feature-media{min-height:300px}.ph-grid{grid-template-columns:1fr}.ph-series-grid{grid-template-columns:repeat(2,1fr)}
 .ph-filters{grid-template-columns:1fr}.ph-filter-row{flex-wrap:wrap}
}
@media(max-width:650px){
 .ph-shell{width:min(100% - 22px,1180px);padding-top:24px}.ph-top{align-items:flex-start;flex-direction:column}.ph-top h1{font-size:38px}.ph-modebar{align-items:flex-start;flex-direction:column}.ph-mode-note{display:none}.ph-modes{width:100%}.ph-mode{flex:1;justify-content:center}
 .ph-feature-info{padding:24px}.ph-video-card{grid-template-columns:130px minmax(0,1fr)}.ph-audio-card{grid-template-columns:110px minmax(0,1fr)}.ph-series-grid{grid-template-columns:1fr}
}
</style>

<main class="podcast-hub">
<div class="ph-shell">

<header class="ph-top">
    <div>
        <span class="ph-kicker"><i class="fas fa-wave-square"></i> Podcast Interlude</span>
        <h1>Ruang dengar &amp; tonton.</h1>
        <p>Obrolan mahasiswa yang bisa kamu nikmati sebagai podcast audio atau video. Pilih format yang paling pas buat jedamu.</p>
    </div>

    <a class="ph-create" href="{{ route('podcasts.create') }}">
        <i class="fas fa-plus"></i>
        Buat Podcast
    </a>
</header>

<div class="ph-modebar">
    <div class="ph-modes">
        <a href="{{ route('podcasts.index', array_filter(['q'=>$search,'duration'=>$duration !== 'all' ? $duration : null,'category'=>$category !== 'all' ? $category : null])) }}"
           class="ph-mode {{ $type === 'all' ? 'active' : '' }}">
            Semua
        </a>

        <a href="{{ route('podcasts.index', array_filter(['type'=>'audio','q'=>$search,'duration'=>$duration !== 'all' ? $duration : null,'category'=>$category !== 'all' ? $category : null])) }}"
           class="ph-mode {{ $type === 'audio' ? 'active' : '' }}">
            <i class="fas fa-headphones"></i> Audio <em>{{ $audioCount }}</em>
        </a>

        <a href="{{ route('podcasts.index', array_filter(['type'=>'video','q'=>$search,'duration'=>$duration !== 'all' ? $duration : null,'category'=>$category !== 'all' ? $category : null])) }}"
           class="ph-mode {{ $type === 'video' ? 'active' : '' }}">
            <i class="fas fa-video"></i> Video <em>{{ $videoCount }}</em>
        </a>
    </div>

    <span class="ph-mode-note">
        Audio untuk didengar · Video untuk ditonton
    </span>
</div>

<form class="ph-filters" method="GET" action="{{ route('podcasts.index') }}">
    @if($type !== 'all')
        <input type="hidden" name="type" value="{{ $type }}">
    @endif

    @if($category !== 'all')
        <input type="hidden" name="category" value="{{ $category }}">
    @endif

    <div class="ph-search">
        <i class="fas fa-search"></i>
        <input
            type="text"
            name="q"
            value="{{ $search }}"
            placeholder="Cari obrolan: skripsi, magang, organisasi, riset..."
        >
    </div>

    <div class="ph-filter-row">
        <select name="duration">
            <option value="all" {{ $duration === 'all' ? 'selected' : '' }}>Semua durasi</option>
            <option value="short" {{ $duration === 'short' ? 'selected' : '' }}>&lt; 15 menit</option>
            <option value="medium" {{ $duration === 'medium' ? 'selected' : '' }}>15–30 menit</option>
            <option value="long" {{ $duration === 'long' ? 'selected' : '' }}>&gt; 30 menit</option>
        </select>

        <button type="submit">Terapkan</button>
    </div>
</form>

<div class="ph-category-row">
    <a
        href="{{ route('podcasts.index', array_filter(['type'=>$type !== 'all' ? $type : null,'q'=>$search,'duration'=>$duration !== 'all' ? $duration : null])) }}"
        class="ph-category {{ $category === 'all' ? 'active' : '' }}"
    >
        Semua topik
    </a>

    @foreach($categories as $categoryName)
        <a
            href="{{ route('podcasts.index', array_filter(['type'=>$type !== 'all' ? $type : null,'q'=>$search,'duration'=>$duration !== 'all' ? $duration : null,'category'=>$categoryName])) }}"
            class="ph-category {{ $category === $categoryName ? 'active' : '' }}"
        >
            {{ $categoryName }}
        </a>
    @endforeach
</div>

@if($featuredEpisode)
<section class="ph-feature-wrap">
    <span class="ph-section-label">Pilihan Interlude</span>
    <h2 class="ph-section-title">{{ $featuredEpisode->media_type === 'video' ? 'Video yang sedang ramai' : 'Dengarkan saat jeda' }}</h2>

    <article class="ph-feature">
        <div class="ph-feature-media {{ $featuredEpisode->media_type }}">
            @if($featuredEpisode->media_type === 'video')
                @php($featuredVisual = $featuredEpisode->thumbnail_image ?: $featuredEpisode->cover_image)

                @if($featuredVisual)
                    <img src="{{ asset('storage/'.$featuredVisual) }}" alt="{{ $featuredEpisode->title }}">
                @endif

                <span class="ph-feature-badge">
                    <i class="fas fa-video"></i> Video Podcast
                </span>

                <a class="ph-feature-play" href="{{ route('podcasts.show',$featuredEpisode) }}">
                    <i class="fas fa-play"></i>
                </a>
            @else
                <span class="ph-feature-badge">
                    <i class="fas fa-headphones"></i> Podcast Audio
                </span>

                <div class="ph-audio-cover">
                    <div class="ph-audio-art">
                        @if($featuredEpisode->cover_image)
                            <img src="{{ asset('storage/'.$featuredEpisode->cover_image) }}" alt="{{ $featuredEpisode->title }}">
                        @else
                            <div class="ph-audio-art-fallback"><i class="fas fa-microphone"></i></div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="ph-feature-info">
            <span class="ph-feature-type">
                <i class="fas {{ $featuredEpisode->media_type === 'video' ? 'fa-video' : 'fa-headphones' }}"></i>
                {{ $featuredEpisode->category ?: 'Podcast Interlude' }}
                @if($featuredEpisode->episode_number)
                    · Episode {{ $featuredEpisode->episode_number }}
                @endif
            </span>

            <h2>{{ $featuredEpisode->title }}</h2>

            <p>{{ \Illuminate\Support\Str::limit($featuredEpisode->description,210) }}</p>

            <div class="ph-meta">
                <span>{{ $featuredEpisode->user->name }}</span>
                <span>•</span>
                <span>{{ $featuredEpisode->formatted_duration }}</span>
                <span>•</span>
                <span>{{ number_format($featuredEpisode->views_count) }} diputar</span>
            </div>

            @if($featuredEpisode->media_type === 'audio')
                <div class="ph-wave" aria-hidden="true">
                    @foreach([32,52,78,44,88,61,37,92,70,49,82,58,41,74,96,64,51,85,43,68,90,55,73,39,60,81,45,71,50,87,34,63,77,48,69,91,54,80] as $height)
                        <span style="height:{{ $height }}%"></span>
                    @endforeach
                </div>
            @endif

            <a class="ph-feature-cta" href="{{ route('podcasts.show',$featuredEpisode) }}">
                <i class="fas fa-play"></i>
                {{ $featuredEpisode->media_type === 'video' ? 'Tonton sekarang' : 'Dengarkan sekarang' }}
            </a>
        </div>
    </article>
</section>
@endif

<section>
    <div class="ph-results-head">
        <div>
            <span class="ph-section-label">
                {{ $type === 'audio' ? 'Audio Room' : ($type === 'video' ? 'Video Studio' : 'Episode terbaru') }}
            </span>
            <h2>
                {{ $type === 'audio' ? 'Untuk didengarkan' : ($type === 'video' ? 'Untuk ditonton' : 'Terbaru untuk jedamu') }}
            </h2>
        </div>

        <span>{{ $episodes->total() }} episode</span>
    </div>

    <div class="ph-grid">
        @forelse($episodes as $episode)

            @if($episode->media_type === 'video')
                <a href="{{ route('podcasts.show',$episode) }}" class="ph-card ph-video-card">
                    <div class="ph-video-thumb">
                        @php($videoVisual = $episode->thumbnail_image ?: $episode->cover_image)

                        @if($videoVisual)
                            <img src="{{ asset('storage/'.$videoVisual) }}" alt="{{ $episode->title }}">
                        @endif

                        <span class="play"><i class="fas fa-play"></i></span>
                        <span class="ph-duration">{{ $episode->formatted_duration }}</span>
                    </div>

                    <div class="ph-card-body">
                        <div class="ph-card-label">
                            <span><i class="fas fa-video"></i> Video</span>
                            @if($episode->episode_number)<span>EP. {{ $episode->episode_number }}</span>@endif
                        </div>

                        <h3>{{ $episode->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($episode->description,92) }}</p>

                        <div class="ph-card-foot">
                            <span>{{ $episode->user->name }}</span>
                            <span>{{ number_format($episode->views_count) }} tontonan</span>
                        </div>
                    </div>
                </a>
            @else
                <a href="{{ route('podcasts.show',$episode) }}" class="ph-card ph-audio-card">
                    <div class="ph-audio-thumb">
                        <div class="ph-audio-thumb-inner">
                            @if($episode->cover_image)
                                <img src="{{ asset('storage/'.$episode->cover_image) }}" alt="{{ $episode->title }}">
                            @else
                                <i class="fas fa-headphones"></i>
                            @endif
                        </div>

                        <span class="ph-audio-play"><i class="fas fa-play"></i></span>
                    </div>

                    <div class="ph-card-body">
                        <div class="ph-card-label">
                            <span><i class="fas fa-headphones"></i> Audio</span>
                            <span>{{ $episode->formatted_duration }}</span>
                        </div>

                        <h3>{{ $episode->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($episode->description,92) }}</p>

                        <div class="ph-card-foot">
                            <span>{{ $episode->user->name }}</span>
                            <span>{{ number_format($episode->views_count) }} diputar</span>
                        </div>
                    </div>
                </a>
            @endif

        @empty
            <div class="ph-empty">
                <i class="fas fa-headphones"></i>
                <h3>Belum ada episode yang cocok</h3>
                <p>Coba ubah format, durasi, kategori, atau kata pencarianmu.</p>
            </div>
        @endforelse
    </div>

    @if($episodes->hasPages())
        <div class="ph-pagination">
            {{ $episodes->links() }}
        </div>
    @endif
</section>

@if($series->isNotEmpty())
<section class="ph-series">
    <span class="ph-section-label">Series</span>
    <h2 class="ph-section-title">Ikuti obrolannya dari awal.</h2>

    <div class="ph-series-grid">
        @foreach($series as $podcastSeries)
            <article class="ph-series-card">
                <small>{{ $podcastSeries->published_episodes_count }} episode</small>
                <h3>{{ $podcastSeries->title }}</h3>
                <p>{{ \Illuminate\Support\Str::limit($podcastSeries->description,95) }}</p>
            </article>
        @endforeach
    </div>
</section>
@endif

</div>
</main>
</x-app-layout>
