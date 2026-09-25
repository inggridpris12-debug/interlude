@php
    $attachments = $attachments ?? collect();
    $images = $attachments->where('type', 'image')->values();
    $videos = $attachments->where('type', 'video')->values();
    $audios = $attachments->where('type', 'audio')->values();
    $files = $attachments->where('type', 'file')->values();
    $links = $attachments->where('type', 'link')->values();
@endphp

@if($images->isNotEmpty())
    <div class="attachment-images attachment-images--{{ min($images->count(), 4) }}">
        @foreach($images->take(4) as $image)
            <a
                href="{{ asset('storage/' . $image->path) }}"
                target="_blank"
                rel="noopener"
                class="attachment-image-link"
                data-stop-thread-click
            >
                <img
                    src="{{ asset('storage/' . $image->path) }}"
                    alt="{{ $image->original_name ?: 'Lampiran gambar' }}"
                >
            </a>
        @endforeach
    </div>
@endif

@foreach($videos as $video)
    <div class="attachment-video" data-stop-thread-click>
        <video controls preload="metadata" playsinline>
            <source
                src="{{ asset('storage/' . $video->path) }}"
                type="{{ $video->mime_type }}"
            >
            Browser kamu tidak mendukung video.
        </video>
    </div>
@endforeach

@foreach($audios as $audio)
    <div class="attachment-audio" data-stop-thread-click>
        <div class="attachment-audio-title">
            <i class="fas fa-headphones"></i>
            <span>{{ $audio->original_name ?: 'Audio' }}</span>
        </div>

        <audio controls preload="metadata">
            <source
                src="{{ asset('storage/' . $audio->path) }}"
                type="{{ $audio->mime_type }}"
            >
        </audio>
    </div>
@endforeach

@foreach($files as $file)
    @php
        $sizeMb = $file->file_size
            ? number_format($file->file_size / 1048576, 1)
            : null;
    @endphp

    <a
        href="{{ asset('storage/' . $file->path) }}"
        target="_blank"
        rel="noopener"
        class="attachment-file"
        data-stop-thread-click
    >
        <span class="attachment-file-icon">
            <i class="far fa-file-lines"></i>
        </span>

        <span class="attachment-file-copy">
            <strong>{{ $file->original_name ?: 'Lampiran' }}</strong>
            <span>
                {{ strtoupper(pathinfo($file->original_name ?? '', PATHINFO_EXTENSION) ?: 'FILE') }}
                @if($sizeMb)
                    · {{ $sizeMb }} MB
                @endif
            </span>
        </span>

        <i class="fas fa-arrow-up-right-from-square attachment-file-open"></i>
    </a>
@endforeach

@foreach($links as $link)
    @php
        $url = data_get($link->metadata, 'url');
    @endphp

    @if($url)
        <a
            href="{{ $url }}"
            target="_blank"
            rel="noopener noreferrer"
            class="attachment-link-card"
            data-stop-thread-click
        >
            <span class="attachment-link-icon">
                <i class="fas fa-link"></i>
            </span>

            <span class="attachment-link-copy">
                <strong>{{ parse_url($url, PHP_URL_HOST) ?: 'Tautan' }}</strong>
                <span>{{ Str::limit($url, 80) }}</span>
            </span>

            <i class="fas fa-arrow-up-right-from-square"></i>
        </a>
    @endif
@endforeach
