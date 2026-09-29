<x-app-layout>
<style>
.podcast-create{--orange:#FB4D00;--brown:#49261D;--linen:#FFEDE3;--blue:#CAE7F7;--border:#E8DCD6;--muted:#806C64;min-height:100vh;background:#FFF9F4;color:#30120A;font-family:'DM Sans',sans-serif}
.pc-shell{width:min(920px,calc(100% - 30px));margin:auto;padding:42px 0 70px}
.pc-head{margin-bottom:24px}.pc-kicker{color:var(--orange);font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:1.2px}.pc-head h1{margin:7px 0 6px;font:800 clamp(31px,5vw,48px)/1.05 'Plus Jakarta Sans';letter-spacing:-1.7px}.pc-head p{margin:0;color:var(--muted);font-size:12px}
.pc-card{padding:27px;border:1px solid var(--border);border-radius:26px;background:#fff;box-shadow:0 16px 38px rgba(73,38,29,.06)}
.pc-format{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:22px}.pc-format input{display:none}.pc-format label{padding:18px;border:2px solid #EEE4DF;border-radius:18px;background:#FFFDFC;cursor:pointer;transition:.18s}.pc-format label strong{display:block;font:800 15px 'Plus Jakarta Sans'}.pc-format label span{display:block;margin-top:4px;color:var(--muted);font-size:9px}.pc-format input:checked+label{border-color:var(--orange);background:var(--linen)}
.pc-grid{display:grid;grid-template-columns:1fr 1fr;gap:15px}.pc-field{display:grid;gap:6px}.pc-field.full{grid-column:1/-1}.pc-field label{font-size:9px;font-weight:800;color:#5F453D}.pc-field input,.pc-field textarea,.pc-field select{width:100%;box-sizing:border-box;border:1px solid #DDD0CA;border-radius:12px;background:#FFFDFC;padding:11px 12px;color:#30120A;font:500 11px 'DM Sans';outline:none}.pc-field textarea{min-height:112px;resize:vertical}.pc-field input:focus,.pc-field textarea:focus,.pc-field select:focus{border-color:var(--orange);box-shadow:0 0 0 3px rgba(251,77,0,.08)}
.pc-upload{padding:18px;border:1px dashed #D5C3BC;border-radius:15px;background:#FBF7F4}.pc-upload strong{display:block;font-size:10px}.pc-upload span{display:block;margin:4px 0 9px;color:var(--muted);font-size:8px}.pc-errors{margin-bottom:18px;padding:14px 16px;border-radius:14px;background:#FFF0ED;color:#9D2510;font-size:10px}.pc-errors ul{margin:0;padding-left:18px}.pc-actions{margin-top:22px;display:flex;justify-content:flex-end;gap:9px}.pc-actions a,.pc-actions button{min-height:42px;padding:0 20px;display:inline-flex;align-items:center;justify-content:center;border-radius:999px;font-size:10px;font-weight:800;text-decoration:none;cursor:pointer}.pc-actions a{background:#F2EDE9;color:var(--brown)}.pc-actions button{border:0;background:var(--orange);color:#fff}
@media(max-width:650px){.pc-grid,.pc-format{grid-template-columns:1fr}.pc-field.full{grid-column:auto}.pc-card{padding:18px}}
</style>

<main class="podcast-create">
<div class="pc-shell">
<div class="pc-head">
<span class="pc-kicker">Podcast Interlude</span>
<h1>Publikasikan episode baru.</h1>
<p>Pilih Audio atau Video, lalu unggah file asli podcast-mu.</p>
</div>

@if($errors->any())
<div class="pc-errors">
<strong>Ada yang perlu diperbaiki:</strong>
<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif

<form class="pc-card" action="{{ route('podcasts.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="pc-format">
<div>
<input type="radio" name="media_type" value="audio" id="podcastAudio" {{ old('media_type','audio') === 'audio' ? 'checked' : '' }}>
<label for="podcastAudio">
<strong>🎧 Audio</strong>
<span>MP3, WAV, M4A, AAC, atau OGG.</span>
</label>
</div>
<div>
<input type="radio" name="media_type" value="video" id="podcastVideo" {{ old('media_type') === 'video' ? 'checked' : '' }}>
<label for="podcastVideo">
<strong>🎥 Video</strong>
<span>MP4, WEBM, MOV, atau M4V.</span>
</label>
</div>
</div>

<div class="pc-grid">
<div class="pc-field full">
<label>Judul episode *</label>
<input type="text" name="title" value="{{ old('title') }}" maxlength="160" required placeholder="Contoh: Cerita Magang Pertama Kali">
</div>

<div class="pc-field full">
<label>Deskripsi</label>
<textarea name="description" placeholder="Episode ini membahas tentang...">{{ old('description') }}</textarea>
</div>

<div class="pc-field">
<label>Kategori</label>
<select name="category">
<option value="">Pilih kategori</option>
@foreach($categories as $category)
<option value="{{ $category }}" {{ old('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
@endforeach
</select>
</div>

<div class="pc-field">
<label>Series</label>
<select name="podcast_series_id">
<option value="">Tanpa series</option>
@foreach($series as $item)
<option value="{{ $item->id }}" {{ (string)old('podcast_series_id') === (string)$item->id ? 'selected' : '' }}>{{ $item->title }}</option>
@endforeach
</select>
</div>

<div class="pc-field">
<label>Nomor episode</label>
<input type="number" name="episode_number" min="1" value="{{ old('episode_number') }}" placeholder="1">
</div>

<div class="pc-field">
<label>Durasi (detik)</label>
<input type="number" name="duration_seconds" min="0" value="{{ old('duration_seconds',0) }}" placeholder="Contoh: 930">
</div>

<div class="pc-field full">
<label>File podcast *</label>
<div class="pc-upload">
<strong id="mediaHelp">Upload audio</strong>
<span id="mediaFormatHelp">Maksimal 200 MB · MP3/WAV/M4A/AAC/OGG</span>
<input type="file" name="media_file" id="mediaFile" accept=".mp3,.wav,.m4a,.aac,.ogg" required>
</div>
</div>

<div class="pc-field">
<label>Cover</label>
<input type="file" name="cover_image" accept=".jpg,.jpeg,.png,.webp,image/*">
</div>

<div class="pc-field" id="thumbnailField">
<label>Thumbnail video (opsional)</label>
<input type="file" name="thumbnail_image" accept=".jpg,.jpeg,.png,.webp,image/*">
</div>

<div class="pc-field full">
<label>Transkrip (opsional)</label>
<textarea name="transcript" placeholder="Tempel transkrip episode di sini...">{{ old('transcript') }}</textarea>
</div>
</div>

<div class="pc-actions">
<a href="{{ route('podcasts.index') }}">Batal</a>
<button type="submit">Publikasikan Podcast</button>
</div>
</form>
</div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const audio = document.getElementById('podcastAudio');
    const video = document.getElementById('podcastVideo');
    const mediaFile = document.getElementById('mediaFile');
    const help = document.getElementById('mediaHelp');
    const formatHelp = document.getElementById('mediaFormatHelp');
    const thumbnailField = document.getElementById('thumbnailField');

    function syncType() {
        if (video.checked) {
            mediaFile.accept = '.mp4,.webm,.mov,.m4v,video/*';
            help.textContent = 'Upload video';
            formatHelp.textContent = 'Maksimal 200 MB · MP4/WEBM/MOV/M4V';
            thumbnailField.style.display = '';
        } else {
            mediaFile.accept = '.mp3,.wav,.m4a,.aac,.ogg,audio/*';
            help.textContent = 'Upload audio';
            formatHelp.textContent = 'Maksimal 200 MB · MP3/WAV/M4A/AAC/OGG';
            thumbnailField.style.display = 'none';
        }
        mediaFile.value = '';
    }

    audio.addEventListener('change', syncType);
    video.addEventListener('change', syncType);
    syncType();
});
</script>
</x-app-layout>
