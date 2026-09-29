<x-app-layout>
<style>
:root{--linen:#FFEDE3;--orange:#FB4D00;--brown:#49261D;--blue:#CAE7F7;--cream:#FFF9F4;--ink:#30120A;--muted:#806C64;--border:#E8DCD6}
.podcast-page{min-height:100vh;background:radial-gradient(circle at 8% 3%,rgba(202,231,247,.42),transparent 23%),linear-gradient(180deg,#FFFDFC,#FFF9F4);color:var(--ink);font-family:'DM Sans',sans-serif}
.podcast-shell{width:min(1180px,calc(100% - 36px));margin:auto;padding:42px 0 70px}
.podcast-hero{position:relative;overflow:hidden;min-height:300px;padding:42px;display:grid;grid-template-columns:minmax(0,1fr) 330px;align-items:center;gap:30px;border:1px solid var(--border);border-radius:32px;background:var(--brown);color:#fff;box-shadow:0 20px 50px rgba(73,38,29,.12)}
.hero-kicker,.section-kicker{display:inline-flex;align-items:center;gap:7px;font-size:10px;font-weight:800;letter-spacing:1.4px;text-transform:uppercase}.hero-kicker{color:#FFD1BC}
.podcast-hero h1{max-width:690px;margin:13px 0;font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(36px,5vw,64px);line-height:.98;letter-spacing:-2.6px;font-weight:800}
.podcast-hero p{max-width:610px;margin:0;color:rgba(255,255,255,.72);font-size:14px;line-height:1.7}
.hero-format-stack{display:grid;gap:12px}.format-chip{padding:17px 18px;display:flex;align-items:center;gap:13px;border:1px solid rgba(255,255,255,.15);border-radius:18px;background:rgba(255,255,255,.09)}
.format-chip i{width:38px;height:38px;display:grid;place-items:center;border-radius:12px;background:var(--orange);color:#fff}.format-chip strong{display:block;font:800 13px 'Plus Jakarta Sans'}.format-chip span{display:block;margin-top:2px;color:rgba(255,255,255,.58);font-size:9px}
.podcast-filters{margin:26px 0 34px;padding:5px;display:inline-flex;gap:3px;border:1px solid var(--border);border-radius:999px;background:#fff}.podcast-filter{min-height:38px;padding:0 18px;display:inline-flex;align-items:center;gap:7px;border-radius:999px;color:var(--muted);text-decoration:none;font-size:11px;font-weight:800}.podcast-filter.is-active{background:var(--brown);color:#fff}
.section-head{margin-bottom:16px;display:flex;align-items:end;justify-content:space-between;gap:20px}.section-kicker{color:var(--orange)}.section-head h2{margin:4px 0 0;font:800 28px 'Plus Jakarta Sans';letter-spacing:-.8px}
.featured-episode{margin-bottom:42px;min-height:320px;display:grid;grid-template-columns:minmax(0,.95fr) minmax(0,1.05fr);overflow:hidden;border:1px solid var(--border);border-radius:28px;background:#fff}
.featured-cover{position:relative;min-height:320px;background:linear-gradient(145deg,var(--blue),var(--linen));overflow:hidden}.featured-cover img,.episode-media img{width:100%;height:100%;object-fit:cover}
.media-badge{position:absolute;top:18px;left:18px;min-height:30px;padding:0 11px;display:inline-flex;align-items:center;gap:6px;border-radius:999px;background:rgba(255,255,255,.92);color:var(--brown);font-size:9px;font-weight:800;text-transform:uppercase}
.featured-info{padding:38px;display:flex;flex-direction:column;justify-content:center}.featured-info .category{color:var(--orange);font-size:9px;font-weight:800;text-transform:uppercase}.featured-info h3{margin:9px 0 10px;font:800 clamp(27px,4vw,43px)/1.06 'Plus Jakarta Sans';letter-spacing:-1.4px}.featured-info p{margin:0;color:var(--muted);font-size:12px;line-height:1.7}.episode-meta{margin-top:22px;display:flex;gap:12px;color:var(--muted);font-size:9px}
.play-button{margin-top:23px;width:max-content;min-height:42px;padding:0 18px;display:inline-flex;align-items:center;gap:9px;border:0;border-radius:999px;background:var(--orange);color:#fff;font-size:10px;font-weight:800}
.episode-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:17px}.episode-card{overflow:hidden;border:1px solid var(--border);border-radius:22px;background:#fff;transition:.18s}.episode-card:hover{transform:translateY(-3px);box-shadow:0 14px 32px rgba(73,38,29,.08)}
.episode-media{position:relative;aspect-ratio:16/10;overflow:hidden;background:linear-gradient(145deg,var(--blue),var(--linen))}.episode-card.is-audio .episode-media{aspect-ratio:1/1}.episode-play{position:absolute;right:14px;bottom:14px;width:42px;height:42px;display:grid;place-items:center;border-radius:50%;background:var(--orange);color:#fff}.duration-pill{position:absolute;right:12px;top:12px;padding:5px 8px;border-radius:999px;background:rgba(48,18,10,.78);color:#fff;font-size:8px;font-weight:800}
.episode-body{padding:17px}.episode-kind{display:flex;justify-content:space-between;gap:8px;color:var(--orange);font-size:8px;font-weight:800;text-transform:uppercase}.episode-body h3{margin:8px 0 7px;font:800 16px/1.25 'Plus Jakarta Sans'}.episode-body p{margin:0;color:var(--muted);font-size:10px;line-height:1.55}.episode-footer{margin-top:15px;padding-top:12px;display:flex;justify-content:space-between;gap:10px;border-top:1px solid #F0E7E3;color:var(--muted);font-size:8px}
.empty-state{grid-column:1/-1;padding:55px 24px;text-align:center;border:1px dashed #DCCBC3;border-radius:24px;background:rgba(255,255,255,.66)}.empty-state i{width:48px;height:48px;margin:0 auto 13px;display:grid;place-items:center;border-radius:15px;background:var(--linen);color:var(--orange)}.empty-state h3{margin:0 0 6px;font:800 17px 'Plus Jakarta Sans'}.empty-state p{margin:0;color:var(--muted);font-size:10px}
.series-section{margin-top:46px}.series-row{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}.series-card{padding:20px;min-height:145px;border-radius:21px;background:var(--brown);color:#fff}.series-card:nth-child(2n){background:#17333F}.series-card:nth-child(3n){background:#B95F43}.series-card span{color:rgba(255,255,255,.60);font-size:8px;font-weight:800;text-transform:uppercase}.series-card h3{margin:12px 0 7px;font:800 19px 'Plus Jakarta Sans'}.series-card p{margin:0;color:rgba(255,255,255,.65);font-size:9px;line-height:1.5}
@media(max-width:900px){.podcast-hero,.featured-episode{grid-template-columns:1fr}.episode-grid,.series-row{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:620px){.podcast-shell{width:min(100% - 22px,1180px);padding-top:22px}.podcast-hero{padding:26px 22px}.episode-grid,.series-row{grid-template-columns:1fr}.podcast-filters{display:flex;width:100%}.podcast-filter{flex:1;justify-content:center}}
</style>

<main class="podcast-page">
<div class="podcast-shell">
<section class="podcast-hero">
<div>
<span class="hero-kicker"><i class="fas fa-headphones"></i> Podcast Interlude</span>
<h1>Dengar. Tonton.<br>Bawa pulang idenya.</h1>
<p>Cerita, pengalaman, dan pengetahuan mahasiswa dalam format yang lebih enak didengar—dan kadang lebih seru ditonton.</p>
</div>
<div class="hero-format-stack">
<div class="format-chip"><i class="fas fa-headphones"></i><div><strong>Podcast Audio</strong><span>Dengarkan sambil kuliah, perjalanan, atau istirahat.</span></div></div>
<div class="format-chip"><i class="fas fa-video"></i><div><strong>Podcast Video</strong><span>Untuk obrolan yang juga enak ditonton.</span></div></div>
</div>
</section>

<nav class="podcast-filters">
<a href="{{ route('podcasts.index') }}" class="podcast-filter {{ $type === 'all' ? 'is-active' : '' }}">Semua</a>
<a href="{{ route('podcasts.index',['type'=>'audio']) }}" class="podcast-filter {{ $type === 'audio' ? 'is-active' : '' }}"><i class="fas fa-headphones"></i>Audio</a>
<a href="{{ route('podcasts.index',['type'=>'video']) }}" class="podcast-filter {{ $type === 'video' ? 'is-active' : '' }}"><i class="fas fa-video"></i>Video</a>
</nav>

@if($featuredEpisode)
<section>
<div class="section-head"><div><span class="section-kicker">Pilihan Interlude</span><h2>Sedang ramai</h2></div></div>
<article class="featured-episode">
<div class="featured-cover">
@if($featuredEpisode->cover_image)<img src="{{ asset('storage/'.$featuredEpisode->cover_image) }}" alt="{{ $featuredEpisode->title }}">@endif
<span class="media-badge"><i class="fas {{ $featuredEpisode->media_type === 'video' ? 'fa-video' : 'fa-headphones' }}"></i>{{ $featuredEpisode->media_type }}</span>
</div>
<div class="featured-info">
<span class="category">{{ $featuredEpisode->category ?: 'Podcast Interlude' }}</span>
<h3>{{ $featuredEpisode->title }}</h3>
<p>{{ \Illuminate\Support\Str::limit($featuredEpisode->description,180) }}</p>
<div class="episode-meta"><span>{{ $featuredEpisode->user->name }}</span><span>•</span><span>{{ $featuredEpisode->formatted_duration }}</span>@if($featuredEpisode->series)<span>•</span><span>{{ $featuredEpisode->series->title }}</span>@endif</div>
<button type="button" class="play-button"><i class="fas fa-play"></i>{{ $featuredEpisode->media_type === 'video' ? 'Tonton episode' : 'Putar episode' }}</button>
</div>
</article>
</section>
@endif

<section>
<div class="section-head"><div><span class="section-kicker">Terbaru</span><h2>{{ $type === 'audio' ? 'Podcast audio' : ($type === 'video' ? 'Podcast video' : 'Episode terbaru') }}</h2></div></div>
<div class="episode-grid">
@forelse($episodes as $episode)
<article class="episode-card {{ $episode->media_type === 'audio' ? 'is-audio' : 'is-video' }}">
<div class="episode-media">
@php($visual = $episode->thumbnail_image ?: $episode->cover_image)
@if($visual)<img src="{{ asset('storage/'.$visual) }}" alt="{{ $episode->title }}">@endif
<span class="duration-pill">{{ $episode->formatted_duration }}</span><span class="episode-play"><i class="fas fa-play"></i></span>
</div>
<div class="episode-body">
<div class="episode-kind"><span><i class="fas {{ $episode->media_type === 'video' ? 'fa-video' : 'fa-headphones' }}"></i> {{ $episode->media_type }}</span>@if($episode->episode_number)<span>EP. {{ $episode->episode_number }}</span>@endif</div>
<h3>{{ $episode->title }}</h3>
<p>{{ \Illuminate\Support\Str::limit($episode->description,95) }}</p>
<footer class="episode-footer"><span>{{ $episode->user->name }}</span><span>{{ optional($episode->published_at)->diffForHumans() }}</span></footer>
</div>
</article>
@empty
<div class="empty-state"><i class="fas fa-headphones"></i><h3>Belum ada episode di sini</h3><p>Podcast audio dan video yang sudah dipublikasikan akan muncul di halaman ini.</p></div>
@endforelse
</div>
@if($episodes->hasPages())<div style="margin-top:28px">{{ $episodes->links() }}</div>@endif
</section>

@if($series->isNotEmpty())
<section class="series-section">
<div class="section-head"><div><span class="section-kicker">Koleksi episode</span><h2>Series untuk diikuti</h2></div></div>
<div class="series-row">
@foreach($series as $podcastSeries)
<article class="series-card"><span>{{ $podcastSeries->published_episodes_count }} episode</span><h3>{{ $podcastSeries->title }}</h3><p>{{ \Illuminate\Support\Str::limit($podcastSeries->description,90) }}</p></article>
@endforeach
</div>
</section>
@endif
</div>
</main>
</x-app-layout>
