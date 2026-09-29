<x-app-layout>
<style>
.podcast-detail{--orange:#FB4D00;--brown:#49261D;--linen:#FFEDE3;--blue:#CAE7F7;--border:#E8DCD6;--muted:#806C64;min-height:100vh;background:#FFF9F4;color:#30120A;font-family:'DM Sans',sans-serif}
.pd-shell{width:min(1050px,calc(100% - 30px));margin:auto;padding:40px 0 70px}.pd-back{display:inline-block;margin-bottom:20px;color:var(--brown);font-size:10px;font-weight:800;text-decoration:none}
.pd-card{display:grid;grid-template-columns:minmax(280px,.8fr) minmax(0,1.2fr);overflow:hidden;border:1px solid var(--border);border-radius:28px;background:#fff;box-shadow:0 18px 45px rgba(73,38,29,.07)}
.pd-visual{min-height:430px;background:linear-gradient(145deg,var(--blue),var(--linen));position:relative;overflow:hidden}.pd-visual img{width:100%;height:100%;object-fit:cover}.pd-body{padding:35px}.pd-type{color:var(--orange);font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:1px}.pd-body h1{margin:8px 0 10px;font:800 clamp(29px,4vw,46px)/1.06 'Plus Jakarta Sans';letter-spacing:-1.4px}.pd-desc{color:var(--muted);font-size:12px;line-height:1.7}.pd-meta{margin:17px 0 22px;display:flex;flex-wrap:wrap;gap:9px;color:var(--muted);font-size:9px}
.pd-player{margin-top:20px;padding:14px;border-radius:18px;background:#F8F3EF}.pd-player audio,.pd-player video{display:block;width:100%}.pd-player video{max-height:420px;border-radius:12px;background:#111}
.pd-transcript{margin-top:34px;padding:26px;border:1px solid var(--border);border-radius:23px;background:#fff}.pd-transcript h2{margin:0 0 12px;font:800 22px 'Plus Jakarta Sans'}.pd-transcript div{color:#5F4C45;font-size:12px;line-height:1.8;white-space:pre-line}
.pd-related{margin-top:35px}.pd-related h2{font:800 23px 'Plus Jakarta Sans'}.pd-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:13px}.pd-related-card{padding:17px;border:1px solid var(--border);border-radius:18px;background:#fff;text-decoration:none;color:inherit}.pd-related-card span{color:var(--orange);font-size:8px;font-weight:800;text-transform:uppercase}.pd-related-card strong{display:block;margin-top:7px;font:800 14px/1.3 'Plus Jakarta Sans'}
@media(max-width:760px){.pd-card{grid-template-columns:1fr}.pd-visual{min-height:280px}.pd-grid{grid-template-columns:1fr}.pd-body{padding:23px}}
</style>
<main class="podcast-detail">
<div class="pd-shell">
<a class="pd-back" href="{{ route('podcasts.index') }}">← Kembali ke Podcast</a>

<article class="pd-card">
<div class="pd-visual">
@php($visual = $podcast->thumbnail_image ?: $podcast->cover_image)
@if($visual)
<img src="{{ asset('storage/'.$visual) }}" alt="{{ $podcast->title }}">
@endif
</div>

<div class="pd-body">
<span class="pd-type">{{ $podcast->media_type === 'video' ? '🎥 Podcast Video' : '🎧 Podcast Audio' }}</span>
<h1>{{ $podcast->title }}</h1>
<p class="pd-desc">{{ $podcast->description }}</p>

<div class="pd-meta">
<span>{{ $podcast->user->name }}</span>
<span>•</span>
<span>{{ $podcast->formatted_duration }}</span>
@if($podcast->category)<span>•</span><span>{{ $podcast->category }}</span>@endif
@if($podcast->series)<span>•</span><span>{{ $podcast->series->title }}</span>@endif
</div>

<div class="pd-player">
@if($podcast->media_type === 'video')
<video controls preload="metadata" poster="{{ $podcast->cover_image ? asset('storage/'.$podcast->cover_image) : '' }}">
<source src="{{ asset('storage/'.$podcast->media_path) }}">
Browser kamu tidak mendukung video HTML5.
</video>
@else
<audio controls preload="metadata">
<source src="{{ asset('storage/'.$podcast->media_path) }}">
Browser kamu tidak mendukung audio HTML5.
</audio>
@endif
</div>
</div>
</article>

@if($podcast->transcript)
<section class="pd-transcript">
<h2>Transkrip</h2>
<div>{{ $podcast->transcript }}</div>
</section>
@endif

@if($relatedEpisodes->isNotEmpty())
<section class="pd-related">
<h2>Episode terkait</h2>
<div class="pd-grid">
@foreach($relatedEpisodes as $item)
<a class="pd-related-card" href="{{ route('podcasts.show',$item) }}">
<span>{{ $item->media_type }}</span>
<strong>{{ $item->title }}</strong>
</a>
@endforeach
</div>
</section>
@endif
</div>
</main>
</x-app-layout>
