<style>
.video-studio {
    --paper: #FDF8F4;
    --white: #FFFFFF;
    --cream: #F8F3EF;
    --cream2: #F2EDE9;
    --line: #E4D8D2;

    --brown: #49261D;
    --dark: #30120A;
    --orange: #FB4D00;
    --orange-soft: #FFDBD0;

    --blue: #CAE7F7;
    --blue-dark: #17333F;
    --muted: #75635D;

    min-height: 100vh;
    background: var(--paper);
    color: var(--dark);
    font-family: 'DM Sans', sans-serif;
}

.vs-shell {
    width: min(1080px, calc(100% - 34px));
    margin: 0 auto;
    padding: 30px 0 80px;
}

/* =========================================================
   BACK
========================================================= */

.vs-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    margin-bottom: 20px;

    color: var(--muted);
    text-decoration: none;

    font-size: 11px;
    font-weight: 800;

    transition: .2s ease;
}

.vs-back:hover {
    color: var(--brown);
}

/* =========================================================
   MODE HEADER
========================================================= */

.vs-modebar {
    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 14px;

    margin-bottom: 18px;
}

.vs-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    padding: 8px 11px;

    border-radius: 999px;

    background: var(--orange-soft);
    color: #842500;

    font: 800 9px 'Plus Jakarta Sans';
    text-transform: uppercase;
    letter-spacing: .7px;
}

.vs-switch {
    display: flex;
    gap: 3px;

    padding: 4px;

    border-radius: 999px;

    background: var(--cream2);
}

.vs-switch button {
    padding: 8px 13px;

    border: 0;
    border-radius: 999px;

    background: transparent;
    color: var(--muted);

    font-size: 9px;
    font-weight: 800;

    cursor: pointer;

    transition: .2s ease;
}

.vs-switch button.active {
    background: var(--brown);
    color: #FFFFFF;
}

/* =========================================================
   VIDEO STAGE
========================================================= */

.vs-stage {
    position: relative;

    width: 100%;

    aspect-ratio: 16 / 9;

    overflow: hidden;

    border-radius: 28px;

    background: #16100E;

    box-shadow:
        0 18px 48px
        rgba(48, 18, 10, .18);

    transition: .25s ease;
}

.vs-media {
    width: 100%;
    height: 100%;

    display: block;

    object-fit: cover;
}

/* Fullscreen */

.vs-stage:fullscreen {
    width: 100vw;
    height: 100vh;

    aspect-ratio: auto;

    border-radius: 0;

    background: #000000;
}

.vs-stage:fullscreen .vs-media {
    width: 100%;
    height: 100%;

    object-fit: contain;

    background: #000000;
}

/* Webkit fullscreen */

.vs-stage:-webkit-full-screen {
    width: 100vw;
    height: 100vh;

    border-radius: 0;

    background: #000000;
}

.vs-stage:-webkit-full-screen .vs-media {
    object-fit: contain;
}

/* =========================================================
   AUDIO MODE
========================================================= */

.vs-stage.audio-only {
    height: 300px;

    aspect-ratio: auto;

    background:
        linear-gradient(
            145deg,
            var(--brown),
            var(--blue-dark)
        );
}

.vs-stage.audio-only .vs-media {
    opacity: .09;

    filter:
        blur(10px)
        grayscale(.4);

    transform: scale(1.04);
}

.vs-audio-overlay {
    position: absolute;
    inset: 0;

    display: none;

    align-items: center;
    justify-content: center;

    padding: 25px;

    text-align: center;

    color: #FFFFFF;
}

.vs-stage.audio-only .vs-audio-overlay {
    display: flex;
}

.vs-audio-overlay > div {
    max-width: 520px;
}

.vs-audio-overlay i {
    font-size: 32px;
    color: #FFD1C0;
}

.vs-audio-overlay strong {
    display: block;

    margin-top: 10px;

    font:
        800 20px
        'Plus Jakarta Sans';
}

