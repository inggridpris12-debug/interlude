<x-app-layout>
    @php
        $hasExistingCover = isset($article)
            && $article->cover_image
            && \Illuminate\Support\Facades\Storage::disk('public')->exists($article->cover_image);
    @endphp

    <div class="write-container">
        <div class="write-header">
            <div class="write-brand">
                <span class="write-mark">I</span>
                <strong>Interlude</strong>
            </div>

            <a href="{{ route('dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>

            <div class="write-actions">
                <span class="save-status">
                    <i class="far fa-pen-to-square"></i>
                    Perubahan belum dipublikasikan
                </span>

                <button type="button" class="btn-secondary-action" onclick="submitForm(false)">
                    <i class="far fa-file-lines"></i>
                    Simpan draft
                </button>

                <button type="button" class="btn-secondary-action" onclick="previewArticle()">
                    <i class="far fa-eye"></i>
                    Preview
                </button>

                <button type="button" class="btn-publish-primary" onclick="submitForm(true)">
                    {{ isset($article) ? 'Perbarui & Publikasikan' : 'Publikasikan' }}
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>

        <section class="publication-banner">
            <div class="publication-icon">
                <i class="fas fa-shield-heart"></i>
            </div>

            <div class="publication-copy">
                <div class="publication-kicker">PEDOMAN PUBLIKASI INTERLUDE</div>
                <p>
                    Bagikan pengalaman dan pengetahuan dengan jujur. Pastikan karya orisinal,
                    sumber dicantumkan, privasi orang lain terlindungi, dan informasi yang kamu
                    publikasikan dapat dipertanggungjawabkan.
                </p>
            </div>

            <button
                type="button"
                class="publication-link"
                onclick="document.getElementById('publicationGuidelines').showModal()"
            >
                Lihat pedoman lengkap
                <i class="fas fa-arrow-right"></i>
            </button>
        </section>

        @if ($errors->any())
            <div class="form-errors" role="alert">
                <div class="form-errors-icon"><i class="fas fa-circle-exclamation"></i></div>
                <div>
                    <strong>Ada bagian yang perlu diperiksa.</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form
            id="articleForm"
            action="{{ isset($article) ? route('articles.update', $article) : route('articles.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @if(isset($article))
                @method('PUT')
            @endif

            <div class="write-layout">
                <main class="write-main">
                    <div class="editor-meta-row">
                        <span class="editor-type">
                            <i class="far fa-pen-to-square"></i>
                            Artikel
                        </span>

                        <span>
                            <i class="far fa-clock"></i>
                            <span id="readingTime">1</span> menit baca
                        </span>

                        <span>
                            <i class="fas fa-align-left"></i>
                            <span id="wordCountTop">0</span> kata
                        </span>
                    </div>

                    <div class="field-block field-block-title">
                        <label for="titleInput" class="field-eyebrow">Judul</label>
                        <input
                            type="text"
                            name="title"
                            id="titleInput"
                            class="title-input"
                            placeholder="Tulis judul yang jelas dan menarik..."
                            value="{{ old('title', $article->title ?? '') }}"
                            maxlength="255"
                            required
                        >
                    </div>

                    <div class="field-block">
                        <label for="excerptInput" class="field-eyebrow">
                            Ringkasan
                            <span>Disarankan</span>
                        </label>
                        <textarea
                            name="excerpt"
                            id="excerptInput"
                            class="excerpt-input"
                            placeholder="Ceritakan singkat apa yang akan pembaca temukan di tulisan ini..."
                            rows="2"
                            maxlength="500"
                        >{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
                        <div class="field-counter"><span id="excerptCount">0</span>/500</div>
                    </div>

                    <div class="topic-field">
                        <div class="topic-heading">
                            <span class="field-eyebrow">Topik</span>
                            <span class="topic-help">Pilih satu topik yang paling sesuai</span>
                        </div>

                        <div class="category-select">
                            @foreach($categories as $category)
                                <label class="category-option">
                                    <input
                                        type="radio"
                                        name="category"
                                        value="{{ $category }}"
                                        {{ old('category', $article->category ?? '') == $category ? 'checked' : '' }}
                                        required
                                    >
                                    <span class="category-label">#{{ $category }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group editor-group">
                        <div class="editor-heading">
                            <div>
                                <span class="field-eyebrow">Isi cerita</span>
                                <p>Tulis dengan bahasamu sendiri. Kamu tetap bisa menyunting sebelum dipublikasikan.</p>
                            </div>
                        </div>

                        <div class="editor-toolbar" aria-label="Toolbar editor">
                            <button type="button" class="toolbar-btn" onclick="formatText('bold')" title="Tebal" aria-label="Tebal">
                                <i class="fas fa-bold"></i>
                            </button>
                            <button type="button" class="toolbar-btn" onclick="formatText('italic')" title="Miring" aria-label="Miring">
                                <i class="fas fa-italic"></i>
                            </button>
                            <button type="button" class="toolbar-btn toolbar-text" onclick="formatText('formatBlock', 'H2')" title="Subjudul">H2</button>
                            <button type="button" class="toolbar-btn" onclick="formatText('formatBlock', 'blockquote')" title="Kutipan" aria-label="Kutipan">
                                <i class="fas fa-quote-right"></i>
                            </button>
                            <button type="button" class="toolbar-btn" onclick="formatText('insertUnorderedList')" title="Daftar" aria-label="Daftar">
                                <i class="fas fa-list-ul"></i>
                            </button>
                            <button type="button" class="toolbar-btn" onclick="createEditorLink()" title="Tautan" aria-label="Tautan">
                                <i class="fas fa-link"></i>
                            </button>
                        </div>

                        <div
                            id="contentEditor"
                            class="content-editor"
                            contenteditable="true"
                            data-placeholder="Mulai tulis pengalaman, insight, atau hal yang kamu pelajari di sini..."
                        >{{ old('content', $article->content ?? '') }}</div>

                        <textarea name="content" id="contentInput" hidden>{{ old('content', $article->content ?? '') }}</textarea>

                        <div class="editor-footer">
                            <span>
                                <i class="fas fa-circle-info"></i>
                                Draft tersimpan ketika kamu menekan tombol <strong>Simpan draft</strong>.
                            </span>
                            <span>
                                <i class="far fa-user"></i>
                                {{ auth()->user()->name }}
                            </span>
                        </div>
                    </div>
                </main>

                <aside class="write-sidebar">
                    <section class="sidebar-panel cover-panel">
                        <div class="sidebar-panel-heading">
                            <div>
                                <span class="sidebar-kicker">Visual</span>
                                <h2>Gambar sampul</h2>
                            </div>
                            <span class="recommended-tag">16:9</span>
                        </div>

                        <label class="cover-upload" id="coverUpload" for="coverImage">
                            <input
                                type="file"
                                name="cover_image"
                                id="coverImage"
                                class="cover-input"
                                accept="image/jpeg,image/png,image/webp"
                                onchange="previewImage(this)"
                            >

                            <div
                                class="upload-placeholder"
                                id="uploadPlaceholder"
                                style="display: {{ $hasExistingCover ? 'none' : 'flex' }};"
                            >
                                <span class="upload-icon"><i class="far fa-image"></i></span>
                                <strong>Pilih gambar sampul</strong>
                                <span>JPG, PNG, atau WEBP · maksimal 2 MB</span>
                            </div>

                            <img
                                id="imagePreview"
                                class="image-preview"
                                src="{{ $hasExistingCover ? asset('storage/' . $article->cover_image) : '' }}"
                                alt="Preview gambar sampul"
                                style="display: {{ $hasExistingCover ? 'block' : 'none' }};"
                            >

                            <span class="cover-change" id="coverChange" style="display: {{ $hasExistingCover ? 'inline-flex' : 'none' }};">
                                <i class="fas fa-camera"></i>
                                Ganti
                            </span>
                        </label>

                        <p class="sidebar-help">
                            Gunakan visual yang relevan dengan isi tulisan. Pastikan kamu memiliki hak untuk menggunakannya.
                        </p>
                    </section>

                    <section class="sidebar-panel publication-status-panel">
                        <div class="sidebar-panel-heading">
                            <div>
                                <span class="sidebar-kicker">Status</span>
                                <h2>Publikasi</h2>
                            </div>
                        </div>

                        <label class="privacy-option">
                            <input
                                type="radio"
                                name="publish"
                                value="1"
                                {{ !isset($article) || $article->is_published ? 'checked' : '' }}
                            >
                            <span>
                                <strong><i class="fas fa-earth-asia"></i> Publik</strong>
                                <small>Artikel dapat ditemukan dan dibaca pengguna Interlude.</small>
                            </span>
                        </label>

                        <label class="privacy-option">
                            <input
                                type="radio"
                                name="publish"
                                value="0"
                                {{ isset($article) && ! $article->is_published ? 'checked' : '' }}
                            >
                            <span>
                                <strong><i class="far fa-file-lines"></i> Draft</strong>
                                <small>Belum dipublikasikan. Kamu masih bisa melanjutkan penyuntingan.</small>
                            </span>
                        </label>
                    </section>

                    <section class="sidebar-panel checklist-panel">
                        <div class="sidebar-panel-heading">
                            <div>
                                <span class="sidebar-kicker">Sebelum terbit</span>
                                <h2>Checklist publikasi</h2>
                            </div>
                            <span class="checklist-score" id="checklistScore">0/5</span>
                        </div>

                        <div class="checklist-progress" aria-hidden="true">
                            <span id="checklistProgress"></span>
                        </div>

                        <div class="checklist-items">
                            <div class="checklist-item" id="checkTitle">
                                <span class="check-icon"><i class="fas fa-check"></i></span>
                                <div>
                                    <strong>Judul sudah jelas</strong>
                                    <small>Wajib</small>
                                </div>
                            </div>

                            <div class="checklist-item" id="checkExcerpt">
                                <span class="check-icon"><i class="fas fa-check"></i></span>
                                <div>
                                    <strong>Ringkasan sudah diisi</strong>
                                    <small>Disarankan</small>
                                </div>
                            </div>

                            <div class="checklist-item" id="checkCategory">
                                <span class="check-icon"><i class="fas fa-check"></i></span>
                                <div>
                                    <strong>Topik sudah dipilih</strong>
                                    <small>Wajib</small>
                                </div>
                            </div>

                            <div class="checklist-item" id="checkContent">
                                <span class="check-icon"><i class="fas fa-check"></i></span>
                                <div>
                                    <strong>Isi cerita sudah ditulis</strong>
                                    <small>Wajib</small>
                                </div>
                            </div>

                            <div class="checklist-item" id="checkCover">
                                <span class="check-icon"><i class="fas fa-check"></i></span>
                                <div>
                                    <strong>Gambar sampul ditambahkan</strong>
                                    <small>Disarankan</small>
                                </div>
                            </div>
                        </div>

                        <p class="checklist-note">
                            Sebelum publikasi, periksa kembali sumber, privasi, dan izin penggunaan media.
                        </p>
                    </section>
                </aside>
            </div>
        </form>
    </div>

    <dialog id="publicationGuidelines" class="guideline-dialog">
        <div class="guideline-dialog-content">
            <div class="guideline-head">
                <div>
                    <span class="write-kicker">PEDOMAN PUBLIKASI INTERLUDE</span>
                    <h2>Berbagi dengan jujur dan bertanggung jawab.</h2>
                    <p>
                        Pedoman ini berlaku untuk karya yang dibagikan di Interlude. Penulis tetap bertanggung jawab
                        atas isi akhir yang dipublikasikan.
                    </p>
                </div>

                <button
                    type="button"
                    class="close-guideline"
                    onclick="document.getElementById('publicationGuidelines').close()"
                    aria-label="Tutup pedoman publikasi"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="guideline-list">
                <article class="guideline-item">
                    <span>01</span>
                    <div><h3>Karya harus orisinal</h3><p>Publikasikan tulisan dan media yang kamu buat sendiri atau memang memiliki izin untuk digunakan. Jangan mengaku karya orang lain sebagai milik sendiri.</p></div>
                </article>

                <article class="guideline-item">
                    <span>02</span>
                    <div><h3>Cantumkan sumber dengan jelas</h3><p>Data, kutipan, teori, gambar, atau gagasan yang berasal dari pihak lain perlu disertai sumber yang sesuai.</p></div>
                </article>

                <article class="guideline-item">
                    <span>03</span>
                    <div><h3>Jujur terhadap pengalaman dan informasi</h3><p>Jangan memalsukan data, pengalaman, identitas, hasil penelitian, atau informasi lain agar konten terlihat lebih menarik.</p></div>
                </article>

                <article class="guideline-item">
                    <span>04</span>
                    <div><h3>Bedakan fakta, opini, dan pengalaman pribadi</h3><p>Pengalaman pribadi boleh dibagikan, tetapi jangan disampaikan seolah-olah mewakili semua orang atau merupakan fakta umum.</p></div>
                </article>

                <article class="guideline-item">
                    <span>05</span>
                    <div><h3>Hormati privasi orang lain</h3><p>Hindari membagikan nama lengkap, nomor kontak, alamat, percakapan pribadi, foto, data responden, atau informasi sensitif tanpa persetujuan.</p></div>
                </article>

                <article class="guideline-item">
                    <span>06</span>
                    <div><h3>Jangan membahayakan atau merendahkan orang lain</h3><p>Konten yang berisi intimidasi, ancaman, pelecehan, diskriminasi, perundungan, atau serangan personal tidak diperbolehkan.</p></div>
                </article>

                <article class="guideline-item">
                    <span>07</span>
                    <div><h3>Hormati hak cipta dan izin media</h3><p>Foto, ilustrasi, musik, rekaman, dokumen, maupun media lain harus merupakan milik sendiri, berlisensi sesuai, atau digunakan dengan izin.</p></div>
                </article>

                <article class="guideline-item">
                    <span>08</span>
                    <div><h3>Jaga kerahasiaan informasi</h3><p>Jangan mempublikasikan dokumen internal, data penelitian rahasia, kredensial akun, atau informasi organisasi dan perusahaan yang bersifat terbatas.</p></div>
                </article>

                <article class="guideline-item">
                    <span>09</span>
                    <div><h3>Gunakan AI secara bertanggung jawab</h3><p>AI boleh membantu proses menulis atau menyunting, tetapi penulis tetap bertanggung jawab atas ketepatan, orisinalitas, dan isi akhir.</p></div>
                </article>

                <article class="guideline-item">
                    <span>10</span>
                    <div><h3>Judul dan sampul harus sesuai isi</h3><p>Hindari judul atau gambar sampul yang menyesatkan, manipulatif, atau memberi gambaran yang berbeda dari isi karya.</p></div>
                </article>

                <article class="guideline-item">
                    <span>11</span>
                    <div><h3>Hindari spam dan promosi berlebihan</h3><p>Interlude digunakan untuk berbagi pengetahuan dan pengalaman, bukan iklan berulang, manipulasi engagement, atau promosi terselubung.</p></div>
                </article>

                <article class="guideline-item">
                    <span>12</span>
                    <div><h3>Terbuka terhadap koreksi</h3><p>Jika terdapat kekeliruan, penulis diharapkan memperbarui atau mengoreksi kontennya secara bertanggung jawab.</p></div>
                </article>
            </div>

            <div class="guideline-footer">
                <p>
                    Dengan mempublikasikan karya di Interlude, kamu menyatakan bahwa konten telah diperiksa dan dapat dipertanggungjawabkan sesuai pedoman ini.
                </p>
                <button
                    type="button"
                    class="btn-publish-primary"
                    onclick="document.getElementById('publicationGuidelines').close()"
                >
                    Saya mengerti
                </button>
            </div>
        </div>
    </dialog>

    <div id="previewModal" class="preview-modal" aria-hidden="true">
        <div class="preview-overlay" onclick="closePreview()"></div>

        <div class="preview-content" role="dialog" aria-modal="true" aria-labelledby="previewTitle">
            <div class="preview-header">
                <div>
                    <span class="write-kicker">PRATINJAU</span>
                    <h3 id="previewTitle">Preview artikel</h3>
                </div>
                <button type="button" class="close-preview" onclick="closePreview()" aria-label="Tutup preview">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="preview-body" id="previewBody"></div>

            <div class="preview-footer">
                <button type="button" class="btn-secondary-action" onclick="closePreview()">Kembali edit</button>
                <button type="button" class="btn-publish-primary" onclick="submitForm(true)">
                    Publikasikan
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <style>
        .write-container {
            width: min(1180px, 100%);
            margin: 0 auto;
            padding: 24px 28px 90px;
            min-height: 100vh;
            color: #49261D;
        }

        .write-header {
            display: grid;
            grid-template-columns: auto auto 1fr;
            align-items: center;
            gap: 18px;
            padding: 6px 0 20px;
        }

        .write-brand {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: #2f211d;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
        }

        .write-mark {
            display: grid;
            width: 22px;
            height: 22px;
            place-items: center;
            border-radius: 7px;
            background: #49261D;
            color: #fff;
            font-size: 10px;
            font-weight: 800;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #68534c;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            transition: .2s ease;
        }

        .back-btn:hover { color: #FB4D00; }

        .write-actions {
            justify-self: end;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .save-status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-right: 4px;
            color: #8a7770;
            font-size: 11px;
        }

        .save-status i { color: #9f857b; }

        .btn-secondary-action,
        .btn-publish-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 38px;
            padding: 0 15px;
            border-radius: 999px;
            font-family: 'DM Sans', sans-serif;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            transition: .2s ease;
        }

        .btn-secondary-action {
            border: 1px solid #e5d5cd;
            background: #fff;
            color: #49261D;
        }

        .btn-secondary-action:hover {
            border-color: #c9a99b;
            background: #FFF9F4;
        }

        .btn-publish-primary {
            border: 0;
            background: #FB4D00;
            color: #fff;
            box-shadow: 0 7px 16px rgba(251, 77, 0, .16);
        }

        .btn-publish-primary:hover {
            background: #49261D;
            transform: translateY(-1px);
        }

        .publication-banner {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 15px;
            margin-bottom: 18px;
            padding: 17px 19px;
            border: 1px solid rgba(73, 38, 29, .08);
            border-radius: 22px;
            background: linear-gradient(115deg, #49261D 0%, #3d241f 54%, #26363a 100%);
            box-shadow: 0 12px 28px rgba(73, 38, 29, .10);
        }

        .publication-icon {
            display: grid;
            width: 40px;
            height: 40px;
            place-items: center;
            border-radius: 13px;
            background: #FB4D00;
            color: #fff;
        }

        .publication-kicker {
            margin-bottom: 4px;
            color: #FFD8C8;
            font: 800 10px 'Plus Jakarta Sans', sans-serif;
            letter-spacing: .8px;
        }

        .publication-copy p {
            max-width: 720px;
            margin: 0;
            color: rgba(255, 255, 255, .88);
            font-size: 11px;
            line-height: 1.55;
        }

        .publication-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 12px;
            border: 1px solid rgba(255, 255, 255, .20);
            border-radius: 999px;
            background: rgba(255, 255, 255, .09);
            color: #fff;
            font: 800 10px 'DM Sans', sans-serif;
            cursor: pointer;
            white-space: nowrap;
        }

        .publication-link:hover { background: rgba(255, 255, 255, .15); }

        .form-errors {
            display: flex;
            gap: 12px;
            margin: 0 0 18px;
            padding: 14px 16px;
            border: 1px solid #f5c4b4;
            border-radius: 16px;
            background: #FFF4EF;
            color: #7f2d16;
            font-size: 12px;
        }

        .form-errors-icon { padding-top: 1px; color: #FB4D00; }
        .form-errors strong { display: block; margin-bottom: 4px; }
        .form-errors ul { margin: 0; padding-left: 18px; }

        .write-layout {
            display: grid;
            grid-template-columns: minmax(0, 1.86fr) minmax(285px, .82fr);
            gap: 18px;
            align-items: start;
        }

        .write-main {
            min-width: 0;
            padding: 27px 29px 22px;
            border: 1px solid rgba(73, 38, 29, .07);
            border-radius: 26px;
            background: #fff;
            box-shadow: 0 7px 26px rgba(73, 38, 29, .045);
        }

        .editor-meta-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 7px;
            margin-bottom: 24px;
            color: #76645d;
            font-size: 10px;
        }

        .editor-meta-row > span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 9px;
            border-radius: 999px;
            background: #F7F3F0;
        }

        .editor-meta-row .editor-type {
            background: #FFEDE3;
            color: #A33613;
            font-weight: 800;
        }

        .field-block {
            position: relative;
            padding: 0 0 18px;
            border-bottom: 1px solid #EEE6E1;
        }

        .field-block + .field-block { padding-top: 17px; }
        .field-block-title { padding-bottom: 8px; }

        .field-eyebrow,
        .sidebar-kicker {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #9B3B1D;
            font: 800 9px 'Plus Jakarta Sans', sans-serif;
            letter-spacing: .7px;
            text-transform: uppercase;
        }

        .field-eyebrow span {
            color: #9A8981;
            font-weight: 600;
            letter-spacing: 0;
            text-transform: none;
        }

        .title-input {
            width: 100%;
            margin: 6px 0 0;
            padding: 4px 0 8px;
            border: 0;
            outline: 0;
            background: transparent;
            color: #342622;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(31px, 4.2vw, 46px);
            font-weight: 800;
            letter-spacing: -1.7px;
            line-height: 1.08;
        }

        .title-input::placeholder { color: #DCCBC3; }

        .excerpt-input {
            width: 100%;
            margin-top: 7px;
            padding: 2px 0 5px;
            border: 0;
            outline: 0;
            resize: none;
            background: transparent;
            color: #604E47;
            font: 400 14px/1.6 'DM Sans', sans-serif;
        }

        .excerpt-input::placeholder { color: #BDAAA2; }

        .field-counter {
            margin-top: 4px;
            color: #A49189;
            font-size: 9px;
            text-align: right;
        }

        .topic-field {
            padding: 18px 0 19px;
            border-bottom: 1px solid #EEE6E1;
        }

        .topic-heading {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 10px;
        }

        .topic-help { color: #A18E86; font-size: 9px; }

        .category-select {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .category-option { cursor: pointer; }
        .category-option input { display: none; }

        .category-label {
            display: inline-flex;
            padding: 6px 9px;
            border: 1px solid #E8DDD7;
            border-radius: 999px;
            background: #fff;
            color: #664E46;
            font-size: 10px;
            font-weight: 600;
            transition: .18s ease;
        }

        .category-option:hover .category-label {
            border-color: #F0B39F;
            background: #FFF9F5;
        }

        .category-option input:checked + .category-label {
            border-color: #F2A88F;
            background: #FFEDE3;
            color: #A33613;
            box-shadow: 0 0 0 2px rgba(251, 77, 0, .05);
        }

        .editor-group { margin-top: 18px; }

        .editor-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .editor-heading p {
            margin: 5px 0 0;
            color: #9B8981;
            font-size: 10px;
        }

        .editor-toolbar {
            display: flex;
            align-items: center;
            gap: 2px;
            width: fit-content;
            max-width: 100%;
            padding: 6px 7px;
            border: 1px solid #E8DDD7;
            border-radius: 999px;
            background: #fff;
            box-shadow: 0 5px 14px rgba(73, 38, 29, .07);
        }

        .toolbar-btn {
            display: grid;
            width: 30px;
            height: 30px;
            place-items: center;
            border: 0;
            border-radius: 50%;
            background: transparent;
            color: #55433D;
            font-size: 10px;
            cursor: pointer;
            transition: .15s ease;
        }

        .toolbar-btn:hover {
            background: #FFEDE3;
            color: #B43A17;
        }

        .toolbar-text { font-weight: 800; font-family: 'Plus Jakarta Sans', sans-serif; }

        .content-editor {
            width: 100%;
            min-height: 400px;
            padding: 23px 2px 28px;
            border: 0;
            outline: 0;
            background: #fff;
            color: #364045;
            font: 400 15px/1.82 'DM Sans', sans-serif;
            overflow-wrap: anywhere;
        }

        .content-editor:empty::before {
            content: attr(data-placeholder);
            color: #C5B3AB;
        }

        .content-editor h2 {
            margin: 29px 0 11px;
            color: #342622;
            font: 800 21px/1.35 'Plus Jakarta Sans', sans-serif;
        }

        .content-editor blockquote {
            margin: 20px 0;
            padding: 15px 17px;
            border-left: 4px solid #FB4D00;
            border-radius: 0 12px 12px 0;
            background: #FFF6F1;
            color: #6E554D;
            font-style: italic;
        }

        .content-editor ul,
        .content-editor ol { margin: 14px 0; padding-left: 24px; }
        .content-editor li { margin: 6px 0; }

        .editor-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding-top: 13px;
            border-top: 1px solid #EEE6E1;
            color: #99877F;
            font-size: 9px;
        }

        .editor-footer i { margin-right: 5px; color: #B24421; }

        .write-sidebar {
            display: grid;
            gap: 14px;
        }

        .sidebar-panel {
            padding: 18px;
            border: 1px solid rgba(73, 38, 29, .07);
            border-radius: 22px;
            background: #fff;
            box-shadow: 0 6px 22px rgba(73, 38, 29, .04);
        }

        .sidebar-panel-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 13px;
        }

        .sidebar-panel-heading h2 {
            margin: 3px 0 0;
            color: #382822;
            font: 800 15px 'Plus Jakarta Sans', sans-serif;
        }

        .recommended-tag,
        .checklist-score {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 25px;
            padding: 0 8px;
            border-radius: 999px;
            background: #FFF0E9;
            color: #AD3A17;
            font-size: 9px;
            font-weight: 800;
        }

        .cover-upload {
            position: relative;
            display: block;
            width: 100%;
            height: 165px;
            overflow: hidden;
            border: 1px dashed #D9C8BF;
            border-radius: 15px;
            background: linear-gradient(135deg, #F6E8DF, #F1DED1);
            cursor: pointer;
            transition: .18s ease;
        }

        .cover-upload:hover {
            border-color: #FB4D00;
            transform: translateY(-1px);
        }

        .cover-input {
            position: absolute;
            inset: 0;
            z-index: 5;
            opacity: 0;
            cursor: pointer;
        }

        .upload-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 15px;
            text-align: center;
        }

        .upload-placeholder .upload-icon {
            display: grid;
            width: 38px;
            height: 38px;
            place-items: center;
            margin-bottom: 3px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .72);
            color: #976B58;
        }

        .upload-placeholder strong { color: #5D443A; font-size: 11px; }
        .upload-placeholder > span:last-child { color: #8A7166; font-size: 9px; }

        .image-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cover-change {
            position: absolute;
            right: 9px;
            bottom: 9px;
            z-index: 4;
            align-items: center;
            gap: 5px;
            padding: 6px 8px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .92);
            color: #49261D;
            font-size: 9px;
            font-weight: 800;
        }

        .sidebar-help {
            margin: 10px 0 0;
            color: #867269;
            font-size: 9px;
            line-height: 1.5;
        }

        .privacy-option {
            display: flex;
            gap: 9px;
            padding: 11px;
            border: 1px solid transparent;
            border-radius: 12px;
            background: #F9F6F4;
            cursor: pointer;
            transition: .15s ease;
        }

        .privacy-option + .privacy-option { margin-top: 8px; }

        .privacy-option:hover {
            border-color: #E9D6CD;
            background: #FFFBF8;
        }

        .privacy-option input {
            flex: 0 0 auto;
            margin-top: 2px;
            accent-color: #FB4D00;
        }

        .privacy-option strong {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #4A3730;
            font-size: 10px;
        }

        .privacy-option small {
            display: block;
            margin-top: 4px;
            color: #806E66;
            font-size: 9px;
            line-height: 1.4;
        }

        .checklist-panel {
            background: linear-gradient(180deg, #F5FBFE, #FFFFFF 65%);
            border-color: #D8ECF6;
        }

        .checklist-progress {
            width: 100%;
            height: 6px;
            margin: -2px 0 14px;
            overflow: hidden;
            border-radius: 999px;
            background: #E5F0F5;
        }

        .checklist-progress span {
            display: block;
            width: 0;
            height: 100%;
            border-radius: inherit;
            background: #FB4D00;
            transition: width .22s ease;
        }

        .checklist-items {
            display: grid;
            gap: 9px;
        }

        .checklist-item {
            display: grid;
            grid-template-columns: auto 1fr;
            align-items: center;
            gap: 9px;
            color: #8B7A73;
        }

        .check-icon {
            display: grid;
            width: 24px;
            height: 24px;
            place-items: center;
            border-radius: 50%;
            background: #EDF1F1;
            color: #B3AAA6;
            font-size: 8px;
        }

        .checklist-item strong {
            display: block;
            color: #6B5A53;
            font-size: 9px;
        }

        .checklist-item small {
            display: block;
            margin-top: 2px;
            color: #AA9991;
            font-size: 8px;
        }

        .checklist-item.done .check-icon {
            background: #DDF2E8;
            color: #2F8B62;
        }

        .checklist-item.done strong { color: #3E5B4C; }

        .checklist-note {
            margin: 14px 0 0;
            padding-top: 12px;
            border-top: 1px solid #E4F0F5;
            color: #6E828B;
            font-size: 9px;
            line-height: 1.48;
        }

        .guideline-dialog {
            width: min(760px, calc(100% - 30px));
            max-height: min(86vh, 820px);
            margin: auto;
            padding: 0;
            overflow: hidden;
            border: 0;
            border-radius: 26px;
            background: #FFFCFA;
            box-shadow: 0 28px 80px rgba(36, 27, 25, .26);
        }

        .guideline-dialog::backdrop {
            background: rgba(49, 31, 26, .60);
            backdrop-filter: blur(5px);
        }

        .guideline-dialog-content {
            max-height: inherit;
            overflow-y: auto;
        }

        .guideline-head {
            position: sticky;
            top: 0;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 27px 28px 20px;
            border-bottom: 1px solid #EFE4DE;
            background: rgba(255, 252, 250, .96);
            backdrop-filter: blur(10px);
        }

        .write-kicker {
            color: #B33A18;
            font: 800 9px 'Plus Jakarta Sans', sans-serif;
            letter-spacing: 1px;
        }

        .guideline-head h2 {
            max-width: 580px;
            margin: 7px 0 7px;
            color: #382822;
            font: 800 25px/1.23 'Plus Jakarta Sans', sans-serif;
            letter-spacing: -.6px;
        }

        .guideline-head p {
            max-width: 600px;
            margin: 0;
            color: #806D65;
            font-size: 11px;
            line-height: 1.55;
        }

        .close-guideline,
        .close-preview {
            display: grid;
            flex: 0 0 auto;
            width: 38px;
            height: 38px;
            place-items: center;
            border: 0;
            border-radius: 50%;
            background: #F6EEE9;
            color: #49261D;
            cursor: pointer;
        }

        .close-guideline:hover,
        .close-preview:hover { background: #FFE0D1; color: #B43A17; }

        .guideline-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            padding: 10px 28px 5px;
        }

        .guideline-item {
            display: grid;
            grid-template-columns: 35px 1fr;
            gap: 10px;
            padding: 17px 16px 17px 0;
            border-bottom: 1px solid #F1E8E3;
        }

        .guideline-item:nth-child(odd) { margin-right: 14px; }

        .guideline-item > span {
            display: grid;
            width: 30px;
            height: 30px;
            place-items: center;
            border-radius: 9px;
            background: #FFEDE3;
            color: #B33A18;
            font-size: 9px;
            font-weight: 800;
        }

        .guideline-item h3 {
            margin: 0 0 5px;
            color: #4A342D;
            font: 800 11px 'Plus Jakarta Sans', sans-serif;
        }

        .guideline-item p {
            margin: 0;
            color: #806D65;
            font-size: 10px;
            line-height: 1.52;
        }

        .guideline-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 19px 28px 25px;
            background: #FFF7F2;
        }

        .guideline-footer p {
            max-width: 550px;
            margin: 0;
            color: #715D55;
            font-size: 10px;
            line-height: 1.5;
        }

        .preview-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
        }

        .preview-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-overlay {
            position: absolute;
            inset: 0;
            background: rgba(49, 31, 26, .66);
            backdrop-filter: blur(5px);
        }

        .preview-content {
            position: relative;
            z-index: 2;
            width: min(780px, calc(100% - 30px));
            max-height: 88vh;
            overflow: hidden;
            border-radius: 26px;
            background: #fff;
            box-shadow: 0 26px 80px rgba(36, 27, 25, .27);
        }

        .preview-header,
        .preview-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 18px 24px;
        }

        .preview-header { border-bottom: 1px solid #EFE4DE; }
        .preview-header h3 { margin: 4px 0 0; color: #382822; font: 800 19px 'Plus Jakarta Sans', sans-serif; }

        .preview-body {
            max-height: calc(88vh - 150px);
            padding: 28px 30px;
            overflow-y: auto;
        }

        .preview-footer {
            justify-content: flex-end;
            border-top: 1px solid #EFE4DE;
            background: #FFFAF6;
        }

        @media (max-width: 900px) {
            .write-container { padding-inline: 18px; }
            .write-header { grid-template-columns: auto 1fr; }
            .back-btn { justify-self: end; }
            .write-actions { grid-column: 1 / -1; justify-self: stretch; flex-wrap: wrap; }
            .save-status { margin-right: auto; }
            .publication-banner { grid-template-columns: auto 1fr; }
            .publication-link { grid-column: 2; justify-self: start; }
            .write-layout { grid-template-columns: 1fr; }
            .write-sidebar { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .checklist-panel { grid-column: 1 / -1; }
        }

        @media (max-width: 640px) {
            .write-container { padding: 13px 12px 60px; }
            .write-header { gap: 12px; }
            .write-actions { display: grid; grid-template-columns: 1fr 1fr; }
            .save-status { grid-column: 1 / -1; }
            .btn-publish-primary { grid-column: 1 / -1; }
            .publication-banner { padding: 15px; }
            .publication-copy p { font-size: 10px; }
            .publication-link { grid-column: 1 / -1; justify-self: stretch; justify-content: center; }
            .write-main { padding: 21px 17px 18px; border-radius: 20px; }
            .title-input { font-size: 30px; letter-spacing: -1px; }
            .topic-heading { align-items: flex-start; flex-direction: column; }
            .editor-toolbar { width: 100%; justify-content: space-around; }
            .content-editor { min-height: 330px; }
            .editor-footer { align-items: flex-start; flex-direction: column; }
            .write-sidebar { grid-template-columns: 1fr; }
            .checklist-panel { grid-column: auto; }
            .guideline-list { grid-template-columns: 1fr; padding-inline: 20px; }
            .guideline-item:nth-child(odd) { margin-right: 0; }
            .guideline-head { padding: 23px 20px 17px; }
            .guideline-head h2 { font-size: 22px; }
            .guideline-footer { align-items: stretch; flex-direction: column; padding: 18px 20px 22px; }
            .guideline-footer .btn-publish-primary { width: 100%; }
        }
    </style>

    <script>
        const articleEditor = document.getElementById('contentEditor');
        const articleTextarea = document.getElementById('contentInput');
        const titleInput = document.getElementById('titleInput');
        const excerptInput = document.getElementById('excerptInput');
        const coverInput = document.getElementById('coverImage');
        const imagePreview = document.getElementById('imagePreview');

        function getEditorText() {
            return (articleEditor?.innerText || '').replace(/\u00a0/g, ' ').trim();
        }

        function syncContent() {
            if (!articleEditor || !articleTextarea) return;

            articleTextarea.value = articleEditor.innerHTML;

            const text = getEditorText();
            const words = text ? text.split(/\s+/).filter(Boolean) : [];
            const wordCount = words.length;

            const wordCountEl = document.getElementById('wordCountTop');
            const readingTimeEl = document.getElementById('readingTime');

            if (wordCountEl) wordCountEl.textContent = wordCount;
            if (readingTimeEl) readingTimeEl.textContent = Math.max(1, Math.ceil(wordCount / 200));

            updateChecklist();
        }

        function formatText(command, value = null) {
            articleEditor?.focus();
            document.execCommand(command, false, value);
            syncContent();
        }

        function createEditorLink() {
            const url = window.prompt('Masukkan URL tautan:');
            if (!url) return;

            const normalized = /^https?:\/\//i.test(url) ? url : `https://${url}`;
            formatText('createLink', normalized);
        }

        function previewImage(input) {
            if (!input.files || !input.files[0]) return;

            const file = input.files[0];
            const maxSize = 2 * 1024 * 1024;
            const allowed = ['image/jpeg', 'image/png', 'image/webp'];

            if (!allowed.includes(file.type)) {
                window.alert('Gunakan gambar JPG, PNG, atau WEBP.');
                input.value = '';
                return;
            }

            if (file.size > maxSize) {
                window.alert('Ukuran gambar maksimal 2 MB.');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                imagePreview.src = event.target.result;
                imagePreview.style.display = 'block';
                document.getElementById('uploadPlaceholder').style.display = 'none';
                document.getElementById('coverChange').style.display = 'inline-flex';
                updateChecklist();
            };
            reader.readAsDataURL(file);
        }

        function setChecklistState(id, done) {
            const row = document.getElementById(id);
            if (!row) return;
            row.classList.toggle('done', Boolean(done));
        }

        function updateChecklist() {
            const hasTitle = Boolean(titleInput?.value.trim());
            const hasExcerpt = Boolean(excerptInput?.value.trim());
            const hasCategory = Boolean(document.querySelector('input[name="category"]:checked'));
            const hasContent = Boolean(getEditorText());
            const hasCover = Boolean(
                (coverInput?.files && coverInput.files.length > 0) ||
                (imagePreview?.src && imagePreview.style.display !== 'none' && imagePreview.src !== window.location.href)
            );

            const states = [hasTitle, hasExcerpt, hasCategory, hasContent, hasCover];

            setChecklistState('checkTitle', hasTitle);
            setChecklistState('checkExcerpt', hasExcerpt);
            setChecklistState('checkCategory', hasCategory);
            setChecklistState('checkContent', hasContent);
            setChecklistState('checkCover', hasCover);

            const score = states.filter(Boolean).length;
            const scoreEl = document.getElementById('checklistScore');
            const progressEl = document.getElementById('checklistProgress');

            if (scoreEl) scoreEl.textContent = `${score}/5`;
            if (progressEl) progressEl.style.width = `${(score / 5) * 100}%`;
        }

        function updateExcerptCounter() {
            const counter = document.getElementById('excerptCount');
            if (counter && excerptInput) counter.textContent = excerptInput.value.length;
        }

        function validateRequiredFields() {
            syncContent();

            if (!titleInput?.value.trim()) {
                titleInput?.focus();
                window.alert('Judul artikel belum diisi.');
                return false;
            }

            if (!document.querySelector('input[name="category"]:checked')) {
                window.alert('Pilih satu topik untuk artikelmu.');
                return false;
            }

            if (!getEditorText()) {
                articleEditor?.focus();
                window.alert('Isi artikel belum ditulis.');
                return false;
            }

            return true;
        }

        function submitForm(publish = true) {
            syncContent();

            if (!validateRequiredFields()) return;

            const publishOption = document.querySelector(`input[name="publish"][value="${publish ? '1' : '0'}"]`);
            if (publishOption) publishOption.checked = true;

            document.getElementById('articleForm').submit();
        }

        function previewArticle() {
            syncContent();

            const title = titleInput?.value.trim() || 'Judul artikel';
            const excerpt = excerptInput?.value.trim() || '';
            const content = articleEditor?.innerHTML || '';
            const category = document.querySelector('input[name="category"]:checked')?.value || '';
            const coverImage = imagePreview?.src || '';

            const previewHTML = `
                <article style="max-width:680px;margin:0 auto;">
                    ${category ? `<span style="display:inline-flex;padding:6px 10px;border-radius:999px;background:#FFEDE3;color:#A33613;font:800 10px 'DM Sans',sans-serif;">#${category}</span>` : ''}
                    <h1 style="font:800 36px/1.16 'Plus Jakarta Sans',sans-serif;letter-spacing:-1px;color:#382822;margin:16px 0 14px;">${escapeHTML(title)}</h1>
                    ${excerpt ? `<p style="font:400 17px/1.65 'DM Sans',sans-serif;color:#756158;margin:0 0 26px;">${escapeHTML(excerpt)}</p>` : ''}
                    ${coverImage && coverImage !== window.location.href ? `<img src="${coverImage}" alt="" style="display:block;width:100%;max-height:390px;object-fit:cover;border-radius:20px;margin:0 0 28px;">` : ''}
                    <div style="font:400 15px/1.82 'DM Sans',sans-serif;color:#424A4E;">${content}</div>
                </article>
            `;

            document.getElementById('previewBody').innerHTML = previewHTML;
            const modal = document.getElementById('previewModal');
            modal.classList.add('active');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closePreview() {
            const modal = document.getElementById('previewModal');
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        function escapeHTML(value) {
            const div = document.createElement('div');
            div.textContent = value;
            return div.innerHTML;
        }

        articleEditor?.addEventListener('input', syncContent);
        titleInput?.addEventListener('input', updateChecklist);
        excerptInput?.addEventListener('input', () => {
            updateExcerptCounter();
            updateChecklist();
        });

        document.querySelectorAll('input[name="category"]').forEach((radio) => {
            radio.addEventListener('change', updateChecklist);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                if (document.getElementById('previewModal')?.classList.contains('active')) closePreview();
                if (document.getElementById('publicationGuidelines')?.open) document.getElementById('publicationGuidelines').close();
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            syncContent();
            updateExcerptCounter();
            updateChecklist();
        });
    </script>
</x-app-layout>
