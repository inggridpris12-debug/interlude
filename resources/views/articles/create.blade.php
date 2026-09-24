<x-app-layout>
    <div class="write-container">

        <div class="write-header">
            <div class="write-brand">
                <span class="write-mark">I</span>
                <strong>Interlude</strong>
            </div>
            <a href="{{ route('dashboard') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Kembali</a>
            <div class="write-actions">
                <span class="save-status"><i class="fas fa-circle-check"></i> Draft tersimpan otomatis</span>
                <button type="button" class="btn-publish" onclick="previewArticle()"><i class="far fa-eye"></i> Preview</button>
                <button type="button" class="btn-publish-primary" onclick="submitForm(true)">{{ isset($article) ? 'Perbarui Artikel' : 'Publikasikan Karya' }} <i class="fas fa-paper-plane"></i></button>
            </div>
        </div>

        <section class="community-banner">
            <div class="community-icon"><i class="fas fa-pen-nib"></i></div>
            <div>
                <div class="community-title">Etika Narasi Interlude <span>· Prinsip Komunitas</span></div>
                <p>Bukan tugas kuliah formal. Tulis apa adanya, bagikan kesalahan yang kamu pelajari agar adik tingkat tidak mengulanginya.</p>
            </div>
            <button type="button" class="community-link" onclick="document.getElementById('communityGuidelines').showModal()">Pelajari Pedoman Komunitas</button>
        </section>

        <form id="articleForm" action="{{ isset($article) ? route('articles.update', $article) : route('articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($article))
                @method('PUT')
            @endif

            <div class="write-layout">
                <div class="write-main">
                    <div class="editor-meta-row">
                        <label class="select-meta">Artikel Pengalaman Kuliah <i class="fas fa-chevron-down"></i></label>
                        <span><i class="far fa-clock"></i> <span id="readingTime">1</span> Menit Baca</span>
                        <span><i class="fas fa-align-left"></i> <span id="wordCountTop">0</span> Kata</span>
                    </div>

                    <input type="text" name="title" id="titleInput" class="title-input" placeholder="Tulis judul pengalaman atau insight kuliahmu di sini..." value="{{ old('title', $article->title ?? '') }}" required>
                    <textarea name="excerpt" id="excerptInput" class="excerpt-input" placeholder="Tambahkan ringkasan singkat agar pembaca tahu apa yang akan mereka temukan..." rows="2">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>

                    <div class="topic-field">
                        <span class="form-label">TOPIK:</span>
                        <div class="category-select">
                            @foreach($categories as $category)
                                <label class="category-option">
                                    <input type="radio" name="category" value="{{ $category }}" {{ old('category', $article->category ?? '') == $category ? 'checked' : '' }} required>
                                    <span class="category-label">#{{ $category }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group editor-group">
                        <label class="form-label sr-only" for="contentEditor">Konten artikel</label>
                    <div class="editor-toolbar">
                            <button type="button" class="toolbar-btn" onclick="formatText('bold')" title="Tebal"><i class="fas fa-bold"></i></button>
                            <button type="button" class="toolbar-btn" onclick="formatText('italic')" title="Miring"><i class="fas fa-italic"></i></button>
                            <button type="button" class="toolbar-btn" onclick="formatText('formatBlock', 'H2')" title="Subjudul">H2</button>
                            <button type="button" class="toolbar-btn" onclick="formatText('formatBlock', 'blockquote')" title="Kutipan"><i class="fas fa-quote-right"></i></button>
                            <button type="button" class="toolbar-btn" onclick="formatText('insertUnorderedList')" title="Daftar"><i class="fas fa-list-ul"></i></button>
                            <button type="button" class="toolbar-btn" onclick="formatText('createLink', prompt('Masukkan URL'))" title="Tautan"><i class="fas fa-link"></i></button>
                            <span class="toolbar-divider"></span>
                            <button type="button" class="toolbar-btn toolbar-extra" title="Audio"><i class="fas fa-volume-high"></i> Audio</button>
                            <button type="button" class="toolbar-btn toolbar-extra" title="Berkas"><i class="fas fa-paperclip"></i> Berkas</button>
                        </div>

                        <div id="contentEditor" class="content-editor" contenteditable="true" data-placeholder="Mulai tulis pengalamanmu di sini...">{{ old('content', $article->content ?? '') }}</div>
                        <textarea name="content" id="contentInput" hidden>{{ old('content', $article->content ?? '') }}</textarea>

                        <div class="editor-footer">
                            <span><i class="far fa-circle-check"></i> Interlude AutoSync aktif ke penyimpanan lokal &amp; cloud kampus</span>
                            <span><i class="fas fa-lock"></i> {{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </div>

                <aside class="write-sidebar">
                    <section class="sidebar-panel cover-panel">
                        <div class="sidebar-panel-heading"><h2>Gambar Sampul</h2><span>DISARANKAN 16:9</span></div>
                        <div class="cover-upload" id="coverUpload">
                            <input type="file" name="cover_image" id="coverImage" class="cover-input" accept="image/*" onchange="previewImage(this)">
                            <div class="upload-placeholder" id="uploadPlaceholder"><i class="fas fa-image"></i><p>Pilih gambar sampul</p><span class="upload-hint">JPG atau PNG, maksimal 2MB</span></div>
                            <img id="imagePreview" class="image-preview" src="{{ isset($article) && $article->cover_image ? asset('storage/' . $article->cover_image) : '' }}" style="display: {{ isset($article) && $article->cover_image ? 'block' : 'none' }};">
                        </div>
                        <p class="sidebar-help">Pilih foto yang membantu pembaca langsung memahami suasana cerita kamu.</p>
                    </section>

                    <section class="sidebar-panel">
                        <div class="sidebar-panel-heading"><h2>Jangkauan &amp; Privasi</h2></div>
                        <label class="privacy-option"><input type="radio" name="publish" value="1" {{ !isset($article) || $article->is_published ? 'checked' : '' }}><span><strong>Publik Seluruh Kampus</strong><small>Dapat dibaca dan ditemukan seluruh mahasiswa di UI, UGM, Unair, dan 140+ kampus lainnya.</small></span></label>
                        <label class="privacy-option"><input type="radio" name="publish" value="0" {{ isset($article) && ! $article->is_published ? 'checked' : '' }}><span><strong>Khusus Mahasiswa Terverifikasi</strong><small>Hanya dapat diakses oleh mahasiswa yang memiliki email resmi.</small></span></label>
                    </section>

                    <section class="sidebar-panel projection-panel">
                        <div class="sidebar-panel-heading"><h2>Proyeksi Pembaca</h2><i class="fas fa-chart-line"></i></div>
                        <p>Berdasarkan topik <strong id="projectionTopic">#{{ old('category', $article->category ?? 'Pengalaman') }}</strong> dan musim rekrutmen semester ganjil, artikel ini berpeluang menjangkau 850–1.400 mahasiswa dalam 7 hari pertama publikasi.</p>
                        <span class="projection-trend"><i class="fas fa-arrow-trend-up"></i> TREN PENCARIAN NAIK 34%</span>
                    </section>
                </aside>
            </div>
        </form>
    </div>

    <dialog id="communityGuidelines" class="guideline-dialog">
        <div class="guideline-dialog-content">
            <button type="button" class="close-preview" onclick="document.getElementById('communityGuidelines').close()"><i class="fas fa-times"></i></button>
            <span class="write-kicker">Prinsip komunitas</span>
            <h2>Bagikan proses, bukan pencitraan.</h2>
            <p>Ceritakan pengalaman dengan jujur, lindungi data pribadi, dan pastikan insight-mu bisa membantu mahasiswa lain.</p>
            <button type="button" class="btn-publish-primary" onclick="document.getElementById('communityGuidelines').close()">Mengerti</button>
        </div>
    </dialog>

    <!-- Preview Modal -->
    <div id="previewModal" class="preview-modal">
        <div class="preview-overlay" onclick="closePreview()"></div>
        <div class="preview-content">
            <div class="preview-header">
                <h3>Preview Artikel</h3>
                <button class="close-preview" onclick="closePreview()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="preview-body" id="previewBody"></div>
            <div class="preview-footer">
                <button class="btn-secondary" onclick="closePreview()">Kembali Edit</button>
                <button class="btn-primary" onclick="submitForm(true)">Publikasikan <i class="fas fa-check"></i></button>
            </div>
        </div>
    </div>

    <style>
        .write-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 7% 100px;
            background: var(--cream);
            min-height: 100vh;
        }

        .write-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            color: var(--text-soft);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            transition: 0.2s;
        }

        .back-btn:hover { background: var(--white); color: var(--tangelo); }

        .write-actions { display: flex; gap: 12px; }

        .btn-draft, .btn-publish {
            padding: 10px 20px;
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--brown);
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: 0.2s;
        }
        .btn-draft:hover { border-color: var(--brown); }
        .btn-publish:hover { border-color: var(--tangelo); color: var(--tangelo); }

        .btn-publish-primary {
            padding: 10px 24px;
            background: var(--tangelo);
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--white);
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-publish-primary:hover { background: var(--brown); }

        .write-content { display: flex; flex-direction: column; gap: 32px; }
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        .form-label { font-size: 14px; font-weight: 600; color: var(--brown); }

        .title-input {
            width: 100%;
            padding: 12px 0;
            border: none;
            border-bottom: 2px solid var(--border);
            background: transparent;
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            font-weight: 800;
            color: var(--brown);
            outline: none;
            transition: 0.2s;
        }
        .title-input:focus { border-bottom-color: var(--tangelo); }
        .title-input::placeholder { color: var(--border); }

        .excerpt-input {
            width: 100%;
            padding: 12px 0;
            border: none;
            border-bottom: 1px solid var(--border);
            background: transparent;
            font-family: 'DM Sans', sans-serif;
            font-size: 16px;
            color: var(--text-soft);
            outline: none;
            resize: none;
        }
        .excerpt-input:focus { border-bottom-color: var(--tangelo); }

        .cover-upload {
            position: relative;
            width: 100%;
            height: 320px;
            border: 2px dashed var(--border);
            border-radius: 16px;
            overflow: hidden;
            cursor: pointer;
            transition: 0.2s;
        }
        .cover-upload:hover { border-color: var(--tangelo); background: var(--linen); }
        .cover-input { position: absolute; inset: 0; opacity: 0; cursor: pointer; z-index: 10; }
        .upload-placeholder {
            position: absolute; inset: 0; display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 12px; color: var(--text-soft);
        }
        .upload-placeholder i { font-size: 48px; color: var(--border); }
        .upload-placeholder p { font-size: 16px; font-weight: 600; color: var(--brown); }
        .upload-hint { font-size: 13px; color: var(--text-soft); }
        .image-preview { width: 100%; height: 100%; object-fit: cover; }

        .category-select { display: flex; flex-wrap: wrap; gap: 10px; }
        .category-option { display: flex; align-items: center; cursor: pointer; }
        .category-option input { display: none; }
        .category-label {
            padding: 10px 20px; background: var(--white); border: 1.5px solid var(--border);
            border-radius: 50px; font-size: 14px; font-weight: 500; color: var(--brown); transition: 0.2s;
        }
        .category-option input:checked + .category-label {
            background: var(--brown); border-color: var(--brown); color: var(--white);
        }
        .category-option:hover .category-label { border-color: var(--brown); }

        .editor-toolbar {
            display: flex; align-items: center; gap: 4px; padding: 12px;
            background: var(--white); border: 1.5px solid var(--border);
            border-bottom: none; border-radius: 12px 12px 0 0;
        }
        .toolbar-btn {
            width: 36px; height: 36px; border: none; background: transparent;
            border-radius: 6px; color: var(--text-soft); cursor: pointer; transition: 0.2s;
            display: flex; align-items: center; justify-content: center;
        }
        .toolbar-btn:hover { background: var(--linen); color: var(--tangelo); }
        .toolbar-divider { width: 1px; height: 24px; background: var(--border); margin: 0 4px; }

        .content-editor {
            width: 100%; min-height: 400px; padding: 20px;
            border: 1.5px solid var(--border); border-radius: 0 0 12px 12px;
            background: var(--white); font-family: 'DM Sans', sans-serif;
            font-size: 16px; line-height: 1.8; color: var(--brown);
            outline: none; overflow-y: auto;
        }
        .content-editor:focus { border-color: var(--tangelo); }
        .content-editor:empty:before {
            content: attr(placeholder); color: var(--border); font-style: italic;
        }
        
        /* Styling untuk hasil format di dalam editor */
        .content-editor b, .content-editor strong { font-weight: 700; font-family: 'Playfair Display', serif; }
        .content-editor i, .content-editor em { font-style: italic; }
        .content-editor u { text-decoration: underline; }
        .content-editor h2 {
            font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 700;
            margin: 32px 0 16px; color: var(--brown);
        }
        .content-editor blockquote {
            border-left: 4px solid var(--tangelo); padding-left: 20px; margin: 24px 0;
            font-style: italic; color: var(--text-soft); background: var(--linen); padding: 16px 20px; border-radius: 0 8px 8px 0;
        }
        .content-editor ul, .content-editor ol { margin: 16px 0; padding-left: 30px; }
        .content-editor li { margin: 8px 0; }

        .editor-hint { font-size: 13px; color: var(--text-soft); text-align: right; }

        /* Preview Modal */
        .preview-modal {
            display: none; position: fixed; inset: 0; z-index: 9999;
        }
        .preview-modal.active { display: flex; align-items: center; justify-content: center; }
        .preview-overlay { position: absolute; inset: 0; background: rgba(73, 38, 29, 0.8); }
        .preview-content {
            position: relative; background: var(--white); width: 90%; max-width: 800px;
            max-height: 90vh; border-radius: 20px; overflow: hidden; z-index: 10;
        }
        .preview-header {
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 32px; border-bottom: 1px solid var(--border);
        }
        .preview-header h3 { font-family: 'Playfair Display', serif; font-size: 24px; color: var(--brown); }
        .close-preview {
            width: 40px; height: 40px; border: none; background: var(--cream);
            border-radius: 10px; color: var(--brown); cursor: pointer; font-size: 18px; transition: 0.2s;
        }
        .close-preview:hover { background: var(--linen); color: var(--tangelo); }
        .preview-body { padding: 32px; overflow-y: auto; max-height: calc(90vh - 140px); }
        .preview-footer {
            display: flex; justify-content: flex-end; gap: 12px; padding: 20px 32px;
            border-top: 1px solid var(--border); background: var(--cream);
        }
        .btn-secondary {
            padding: 10px 20px; background: var(--white); border: 1.5px solid var(--border);
            border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer;
            font-family: 'DM Sans', sans-serif; transition: 0.2s;
        }
        .btn-secondary:hover { border-color: var(--brown); }

        @media (max-width: 768px) {
            .write-header { flex-direction: column; gap: 16px; align-items: flex-start; }
            .write-actions { width: 100%; justify-content: space-between; }
            .title-input { font-size: 28px; }
            .cover-upload { height: 240px; }
        }

        .write-container {
            max-width: 1080px;
            padding: 34px 5% 110px;
        }

        .write-header {
            position: sticky;
            top: 0;
            z-index: 20;
            margin: 0 -5% 46px;
            padding: 15px 5%;
            background: rgba(255, 250, 246, .94);
            backdrop-filter: blur(12px);
        }

        .back-btn {
            padding: 9px 14px;
            border: 1px solid var(--border);
            border-radius: 999px;
            background: var(--white);
            font-weight: 700;
        }

        .write-actions { align-items: center; }
        .btn-draft, .btn-publish, .btn-publish-primary { border-radius: 999px; }
        .btn-publish-primary { box-shadow: 0 8px 18px rgba(251, 77, 0, .18); }

        .write-content { gap: 38px; }
        .title-input {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(32px, 5vw, 56px);
            letter-spacing: -1.6px;
            line-height: 1.08;
        }

        .excerpt-input { font-size: 18px; line-height: 1.6; }
        .cover-upload { height: 290px; border-radius: 22px; background: rgba(255, 255, 255, .5); }
        .category-label { border-radius: 999px; }
        .editor-toolbar { border-radius: 16px 16px 0 0; }
        .content-editor { min-height: 440px; border-radius: 0 0 16px 16px; }
        .preview-content { border-radius: 24px; }

        @media (max-width: 768px) {
            .write-header { margin: 0 -4% 34px; padding: 12px 4%; }
            .write-actions { flex-wrap: wrap; gap: 8px; }
            .write-actions button { flex: 1; min-width: 110px; padding-left: 12px; padding-right: 12px; }
        }

        .write-container {
            width: min(1180px, 100%);
            max-width: none;
            padding: 12px 4% 90px;
            background: #f9f7f4;
        }

        .write-header {
            display: grid;
            grid-template-columns: auto auto 1fr;
            align-items: center;
            gap: 22px;
            margin: 0 0 18px;
            padding: 0 4px 10px;
            border: 0;
            background: transparent;
        }

        .write-brand { display: inline-flex; align-items: center; gap: 8px; color: #241b19; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; }
        .write-mark { display: grid; width: 18px; height: 18px; place-items: center; border-radius: 5px; background: #241b19; color: #fff; font-size: 10px; }
        .back-btn { order: 3; justify-self: end; padding: 0; border: 0; background: transparent; color: #241b19; }
        .back-btn:hover { background: transparent; color: var(--tangelo); }
        .write-actions { grid-column: 1 / -1; grid-row: 2; justify-content: flex-end; gap: 8px; }
        .save-status { margin-right: auto; color: #72645e; font-size: 11px; }
        .save-status i { color: #45a77b; }
        .btn-publish, .btn-publish-primary { padding: 8px 14px; font-size: 11px; }
        .btn-publish { background: #fff; }
        .btn-publish-primary { background: #9e2b10; box-shadow: none; }

        .community-banner {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 13px;
            margin-bottom: 16px;
            padding: 16px 20px;
            border-radius: 22px;
            background: #06232c;
            color: #fff;
            box-shadow: 0 10px 18px rgba(6, 35, 44, .12);
        }

        .community-icon { display: grid; width: 34px; height: 34px; place-items: center; border-radius: 50%; background: #b93b16; font-size: 14px; }
        .community-title { font-size: 10px; font-weight: 800; letter-spacing: .2px; text-transform: uppercase; }
        .community-title span { color: #a6c0c1; font-weight: 500; text-transform: none; }
        .community-banner p { max-width: 680px; margin: 4px 0 0; color: #f1f6f5; font-size: 11px; line-height: 1.5; }
        .community-link { padding: 8px 12px; border: 1px solid #2e5960; border-radius: 999px; background: #103942; color: #fff; font: 700 10px 'DM Sans', sans-serif; cursor: pointer; }
        .community-link:hover { background: #1c4e58; }

        .write-layout { display: grid; grid-template-columns: minmax(0, 1.8fr) minmax(260px, .92fr); gap: 16px; align-items: start; }
        .write-main { min-width: 0; padding: 22px 24px 18px; border-radius: 22px; background: #fff; box-shadow: 0 2px 8px rgba(73, 38, 29, .035); }
        .write-sidebar { display: grid; gap: 14px; }
        .editor-meta-row { display: flex; flex-wrap: wrap; align-items: center; gap: 7px; margin-bottom: 16px; color: #7d6e67; font-size: 10px; }
        .editor-meta-row > span, .select-meta { display: inline-flex; align-items: center; gap: 6px; padding: 5px 9px; border-radius: 999px; background: #f7eee9; color: #8a2d15; font-size: 10px; font-weight: 800; }
        .editor-meta-row > span { color: #665953; background: #f5f3f1; font-weight: 600; }
        .title-input { margin: 0; padding: 0 0 10px; border: 0; color: #283137; font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(28px, 4vw, 45px); letter-spacing: -1.8px; line-height: 1.08; }
        .title-input::placeholder { color: #d6c1ba; }
        .title-input:focus { border-bottom: 0; }
        .excerpt-input { margin-top: 7px; padding: 8px 0 14px; border-bottom: 1px solid #eee6e1; color: #5f514b; font-size: 14px; }
        .topic-field { display: flex; align-items: center; flex-wrap: wrap; gap: 8px; padding: 13px 0 15px; border-bottom: 1px solid #eee6e1; }
        .topic-field .form-label { font-size: 9px; letter-spacing: .4px; }
        .category-select { gap: 5px; }
        .category-label { padding: 5px 8px; border-color: #ece4df; color: #654f48; font-size: 10px; }
        .category-option input:checked + .category-label { background: #fff0e9; border-color: #f0b39f; color: #9e2b10; }
        .editor-group { gap: 0; margin-top: 16px; }
        .editor-toolbar { gap: 1px; padding: 6px 8px; border-color: #e8dfda; border-radius: 999px; box-shadow: 0 4px 12px rgba(73, 38, 29, .08); }
        .toolbar-btn { width: 28px; height: 28px; color: #4d403b; font-size: 10px; }
        .toolbar-btn:hover { background: #fff0e9; color: #9e2b10; }
        .toolbar-extra { width: auto; padding: 0 8px; gap: 5px; }
        .toolbar-divider { height: 18px; margin: 0 4px; background: #e3d8d2; }
        .content-editor { min-height: 360px; padding: 20px 0; border: 0; border-radius: 0; background: #fff; color: #29353b; font-size: 14px; line-height: 1.75; }
        .content-editor:focus { border: 0; }
        .content-editor:empty::before { content: attr(data-placeholder); color: #c8b7b0; font-style: normal; }
        .content-editor h2 { color: #29353b; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 19px; }
        .content-editor blockquote { margin: 20px 0; border-left-color: #bb421f; background: #f7f1ed; }
        .editor-footer { display: flex; justify-content: space-between; gap: 12px; padding-top: 12px; border-top: 1px solid #eee6e1; color: #8c7c74; font-size: 9px; }
        .editor-footer i { color: #b33a1a; }
        .sidebar-panel { padding: 17px; border-radius: 20px; background: #fff; box-shadow: 0 2px 8px rgba(73, 38, 29, .035); }
        .sidebar-panel-heading { display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 12px; }
        .sidebar-panel-heading h2 { margin: 0; color: #352723; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; }
        .sidebar-panel-heading > span { color: #b33a1a; font-size: 8px; font-weight: 800; }
        .sidebar-panel-heading > i { color: #b33a1a; font-size: 13px; }
        .cover-upload { height: 142px; border: 0; border-radius: 11px; background: #ead8c9; }
        .cover-upload:hover { background: #f4e6dd; }
        .upload-placeholder { gap: 6px; text-align: center; }
        .upload-placeholder i { font-size: 24px; color: #9e7159; }
        .upload-placeholder p { margin: 0; color: #5b4338; font-size: 12px; }
        .upload-hint { font-size: 9px; }
        .sidebar-help { margin: 10px 0 0; color: #7c6a62; font-size: 10px; line-height: 1.45; }
        .privacy-option { display: flex; gap: 8px; padding: 10px; border-radius: 8px; background: #f8f5f2; cursor: pointer; }
        .privacy-option + .privacy-option { margin-top: 7px; }
        .privacy-option input { accent-color: #b33a1a; margin-top: 2px; }
        .privacy-option strong { display: block; color: #4a3730; font-size: 10px; }
        .privacy-option small { display: block; margin-top: 3px; color: #806e66; font-size: 9px; line-height: 1.35; }
        .projection-panel { background: #cbe9f8; }
        .projection-panel p { margin: 0; color: #385966; font-size: 10px; line-height: 1.5; }
        .projection-trend { display: block; margin-top: 11px; color: #b33a1a; font-size: 9px; font-weight: 800; }
        .guideline-dialog { width: min(420px, calc(100% - 32px)); border: 0; border-radius: 20px; padding: 0; box-shadow: 0 24px 70px rgba(36, 27, 25, .25); }
        .guideline-dialog::backdrop { background: rgba(6, 35, 44, .56); }
        .guideline-dialog-content { position: relative; padding: 28px; }
        .guideline-dialog-content .close-preview { position: absolute; top: 16px; right: 16px; }
        .write-kicker { color: #b33a1a; font-size: 10px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; }
        .guideline-dialog h2 { margin: 10px 0; color: #352723; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 23px; }
        .guideline-dialog p { margin: 0 0 20px; color: #806e66; font-size: 14px; line-height: 1.6; }

        @media (max-width: 800px) {
            .write-header { grid-template-columns: auto 1fr; }
            .back-btn { order: 0; justify-self: end; }
            .write-actions { grid-column: 1 / -1; }
            .community-banner { grid-template-columns: auto 1fr; }
            .community-link { grid-column: 2; justify-self: start; }
            .write-layout { grid-template-columns: 1fr; }
            .write-sidebar { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .projection-panel { grid-column: 1 / -1; }
        }

        @media (max-width: 560px) {
            .write-container { padding: 10px 3% 60px; }
            .write-header { gap: 10px; }
            .save-status { display: none; }
            .write-actions { justify-content: stretch; }
            .write-actions .btn-publish, .write-actions .btn-publish-primary { flex: 1; min-width: 0; }
            .community-banner { padding: 14px; }
            .community-banner p { font-size: 10px; }
            .write-main { padding: 18px 15px; }
            .write-sidebar { grid-template-columns: 1fr; }
            .projection-panel { grid-column: auto; }
            .toolbar-extra { display: none; }
            .editor-footer { flex-direction: column; }
        }
    </style>

    <script>
        // 1. Sinkronisasi konten dari visual editor ke textarea tersembunyi
        function syncContent() {
            const editor = document.getElementById('contentEditor');
            const textarea = document.getElementById('contentInput');
            textarea.value = editor.innerHTML;
            
            // Update word count
            const text = editor.innerText || '';
            const wordCount = text.trim().split(/\s+/).filter(word => word.length > 0).length;
            document.getElementById('wordCountTop').textContent = wordCount;
            document.getElementById('readingTime').textContent = Math.max(1, Math.ceil(wordCount / 200));
        }

        // 2. Fungsi Formatting
        function formatText(command, value = null) {
            document.execCommand(command, false, value);
            document.getElementById('contentEditor').focus();
            syncContent(); // Langsung sinkronkan setelah format
        }

        // 3. Event Listener untuk update real-time
        document.getElementById('contentEditor').addEventListener('input', function() {
            syncContent();
        });

        // 4. Image Preview
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                    document.getElementById('uploadPlaceholder').style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // 5. Submit Form (PENTING: sync dulu baru submit)
        function submitForm(publish = true) {
            syncContent(); // Pastikan data terbaru masuk ke textarea
            const publishOption = document.querySelector(`input[name="publish"][value="${publish ? '1' : '0'}"]`);
            if (publishOption) {
                publishOption.checked = true;
            }
            document.getElementById('articleForm').submit();
        }

        // 6. Preview Article
        function previewArticle() {
            syncContent(); // Sync dulu
            
            const title = document.getElementById('titleInput').value;
            const excerpt = document.getElementById('excerptInput').value;
            const content = document.getElementById('contentEditor').innerHTML;
            const category = document.querySelector('input[name="category"]:checked')?.value || '';
            const coverImage = document.getElementById('imagePreview').src;

            let previewHTML = `
                ${category ? `<span style="color: var(--tangelo); font-size: 11px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase;">${category}</span>` : ''}
                <h1 style="font-family: 'Playfair Display', serif; font-size: 36px; font-weight: 800; color: var(--brown); margin: 16px 0 24px; line-height: 1.2;">${title || 'Judul Artikel'}</h1>
                ${excerpt ? `<p style="font-size: 18px; color: var(--text-soft); margin-bottom: 32px; line-height: 1.6;">${excerpt}</p>` : ''}
                ${coverImage && coverImage !== window.location.href ? `<img src="${coverImage}" style="width: 100%; border-radius: 12px; margin-bottom: 32px; object-fit: cover;">` : ''}
                <div style="font-size: 16px; line-height: 1.8; color: var(--text-soft);">
                    ${content}
                </div>
            `;

            document.getElementById('previewBody').innerHTML = previewHTML;
            document.getElementById('previewModal').classList.add('active');
        }

        function closePreview() {
            document.getElementById('previewModal').classList.remove('active');
        }

        // Jalankan sync saat halaman dimuat (untuk handle old input)
        document.addEventListener('DOMContentLoaded', syncContent);
    </script>
</x-app-layout>