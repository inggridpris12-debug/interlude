<x-app-layout>
<style>
    .podcast-create {
        --paper: #FDF8F4;
        --white: #FFFFFF;
        --cream: #F8F3EF;
        --cream-2: #F2EDE9;
        --line: #E4D8D2;
        --brown: #49261D;
        --dark: #30120A;
        --orange: #FB4D00;
        --orange-soft: #FFF0E8;
        --muted: #75635D;

        min-height: 100vh;
        background: var(--paper);
        color: var(--dark);
        font-family: 'DM Sans', sans-serif;
    }

    .pc-shell {
        width: min(1040px, calc(100% - 40px));
        margin: 0 auto;
        padding: 52px 0 90px;
    }

    .pc-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 32px;
        margin-bottom: 28px;
    }

    .pc-heading {
        max-width: 720px;
    }

    .pc-kicker {
        display: inline-block;
        margin-bottom: 10px;
        color: var(--orange);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.4px;
        text-transform: uppercase;
    }

    .pc-head h1 {
        margin: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: clamp(38px, 5vw, 52px);
        font-weight: 800;
        line-height: 1.06;
        letter-spacing: -2px;
        color: var(--dark);
    }

    .pc-head p {
        max-width: 650px;
        margin: 12px 0 0;
        color: var(--muted);
        font-size: 15px;
        line-height: 1.65;
    }

    .pc-back {
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 44px;
        padding: 0 17px;
        border: 1px solid var(--line);
        border-radius: 999px;
        background: var(--white);
        color: var(--brown);
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        transition: .2s ease;
    }

    .pc-back:hover {
        border-color: var(--brown);
        transform: translateY(-1px);
    }

    .pc-errors {
        margin-bottom: 20px;
        padding: 16px 18px;
        border: 1px solid #FFD0C3;
        border-radius: 16px;
        background: #FFF0EC;
        color: #9A2A0E;
        font-size: 14px;
        line-height: 1.6;
    }

    .pc-errors strong {
        font-weight: 800;
    }

    .pc-errors ul {
        margin: 7px 0 0;
        padding-left: 20px;
    }

    .pc-card {
        padding: 34px;
        border: 1px solid var(--line);
        border-radius: 28px;
        background: var(--white);
        box-shadow: 0 18px 55px rgba(73, 38, 29, .07);
    }

    .pc-section {
        margin-bottom: 34px;
    }

    .pc-section:last-of-type {
        margin-bottom: 0;
    }

    .pc-section-head {
        margin-bottom: 16px;
    }

    .pc-section-title {
        margin: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 17px;
        font-weight: 800;
        color: var(--dark);
    }

    .pc-section-desc {
        margin: 5px 0 0;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.5;
    }

    /* FORMAT EPISODE */
    .pc-format {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .pc-format-item {
        min-width: 0;
    }

    .pc-format input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .pc-option {
        position: relative;
        display: flex;
        flex-direction: column;
        min-height: 185px;
        padding: 22px;
        border: 2px solid #ECE2DD;
        border-radius: 20px;
        background: #FFFCFA;
        cursor: pointer;
        box-sizing: border-box;
        transition: .2s ease;
    }

    .pc-option:hover {
        border-color: #D9C5BB;
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(73, 38, 29, .06);
    }

    .pc-option-icon {
        width: 48px;
        height: 48px;
        flex: 0 0 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 0 20px 0;
        border-radius: 14px;
        background: var(--cream-2);
        color: var(--brown);
        box-sizing: border-box;
        transition: .2s ease;
    }

    .pc-option-icon svg {
        width: 25px;
        height: 25px;
        display: block;
        flex-shrink: 0;
        margin: 0;
    }

    .pc-option strong {
        display: block;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 17px;
        font-weight: 800;
        color: var(--dark);
    }

    .pc-option-desc {
        display: block;
        margin-top: 7px;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.55;
    }

    .pc-radio-dot {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 20px;
        height: 20px;
        margin: 0;
        border: 2px solid #D8C7BF;
        border-radius: 50%;
        background: #FFFFFF;
        box-sizing: border-box;
    }

    .pc-format input:checked + .pc-option {
        border-color: var(--orange);
        background: #FFF7F2;
        box-shadow: 0 8px 25px rgba(251, 77, 0, .08);
    }

    .pc-format input:checked + .pc-option .pc-option-icon {
        background: var(--orange);
        color: #FFFFFF;
    }

    .pc-format input:checked + .pc-option .pc-radio-dot {
        border: 6px solid var(--orange);
    }

    /* FORM */
    .pc-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .pc-field {
        display: grid;
        gap: 8px;
        min-width: 0;
    }

    .pc-field.full {
        grid-column: 1 / -1;
    }

    .pc-field label {
        color: #5D4942;
        font-size: 13px;
        font-weight: 800;
    }

    .pc-required {
        color: var(--orange);
    }

    .pc-field input,
    .pc-field textarea,
    .pc-field select {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #DED1CB;
        border-radius: 14px;
        background: #FFFDFC;
        color: var(--dark);
        outline: none;
        font-family: 'DM Sans', sans-serif;
        font-size: 15px;
        font-weight: 500;
        transition: .2s ease;
    }

    .pc-field input,
    .pc-field select {
        min-height: 50px;
        padding: 0 15px;
    }

    .pc-field textarea {
        min-height: 135px;
        padding: 14px 15px;
        line-height: 1.65;
        resize: vertical;
    }

    .pc-field input::placeholder,
    .pc-field textarea::placeholder {
        color: #A6948D;
    }

    .pc-field input:focus,
    .pc-field textarea:focus,
    .pc-field select:focus {
        border-color: var(--orange);
        box-shadow: 0 0 0 4px rgba(251, 77, 0, .08);
    }

    .pc-help {
        color: var(--muted);
        font-size: 12px;
        line-height: 1.5;
    }

    /* UPLOAD */
    .pc-upload {
        position: relative;
        padding: 26px;
        border: 1.5px dashed #D2BDB4;
        border-radius: 18px;
        background: var(--cream);
        text-align: center;
        transition: .2s ease;
    }

    .pc-upload:hover {
        border-color: var(--orange);
        background: #FFF8F4;
    }

    .pc-upload-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 13px;
        border-radius: 15px;
        background: var(--orange-soft);
        color: var(--orange);
    }

    .pc-upload-icon svg {
        width: 22px;
        height: 22px;
        display: block;
    }

    .pc-upload strong {
        display: block;
        color: var(--dark);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 15px;
        font-weight: 800;
    }

    .pc-upload span {
        display: block;
        margin: 5px 0 16px;
        color: var(--muted);
        font-size: 12px;
    }

    .pc-upload input[type="file"] {
        width: auto;
        max-width: 100%;
        min-height: unset;
        padding: 0;
        border: 0;
        background: transparent;
        font-size: 13px;
    }

    .pc-upload input[type="file"]::file-selector-button {
        margin-right: 10px;
        padding: 10px 15px;
        border: 0;
        border-radius: 999px;
        background: var(--brown);
        color: white;
        font-family: 'DM Sans', sans-serif;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .pc-image-field input[type="file"] {
        height: auto;
        min-height: 50px;
        padding: 9px 10px;
    }

    .pc-image-field input[type="file"]::file-selector-button {
        margin-right: 10px;
        padding: 8px 12px;
        border: 0;
        border-radius: 9px;
        background: var(--cream-2);
        color: var(--brown);
        font-weight: 700;
        cursor: pointer;
    }

    /* ACTIONS */
    .pc-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        padding-top: 30px;
        margin-top: 34px;
        border-top: 1px solid #EEE4DF;
    }

    .pc-btn {
        min-height: 48px;
        padding: 0 22px;
        border: 0;
        border-radius: 999px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
        transition: .2s ease;
    }

    .pc-btn:hover {
        transform: translateY(-1px);
    }

    .pc-btn.secondary {
        background: var(--cream-2);
        color: var(--brown);
    }

    .pc-btn.primary {
        background: var(--orange);
        color: white;
        box-shadow: 0 8px 20px rgba(251, 77, 0, .18);
    }

    @media (max-width: 760px) {
        .pc-shell {
            width: min(100% - 24px, 1040px);
            padding-top: 32px;
        }

        .pc-head {
            align-items: flex-start;
            flex-direction: column;
            gap: 20px;
        }

        .pc-head h1 {
            font-size: 38px;
        }

        .pc-format,
        .pc-grid {
            grid-template-columns: 1fr;
        }

        .pc-field.full {
            grid-column: auto;
        }

        .pc-card {
            padding: 22px;
            border-radius: 22px;
        }

        .pc-option {
            min-height: 165px;
        }

        .pc-actions {
            flex-direction: column-reverse;
        }

        .pc-btn {
            width: 100%;
        }
    }
