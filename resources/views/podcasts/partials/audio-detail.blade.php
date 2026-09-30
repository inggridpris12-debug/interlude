<style>
.audio-room{
    --paper:#FDF8F4;--white:#fff;--cream:#F8F3EF;--cream2:#F2EDE9;--line:#E4D8D2;
    --brown:#49261D;--dark:#30120A;--orange:#FB4D00;--orange-soft:#FFDBD0;
    --blue:#CAE7F7;--blue-dark:#17333F;--muted:#75635D;
    min-height:100vh;background:var(--paper);color:var(--dark);font-family:'DM Sans',sans-serif
}
.ar-shell{width:min(1160px,calc(100% - 34px));margin:auto;padding:28px 0 80px}.ar-back{display:inline-flex;align-items:center;gap:7px;margin-bottom:18px;color:var(--muted);text-decoration:none;font-size:10px;font-weight:800}
.ar-context{display:flex;justify-content:space-between;align-items:center;gap:14px;margin-bottom:17px}.ar-badge{display:inline-flex;align-items:center;gap:7px;padding:8px 11px;border-radius:999px;background:var(--orange-soft);color:#842500;font:800 8px 'Plus Jakarta Sans';text-transform:uppercase;letter-spacing:.7px}.ar-format-link{padding:8px 12px;border-radius:999px;background:var(--cream2);color:var(--brown);text-decoration:none;font-size:9px;font-weight:800}
.ar-main{display:grid;grid-template-columns:minmax(0,7fr) minmax(310px,5fr);gap:18px;align-items:stretch}
.ar-player{position:relative;overflow:hidden;padding:28px;border:1px solid var(--line);border-radius:27px;background:#fff;box-shadow:0 16px 45px rgba(73,38,29,.07)}.ar-player:after{content:"";position:absolute;width:260px;height:260px;border-radius:50%;right:-100px;top:-100px;background:rgba(202,231,247,.45);filter:blur(8px)}
.ar-player-content{position:relative;z-index:1}.ar-topmeta{display:flex;justify-content:space-between;gap:12px;align-items:center}.ar-topmeta span{font-size:8px;font-weight:800;color:var(--muted)}.ar-title{margin:16px 0 8px;font:800 clamp(28px,4vw,43px)/1.07 'Plus Jakarta Sans';letter-spacing:-1.45px}.ar-desc{margin:0;color:var(--muted);font-size:12px;line-height:1.7}
.ar-author{margin-top:20px;padding:12px;display:flex;align-items:center;gap:11px;border-radius:16px;background:var(--cream)}.ar-avatar{width:43px;height:43px;border-radius:50%;display:grid;place-items:center;background:var(--brown);color:#fff;font:800 13px 'Plus Jakarta Sans'}.ar-author strong{display:block;font:800 11px 'Plus Jakarta Sans'}.ar-author small{display:block;margin-top:2px;color:var(--muted);font-size:8px}
.ar-wavebox{margin-top:20px;padding:17px;border-radius:18px;background:var(--cream)}.ar-time{display:flex;justify-content:space-between;margin-bottom:9px;color:var(--muted);font-size:8px;font-weight:800}.ar-wave{height:68px;display:flex;align-items:center;gap:3px;cursor:pointer}.ar-wave span{flex:1;min-width:2px;border-radius:999px;background:rgba(73,38,29,.19);transition:.15s}.ar-wave span.played{background:var(--orange)}
.ar-progress{margin-top:10px;width:100%;accent-color:var(--orange)}
.ar-controls{display:grid;grid-template-columns:1fr auto 1fr;align-items:center;gap:15px;margin-top:18px}.ar-controls-left,.ar-controls-right{display:flex;align-items:center;gap:8px}.ar-controls-right{justify-content:flex-end}.ar-icon-btn{width:37px;height:37px;border:0;border-radius:50%;display:grid;place-items:center;background:var(--cream2);color:var(--brown);cursor:pointer}.ar-speed{height:37px;padding:0 12px;border:0;border-radius:999px;background:var(--cream2);color:var(--brown);font-size:9px;font-weight:800;cursor:pointer}.ar-mainplay{width:58px;height:58px;border:0;border-radius:50%;display:grid;place-items:center;background:var(--orange);color:#fff;font-size:18px;cursor:pointer;box-shadow:0 10px 25px rgba(251,77,0,.23)}.ar-volume{width:75px;accent-color:var(--orange)}
.ar-actions{display:flex;flex-wrap:wrap;gap:7px;margin-top:19px}.ar-action{padding:9px 12px;border:0;border-radius:999px;background:var(--cream2);color:var(--brown);font-size:8.5px;font-weight:800}.ar-action.primary{background:var(--brown);color:#fff}
.ar-side{padding:18px;border:1px solid var(--line);border-radius:27px;background:#fff;box-shadow:0 16px 45px rgba(73,38,29,.05);min-height:520px}.ar-tabs{display:flex;padding:4px;border-radius:14px;background:var(--cream2);gap:4px}.ar-tab{flex:1;padding:9px;border:0;border-radius:11px;background:transparent;color:var(--muted);font:800 9px 'Plus Jakarta Sans';cursor:pointer}.ar-tab.active{background:#fff;color:var(--brown);box-shadow:0 3px 12px rgba(73,38,29,.05)}
.ar-panel{display:none;margin-top:15px}.ar-panel.active{display:block}.ar-transcript-head{display:flex;justify-content:space-between;margin-bottom:12px;color:var(--muted);font-size:8px}.ar-live{color:var(--orange);font-weight:800}.ar-transcript{max-height:430px;overflow:auto;white-space:pre-line;color:#5E4A44;font-size:11px;line-height:1.85;padding-right:5px}.ar-empty-text{padding:35px 12px;text-align:center;color:var(--muted);font-size:10px}.ar-queue{display:grid;gap:9px}.ar-queue-item{display:grid;grid-template-columns:58px 1fr;gap:10px;padding:9px;border-radius:13px;background:var(--cream);text-decoration:none;color:inherit}.ar-queue-art{width:58px;height:58px;border-radius:10px;background:var(--brown);overflow:hidden;display:grid;place-items:center;color:#fff}.ar-queue-art img{width:100%;height:100%;object-fit:cover}.ar-queue-item strong{font:800 10px/1.35 'Plus Jakarta Sans';display:block}.ar-queue-item small{display:block;margin-top:4px;color:var(--muted);font-size:8px}
.ar-related{margin-top:36px}.ar-related h2{font:800 24px 'Plus Jakarta Sans';letter-spacing:-.7px}.ar-related-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}.ar-related-card{padding:16px;border:1px solid var(--line);border-radius:18px;background:#fff;color:inherit;text-decoration:none}.ar-related-card small{color:var(--orange);font-size:8px;font-weight:800;text-transform:uppercase}.ar-related-card strong{display:block;margin-top:7px;font:800 13px/1.35 'Plus Jakarta Sans'}
.ar-no-media{margin-top:20px;padding:14px;border-radius:13px;background:#FFF0EC;color:#92310F;font-size:9px}
@media(max-width:900px){.ar-main{grid-template-columns:1fr}.ar-related-grid{grid-template-columns:repeat(2,1fr)}}@media(max-width:620px){.ar-shell{width:min(100% - 22px,1160px)}.ar-player{padding:20px}.ar-controls{grid-template-columns:1fr}.ar-controls-left,.ar-controls-right,.ar-mainplay-wrap{justify-content:center;display:flex}.ar-related-grid{grid-template-columns:1fr}.ar-volume{display:none}}
</style>

<main class="audio-room">
<div class="ar-shell">
    <a class="ar-back" href="{{ route('podcasts.index',['type'=>'audio']) }}"><i class="fas fa-arrow-left"></i> Kembali ke Audio Room</a>

    <div class="ar-context">
        <span class="ar-badge"><i class="fas fa-headphones"></i> Podcast Audio</span>
        <a class="ar-format-link" href="{{ route('podcasts.index',['type'=>'video']) }}"><i class="fas fa-video"></i> Lihat Video Podcast</a>
    </div>

    <div class="ar-main">
        <section class="ar-player">
            <div class="ar-player-content">
                <div class="ar-topmeta">
                    <span>
                        {{ $podcast->category ?: 'Podcast Interlude' }}
                        @if($podcast->episode_number) · EP. {{ $podcast->episode_number }} @endif
                    </span>
                    <span>{{ number_format($podcast->views_count) }} diputar</span>
                </div>

                <h1 class="ar-title">{{ $podcast->title }}</h1>
                <p class="ar-desc">{{ $podcast->description }}</p>

                <div class="ar-author">
                    <div class="ar-avatar">{{ strtoupper(substr($podcast->user->name,0,1)) }}</div>
                    <div>
                        <strong>{{ $podcast->user->name }}</strong>
                        <small>
                            @if($podcast->series){{ $podcast->series->title }} · @endif
                            {{ optional($podcast->published_at)->diffForHumans() }}
                        </small>
                    </div>
                </div>

                @if($podcast->media_path)
                    <audio id="interludeAudio" preload="metadata">
                        <source src="{{ asset('storage/'.$podcast->media_path) }}">
                    </audio>

                    <div class="ar-wavebox">
                        <div class="ar-time">
                            <span id="audioCurrent">0:00</span>
                            <span id="audioDuration">{{ $podcast->formatted_duration }}</span>
                        </div>

                        <div class="ar-wave" id="audioWave">
                            @foreach([30,52,76,43,87,61,36,91,69,48,80,57,40,74,95,64,50,84,42,67,89,54,72,38,59,81,44,70,49,86,33,62,78,47,68,90,53,79,35,65,83,46,73,55,92,39,60,75,51,88,45,71,58,82] as $height)
                                <span style="height:{{ $height }}%"></span>
                            @endforeach
                        </div>

                        <input id="audioProgress" class="ar-progress" type="range" min="0" max="1000" value="0">
                    </div>

                    <div class="ar-controls">
                        <div class="ar-controls-left">
                            <button class="ar-speed" id="audioSpeed" type="button">1.0x</button>
                            <button class="ar-icon-btn" id="audioBack" type="button" title="Mundur 15 detik"><i class="fas fa-undo"></i></button>
                        </div>

                        <div class="ar-mainplay-wrap">
                            <button class="ar-mainplay" id="audioPlay" type="button"><i class="fas fa-play"></i></button>
                        </div>

                        <div class="ar-controls-right">
                            <button class="ar-icon-btn" id="audioForward" type="button" title="Maju 30 detik"><i class="fas fa-redo"></i></button>
                            <i class="fas fa-volume-up" style="font-size:11px;color:#75635D"></i>
                            <input id="audioVolume" class="ar-volume" type="range" min="0" max="1" step=".01" value=".8">
                        </div>
                    </div>
                @else
                    <div class="ar-no-media">Episode ini belum memiliki file audio. Upload ulang episode melalui form Podcast untuk mengaktifkan player.</div>
                @endif

                <div class="ar-actions">
                    <button class="ar-action primary" type="button"><i class="fas fa-bookmark"></i> Simpan</button>
                    <button class="ar-action" type="button" onclick="navigator.clipboard?.writeText(window.location.href)"><i class="fas fa-link"></i> Salin tautan</button>
                    @if($podcast->transcript)<button class="ar-action" type="button" data-open-transcript><i class="fas fa-file-alt"></i> Baca transkrip</button>@endif
                </div>
            </div>
        </section>

        <aside class="ar-side">
            <div class="ar-tabs">
                <button class="ar-tab active" type="button" data-audio-tab="transcript">Transkrip</button>
                <button class="ar-tab" type="button" data-audio-tab="queue">Antrean</button>
            </div>

            <div class="ar-panel active" data-audio-panel="transcript">
                <div class="ar-transcript-head">
                    <span>TRANSKRIP EPISODE</span>
                    @if($podcast->transcript)<span class="ar-live">● tersedia</span>@endif
                </div>

                @if($podcast->transcript)
                    <div class="ar-transcript">{{ $podcast->transcript }}</div>
                @else
                    <div class="ar-empty-text">Belum ada transkrip untuk episode ini.</div>
                @endif
            </div>

            <div class="ar-panel" data-audio-panel="queue">
                <div class="ar-queue">
                    @forelse($relatedEpisodes as $item)
                        <a class="ar-queue-item" href="{{ route('podcasts.show',$item) }}">
                            <div class="ar-queue-art">
                                @if($item->cover_image)
                                    <img src="{{ asset('storage/'.$item->cover_image) }}" alt="{{ $item->title }}">
                                @else
                                    <i class="fas fa-headphones"></i>
                                @endif
                            </div>
                            <div>
                                <strong>{{ $item->title }}</strong>
                                <small>{{ $item->user->name }} · {{ $item->formatted_duration }}</small>
                            </div>
                        </a>
                    @empty
                        <div class="ar-empty-text">Belum ada episode lain dalam antrean.</div>
                    @endforelse
                </div>
            </div>
        </aside>
    </div>

    @if($relatedEpisodes->isNotEmpty())
        <section class="ar-related">
            <h2>Lanjut dengarkan</h2>
            <div class="ar-related-grid">
                @foreach($relatedEpisodes->take(3) as $item)
                    <a class="ar-related-card" href="{{ route('podcasts.show',$item) }}">
                        <small>{{ $item->category ?: 'Audio' }}</small>
                        <strong>{{ $item->title }}</strong>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
</main>

@if($podcast->media_path)
<script>
(() => {
    const audio = document.getElementById('interludeAudio');
    const play = document.getElementById('audioPlay');
    const progress = document.getElementById('audioProgress');
    const current = document.getElementById('audioCurrent');
    const duration = document.getElementById('audioDuration');
    const volume = document.getElementById('audioVolume');
    const speed = document.getElementById('audioSpeed');
    const wave = document.getElementById('audioWave');
    const bars = [...wave.querySelectorAll('span')];
    const speeds = [1,1.25,1.5,1.75,2];
    let speedIndex = 0;

    const fmt = (seconds) => {
        if (!Number.isFinite(seconds)) return '0:00';
        seconds = Math.max(0, Math.floor(seconds));
        const h = Math.floor(seconds / 3600);
        const m = Math.floor((seconds % 3600) / 60);
        const s = seconds % 60;
        return h ? `${h}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}` : `${m}:${String(s).padStart(2,'0')}`;
    };

    const sync = () => {
        const ratio = audio.duration ? audio.currentTime / audio.duration : 0;
        progress.value = Math.round(ratio * 1000);
        current.textContent = fmt(audio.currentTime);
        if (Number.isFinite(audio.duration)) duration.textContent = fmt(audio.duration);

        bars.forEach((bar, i) => {
            bar.classList.toggle('played', i / bars.length <= ratio);
        });
    };

    play.addEventListener('click', async () => {
        if (audio.paused) await audio.play();
        else audio.pause();
    });

    audio.addEventListener('play', () => play.innerHTML = '<i class="fas fa-pause"></i>');
    audio.addEventListener('pause', () => play.innerHTML = '<i class="fas fa-play"></i>');
    audio.addEventListener('timeupdate', sync);
    audio.addEventListener('loadedmetadata', sync);

    progress.addEventListener('input', () => {
        if (audio.duration) audio.currentTime = (progress.value / 1000) * audio.duration;
    });

    wave.addEventListener('click', (event) => {
        if (!audio.duration) return;
        const rect = wave.getBoundingClientRect();
        const ratio = Math.min(1, Math.max(0, (event.clientX - rect.left) / rect.width));
        audio.currentTime = ratio * audio.duration;
    });

    document.getElementById('audioBack').addEventListener('click', () => audio.currentTime = Math.max(0, audio.currentTime - 15));
    document.getElementById('audioForward').addEventListener('click', () => audio.currentTime = Math.min(audio.duration || Infinity, audio.currentTime + 30));
    volume.addEventListener('input', () => audio.volume = volume.value);
    audio.volume = volume.value;

    speed.addEventListener('click', () => {
        speedIndex = (speedIndex + 1) % speeds.length;
        audio.playbackRate = speeds[speedIndex];
        speed.textContent = `${speeds[speedIndex]}x`;
    });
})();
</script>
@endif

<script>
(() => {
    const tabs = [...document.querySelectorAll('[data-audio-tab]')];
    const panels = [...document.querySelectorAll('[data-audio-panel]')];

    const open = (name) => {
        tabs.forEach(t => t.classList.toggle('active', t.dataset.audioTab === name));
        panels.forEach(p => p.classList.toggle('active', p.dataset.audioPanel === name));
    };

    tabs.forEach(t => t.addEventListener('click', () => open(t.dataset.audioTab)));
    document.querySelector('[data-open-transcript]')?.addEventListener('click', () => open('transcript'));
})();
</script>