.vs-audio-overlay span {
    display: block;

    margin-top: 7px;

    color: rgba(255,255,255,.70);

    font-size: 12px;
    line-height: 1.6;
}

/* =========================================================
   TOP BADGES
========================================================= */

.vs-stage-top {
    position: absolute;

    top: 14px;
    left: 14px;
    right: 14px;

    z-index: 3;

    display: flex;
    justify-content: space-between;

    gap: 8px;

    pointer-events: none;
}

.vs-stage-tag {
    padding: 7px 10px;

    border-radius: 999px;

    background:
        rgba(48,18,10,.75);

    backdrop-filter: blur(8px);

    color: #FFFFFF;

    font:
        800 8px
        'Plus Jakarta Sans';

    text-transform: uppercase;
    letter-spacing: .6px;
}

/* =========================================================
   VIDEO CONTROLS
========================================================= */

.vs-controls {
    position: absolute;

    left: 0;
    right: 0;
    bottom: 0;

    z-index: 5;

    padding: 38px 16px 14px;

    background:
        linear-gradient(
            transparent,
            rgba(31,13,8,.94)
        );

    color: #FFFFFF;
}

.vs-progress {
    width: 100%;

    accent-color: var(--orange);

    cursor: pointer;
}

.vs-control-row {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 12px;

    margin-top: 8px;
}

.vs-control-left,
.vs-control-right {
    display: flex;
    align-items: center;

    gap: 8px;
}

.vs-control-btn {
    border: 0;

    background: transparent;
    color: #FFFFFF;

    cursor: pointer;

    font-size: 14px;

    transition: .2s ease;
}

.vs-control-btn:hover {
    opacity: .8;
}

.vs-play {
    width: 38px;
    height: 38px;

    display: grid;
    place-items: center;

    border-radius: 50%;

    background: var(--orange);
}

.vs-time {
    font-size: 10px;

    color:
        rgba(255,255,255,.84);
}

.vs-speed {
    padding: 6px 9px;

    border-radius: 999px;

    background:
        rgba(255,255,255,.15);

    font-size: 9px;
}

.vs-volume {
    width: 80px;

    accent-color: #FFFFFF;
}

#videoFullscreen {
    width: 34px;
    height: 34px;

    display: grid;
    place-items: center;

    border-radius: 9px;
}

#videoFullscreen:hover {
    opacity: 1;

    background:
        rgba(255,255,255,.14);
}

/* =========================================================
   INFORMATION
========================================================= */

.vs-info {
    margin-top: 18px;

    padding: 28px;

    border:
        1px solid
        var(--line);

    border-radius: 24px;

    background: #FFFFFF;
}

.vs-meta {
    display: flex;
    flex-wrap: wrap;

    justify-content: space-between;

    gap: 10px;

    color: var(--muted);

    font-size: 11px;
}

.vs-meta-left {
    display: flex;
    flex-wrap: wrap;

    gap: 7px;
}

.vs-pill {
    padding: 7px 10px;

    border-radius: 999px;

    background: var(--cream2);

    color: var(--brown);

    font-size: 10px;
    font-weight: 800;
}

.vs-info h1 {
    max-width: 900px;

    margin:
        18px 0 10px;

    font:
        800
        clamp(30px, 4vw, 46px)
        / 1.08
        'Plus Jakarta Sans';

    letter-spacing: -1.5px;
}

.vs-description {
    max-width: 900px;

    margin: 0;

    color: var(--muted);

    font-size: 14px;
    line-height: 1.75;

    white-space: pre-line;
    overflow-wrap: anywhere;
}

/* =========================================================
   HOST
========================================================= */

.vs-host {
    display: flex;
    align-items: center;

    gap: 12px;

    margin-top: 22px;

    padding: 13px;

    border-radius: 16px;

    background: var(--cream);
}

.vs-avatar {
    width: 46px;
    height: 46px;

    flex:
        0 0 46px;

    display: grid;
    place-items: center;

    border-radius: 50%;

    background: var(--brown);

    color: #FFFFFF;

    font:
        800 13px
        'Plus Jakarta Sans';
}