</style>

<main class="podcast-create">
    <div class="pc-shell">

        <header class="pc-head">
            <div class="pc-heading">
                <span class="pc-kicker">Podcast Interlude</span>

                <h1>Buat episode baru.</h1>

                <p>
                    Bagikan cerita, pengalaman, atau pembahasan dalam format audio
                    maupun video melalui ruang Podcast Interlude.
                </p>
            </div>

            <a class="pc-back" href="{{ route('podcasts.index') }}">
                <span>←</span>
                <span>Kembali ke Podcast</span>
            </a>
        </header>

        @if($errors->any())
            <div class="pc-errors">
                <strong>Ada yang perlu diperbaiki:</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            class="pc-card"
            action="{{ route('podcasts.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <section class="pc-section">
                <div class="pc-section-head">
                    <h2 class="pc-section-title">Pilih format episode</h2>

                    <p class="pc-section-desc">
                        Pilih cara yang paling cocok untuk menyampaikan isi podcastmu.
                    </p>
                </div>

                <div class="pc-format">

                    <div class="pc-format-item">
                        <input
                            type="radio"
                            name="media_type"
                            value="audio"
                            id="podcastAudio"
                            {{ old('media_type', 'audio') === 'audio' ? 'checked' : '' }}
                        >

                        <label class="pc-option" for="podcastAudio">
                            <span class="pc-radio-dot"></span>

                            <span class="pc-option-icon">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M4 13v-1a8 8 0 0 1 16 0v1"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                    />

                                    <path
                                        d="M4 13h2a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a1 1 0 0 1-1-1v-6Z"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    />

                                    <path
                                        d="M20 13h-2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1a1 1 0 0 0 1-1v-6Z"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    />
                                </svg>
                            </span>

                            <strong>Podcast Audio</strong>

                            <span class="pc-option-desc">
                                Cocok untuk cerita dan obrolan yang bisa dinikmati
                                tanpa perlu melihat layar.
                            </span>
                        </label>
                    </div>

                    <div class="pc-format-item">
                        <input
                            type="radio"
                            name="media_type"
                            value="video"
                            id="podcastVideo"
                            {{ old('media_type') === 'video' ? 'checked' : '' }}
                        >

                        <label class="pc-option" for="podcastVideo">
                            <span class="pc-radio-dot"></span>

                            <span class="pc-option-icon">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <rect
                                        x="3"
                                        y="6"
                                        width="12"
                                        height="12"
                                        rx="2"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    />

                                    <path
                                        d="M15 10l5-3v10l-5-3v-4Z"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                            </span>

                            <strong>Video Podcast</strong>

                            <span class="pc-option-desc">
                                Cocok untuk percakapan atau pembahasan yang lebih
                                menarik ketika dinikmati secara visual.
                            </span>
                        </label>
                    </div>

                </div>
            </section>

            <section class="pc-section">
                <div class="pc-section-head">
                    <h2 class="pc-section-title">Informasi episode</h2>

                    <p class="pc-section-desc">
                        Lengkapi informasi utama agar episode mudah ditemukan dan dipahami.
                    </p>
                </div>

                <div class="pc-grid">

                    <div class="pc-field full">
                        <label for="title">
                            Judul episode
                            <span class="pc-required">*</span>
                        </label>

                        <input
                            id="title"
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            maxlength="160"
                            required
                            placeholder="Contoh: Cerita Magang Pertama Kali"
                        >
                    </div>

                    <div class="pc-field full">
                        <label for="description">
                            Deskripsi
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            placeholder="Ceritakan secara singkat isi episode..."
                        >{{ old('description') }}</textarea>
                    </div>

                    <div class="pc-field">
                        <label for="category">
                            Kategori
                        </label>

                        <select id="category" name="category">
                            <option value="">
                                Pilih kategori
                            </option>

                            @foreach($categories as $category)
                                <option
                                    value="{{ $category }}"
                                    {{ old('category') === $category ? 'selected' : '' }}
                                >
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pc-field">
                        <label for="podcast_series_id">
                            Series
                        </label>

                        <select
                            id="podcast_series_id"
                            name="podcast_series_id"
                        >
                            <option value="">
                                Tanpa series
                            </option>

                            @foreach($series as $item)
                                <option
                                    value="{{ $item->id }}"
                                    {{ (string) old('podcast_series_id') === (string) $item->id ? 'selected' : '' }}
                                >
                                    {{ $item->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pc-field">
                        <label for="episode_number">
                            Nomor episode
                        </label>

                        <input
                            id="episode_number"
                            type="number"
                            name="episode_number"
                            min="1"
                            value="{{ old('episode_number') }}"
                            placeholder="Contoh: 1"
                        >
                    </div>

                    <div class="pc-field">
                        <label for="duration_seconds">
                            Durasi episode
                        </label>

                        <input
                            id="duration_seconds"
                            type="number"
                            name="duration_seconds"
                            min="0"
                            value="{{ old('duration_seconds', 0) }}"
                            placeholder="Contoh: 1800"
                        >

                        <span class="pc-help">
                            Masukkan durasi dalam detik. Contoh: 1800 = 30 menit.
                        </span>
                    </div>

                </div>
            </section>

            <section class="pc-section">
                <div class="pc-section-head">
                    <h2 class="pc-section-title">
                        Media episode
                    </h2>

                    <p class="pc-section-desc">
                        Upload file utama serta gambar pendukung episode.
                    </p>
                </div>

                <div class="pc-grid">

                    <div class="pc-field full">
                        <label>
                            File podcast
                            <span class="pc-required">*</span>
                        </label>

                        <div class="pc-upload">
                            <div class="pc-upload-icon">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M12 16V5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                    />

                                    <path
                                        d="M8 9l4-4 4 4"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />

                                    <path
                                        d="M5 19h14"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                    />
                                </svg>
                            </div>

                            <strong id="mediaHelp">
                                Upload file audio
                            </strong>

                            <span id="mediaFormatHelp">
                                MP3, WAV, M4A, AAC, OGG · maksimal 200 MB
                            </span>

                            <input
                                type="file"
                                name="media_file"
                                id="mediaFile"
                                accept=".mp3,.wav,.m4a,.aac,.ogg,audio/*"
                                required
                            >
                        </div>
                    </div>

                    <div class="pc-field pc-image-field">
                        <label for="cover_image">
                            Cover episode
                        </label>

                        <input
                            id="cover_image"
                            type="file"
                            name="cover_image"
                            accept=".jpg,.jpeg,.png,.webp,image/*"
                        >

                        <span class="pc-help">
                            JPG, PNG, atau WEBP.
                        </span>
                    </div>

                    <div
                        class="pc-field pc-image-field"
                        id="thumbnailField"
                    >
                        <label for="thumbnail_image">
                            Thumbnail video
                        </label>

                        <input
                            id="thumbnail_image"
                            type="file"
                            name="thumbnail_image"
                            accept=".jpg,.jpeg,.png,.webp,image/*"
                        >

                        <span class="pc-help">
                            Ditampilkan untuk episode berformat video.
                        </span>
                    </div>

                </div>
            </section>

            <div class="pc-actions">
                <a
                    class="pc-btn secondary"
                    href="{{ route('podcasts.index') }}"
                >
                    Batal
                </a>

                <button
                    class="pc-btn primary"
                    type="submit"
                >
                    Publikasikan Podcast
                </button>
            </div>

        </form>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const audio = document.getElementById('podcastAudio');
        const video = document.getElementById('podcastVideo');
        const file = document.getElementById('mediaFile');
        const help = document.getElementById('mediaHelp');
        const formats = document.getElementById('mediaFormatHelp');
        const thumbnailField = document.getElementById('thumbnailField');

        function syncPodcastFormat(resetFile = false) {
            if (video.checked) {
                file.accept = '.mp4,.webm,.mov,.m4v,video/*';

                help.textContent = 'Upload file video';

                formats.textContent =
                    'MP4, WEBM, MOV, M4V · maksimal 200 MB';

                thumbnailField.style.display = 'grid';
            } else {
                file.accept = '.mp3,.wav,.m4a,.aac,.ogg,audio/*';

                help.textContent = 'Upload file audio';

                formats.textContent =
                    'MP3, WAV, M4A, AAC, OGG · maksimal 200 MB';

                thumbnailField.style.display = 'none';
            }

            if (resetFile) {
                file.value = '';
            }
        }

        audio.addEventListener('change', () => {
            syncPodcastFormat(true);
        });

        video.addEventListener('change', () => {
            syncPodcastFormat(true);
        });

        syncPodcastFormat(false);
    });
</script>
</x-app-layout>