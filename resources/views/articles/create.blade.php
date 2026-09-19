<x-app-layout>
    <div class="write-container">
        
        <!-- Header -->
        <div class="write-header">
            <a href="{{ route('dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
            <div class="write-actions">
                <button type="button" class="btn-draft" onclick="submitForm(false)">
                    Simpan Draft
                </button>
                <button type="button" class="btn-publish" onclick="previewArticle()">
                    Preview
                </button>
                <button type="button" class="btn-publish-primary" onclick="submitForm(true)">
                    Publikasikan <i class="fas fa-check"></i>
                </button>
            </div>
        </div>

        <!-- Form -->
        <form id="articleForm" action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="publish" id="publishInput" value="1">

            <div class="write-content">
                
                <!-- Title Input -->
                <div class="form-group">
                    <input 
                        type="text" 
                        name="title" 
                        id="titleInput" 
                        class="title-input" 
                        placeholder="Judul artikel"
                        value="{{ old('title') }}"
                        required
                    >
                </div>

                <!-- Excerpt Input -->
                <div class="form-group">
                    <textarea 
                        name="excerpt" 
                        id="excerptInput" 
                        class="excerpt-input" 
                        placeholder="Ringkasan singkat artikel (opsional)"
                        rows="2"
                    >{{ old('excerpt') }}</textarea>
                </div>

                <!-- Cover Image Upload -->
                <div class="form-group">
                    <div class="cover-upload" id="coverUpload">
                        <input 
                            type="file" 
                            name="cover_image" 
                            id="coverImage" 
                            class="cover-input" 
                            accept="image/*"
                            onchange="previewImage(this)"
                        >
                        <div class="upload-placeholder" id="uploadPlaceholder">
                            <i class="fas fa-image"></i>
                            <p>Klik untuk upload cover artikel</p>
                            <span class="upload-hint">PNG, JPG maksimal 2MB</span>
                        </div>
                        <img id="imagePreview" class="image-preview" style="display: none;">
                    </div>
                </div>

                <!-- Category Select -->
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <div class="category-select">
                        @foreach($categories as $category)
                            <label class="category-option">
                                <input 
                                    type="radio" 
                                    name="category" 
                                    value="{{ $category }}"
                                    {{ old('category') == $category ? 'checked' : '' }}
                                    required
                                >
                                <span class="category-label">{{ $category }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Content Editor (FIXED) -->
                <div class="form-group">
                    <label class="form-label">Konten</label>
                    <div class="editor-toolbar">
                        <button type="button" class="toolbar-btn" onclick="formatText('bold')" title="Bold">
                            <i class="fas fa-bold"></i>
                        </button>
                        <button type="button" class="toolbar-btn" onclick="formatText('italic')" title="Italic">
                            <i class="fas fa-italic"></i>
                        </button>
                        <button type="button" class="toolbar-btn" onclick="formatText('underline')" title="Underline">
                            <i class="fas fa-underline"></i>
                        </button>
                        <div class="toolbar-divider"></div>
                        <button type="button" class="toolbar-btn" onclick="formatText('insertUnorderedList')" title="Bullet list">
                            <i class="fas fa-list-ul"></i>
                        </button>
                        <button type="button" class="toolbar-btn" onclick="formatText('insertOrderedList')" title="Numbered list">
                            <i class="fas fa-list-ol"></i>
                        </button>
                        <div class="toolbar-divider"></div>
                        <button type="button" class="toolbar-btn" onclick="formatText('formatBlock', 'H2')" title="Heading">
                            <i class="fas fa-heading"></i>
                        </button>
                        <button type="button" class="toolbar-btn" onclick="formatText('formatBlock', 'blockquote')" title="Quote">
                            <i class="fas fa-quote-left"></i>
                        </button>
                    </div>
                    
                    <!-- Visual Editor -->
                    <div 
                        id="contentEditor" 
                        class="content-editor" 
                        contenteditable="true"
                        placeholder="Tulis ceritamu di sini..."
                    >{{ old('content') }}</div>
                    
                    <!-- Hidden Textarea untuk dikirim ke Controller -->
                    <textarea name="content" id="contentInput" style="display: none;">{{ old('content') }}</textarea>
                    
                    <div class="editor-hint">
                        <span id="wordCount">0 kata</span> · {{ auth()->user()->name }}
                    </div>
                </div>
            </div>
        </form>
    </div>

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
            document.getElementById('wordCount').textContent = wordCount + ' kata';
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
            document.getElementById('publishInput').value = publish ? '1' : '0';
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