.vs-host strong {
    display: block;

    font:
        800 12px
        'Plus Jakarta Sans';
}

.vs-host small {
    display: block;

    margin-top: 3px;

    color: var(--muted);

    font-size: 9px;
}

/* =========================================================
   ACTIONS
========================================================= */

.vs-actions {
    display: flex;
    flex-wrap: wrap;
    align-items: center;

    gap: 9px;

    margin-top: 18px;
}

.vs-action-form {
    margin: 0;
}

.vs-action {
    min-height: 40px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 7px;

    padding:
        0 15px;

    border: 0;
    border-radius: 999px;

    background: var(--cream2);

    color: var(--brown);

    font-size: 11px;
    font-weight: 800;

    cursor: pointer;

    transition: .2s ease;
}

.vs-action:hover {
    transform:
        translateY(-1px);

    background: #E9DFDA;
}

.vs-action.saved {
    background: var(--orange);
    color: #FFFFFF;
}

.vs-action.saved:hover {
    background: #E84600;
}

.vs-share-message {
    display: none;

    color: var(--orange);

    font-size: 11px;
    font-weight: 800;
}

.vs-share-message.show {
    display: inline-flex;
}

/* =========================================================
   RELATED VIDEOS
========================================================= */

.vs-related {
    margin-top: 40px;
}

.vs-related h2 {
    margin:
        0 0 16px;

    font:
        800 26px
        'Plus Jakarta Sans';

    letter-spacing: -.8px;
}

.vs-related-grid {
    display: grid;

    grid-template-columns:
        repeat(
            3,
            minmax(0,1fr)
        );

    gap: 14px;
}

.vs-related-card {
    overflow: hidden;

    border:
        1px solid
        var(--line);

    border-radius: 20px;

    background: #FFFFFF;

    color: inherit;
    text-decoration: none;

    transition: .2s ease;
}

.vs-related-card:hover {
    transform:
        translateY(-3px);

    box-shadow:
        0 12px 28px
        rgba(73,38,29,.08);
}

.vs-related-thumb {
    aspect-ratio:
        16 / 9;

    overflow: hidden;

    background:
        linear-gradient(
            145deg,
            var(--blue),
            var(--cream2)
        );
}

.vs-related-thumb img {
    width: 100%;
    height: 100%;

    object-fit: cover;
}

.vs-related-placeholder {
    width: 100%;
    height: 100%;

    display: grid;
    place-items: center;

    color: var(--brown);

    font-size: 24px;
}

.vs-related-body {
    padding: 14px;
}

.vs-related-body small {
    color: var(--orange);

    font-size: 9px;
    font-weight: 800;

    text-transform: uppercase;
}

.vs-related-body strong {
    display: block;

    margin-top: 6px;

    font:
        800 14px / 1.4
        'Plus Jakarta Sans';
}

/* =========================================================
   NO MEDIA
========================================================= */

.vs-no-media {
    height: 100%;

    display: grid;
    place-items: center;

    padding: 30px;

    color: #FFFFFF;

    text-align: center;
}

.vs-no-media i {
    display: block;

    margin-bottom: 10px;

    font-size: 34px;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:700px) {

    .vs-shell {
        width:
            min(
                100% - 22px,
                1080px
            );
    }

    .vs-modebar {
        align-items: flex-start;
        flex-direction: column;
    }

    .vs-info {
        padding: 20px;
    }

    .vs-info h1 {
        font-size: 30px;
    }

    .vs-volume {
        display: none;
    }

    .vs-control-right
    .vs-speed {
        display: none;
    }

    .vs-related-grid {
        grid-template-columns:
            1fr;
    }
}
</style>


<main class="video-studio">

<div class="vs-shell">

    {{-- BACK --}}
    <a
        class="vs-back"
        href="{{ route('podcasts.index', ['type' => 'video']) }}"
    >
        <i class="fas fa-arrow-left"></i>

        Kembali ke Video Studio
    </a>


    {{-- MODE BAR --}}
    <div class="vs-modebar">

        <span class="vs-badge">

            <i class="fas fa-video"></i>

            Video Podcast

        </span>


        <div class="vs-switch">

            <button
                class="active"
                type="button"
                data-video-mode="video"
            >
                <i class="fas fa-video"></i>

                Mode Video
            </button>


            <button
                type="button"
                data-video-mode="audio"
            >
                <i class="fas fa-headphones"></i>

                Mode Dengar
            </button>

        </div>

    </div>


    {{-- PLAYER --}}
    <section
        class="vs-stage"
        id="videoStage"
    >

        @if($podcast->media_path)

            <video
                class="vs-media"
                id="interludeVideo"
                preload="metadata"
                playsinline
                poster="{{ $podcast->thumbnail_image ? asset('storage/'.$podcast->thumbnail_image) : ($podcast->cover_image ? asset('storage/'.$podcast->cover_image) : '') }}"
            >
                <source
                    src="{{ asset('storage/'.$podcast->media_path) }}"
                >
            </video>


            {{-- AUDIO MODE OVERLAY --}}
            <div class="vs-audio-overlay">

                <div>

                    <i class="fas fa-headphones"></i>

                    <strong>
                        Mode dengar aktif
                    </strong>

                    <span>
                        Videonya disembunyikan, tetapi audio tetap berjalan.
                        Cocok ketika kamu hanya ingin mendengarkan podcast.
                    </span>

                </div>

            </div>


            {{-- TOP LABEL --}}
            <div class="vs-stage-top">

                <span class="vs-stage-tag">

                    @if($podcast->episode_number)
                        EP. {{ $podcast->episode_number }} ·
                    @endif

                    VIDEO PODCAST

                </span>


                <span class="vs-stage-tag">

                    {{ number_format($podcast->views_count) }}

                    tontonan

                </span>

            </div>


            {{-- PLAYER CONTROLS --}}
            <div class="vs-controls">

                <input
                    class="vs-progress"
                    id="videoProgress"
                    type="range"
                    min="0"
                    max="1000"
                    value="0"
                >


                <div class="vs-control-row">

                    <div class="vs-control-left">

                        <button
                            class="vs-control-btn vs-play"
                            id="videoPlay"
                            type="button"
                            aria-label="Putar video"
                        >
                            <i class="fas fa-play"></i>
                        </button>


                        <button
                            class="vs-control-btn"
                            id="videoBack"
                            type="button"
                            title="Mundur 10 detik"
                        >
                            <i class="fas fa-undo"></i>
                        </button>


                        <button
                            class="vs-control-btn"
                            id="videoForward"
                            type="button"
                            title="Maju 10 detik"
                        >
                            <i class="fas fa-redo"></i>
                        </button>


                        <span class="vs-time">

                            <span id="videoCurrent">
                                0:00
                            </span>

                            /

                            <span id="videoDuration">
                                {{ $podcast->formatted_duration }}
                            </span>

                        </span>

                    </div>


                    <div class="vs-control-right">

                        <input
                            class="vs-volume"
                            id="videoVolume"
                            type="range"
                            min="0"
                            max="1"
                            step=".01"
                            value=".8"
                        >


                        <button
                            class="vs-control-btn vs-speed"
                            id="videoSpeed"
                            type="button"
                        >
                            1.0x
                        </button>


                        <button
                            class="vs-control-btn"
                            id="videoFullscreen"
                            type="button"
                            aria-label="Fullscreen"
                            title="Fullscreen"
                        >
                            <i class="fas fa-expand"></i>
                        </button>

                    </div>

                </div>

            </div>

        @else

            <div class="vs-no-media">

                <div>

                    <i class="fas fa-video"></i>

                    Episode ini belum memiliki file video.

                </div>

            </div>

        @endif

    </section>


    {{-- INFORMATION --}}
    <section class="vs-info">

        <div class="vs-meta">

            <div class="vs-meta-left">

                <span class="vs-pill">
                    {{ $podcast->category ?: 'Video Podcast' }}
                </span>


                @if($podcast->series)

                    <span class="vs-pill">
                        {{ $podcast->series->title }}
                    </span>

                @endif

            </div>


            <span>
                {{ optional($podcast->published_at)->diffForHumans() }}
            </span>

        </div>


        <h1>
            {{ $podcast->title }}
        </h1>


        <p class="vs-description">
            {{ $podcast->description }}
        </p>


        {{-- HOST --}}
        <div class="vs-host">

            <div class="vs-avatar">
                {{ strtoupper(substr($podcast->user->name, 0, 1)) }}
            </div>


            <div>

                <strong>
                    {{ $podcast->user->name }}
                </strong>

                <small>
                    Host · Podcast Interlude
                </small>

            </div>

        </div>


        {{-- ACTIONS --}}
        <div class="vs-actions">

            @php($podcastSaved = auth()->check() && $podcast->isBookmarkedBy(auth()->user()))


            {{-- BOOKMARK --}}
            <form
                class="vs-action-form"
                action="{{ route('podcasts.bookmark', $podcast) }}"
                method="POST"
            >
                @csrf

                <button
                    class="vs-action {{ $podcastSaved ? 'saved' : '' }}"
                    type="submit"
                >
                    <i class="fas fa-bookmark"></i>

                    {{ $podcastSaved ? 'Tersimpan' : 'Simpan' }}
                </button>

            </form>


            {{-- SHARE --}}
            <button
                class="vs-action"
                id="podcastShareButton"
                type="button"
            >
                <i class="fas fa-share-alt"></i>

                <span id="podcastShareLabel">
                    Bagikan
                </span>
            </button>


            <span
                class="vs-share-message"
                id="podcastShareMessage"
            >
                Tautan disalin ✓
            </span>

        </div>

    </section>


    {{-- RELATED VIDEOS --}}
    @if($relatedEpisodes->isNotEmpty())

        <section class="vs-related">

            <h2>
                Video berikutnya
            </h2>


            <div class="vs-related-grid">

                @foreach($relatedEpisodes->take(3) as $item)

                    <a
                        class="vs-related-card"
                        href="{{ route('podcasts.show', $item) }}"
                    >

                        <div class="vs-related-thumb">

                            @php($relatedVisual = $item->thumbnail_image ?: $item->cover_image)

                            @if($relatedVisual)

                                <img
                                    src="{{ asset('storage/'.$relatedVisual) }}"
                                    alt="{{ $item->title }}"
                                >

                            @else

                                <div class="vs-related-placeholder">
                                    <i class="fas fa-video"></i>
                                </div>

                            @endif

                        </div>


                        <div class="vs-related-body">

                            <small>
                                {{ $item->category ?: 'Video' }}
                            </small>

                            <strong>
                                {{ $item->title }}
                            </strong>

                        </div>

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

    const video =
        document.getElementById('interludeVideo');

    const stage =
        document.getElementById('videoStage');

    const play =
        document.getElementById('videoPlay');

    const progress =
        document.getElementById('videoProgress');

    const current =
        document.getElementById('videoCurrent');

    const duration =
        document.getElementById('videoDuration');

    const volume =
        document.getElementById('videoVolume');

    const speed =
        document.getElementById('videoSpeed');

    const fullscreenButton =
        document.getElementById('videoFullscreen');

    const modeButtons = [
        ...document.querySelectorAll(
            '[data-video-mode]'
        )
    ];


    const speeds = [
        1,
        1.25,
        1.5,
        1.75,
        2
    ];

    let speedIndex = 0;


    /* =====================================================
       FORMAT TIME
    ===================================================== */

    const fmt = (seconds) => {

        if (!Number.isFinite(seconds)) {
            return '0:00';
        }

        seconds =
            Math.max(
                0,
                Math.floor(seconds)
            );

        const h =
            Math.floor(
                seconds / 3600
            );

        const m =
            Math.floor(
                (seconds % 3600) / 60
            );

        const s =
            seconds % 60;


        return h
            ? `${h}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`
            : `${m}:${String(s).padStart(2,'0')}`;

    };


    /* =====================================================
       PLAYER SYNC
    ===================================================== */

    const sync = () => {

        const ratio =
            video.duration
                ? video.currentTime / video.duration
                : 0;


        progress.value =
            Math.round(
                ratio * 1000
            );


        current.textContent =
            fmt(
                video.currentTime
            );


        if (
            Number.isFinite(
                video.duration
            )
        ) {

            duration.textContent =
                fmt(
                    video.duration
                );

        }

    };


    /* =====================================================
       PLAY / PAUSE
    ===================================================== */

    play.addEventListener(
        'click',
        async () => {

            if (video.paused) {

                try {
                    await video.play();
                } catch (error) {
                    console.error(error);
                }

            } else {

                video.pause();

            }

        }
    );


    video.addEventListener(
        'play',
        () => {

            play.innerHTML =
                '<i class="fas fa-pause"></i>';

            play.setAttribute(
                'aria-label',
                'Jeda video'
            );

        }
    );


    video.addEventListener(
        'pause',
        () => {

            play.innerHTML =
                '<i class="fas fa-play"></i>';

            play.setAttribute(
                'aria-label',
                'Putar video'
            );

        }
    );


    video.addEventListener(
        'timeupdate',
        sync
    );


    video.addEventListener(
        'loadedmetadata',
        sync
    );


    /* =====================================================
       SEEK
    ===================================================== */

    progress.addEventListener(
        'input',
        () => {

            if (video.duration) {

                video.currentTime =
                    (
                        progress.value / 1000
                    )
                    *
                    video.duration;

            }

        }
    );


    /* =====================================================
       BACK 10 SECONDS
    ===================================================== */

    document
        .getElementById('videoBack')
        .addEventListener(
            'click',
            () => {

                video.currentTime =
                    Math.max(
                        0,
                        video.currentTime - 10
                    );

            }
        );


    /* =====================================================
       FORWARD 10 SECONDS
    ===================================================== */

    document
        .getElementById('videoForward')
        .addEventListener(
            'click',
            () => {

                video.currentTime =
                    Math.min(
                        video.duration || Infinity,
                        video.currentTime + 10
                    );

            }
        );


    /* =====================================================
       VOLUME
    ===================================================== */

    volume.addEventListener(
        'input',
        () => {

            video.volume =
                Number(
                    volume.value
                );

        }
    );


    video.volume =
        Number(
            volume.value
        );


    /* =====================================================
       SPEED
    ===================================================== */

    speed.addEventListener(
        'click',
        () => {

            speedIndex =
                (
                    speedIndex + 1
                )
                %
                speeds.length;


            video.playbackRate =
                speeds[
                    speedIndex
                ];


            speed.textContent =
                `${speeds[speedIndex]}x`;

        }
    );


    /* =====================================================
       FULLSCREEN
    ===================================================== */

    const getFullscreenElement = () => {

        return (
            document.fullscreenElement
            ||
            document.webkitFullscreenElement
            ||
            null
        );

    };


    const enterFullscreen =
        async () => {

            try {

                if (
                    stage.requestFullscreen
                ) {

                    await stage.requestFullscreen();

                } else if (
                    stage.webkitRequestFullscreen
                ) {

                    stage.webkitRequestFullscreen();

                }

            } catch (error) {

                console.error(
                    'Fullscreen gagal:',
                    error
                );

            }

        };


    const exitFullscreen =
        async () => {

            try {

                if (
                    document.exitFullscreen
                ) {

                    await document.exitFullscreen();

                } else if (
                    document.webkitExitFullscreen
                ) {

                    document.webkitExitFullscreen();

                }

            } catch (error) {

                console.error(
                    'Keluar fullscreen gagal:',
                    error
                );

            }

        };


    fullscreenButton.addEventListener(
        'click',
        async () => {

            if (
                getFullscreenElement()
            ) {

                await exitFullscreen();

            } else {

                await enterFullscreen();

            }

        }
    );


    const updateFullscreenButton =
        () => {

            const active =
                getFullscreenElement()
                ===
                stage;


            if (active) {

                fullscreenButton.innerHTML =
                    '<i class="fas fa-compress"></i>';

                fullscreenButton.setAttribute(
                    'title',
                    'Keluar fullscreen'
                );

                fullscreenButton.setAttribute(
                    'aria-label',
                    'Keluar fullscreen'
                );

            } else {

                fullscreenButton.innerHTML =
                    '<i class="fas fa-expand"></i>';

                fullscreenButton.setAttribute(
                    'title',
                    'Fullscreen'
                );

                fullscreenButton.setAttribute(
                    'aria-label',
                    'Fullscreen'
                );

            }

        };


    document.addEventListener(
        'fullscreenchange',
        updateFullscreenButton
    );


    document.addEventListener(
        'webkitfullscreenchange',
        updateFullscreenButton
    );


    /* Double click = fullscreen toggle */

    video.addEventListener(
        'dblclick',
        async () => {

            if (
                getFullscreenElement()
            ) {

                await exitFullscreen();

            } else {

                await enterFullscreen();

            }

        }
    );


    /* =====================================================
       MODE VIDEO / AUDIO
    ===================================================== */

    modeButtons.forEach(
        button => {

            button.addEventListener(
                'click',
                () => {

                    const audioMode =
                        button
                            .dataset
                            .videoMode
                        ===
                        'audio';


                    stage.classList.toggle(
                        'audio-only',
                        audioMode
                    );


                    modeButtons.forEach(
                        btn => {

                            btn.classList.toggle(
                                'active',
                                btn === button
                            );

                        }
                    );

                }
            );

        }
    );

})();
</script>

@endif


<script>
(() => {

    const shareButton =
        document.getElementById(
            'podcastShareButton'
        );

    const shareLabel =
        document.getElementById(
            'podcastShareLabel'
        );

    const shareMessage =
        document.getElementById(
            'podcastShareMessage'
        );


    if (!shareButton) {
        return;
    }


    const showCopiedState = () => {

        if (shareLabel) {
            shareLabel.textContent =
                'Tersalin';
        }


        if (shareMessage) {

            shareMessage
                .classList
                .add('show');

        }


        setTimeout(
            () => {

                if (shareLabel) {
                    shareLabel.textContent =
                        'Bagikan';
                }


                if (shareMessage) {

                    shareMessage
                        .classList
                        .remove('show');

                }

            },
            1800
        );

    };


    const fallbackCopy =
        async () => {

            try {

                await navigator
                    .clipboard
                    .writeText(
                        window.location.href
                    );


                showCopiedState();

            } catch (error) {

                const textarea =
                    document.createElement(
                        'textarea'
                    );


                textarea.value =
                    window.location.href;


                textarea.style.position =
                    'fixed';


                textarea.style.opacity =
                    '0';


                document.body
                    .appendChild(
                        textarea
                    );


                textarea.focus();

                textarea.select();


                document.execCommand(
                    'copy'
                );


                textarea.remove();


                showCopiedState();

            }

        };


    shareButton.addEventListener(
        'click',
        async () => {

            const shareData = {

                title:
                    @json($podcast->title),

                text:
                    'Lihat podcast ini di Interlude.',

                url:
                    window.location.href

            };


            if (
                navigator.share
            ) {

                try {

                    await navigator.share(
                        shareData
                    );

                } catch (error) {

                    if (
                        error.name
                        !==
                        'AbortError'
                    ) {

                        await fallbackCopy();

                    }

                }

            } else {

                await fallbackCopy();

            }

        }
    );

})();
</script>