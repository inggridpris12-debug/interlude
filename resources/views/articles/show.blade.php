<x-app-layout>







    <article

        class="article-page"

        id="articleReader"

        data-reader-font="serif"

        data-reader-theme="light"

        data-reader-spacing="normal"

    >















        <!-- TOP NAVBAR -->







        <nav class="article-topbar">







            <a href="{{ route('dashboard') }}" class="close-btn">







                <i class="fas fa-times"></i>







            </a>







            <div class="topbar-center">







                <div class="topbar-avatar" style="background: linear-gradient(135deg, #FF8C5A, #FB4D00);">







                    {{ substr($article->user->name, 0, 1) }}







                </div>







            </div>







            <div class="topbar-right">







                @if(auth()->id() === $article->user_id)







                    <a href="{{ route('articles.edit', $article) }}" class="edit-article-btn"><i class="fas fa-pen"></i> Edit artikel</a>







                @endif







                <!-- Reader settings -->

                <button

                    type="button"

                    class="reader-trigger"

                    id="readerTrigger"

                    aria-label="Pengaturan keterbacaan"

                    aria-expanded="false"

                    aria-controls="readerSettings"

                >

                    <span class="reader-trigger-small">A−</span>

                    <span class="reader-trigger-slash">/</span>

                    <span class="reader-trigger-large">A+</span>

                </button>



                <button type="button" class="icon-btn {{ $isBookmarked ? 'active' : '' }}" onclick="toggleBookmark(@js(route('articles.bookmark', $article)))" aria-label="Simpan artikel">







                    <i class="{{ $isBookmarked ? 'fas' : 'far' }} fa-bookmark"></i>







                </button>







                <button type="button" class="icon-btn" onclick="shareArticle()" aria-label="Bagikan artikel">







                    <i class="fas fa-share-nodes"></i>







                </button>







            </div>







        </nav>



        <!-- READER SETTINGS -->

        <aside

            class="reader-settings"

            id="readerSettings"

            aria-label="Pengaturan bacaan"

            hidden

        >

            <div class="reader-settings-head">

                <div>

                    <span class="reader-settings-kicker">Keterbacaan</span>

                    <h2>Pengaturan bacaan</h2>

                </div>



                <button

                    type="button"

                    class="reader-settings-close"

                    id="readerSettingsClose"

                    aria-label="Tutup pengaturan bacaan"

                >

                    <i class="fas fa-xmark"></i>

                </button>

            </div>



            <div class="reader-setting-group">

                <div class="reader-setting-heading">

                    <span>Ukuran teks</span>

                    <strong id="fontSizeValue">20px</strong>

                </div>



                <div class="reader-size-control">

                    <button

                        type="button"

                        id="decreaseFont"

                        aria-label="Perkecil ukuran teks"

                    >

                        A−

                    </button>



                    <div class="reader-size-track" aria-hidden="true">

                        <span id="readerSizeIndicator"></span>

                    </div>



                    <button

                        type="button"

                        id="increaseFont"

                        aria-label="Perbesar ukuran teks"

                    >

                        A+

                    </button>

                </div>

            </div>



            <div class="reader-setting-group">

                <span class="reader-setting-label">Tipografi</span>



                <div class="reader-option-row">

                    <button

                        type="button"

                        class="reader-option reader-option-serif"

                        data-reader-font-option="serif"

                    >

                        Serif

                    </button>



                    <button

                        type="button"

                        class="reader-option reader-option-sans"

                        data-reader-font-option="sans"

                    >

                        Sans

                    </button>



                    <button

                        type="button"

                        class="reader-option reader-option-mono"

                        data-reader-font-option="mono"

                    >

                        Mono

                    </button>

                </div>

            </div>



            <div class="reader-setting-group">

                <span class="reader-setting-label">Tema bacaan</span>



                <div class="reader-theme-grid">

                    <button

                        type="button"

                        class="reader-theme-option"

                        data-reader-theme-option="light"

                    >

                        <span class="reader-theme-dot reader-theme-dot-light"></span>

                        <span>Terang</span>

                    </button>



                    <button

                        type="button"

                        class="reader-theme-option"

                        data-reader-theme-option="warm"

                    >

                        <span class="reader-theme-dot reader-theme-dot-warm"></span>

                        <span>Hangat</span>

                    </button>



                    <button

                        type="button"

                        class="reader-theme-option"

                        data-reader-theme-option="cream"

                    >

                        <span class="reader-theme-dot reader-theme-dot-cream"></span>

                        <span>Krem</span>

                    </button>



                    <button

                        type="button"

                        class="reader-theme-option"

                        data-reader-theme-option="dark"

                    >

                        <span class="reader-theme-dot reader-theme-dot-dark"></span>

                        <span>Gelap</span>

                    </button>

                </div>

            </div>



            <div class="reader-setting-group">

                <span class="reader-setting-label">Spasi baris</span>



                <div class="reader-option-row">

                    <button

                        type="button"

                        class="reader-option"

                        data-reader-spacing-option="compact"

                    >

                        Rapat

                    </button>



                    <button

                        type="button"

                        class="reader-option"

                        data-reader-spacing-option="normal"

                    >

                        Normal

                    </button>



                    <button

                        type="button"

                        class="reader-option"

                        data-reader-spacing-option="relaxed"

                    >

                        Lega

                    </button>

                </div>

            </div>



            <button

                type="button"

                class="reader-reset"

                id="resetReaderSettings"

            >

                <i class="fas fa-arrow-rotate-left"></i>

                Reset ke default

            </button>

        </aside>

















        <!-- ARTICLE CONTENT -->







        <div class="article-body">







            <div class="article-inner">















                <!-- Category -->







                <div class="article-category">{{ $article->category }}</div>















                <!-- Title (SANS-SERIF) -->







                <h1 class="article-title">{{ $article->title }}</h1>















                <!-- Excerpt -->







                @if($article->excerpt)







                <p class="article-excerpt">{{ $article->excerpt }}</p>







                @endif















                <!-- Author -->







                <div class="article-author">







                    <div class="author-avatar" style="background: linear-gradient(135deg, #FF8C5A, #FB4D00);">







                        {{ substr($article->user->name, 0, 1) }}







                    </div>







                    <div class="author-details">







                        <span class="author-name">{{ strtoupper($article->user->name) }}</span>







                        <span class="article-date">







                            {{ $article->created_at->locale('id')->isoFormat('MMM DD, YYYY') }}







                        </span>







                    </div>







                </div>















                <div class="article-meta-row">







                    <span><i class="far fa-clock"></i> {{ $article->reading_time }} menit baca</span>







                    <span><i class="far fa-eye"></i> {{ number_format($article->views_count) }} dibaca</span>







                    @if($article->is_featured)







                        <span class="featured-note"><i class="fas fa-sparkles"></i> Pilihan Interlude</span>







                    @endif







                </div>















                <!-- Divider -->







                <div class="article-divider"></div>















                <!-- Cover Image -->







                @if($hasCoverImage)







                <figure class="article-figure">







                    <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}">







                    <figcaption>Ilustrasi {{ strtolower($article->category) }}.</figcaption>







                </figure>







                @else







                    <div class="article-visual-placeholder" role="img" aria-label="Ilustrasi {{ $article->category }}">







                        <i class="fas fa-book-open"></i>







                        <span>{{ $article->category }}</span>







                    </div>







                @endif















                <!-- Article Text (SERIF - Playfair Display) -->







                <div class="article-text">







                    {!! $article->content !!}







                </div>















                <!-- Engagement Bar -->



                <div class="engagement-bar">







                    <!-- Like -->



                    <button



                        type="button"



                        class="engage-btn {{ $isLiked ? 'active' : '' }}"



                        onclick="toggleLike(@js(route('articles.like', $article)), this)"



                    >



                        <i class="{{ $isLiked ? 'fas' : 'far' }} fa-heart"></i>



                        <span>{{ $article->likes_count }}</span>



                    </button>







                    <!-- Comment -->



                    <button



                        type="button"



                        class="engage-btn"



                        onclick="document.getElementById('commentContent').focus()"



                    >



                        <i class="far fa-comment"></i>



                        <span>{{ $article->comments_count }}</span>



                    </button>







                    <!-- Save -->



                    <button



                        type="button"



                        class="engage-btn {{ $isBookmarked ? 'active' : '' }}"



                        onclick="toggleBookmark(@js(route('articles.bookmark', $article)))"



                    >



                        <i class="{{ $isBookmarked ? 'fas' : 'far' }} fa-bookmark"></i>



                        <span>Simpan</span>



                    </button>







                    <!-- Download -->



                    <a



                        href="{{ route('articles.download', $article) }}"



                        class="engage-btn download-btn"



                        aria-label="Unduh artikel"



                    >



                        <i class="fas fa-arrow-down"></i>



                        <span>Unduh</span>



                    </a>







                    <!-- Share -->



                    <button



                        type="button"



                        class="engage-btn"



                        onclick="shareArticle()"



                    >



                        <i class="fas fa-share-nodes"></i>



                        <span>Bagikan</span>



                    </button>

                    <!-- Quote Share -->
                    <button
                        type="button"
                        class="engage-btn quote-share-trigger"
                        id="openQuoteShareModal"
                        aria-label="Bagikan kutipan"
                    >
                        <i class="fas fa-quote-right"></i>
                        <span>Kutipan</span>
                    </button>








                </div>











                <section class="article-followup" aria-labelledby="conversation-heading">







                    <div class="followup-heading">







                        <div>







                            <span class="section-kicker">Ruang percakapan</span>







                            <h2 id="conversation-heading">Apa yang kamu pelajari dari cerita ini?</h2>







                        </div>







                        <span class="comment-count">{{ $article->comments->count() }} komentar</span>







                    </div>















                    @if(session('success'))







                        <div class="comment-success" role="status"><i class="fas fa-circle-check"></i> {{ session('success') }}</div>







                    @endif















                    <form method="POST" action="{{ route('articles.comments.store', $article) }}" class="comment-form">







                        @csrf







                        <label for="commentContent">Bagikan refleksimu</label>







                        <textarea id="commentContent" name="content" rows="3" maxlength="2000" placeholder="Apa yang paling mengena dari cerita ini?" required>{{ old('content') }}</textarea>







                        @error('content')







                            <span class="comment-error">{{ $message }}</span>







                        @enderror







                        <div class="comment-form-footer">







                            <span>Masuk sebagai {{ auth()->user()->name }}</span>







                            <button type="submit">Kirim komentar <i class="fas fa-arrow-right"></i></button>







                        </div>







                    </form>















                    <div class="comment-list">







                        @forelse($article->comments as $comment)







                            <div class="comment-item">







                                <div class="comment-avatar">{{ substr($comment->user->name, 0, 1) }}</div>







                                <div class="comment-copy">







                                    <div class="comment-byline">







                                        <strong>{{ $comment->user->name }}</strong>







                                        <time datetime="{{ $comment->created_at->toIso8601String() }}">{{ $comment->created_at->locale('id')->diffForHumans() }}</time>







                                    </div>







                                    <p>{{ $comment->content }}</p>







                                </div>







                            </div>







                        @empty







                            <div class="comment-empty">







                                <i class="far fa-comment-dots"></i>







                                <p>Belum ada percakapan. Jadilah yang pertama membagikan refleksimu.</p>







                            </div>







                        @endforelse







                    </div>







                </section>















                @if($relatedArticles->isNotEmpty())







                    <section class="related-section" aria-labelledby="related-heading">







                        <div class="followup-heading">







                            <div>







                                <span class="section-kicker">Lanjut membaca</span>







                                <h2 id="related-heading">Cerita lain dari topik {{ $article->category }}</h2>







                            </div>







                        </div>







                        <div class="related-grid">







                            @foreach($relatedArticles as $relatedArticle)







                                <a href="{{ route('articles.show', $relatedArticle->slug) }}" class="related-card">







                                    <span class="related-category">{{ $relatedArticle->category }}</span>







                                    <h3>{{ $relatedArticle->title }}</h3>







                                    <span class="related-author">{{ $relatedArticle->user->name }} · {{ $relatedArticle->reading_time }} menit</span>







                                </a>







                            @endforeach







                        </div>







                    </section>







                @endif















            </div>







        </div>















    

        @php
            $quoteCoverUrl = $hasCoverImage
                ? asset('storage/' . $article->cover_image)
                : null;

            $defaultQuote = trim(
                $article->excerpt
                    ?: \Illuminate\Support\Str::limit(
                        trim(strip_tags($article->content)),
                        200
                    )
            );
        @endphp

        <!-- =========================================================
             INTERLUDE — BAGIKAN KUTIPAN BACAAN
        ========================================================== -->
        <div
            class="quote-share-modal"
            id="quoteShareModal"
            hidden
            aria-hidden="true"
        >
            <div
                class="quote-share-backdrop"
                id="quoteShareBackdrop"
            ></div>

            <section
                class="quote-share-dialog"
                role="dialog"
                aria-modal="true"
                aria-labelledby="quoteShareTitle"
            >
                <header class="quote-share-head">
                    <div class="quote-share-heading">
                        <div class="quote-share-title-row">
                            <i class="fas fa-quote-right"></i>

                            <h2 id="quoteShareTitle">
                                Bagikan Kutipan Bacaan
                            </h2>

                        </div>

                        <p>
                            Buat kartu kutipan estetis untuk Instagram Story,
                            Twitter/X, atau simpan sebagai gambar HD.
                        </p>
                    </div>

                    <button
                        type="button"
                        class="quote-share-close"
                        id="closeQuoteShareModal"
                        aria-label="Tutup modal"
                    >
                        <i class="fas fa-xmark"></i>
                    </button>
                </header>

                <div class="quote-share-main">

                    <!-- LEFT: PREVIEW -->
                    <aside class="quote-preview-panel">

                        <div
                            class="quote-ratio-tabs"
                            aria-label="Pilih rasio kartu"
                        >
                            <button
                                type="button"
                                class="quote-ratio-tab is-active"
                                data-quote-ratio="story"
                                data-output-width="1080"
                                data-output-height="1920"
                                data-ratio-label="9:16"
                            >
                                Story (9:16)
                            </button>

                            <button
                                type="button"
                                class="quote-ratio-tab"
                                data-quote-ratio="square"
                                data-output-width="1080"
                                data-output-height="1080"
                                data-ratio-label="1:1"
                            >
                                Square (1:1)
                            </button>

                            <button
                                type="button"
                                class="quote-ratio-tab"
                                data-quote-ratio="feed"
                                data-output-width="1080"
                                data-output-height="1350"
                                data-ratio-label="4:5"
                            >
                                Feed (4:5)
                            </button>

                            <button
                                type="button"
                                class="quote-ratio-tab"
                                data-quote-ratio="custom"
                                data-output-width="1080"
                                data-output-height="1600"
                                data-ratio-label="Custom"
                            >
                                Custom
                            </button>
                        </div>

                        <div
                            class="quote-custom-size"
                            id="quoteCustomSize"
                            hidden
                        >
                            <div class="quote-custom-size-head">
                                <span>Ukuran custom</span>
                                <small id="quoteCustomRatioValue">1080 × 1600 · 27:40</small>
                            </div>

                            <div class="quote-custom-size-row">
                                <label>
                                    <span>Lebar</span>
                                    <input
                                        type="number"
                                        id="quoteCustomWidth"
                                        min="600"
                                        max="3000"
                                        step="10"
                                        value="1080"
                                    >
                                    <small>px</small>
                                </label>

                                <button
                                    type="button"
                                    class="quote-swap-size"
                                    id="quoteSwapSize"
                                    aria-label="Tukar lebar dan tinggi"
                                    title="Tukar lebar dan tinggi"
                                >
                                    <i class="fas fa-arrows-rotate"></i>
                                </button>

                                <label>
                                    <span>Tinggi</span>
                                    <input
                                        type="number"
                                        id="quoteCustomHeight"
                                        min="600"
                                        max="3000"
                                        step="10"
                                        value="1600"
                                    >
                                    <small>px</small>
                                </label>
                            </div>

                            <div class="quote-custom-presets">
                                <button
                                    type="button"
                                    data-custom-size="1080x1920"
                                >
                                    1080×1920
                                </button>

                                <button
                                    type="button"
                                    data-custom-size="1080x1350"
                                >
                                    1080×1350
                                </button>

                                <button
                                    type="button"
                                    data-custom-size="1080x1080"
                                >
                                    1080×1080
                                </button>

                                <button
                                    type="button"
                                    data-custom-size="1200x1500"
                                >
                                    1200×1500
                                </button>
                            </div>
                        </div>

                        <div
                            class="spotify-quote-card"
                            id="quotePreviewCard"
                            data-theme="{{ $quoteCoverUrl ? 'cover' : 'espresso' }}"
                            data-ratio="story"
                            data-font-style="modern"
                            data-density="normal"
                        >
                            @if($quoteCoverUrl)
                                <img
                                    src="{{ $quoteCoverUrl }}"
                                    alt=""
                                    class="spotify-card-cover"
                                    id="quoteCoverImage"
                                >
                            @else
                                <div
                                    class="spotify-card-cover spotify-card-cover--fallback"
                                    id="quoteCoverImage"
                                    aria-hidden="true"
                                ></div>
                            @endif

                            <div
                                class="spotify-card-overlay"
                                id="quoteCardOverlay"
                            ></div>

                            <div class="spotify-card-content">

                                <div class="spotify-card-top">
                                    <div class="spotify-brand">
                                        <span class="spotify-brand-mark">
                                            <i class="fas fa-book-open"></i>
                                        </span>

                                        <div>
                                            <strong>INTERLUDE</strong>
                                            <span>{{ strtoupper($article->category) }}</span>
                                        </div>
                                    </div>

                                    <div class="spotify-card-badges">
                                        <span
                                            class="spotify-card-ratio-badge"
                                            id="quoteRatioBadge"
                                        >
                                            9:16
                                        </span>
                                    </div>
                                </div>

                                <div class="spotify-card-quotes">
                                    <span class="spotify-big-quote">
                                        “
                                    </span>

                                    <blockquote
                                        class="spotify-primary-quote"
                                        id="previewPrimaryQuote"
                                    >
                                        {{ $defaultQuote }}
                                    </blockquote>

                                    <div
                                        class="spotify-secondary-wrap"
                                        id="previewSecondaryWrap"
                                        hidden
                                    >
                                        <blockquote
                                            class="spotify-secondary-quote"
                                            id="previewSecondaryQuote"
                                        ></blockquote>
                                    </div>
                                </div>

                                <div class="spotify-card-footer">
                                    <div
                                        class="spotify-card-author"
                                        id="previewAuthorBlock"
                                    >
                                        <span>Karya oleh</span>
                                        <strong>
                                            {{ $article->user->name }}
                                        </strong>
                                        <small>
                                            {{ $article->title }}
                                        </small>
                                    </div>

                                    <div
                                        class="spotify-qr-shell"
                                        id="previewQrShell"
                                        title="Buka artikel"
                                    >
                                        <div id="quoteQrCode"></div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <p class="quote-preview-caption">
                            <i class="fas fa-camera"></i>
                            Pratinjau langsung kartu cerita Instagram & Feed
                        </p>
                    </aside>


                    <!-- RIGHT: CONTROLS -->
                    <div class="quote-control-panel">

                        <div class="quote-control-scroll">

                            <!-- Quote selector -->
                            <section class="spotify-control-section">
                                <div class="spotify-section-head">
                                    <span>
                                        Pilih Kutipan dari Esai
                                        <small>(Spotify Lyrics Selector)</small>
                                    </span>

                                    <strong id="selectedQuoteCount">
                                        0 Dipilih
                                    </strong>
                                </div>

                                <div
                                    class="spotify-quote-selector"
                                    id="quoteCandidateList"
                                >
                                    <!-- Filled from article text by JavaScript -->
                                </div>

                                <p class="spotify-selector-note">
                                    Maksimal 2 kutipan. Kutipan pertama menjadi teks utama,
                                    kutipan kedua menjadi kutipan pendamping.
                                </p>
                            </section>


                            <!-- Theme -->
                            <section class="spotify-control-section">
                                <div class="spotify-section-head">
                                    <span>
                                        Tema & Latar Belakang Kartu
                                    </span>

                                    <strong
                                        class="spotify-mode-status"
                                        id="quoteThemeStatus"
                                    >
                                        {{ $quoteCoverUrl ? 'Cover Mode Aktif' : 'Espresso Aktif' }}
                                    </strong>
                                </div>

                                <div class="spotify-theme-grid">

                                    <button
                                        type="button"
                                        class="spotify-theme-option {{ $quoteCoverUrl ? 'is-active' : 'is-disabled' }}"
                                        data-quote-theme="cover"
                                        {{ $quoteCoverUrl ? '' : 'disabled' }}
                                    >
                                        <span
                                            class="spotify-theme-swatch spotify-theme-swatch--cover"
                                            @if($quoteCoverUrl)
                                                style="background-image:url('{{ $quoteCoverUrl }}')"
                                            @endif
                                        ></span>

                                        <span>Cover</span>

                                        <i class="fas fa-circle-check"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="spotify-theme-option"
                                        data-quote-theme="warm"
                                    >
                                        <span class="spotify-theme-swatch spotify-theme-swatch--warm"></span>
                                        <span>Hangat</span>
                                        <i class="fas fa-circle-check"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="spotify-theme-option {{ $quoteCoverUrl ? '' : 'is-active' }}"
                                        data-quote-theme="espresso"
                                    >
                                        <span class="spotify-theme-swatch spotify-theme-swatch--espresso"></span>
                                        <span>Espresso</span>
                                        <i class="fas fa-circle-check"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="spotify-theme-option"
                                        data-quote-theme="botanical"
                                    >
                                        <span class="spotify-theme-swatch spotify-theme-swatch--botanical"></span>
                                        <span>Botanical</span>
                                        <i class="fas fa-circle-check"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="spotify-theme-option"
                                        data-quote-theme="sunset"
                                    >
                                        <span class="spotify-theme-swatch spotify-theme-swatch--sunset"></span>
                                        <span>Sunset</span>
                                        <i class="fas fa-circle-check"></i>
                                    </button>

                                </div>


                                <div
                                    class="spotify-cover-tuning"
                                    id="quoteCoverTuning"
                                    {{ $quoteCoverUrl ? '' : 'hidden' }}
                                >
                                    <div class="spotify-tuning-head">
                                        <span>
                                            <i class="fas fa-sliders"></i>
                                            Penyesuaian Efek Cover
                                        </span>

                                        <strong id="quoteCoverStatus">
                                            Gelap 55% · Blur Ringan
                                        </strong>
                                    </div>

                                    <div class="spotify-tuning-grid">

                                        <div class="spotify-tuning-control">
                                            <span>Redupkan Foto</span>

                                            <div>
                                                <button
                                                    type="button"
                                                    data-quote-dimmer="30"
                                                >
                                                    30%
                                                </button>

                                                <button
                                                    type="button"
                                                    class="is-active"
                                                    data-quote-dimmer="55"
                                                >
                                                    55%
                                                </button>

                                                <button
                                                    type="button"
                                                    data-quote-dimmer="75"
                                                >
                                                    75%
                                                </button>
                                            </div>
                                        </div>


                                        <div class="spotify-tuning-control">
                                            <span>Efek Buram</span>

                                            <div>
                                                <button
                                                    type="button"
                                                    data-quote-blur="off"
                                                >
                                                    Off
                                                </button>

                                                <button
                                                    type="button"
                                                    class="is-active"
                                                    data-quote-blur="soft"
                                                >
                                                    Halus
                                                </button>

                                                <button
                                                    type="button"
                                                    data-quote-blur="strong"
                                                >
                                                    Kuat
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </section>


                            <!-- Font + detail -->
                            <section class="spotify-control-section spotify-detail-grid">

                                <div>
                                    <div class="spotify-section-head spotify-section-head--simple">
                                        <span>Gaya Tipografi</span>
                                    </div>

                                    <div class="spotify-font-grid">
                                        <button
                                            type="button"
                                            class="spotify-font-option is-active"
                                            data-quote-font="modern"
                                        >
                                            Modern
                                        </button>

                                        <button
                                            type="button"
                                            class="spotify-font-option spotify-font-option--editorial"
                                            data-quote-font="editorial"
                                        >
                                            Editorial
                                        </button>

                                        <button
                                            type="button"
                                            class="spotify-font-option spotify-font-option--mono"
                                            data-quote-font="mono"
                                        >
                                            Monospace
                                        </button>
                                    </div>
                                </div>


                                <div>
                                    <div class="spotify-section-head spotify-section-head--simple">
                                        <span>Detail & Watermark</span>
                                    </div>

                                    <div class="spotify-toggle-list">

                                        <label>
                                            <span>Tampilkan Penulis</span>
                                            <input
                                                type="checkbox"
                                                id="quoteShowAuthor"
                                                checked
                                            >
                                        </label>

                                        <label>
                                            <span>Tampilkan QR Code Baca</span>
                                            <input
                                                type="checkbox"
                                                id="quoteShowQr"
                                                checked
                                            >
                                        </label>

                                    </div>
                                </div>

                            </section>

                        </div>


                        <!-- Sticky action footer -->
                        <footer class="spotify-share-footer">

                            <div class="spotify-primary-actions">
                                <button
                                    type="button"
                                    class="spotify-download-btn"
                                    id="downloadQuoteCardBtn"
                                >
                                    <i class="fas fa-download"></i>
                                    Unduh Gambar (PNG HD)
                                </button>

                                <button
                                    type="button"
                                    class="spotify-copy-image-btn"
                                    id="copyQuoteImageBtn"
                                >
                                    <i class="far fa-copy"></i>
                                    Salin Gambar
                                </button>
                            </div>

                            <div class="spotify-direct-share">
                                <span>Bagikan langsung:</span>

                                <div>
                                    <button
                                        type="button"
                                        id="shareQuoteInstagramBtn"
                                    >
                                        <i class="fas fa-camera"></i>
                                        Instagram Stories
                                    </button>

                                    <button
                                        type="button"
                                        id="shareQuoteTwitterBtn"
                                    >
                                        <i class="fab fa-x-twitter"></i>
                                        Twitter / X
                                    </button>

                                    <button
                                        type="button"
                                        id="copyQuoteLinkBtn"
                                    >
                                        <i class="fas fa-link"></i>
                                        Salin Tautan
                                    </button>
                                </div>
                            </div>

                        </footer>

                    </div>
                </div>
            </section>
        </div>

</article>















    <style>







        .article-page {







            background: var(--white);







            min-height: 100vh;







        }















        /* TOP NAVBAR */







        .article-topbar {







            position: sticky;







            top: 0;







            background: var(--white);







            border-bottom: 1px solid var(--border);







            padding: 12px 24px;







            display: flex;







            align-items: center;







            justify-content: space-between;







            z-index: 100;







        }















        .close-btn {







            width: 40px;







            height: 40px;







            border-radius: 10px;







            border: 1px solid var(--border);







            background: var(--white);







            display: flex;







            align-items: center;







            justify-content: center;







            color: var(--brown);







            text-decoration: none;







            font-size: 16px;







            transition: 0.2s;







        }















        .close-btn:hover {







            background: var(--cream);







        }















        .topbar-center {







            display: flex;







            align-items: center;







        }















        .topbar-avatar {







            width: 36px;







            height: 36px;







            border-radius: 50%;







            display: flex;







            align-items: center;







            justify-content: center;







            font-weight: 700;







            font-size: 14px;







            color: var(--white);







        }















        .topbar-right {







            display: flex;







            align-items: center;







            gap: 10px;







        }















        .subscribe-btn {







            padding: 10px 20px;







            background: var(--tangelo);







            color: var(--white);







            border: none;







            border-radius: 8px;







            font-size: 14px;







            font-weight: 600;







            cursor: pointer;







            font-family: 'DM Sans', sans-serif;







            transition: 0.2s;







        }















        .subscribe-btn:hover {







            background: #e04400;







        }















        .edit-article-btn {







            display: inline-flex;







            align-items: center;







            gap: 7px;







            padding: 10px 14px;







            border: 1px solid var(--border);







            border-radius: 999px;







            color: var(--brown);







            font-size: 13px;







            font-weight: 700;







            text-decoration: none;







        }















        .edit-article-btn:hover { border-color: var(--tangelo); color: var(--tangelo); }















        .icon-btn {







            width: 40px;







            height: 40px;







            border-radius: 10px;







            border: 1px solid var(--border);







            background: var(--white);







            display: flex;







            align-items: center;







            justify-content: center;







            color: var(--brown);







            cursor: pointer;







            font-size: 14px;







            transition: 0.2s;







        }















        .icon-btn:hover {







            background: var(--cream);







        }















        .icon-btn.active { border-color: var(--tangelo); color: var(--tangelo); }















        /* ARTICLE BODY */







        .article-body {







            max-width: 680px;







            margin: 0 auto;







            padding: 60px 24px 100px;







        }















        .article-inner {







            max-width: 680px;







        }















        .article-category {







            font-size: 12px;







            font-weight: 700;







            letter-spacing: 2px;







            color: var(--tangelo);







            text-transform: uppercase;







            margin-bottom: 20px;







        }















        /* JUDUL - SANS-SERIF (DM Sans) */







        .article-title {







            font-family: 'DM Sans', sans-serif;







            font-size: 40px;







            font-weight: 700;







            line-height: 1.2;







            color: var(--brown);







            margin-bottom: 20px;







            letter-spacing: -0.5px;







        }















        .article-excerpt {







            font-size: 20px;







            line-height: 1.6;







            color: var(--text-soft);







            margin-bottom: 32px;







            font-weight: 400;







        }















        .article-author {







            display: flex;







            align-items: center;







            gap: 14px;







            margin-bottom: 40px;







        }















        .article-meta-row {







            display: flex;







            flex-wrap: wrap;







            gap: 10px 18px;







            margin: -22px 0 32px 62px;







            color: var(--text-soft);







            font-size: 13px;







        }















        .article-meta-row span { display: inline-flex; align-items: center; gap: 6px; }







        .article-meta-row i { color: var(--tangelo); }







        .article-meta-row .featured-note { color: var(--brown); font-weight: 700; }















        .author-avatar {







            width: 48px;







            height: 48px;







            border-radius: 50%;







            display: flex;







            align-items: center;







            justify-content: center;







            font-weight: 700;







            font-size: 18px;







            color: var(--white);







        }















        .author-details {







            display: flex;







            flex-direction: column;







            gap: 2px;







        }















        .author-name {







            font-weight: 700;







            font-size: 14px;







            color: var(--brown);







            letter-spacing: 0.5px;







        }















        .article-date {







            font-size: 13px;







            color: var(--text-soft);







        }















        .article-divider {







            height: 1px;







            background: var(--border);







            margin-bottom: 48px;







        }















        /* FIGURE */







        .article-figure {







            margin: 0 0 48px;







        }















        .article-figure img {







            width: 100%;







            border-radius: 4px;







            display: block;







        }















        .article-figure figcaption {







            text-align: center;







            font-size: 14px;







            color: var(--text-soft);







            margin-top: 12px;







            font-style: italic;







        }















        .article-visual-placeholder {







            display: flex;







            min-height: 260px;







            align-items: center;







            justify-content: center;







            gap: 10px;







            margin-bottom: 48px;







            border-radius: 16px;







            background: linear-gradient(135deg, var(--linen), var(--blue));







            color: var(--brown);







            font-size: 14px;







            font-weight: 800;







        }















        .article-visual-placeholder i { color: var(--tangelo); font-size: 28px; }















        /* ARTICLE TEXT - SERIF (Playfair Display) - TETAP SAMA */







        .article-text {







            font-family: 'Playfair Display', serif;







            font-size: 20px;







            line-height: 1.8;







            color: #2C2C2C;







        }















        .article-text p {







            margin-bottom: 28px;







        }















        /* Heading dalam artikel - SERIF (Playfair Display) */







        .article-text h2 {







            font-family: 'Playfair Display', serif;







            font-size: 28px;







            font-weight: 700;







            margin: 40px 0 20px;







            color: var(--brown);







            line-height: 1.3;







        }















        .article-text h3 {







            font-family: 'Playfair Display', serif;







            font-size: 22px;







            font-weight: 700;







            margin: 32px 0 16px;







            color: var(--brown);







        }















        .article-text strong,







        .article-text b {







            font-weight: 700;







        }















        .article-text em,







        .article-text i {







            font-style: italic;







        }















        .article-text u {







            text-decoration: underline;







        }















        .article-text blockquote {







            border-left: 4px solid var(--tangelo);







            padding: 16px 24px;







            margin: 32px 0;







            font-style: italic;







            color: var(--text-soft);







            background: var(--linen);







            border-radius: 0 8px 8px 0;







        }















        .article-text blockquote p {







            margin-bottom: 0;







        }















        .article-text ul,







        .article-text ol {







            margin: 24px 0;







            padding-left: 32px;







        }















        .article-text li {







            margin: 12px 0;







            line-height: 1.7;







        }















        .article-text hr {







            border: none;







            border-top: 1px solid var(--border);







            margin: 40px 0;







        }















        /* ENGAGEMENT BAR */







        .engagement-bar {







            display: flex;







            justify-content: space-around;







            align-items: center;







            padding: 20px 0;







            margin-top: 48px;







            border-top: 1px solid var(--border);







            border-bottom: 1px solid var(--border);







        }















        .engage-btn {







            display: flex;







            align-items: center;







            gap: 8px;







            background: none;







            border: none;







            color: var(--text-soft);







            font-size: 16px;







            cursor: pointer;







            padding: 10px 16px;







            border-radius: 8px;







            transition: 0.2s;







            font-family: 'DM Sans', sans-serif;







        }















        .engage-btn:hover {







            background: var(--cream);







            color: var(--tangelo);







        }















        .engage-btn.active {







            color: var(--tangelo);







        }















        .engage-btn.active i { color: var(--tangelo); }















        .engage-btn i {







            font-size: 20px;







        }















        .engage-btn span {







            font-size: 15px;







            font-weight: 600;







        }







        .download-btn {



            text-decoration: none;



        }















        .article-followup,







        .related-section {







            margin-top: 64px;







            padding-top: 32px;







            border-top: 1px solid var(--border);







        }















        .followup-heading {







            display: flex;







            align-items: flex-end;







            justify-content: space-between;







            gap: 20px;







            margin-bottom: 24px;







        }















        .section-kicker,







        .related-category {







            color: var(--tangelo);







            font-size: 11px;







            font-weight: 800;







            letter-spacing: 1.4px;







            text-transform: uppercase;







        }















        .followup-heading h2 {







            max-width: 480px;







            margin: 7px 0 0;







            color: var(--brown);







            font-family: 'Plus Jakarta Sans', sans-serif;







            font-size: 24px;







            line-height: 1.25;







        }















        .comment-count { color: var(--text-soft); font-size: 13px; white-space: nowrap; }







        .comment-list { display: grid; gap: 18px; }







        .comment-success { display: flex; align-items: center; gap: 7px; margin-bottom: 16px; padding: 11px 13px; border-radius: 12px; background: #e4f4ed; color: #226d4e; font-size: 13px; }







        .comment-form { display: grid; gap: 9px; margin-bottom: 24px; padding: 16px; border: 1px solid var(--border); border-radius: 16px; background: var(--white); }







        .comment-form label { color: var(--brown); font-size: 13px; font-weight: 800; }







        .comment-form textarea { width: 100%; box-sizing: border-box; resize: vertical; padding: 12px; border: 1px solid var(--border); border-radius: 11px; background: var(--cream); color: var(--brown); font: 14px/1.55 'DM Sans', sans-serif; outline: none; }







        .comment-form textarea:focus { border-color: var(--tangelo); box-shadow: 0 0 0 3px rgba(251, 77, 0, .1); }







        .comment-form-footer { display: flex; align-items: center; justify-content: space-between; gap: 12px; color: var(--text-soft); font-size: 11px; }







        .comment-form-footer button { display: inline-flex; align-items: center; gap: 7px; padding: 9px 13px; border: 0; border-radius: 999px; background: var(--brown); color: var(--white); font: 800 12px 'DM Sans', sans-serif; cursor: pointer; }







        .comment-form-footer button:hover { background: var(--tangelo); }







        .comment-error { color: #b42318; font-size: 12px; }







        .comment-item { display: flex; gap: 12px; padding: 16px; border-radius: 16px; background: var(--cream); }







        .comment-avatar { flex: 0 0 36px; height: 36px; display: grid; place-items: center; border-radius: 50%; background: var(--blue); color: var(--brown); font-weight: 800; }







        .comment-copy { min-width: 0; }







        .comment-byline { display: flex; align-items: baseline; gap: 9px; flex-wrap: wrap; }







        .comment-byline strong { color: var(--brown); font-size: 14px; }







        .comment-byline time { color: var(--text-soft); font-size: 12px; }







        .comment-copy p { margin: 5px 0 0; color: var(--text-soft); font-size: 14px; line-height: 1.6; }







        .comment-empty { padding: 24px; border: 1px dashed var(--border); border-radius: 16px; color: var(--text-soft); text-align: center; }







        .comment-empty i { color: var(--tangelo); font-size: 24px; }







        .comment-empty p { margin: 8px 0 0; font-size: 14px; }







        .related-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; }







        .related-card { display: flex; min-height: 150px; flex-direction: column; justify-content: space-between; gap: 14px; padding: 18px; border: 1px solid var(--border); border-radius: 16px; background: var(--white); text-decoration: none; transition: transform .2s ease, border-color .2s ease, background .2s ease; }







        .related-card:hover { transform: translateY(-3px); border-color: var(--tangelo); background: var(--linen); }







        .related-card h3 { margin: 0; color: var(--brown); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; line-height: 1.35; }







        .related-author { color: var(--text-soft); font-size: 12px; }















        /* RESPONSIVE */







        @media (max-width: 768px) {







            .article-body {







                padding: 40px 20px 80px;







            }















            .article-title {







                font-size: 28px;







            }















            .article-excerpt {







                font-size: 17px;







            }















            .article-text {







                font-size: 18px;







            }















            .article-text h2 {







                font-size: 24px;







            }















            .article-text h3 {







                font-size: 20px;







            }















            .subscribe-btn {







                display: none;







            }















            .edit-article-btn { padding: 9px 11px; font-size: 12px; }















            .article-meta-row { margin-left: 0; }







            .followup-heading { align-items: flex-start; flex-direction: column; gap: 8px; }







            .related-grid { grid-template-columns: 1fr; }







            .engagement-bar { gap: 4px; justify-content: space-between; }







            .engage-btn { gap: 5px; padding: 9px 7px; font-size: 13px; }







            .engage-btn i { font-size: 17px; }







            .engage-btn span { font-size: 12px; }







            .comment-form-footer { align-items: flex-start; flex-direction: column; }







            .comment-form-footer button { width: 100%; justify-content: center; }







        }









        /* ==========================================================

           READER / KETERBACAAN SETTINGS

        ========================================================== */



        .article-page {

            --reader-font-size: 20px;

            --reader-line-height: 1.8;

            --reader-font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;



            --reader-page-bg: #FFFFFF;

            --reader-surface: #FFFFFF;

            --reader-soft: #FBF9F4;

            --reader-text: #2C2C2C;

            --reader-muted: #6F625C;

            --reader-heading: #49261D;

            --reader-border: #E8DCD6;



            background: var(--reader-page-bg);

            color: var(--reader-text);



            transition:

                background-color .22s ease,

                color .22s ease;

        }



        .article-page[data-reader-theme="light"] {

            --reader-page-bg: #FFFFFF;

            --reader-surface: #FFFFFF;

            --reader-soft: #FBF9F4;

            --reader-text: #2C2C2C;

            --reader-muted: #6F625C;

            --reader-heading: #49261D;

            --reader-border: #E8DCD6;

        }



        .article-page[data-reader-theme="warm"] {

            --reader-page-bg: #FFF5EF;

            --reader-surface: #FFF9F5;

            --reader-soft: #FFEDE3;

            --reader-text: #47352F;

            --reader-muted: #7B6258;

            --reader-heading: #49261D;

            --reader-border: #EACFC3;

        }



        .article-page[data-reader-theme="cream"] {

            --reader-page-bg: #F7EFD9;

            --reader-surface: #FBF5E6;

            --reader-soft: #EFE3C5;

            --reader-text: #40372D;

            --reader-muted: #716559;

            --reader-heading: #4B382B;

            --reader-border: #DCCFB0;

        }



        .article-page[data-reader-theme="dark"] {

            --reader-page-bg: #232120;

            --reader-surface: #2B2826;

            --reader-soft: #35312F;

            --reader-text: #F3ECE7;

            --reader-muted: #C7B8B0;

            --reader-heading: #FFF7F2;

            --reader-border: #4D4541;

        }



        .article-page .article-topbar {

            background: var(--reader-surface);

            border-color: var(--reader-border);

        }



        .article-page .close-btn,

        .article-page .icon-btn,

        .article-page .edit-article-btn,

        .article-page .reader-trigger {

            background: var(--reader-surface);

            border-color: var(--reader-border);

            color: var(--reader-heading);

        }



        .article-page .close-btn:hover,

        .article-page .icon-btn:hover,

        .article-page .reader-trigger:hover {

            background: var(--reader-soft);

        }



        .article-page .article-title,

        .article-page .author-name,

        .article-page .followup-heading h2,

        .article-page .related-card h3,

        .article-page .comment-form label {

            color: var(--reader-heading);

        }



        .article-page .article-excerpt,

        .article-page .article-meta-row,

        .article-page .article-date,

        .article-page .comment-count,

        .article-page .comment-copy p,

        .article-page .related-author {

            color: var(--reader-muted);

        }



        .article-page .article-divider,

        .article-page .engagement-bar,

        .article-page .article-followup,

        .article-page .related-section,

        .article-page .comment-form,

        .article-page .related-card {

            border-color: var(--reader-border);

        }



        .article-page .comment-form,

        .article-page .related-card {

            background: var(--reader-surface);

        }



        .article-page .comment-form textarea,

        .article-page .comment-item,

        .article-page .comment-empty {

            background: var(--reader-soft);

            color: var(--reader-text);

        }



        .article-page .comment-byline strong {

            color: var(--reader-heading);

        }



        .article-page .comment-byline time {

            color: var(--reader-muted);

        }



        .article-page .article-text blockquote {

            background: var(--reader-soft);

            color: var(--reader-muted);

        }



        .article-page .article-text hr {

            border-color: var(--reader-border);

        }



        .article-page[data-reader-font="serif"] {

            --reader-font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;

        }



        .article-page[data-reader-font="sans"] {

            --reader-font-family: 'DM Sans', Arial, sans-serif;

        }



        .article-page[data-reader-font="mono"] {

            --reader-font-family: 'Courier New', ui-monospace, SFMono-Regular, Menlo, Monaco, monospace;

        }



        .article-page .article-text,

        .article-page .article-text h2,

        .article-page .article-text h3 {

            font-family: var(--reader-font-family);

            color: var(--reader-text);

        }



        .article-page .article-text {

            font-size: var(--reader-font-size);

            line-height: var(--reader-line-height);

        }



        .article-page .article-text h2,

        .article-page .article-text h3 {

            color: var(--reader-heading);

        }



        .article-page .article-text p,

        .article-page .article-text li {

            line-height: var(--reader-line-height);

        }



        .article-page[data-reader-spacing="compact"] {

            --reader-line-height: 1.55;

        }



        .article-page[data-reader-spacing="normal"] {

            --reader-line-height: 1.8;

        }



        .article-page[data-reader-spacing="relaxed"] {

            --reader-line-height: 2.05;

        }



        .reader-trigger {

            min-width: 86px;

            height: 40px;

            padding: 0 12px;



            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 6px;



            border: 1px solid var(--reader-border);

            border-radius: 10px;



            cursor: pointer;



            font-family: 'DM Sans', sans-serif;

            font-weight: 800;



            transition:

                background .2s ease,

                border-color .2s ease,

                color .2s ease;

        }



        .reader-trigger-small {

            font-size: 11px;

        }



        .reader-trigger-large {

            font-size: 14px;

        }



        .reader-trigger-slash {

            color: var(--reader-muted);

            font-size: 10px;

            font-weight: 500;

        }



        .reader-settings[hidden] {

            display: none !important;

        }



        .reader-settings {

            position: fixed;

            top: 76px;

            right: 24px;

            z-index: 250;



            width: min(340px, calc(100vw - 32px));

            max-height: calc(100vh - 96px);

            overflow-y: auto;



            padding: 20px;



            border: 1px solid var(--reader-border);

            border-radius: 20px;



            background: var(--reader-surface);

            color: var(--reader-text);



            box-shadow:

                0 24px 65px rgba(73, 38, 29, .18);



            animation: readerSettingsIn .16s ease-out;

        }



        @keyframes readerSettingsIn {

            from {

                opacity: 0;

                transform: translateY(-6px) scale(.985);

            }



            to {

                opacity: 1;

                transform: translateY(0) scale(1);

            }

        }



        .reader-settings-head {

            display: flex;

            align-items: flex-start;

            justify-content: space-between;

            gap: 14px;

            padding-bottom: 16px;

        }



        .reader-settings-kicker {

            display: block;

            margin-bottom: 4px;



            color: var(--tangelo);



            font-family: 'Plus Jakarta Sans', sans-serif;

            font-size: 9px;

            font-weight: 800;

            letter-spacing: 1.2px;

            text-transform: uppercase;

        }



        .reader-settings-head h2 {

            margin: 0;



            color: var(--reader-heading);



            font-family: 'Plus Jakarta Sans', sans-serif;

            font-size: 19px;

            font-weight: 800;

            line-height: 1.25;

        }



        .reader-settings-close {

            width: 34px;

            height: 34px;

            flex: 0 0 34px;



            display: grid;

            place-items: center;



            border: 0;

            border-radius: 50%;



            background: var(--reader-soft);

            color: var(--reader-heading);



            cursor: pointer;

        }



        .reader-settings-close:hover {

            color: var(--tangelo);

        }



        .reader-setting-group {

            padding: 15px 0;

            border-top: 1px solid var(--reader-border);

        }



        .reader-setting-heading {

            margin-bottom: 10px;



            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 10px;



            color: var(--reader-heading);



            font-size: 11px;

            font-weight: 800;

        }



        .reader-setting-heading strong {

            color: var(--reader-muted);

            font-size: 10px;

        }



        .reader-setting-label {

            display: block;

            margin-bottom: 10px;



            color: var(--reader-heading);



            font-size: 11px;

            font-weight: 800;

        }



        .reader-size-control {

            display: grid;

            grid-template-columns: 44px minmax(0, 1fr) 44px;

            align-items: center;

            gap: 10px;

        }



        .reader-size-control > button {

            width: 44px;

            height: 38px;



            border: 1px solid var(--reader-border);

            border-radius: 11px;



            background: var(--reader-soft);

            color: var(--reader-heading);



            cursor: pointer;



            font-family: 'DM Sans', sans-serif;

            font-size: 12px;

            font-weight: 800;

        }



        .reader-size-control > button:hover {

            border-color: var(--tangelo);

            color: var(--tangelo);

        }



        .reader-size-track {

            position: relative;

            height: 5px;

            overflow: hidden;

            border-radius: 999px;

            background: var(--reader-soft);

        }



        .reader-size-track span {

            position: absolute;

            inset: 0 auto 0 0;

            width: 50%;

            border-radius: inherit;

            background: var(--tangelo);

            transition: width .18s ease;

        }



        .reader-option-row {

            display: grid;

            grid-template-columns: repeat(3, minmax(0, 1fr));

            gap: 7px;

        }



        .reader-option {

            min-height: 40px;

            padding: 0 8px;



            border: 1px solid var(--reader-border);

            border-radius: 11px;



            background: var(--reader-surface);

            color: var(--reader-muted);



            cursor: pointer;



            font-size: 10px;

            font-weight: 700;

        }



        .reader-option:hover {

            background: var(--reader-soft);

        }



        .reader-option.is-active {

            border-color: var(--reader-heading);

            background: var(--reader-heading);

            color: var(--reader-surface);

        }



        .reader-option-serif {

            font-family: Georgia, 'Times New Roman', serif;

        }



        .reader-option-sans {

            font-family: 'DM Sans', Arial, sans-serif;

        }



        .reader-option-mono {

            font-family: 'Courier New', monospace;

        }



        .reader-theme-grid {

            display: grid;

            grid-template-columns: repeat(2, minmax(0, 1fr));

            gap: 7px;

        }



        .reader-theme-option {

            min-height: 44px;

            padding: 8px 10px;



            display: flex;

            align-items: center;

            gap: 8px;



            border: 1px solid var(--reader-border);

            border-radius: 12px;



            background: var(--reader-surface);

            color: var(--reader-muted);



            cursor: pointer;



            font-family: 'DM Sans', sans-serif;

            font-size: 10px;

            font-weight: 700;

        }



        .reader-theme-option:hover {

            background: var(--reader-soft);

        }



        .reader-theme-option.is-active {

            border-color: var(--tangelo);

            box-shadow:

                inset 0 0 0 1px var(--tangelo);

        }



        .reader-theme-dot {

            width: 27px;

            height: 27px;

            flex: 0 0 27px;



            border: 1px solid rgba(73, 38, 29, .12);

            border-radius: 8px;

        }



        .reader-theme-dot-light {

            background: #FFFFFF;

        }



        .reader-theme-dot-warm {

            background: #FFF5EF;

        }



        .reader-theme-dot-cream {

            background: #F7EFD9;

        }



        .reader-theme-dot-dark {

            background: #232120;

        }



        .reader-reset {

            width: 100%;

            min-height: 40px;



            margin-top: 4px;



            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 7px;



            border: 0;

            border-radius: 999px;



            background: var(--reader-soft);

            color: var(--reader-muted);



            cursor: pointer;



            font-family: 'DM Sans', sans-serif;

            font-size: 10px;

            font-weight: 800;

        }



        .reader-reset:hover {

            color: var(--tangelo);

        }



        @media (max-width: 768px) {

            .reader-trigger {

                min-width: 72px;

                height: 38px;

                padding: 0 9px;

            }



            .reader-settings {

                top: auto;

                right: 0;

                bottom: 0;

                left: 0;



                width: 100%;

                max-height: 82vh;



                border-right: 0;

                border-bottom: 0;

                border-left: 0;

                border-radius: 24px 24px 0 0;

            }

        }




        /* ==========================================================
           QUOTE SHARE — SPOTIFY LYRICS SELECTOR STYLE
        ========================================================== */

        .quote-share-modal[hidden] {
            display: none !important;
        }

        .quote-share-modal {
            position: fixed;
            inset: 0;
            z-index: 5000;

            padding: 18px;

            display: grid;
            place-items: center;
        }

        .quote-share-backdrop {
            position: absolute;
            inset: 0;

            background: rgba(48, 31, 26, .62);

            backdrop-filter: blur(7px);
            -webkit-backdrop-filter: blur(7px);
        }

        .quote-share-dialog {
            position: relative;
            z-index: 1;

            width: min(1020px, 100%);
            height: min(760px, calc(100vh - 36px));
            max-height: calc(100vh - 36px);

            display: flex;
            flex-direction: column;

            overflow: hidden;

            border: 1px solid #E8DCD6;
            border-radius: 18px;

            background: #FFFDFB;

            box-shadow:
                0 32px 90px rgba(48, 18, 10, .26);

            animation: spotifyQuoteModalIn .18s ease-out;
        }

        @keyframes spotifyQuoteModalIn {
            from {
                opacity: 0;
                transform: translateY(8px) scale(.99);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .quote-share-head {
            flex: 0 0 auto;

            min-height: 84px;
            padding: 16px 20px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;

            border-bottom: 1px solid #E8DCD6;

            background: rgba(255, 253, 251, .96);
        }

        .quote-share-title-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .quote-share-title-row > i {
            color: #FB4D00;
            font-size: 15px;
        }

        .quote-share-title-row h2 {
            margin: 0;

            color: #30120A;

            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 17px;
            font-weight: 800;
            letter-spacing: -.3px;
        }

        .quote-spotify-badge {
            padding: 3px 7px;

            border-radius: 999px;

            background: #F4EFEC;
            color: #8A7770;

            font-family: 'DM Sans', sans-serif;
            font-size: 7px;
            font-weight: 800;
            letter-spacing: .6px;
            text-transform: uppercase;
        }

        .quote-share-heading p {
            margin: 4px 0 0;

            color: #8F7A72;

            font-family: 'DM Sans', sans-serif;
            font-size: 9px;
        }

        .quote-share-close {
            width: 34px;
            height: 34px;
            flex: 0 0 34px;

            display: grid;
            place-items: center;

            border: 0;
            border-radius: 50%;

            background: #F7F2EE;
            color: #6A5048;

            cursor: pointer;
        }

        .quote-share-close:hover {
            color: #FB4D00;
        }


        /* Main modal layout */

        .quote-share-main {
            flex: 1 1 auto;
            min-height: 0;

            display: grid;
            grid-template-columns:
                minmax(330px, .82fr)
                minmax(500px, 1.18fr);

            overflow: hidden;
        }


        /* ======================================================
           LEFT PREVIEW
        ====================================================== */

        .quote-preview-panel {
            min-width: 0;
            min-height: 0;

            overflow-y: auto;
            overscroll-behavior: contain;

            padding: 18px;

            display: flex;
            flex-direction: column;
            align-items: center;

            border-right: 1px solid #E8DCD6;

            background:
                radial-gradient(
                    circle at 16% 12%,
                    rgba(202, 231, 247, .43),
                    transparent 32%
                ),
                #FBF7F3;
        }

        .quote-ratio-tabs {
            margin-bottom: 12px;
            padding: 3px;

            display: inline-flex;
            align-items: center;
            gap: 2px;

            border-radius: 999px;

            background: #F1ECE8;
        }

        .quote-ratio-tab {
            min-height: 26px;
            padding: 0 10px;

            border: 0;
            border-radius: 999px;

            background: transparent;
            color: #8B7870;

            cursor: pointer;

            font-family: 'DM Sans', sans-serif;
            font-size: 8px;
            font-weight: 800;
        }

        .quote-ratio-tab.is-active {
            background: #FFFFFF;
            color: #49261D;

            box-shadow:
                0 2px 6px rgba(73, 38, 29, .08);
        }



        /* Custom output size */

        .quote-custom-size[hidden] {
            display: none !important;
        }

        .quote-custom-size {
            width: min(100%, 350px);

            margin: -2px 0 12px;
            padding: 10px;

            border: 1px solid #E5D8D2;
            border-radius: 12px;

            background: rgba(255,255,255,.74);
        }

        .quote-custom-size-head {
            margin-bottom: 8px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .quote-custom-size-head > span {
            color: #5F453D;

            font-family: 'DM Sans', sans-serif;
            font-size: 8px;
            font-weight: 800;
        }

        .quote-custom-size-head > small {
            color: #9A8780;

            font-family: 'DM Sans', sans-serif;
            font-size: 6px;
            font-weight: 700;
        }

        .quote-custom-size-row {
            display: grid;
            grid-template-columns: minmax(0,1fr) 30px minmax(0,1fr);
            align-items: end;
            gap: 6px;
        }

        .quote-custom-size-row label {
            position: relative;

            min-width: 0;

            display: grid;
            gap: 4px;
        }

        .quote-custom-size-row label > span {
            color: #8B7770;

            font-family: 'DM Sans', sans-serif;
            font-size: 6px;
            font-weight: 800;
        }

        .quote-custom-size-row input {
            width: 100%;
            height: 33px;

            padding: 0 27px 0 9px;

            border: 1px solid #DED0CA;
            border-radius: 8px;

            outline: 0;

            background: #FFFFFF;
            color: #49261D;

            font-family: 'DM Sans', sans-serif;
            font-size: 8px;
            font-weight: 800;
        }

        .quote-custom-size-row input:focus {
            border-color: #FB4D00;
            box-shadow: 0 0 0 3px rgba(251,77,0,.08);
        }

        .quote-custom-size-row label > small {
            position: absolute;
            right: 8px;
            bottom: 9px;

            color: #A18E87;

            font-family: 'DM Sans', sans-serif;
            font-size: 6px;
        }

        .quote-swap-size {
            width: 30px;
            height: 33px;

            display: grid;
            place-items: center;

            border: 1px solid #DED0CA;
            border-radius: 8px;

            background: #F7F2EE;
            color: #6D554D;

            cursor: pointer;
        }

        .quote-swap-size:hover {
            color: #FB4D00;
            background: #FFF2EB;
        }

        .quote-custom-presets {
            margin-top: 7px;

            display: flex;
            gap: 4px;
            flex-wrap: wrap;
        }

        .quote-custom-presets button {
            min-height: 22px;
            padding: 0 7px;

            border: 0;
            border-radius: 999px;

            background: #F2EDE9;
            color: #856F67;

            cursor: pointer;

            font-family: 'DM Sans', sans-serif;
            font-size: 6px;
            font-weight: 800;
        }

        .quote-custom-presets button:hover {
            background: #FFEDE3;
            color: #D24712;
        }

        /* Preview card */

        .spotify-quote-card {
            position: relative;

            width: min(100%, 300px);
            aspect-ratio: 9 / 16;

            flex: 0 0 auto;

            overflow: hidden;
            isolation: isolate;

            border-radius: 17px;

            background: #1C1B19;
            color: #FFFFFF;

            box-shadow:
                0 20px 50px rgba(50, 27, 20, .22);

            transition:
                width .18s ease,
                aspect-ratio .18s ease;
        }

        .spotify-quote-card[data-ratio="story"] {
            width: min(100%, 300px);
            aspect-ratio: 9 / 16;
        }

        .spotify-quote-card[data-ratio="square"] {
            width: min(100%, 350px);
            aspect-ratio: 1 / 1;
        }

        .spotify-quote-card[data-ratio="feed"] {
            width: min(100%, 340px);
            aspect-ratio: 4 / 5;
        }

        .spotify-quote-card[data-ratio="custom"] {
            width: min(100%, 340px);
            aspect-ratio: var(--custom-card-ratio, 1080 / 1600);
        }

        .spotify-card-cover {
            position: absolute;
            inset: -4%;

            z-index: -4;

            width: 108%;
            height: 108%;

            object-fit: cover;
            object-position: center;

            transform: scale(1.06);

            transition:
                opacity .2s ease,
                filter .2s ease,
                transform .2s ease;
        }

        .spotify-card-cover--fallback {
            background:
                linear-gradient(
                    145deg,
                    #72443A,
                    #2A1612
                );
        }

        .spotify-quote-card:not([data-theme="cover"])
        .spotify-card-cover {
            opacity: 0;
        }

        .spotify-card-overlay {
            position: absolute;
            inset: 0;

            z-index: -3;

            background:
                linear-gradient(
                    180deg,
                    rgba(42, 19, 13, .65),
                    rgba(42, 19, 13, .32) 42%,
                    rgba(28, 12, 10, .88)
                );
        }

        .spotify-quote-card::before {
            content: "";

            position: absolute;
            inset: 0;

            z-index: -2;

            pointer-events: none;

            background:
                repeating-linear-gradient(
                    0deg,
                    rgba(255,255,255,.018) 0,
                    rgba(255,255,255,.018) 1px,
                    transparent 1px,
                    transparent 3px
                );
        }

        .spotify-quote-card[data-theme="warm"] {
            background:
                radial-gradient(
                    circle at 84% 10%,
                    rgba(255,220,195,.35),
                    transparent 30%
                ),
                linear-gradient(
                    155deg,
                    #CF7A57,
                    #6F3A2E 64%,
                    #3A1D18
                );
        }

        .spotify-quote-card[data-theme="espresso"] {
            background:
                radial-gradient(
                    circle at 16% 12%,
                    rgba(148,100,80,.30),
                    transparent 30%
                ),
                linear-gradient(
                    155deg,
                    #604034,
                    #291713 70%
                );
        }

        .spotify-quote-card[data-theme="botanical"] {
            background:
                radial-gradient(
                    circle at 80% 12%,
                    rgba(167,206,177,.18),
                    transparent 30%
                ),
                linear-gradient(
                    155deg,
                    #5F7B67,
                    #243D31 67%,
                    #172820
                );
        }

        .spotify-quote-card[data-theme="sunset"] {
            background:
                radial-gradient(
                    circle at 80% 10%,
                    rgba(255,211,151,.40),
                    transparent 29%
                ),
                linear-gradient(
                    155deg,
                    #E48559,
                    #A94F5F 58%,
                    #57304D
                );
        }

        .spotify-card-content {
            position: relative;
            z-index: 1;

            height: 100%;
            min-height: 0;

            padding: 16px 16px 26px;

            display: grid;
            grid-template-rows:
                auto
                minmax(0, 1fr)
                auto;

            box-sizing: border-box;
        }

        .spotify-card-top {
            padding-bottom: 11px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;

            border-bottom: 1px solid rgba(255,255,255,.20);
        }

        .spotify-brand {
            min-width: 0;

            display: flex;
            align-items: center;
            gap: 7px;
        }

        .spotify-brand-mark {
            width: 22px;
            height: 22px;
            flex: 0 0 22px;

            display: grid;
            place-items: center;

            border-radius: 6px;

            background: rgba(255,255,255,.94);
            color: #49261D;

            font-size: 8px;
        }

        .spotify-brand > div {
            min-width: 0;

            display: grid;
            gap: 0;
        }

        .spotify-brand strong {
            color: #FFFFFF;

            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 7px;
            font-weight: 800;
            letter-spacing: .45px;
        }

        .spotify-brand span {
            color: rgba(255,255,255,.68);

            font-family: 'DM Sans', sans-serif;
            font-size: 5px;
            font-weight: 700;
            letter-spacing: .65px;
        }

        .spotify-card-badges {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .spotify-card-ratio-badge {
            min-height: 20px;
            padding: 0 7px;

            display: inline-flex;
            align-items: center;

            border: 1px solid rgba(255,255,255,.18);
            border-radius: 999px;

            background: rgba(255,255,255,.14);
            color: #FFFFFF;

            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);

            font-family: 'DM Sans', sans-serif;
            font-size: 5px;
            font-weight: 800;
        }


        /* Quote body: never pushes footer outside */

        .spotify-card-quotes {
            min-height: 0;
            overflow: hidden;

            padding: 12px 0;

            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .spotify-big-quote {
            display: block;

            height: 22px;

            color: rgba(255,255,255,.22);

            font-family: Georgia, serif;
            font-size: 35px;
            font-weight: 800;
            line-height: 1;
        }

        .spotify-primary-quote {
            margin: 0;

            color: #FFFFFF;

            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 20px;
            font-weight: 800;
            line-height: 1.22;
            letter-spacing: -.45px;

            overflow-wrap: anywhere;
        }

        .spotify-secondary-wrap {
            margin-top: 12px;
            padding: 7px 9px;

            border-left: 2px solid #FB4D00;
            border-radius: 0 7px 7px 0;

            background: rgba(48, 18, 10, .28);
        }

        .spotify-secondary-wrap[hidden] {
            display: none !important;
        }

        .spotify-secondary-quote {
            margin: 0;

            color: rgba(255,255,255,.90);

            font-family: 'DM Sans', sans-serif;
            font-size: 9px;
            font-weight: 600;
            line-height: 1.35;
        }


        /* Adaptive density */

        .spotify-quote-card[data-density="compact"]
        .spotify-primary-quote {
            font-size: 17px;
            line-height: 1.20;
        }

        .spotify-quote-card[data-density="compact"]
        .spotify-secondary-quote {
            font-size: 8px;
        }

        .spotify-quote-card[data-density="tight"]
        .spotify-primary-quote {
            font-size: 14px;
            line-height: 1.18;
        }

        .spotify-quote-card[data-density="tight"]
        .spotify-secondary-quote {
            font-size: 7px;
            line-height: 1.26;
        }

        .spotify-quote-card[data-ratio="square"]
        .spotify-card-content {
            padding: 14px;
        }

        .spotify-quote-card[data-ratio="square"]
        .spotify-primary-quote {
            font-size: 16px;
        }

        .spotify-quote-card[data-ratio="square"][data-density="compact"]
        .spotify-primary-quote {
            font-size: 13px;
        }

        .spotify-quote-card[data-ratio="square"][data-density="tight"]
        .spotify-primary-quote {
            font-size: 11px;
        }

        .spotify-quote-card[data-ratio="feed"]
        .spotify-primary-quote {
            font-size: 18px;
        }

        .spotify-quote-card[data-ratio="feed"][data-density="compact"]
        .spotify-primary-quote {
            font-size: 15px;
        }

        .spotify-quote-card[data-ratio="feed"][data-density="tight"]
        .spotify-primary-quote {
            font-size: 12px;
        }


        /* Typography */

        .spotify-quote-card[data-font-style="modern"]
        .spotify-primary-quote {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .spotify-quote-card[data-font-style="editorial"]
        .spotify-primary-quote {
            font-family: Georgia, 'Times New Roman', serif;
            font-weight: 700;
            letter-spacing: -.25px;
        }

        .spotify-quote-card[data-font-style="mono"]
        .spotify-primary-quote {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            letter-spacing: -.35px;
        }


        /* Footer */

        .spotify-card-footer {
            min-height: 62px;
            padding-top: 12px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;

            border-top: 1px solid rgba(255,255,255,.20);
        }

        .spotify-card-author {
            min-width: 0;
            max-width: calc(100% - 48px);

            display: grid;
            gap: 1px;
        }

        .spotify-card-author > span {
            color: rgba(255,255,255,.64);

            font-family: 'DM Sans', sans-serif;
            font-size: 5px;
            font-weight: 800;
            letter-spacing: .55px;
            text-transform: uppercase;
        }

        .spotify-card-author > strong {
            color: #FFFFFF;

            font-family: 'DM Sans', sans-serif;
            font-size: 9px;
            font-weight: 800;
        }

        .spotify-card-author > small {
            max-width: 100%;
            min-height: 12px;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

            color: rgba(255,255,255,.72);

            font-family: 'DM Sans', sans-serif;
            font-size: 6px;
        }

        .spotify-qr-shell {
            width: 34px;
            height: 34px;
            flex: 0 0 34px;

            padding: 3px;

            overflow: hidden;

            border-radius: 7px;

            background: #FFFFFF;

            box-shadow:
                0 4px 10px rgba(0,0,0,.14);
        }

        #quoteQrCode,
        #quoteQrCode img,
        #quoteQrCode canvas {
            width: 100% !important;
            height: 100% !important;

            display: block;
        }

        .quote-preview-caption {
            margin: 10px 0 0;

            display: flex;
            align-items: center;
            gap: 5px;

            color: #8D7971;

            font-family: 'DM Sans', sans-serif;
            font-size: 8px;
        }

        .quote-preview-caption i {
            color: #FB4D00;
        }


        /* ======================================================
           RIGHT CONTROL PANEL
        ====================================================== */

        .quote-control-panel {
            min-width: 0;
            min-height: 0;

            display: grid;
            grid-template-rows:
                minmax(0, 1fr)
                auto;

            overflow: hidden;

            background: #FFFDFB;
        }

        .quote-control-scroll {
            min-height: 0;

            overflow-y: auto;
            overscroll-behavior: contain;

            padding: 18px 20px 14px;

            scrollbar-width: thin;
            scrollbar-color: #CDBBB4 transparent;
        }

        .quote-control-scroll::-webkit-scrollbar {
            width: 7px;
        }

        .quote-control-scroll::-webkit-scrollbar-thumb {
            border: 2px solid transparent;
            border-radius: 999px;

            background: #CDBBB4;
            background-clip: padding-box;
        }

        .spotify-control-section {
            padding: 0 0 15px;
            margin-bottom: 15px;

            border-bottom: 1px solid #E9DDD7;
        }

        .spotify-control-section:last-child {
            margin-bottom: 0;
            border-bottom: 0;
        }

        .spotify-section-head {
            margin-bottom: 8px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;

            color: #49261D;
        }

        .spotify-section-head > span {
            font-family: 'DM Sans', sans-serif;
            font-size: 10px;
            font-weight: 800;
        }

        .spotify-section-head > span small {
            color: #9A8780;

            font-size: 8px;
            font-weight: 700;
        }

        .spotify-section-head > strong {
            color: #FB4D00;

            font-family: 'DM Sans', sans-serif;
            font-size: 8px;
            font-weight: 800;
        }

        .spotify-section-head--simple {
            justify-content: flex-start;
        }


        /* Lyrics selector */

        .spotify-quote-selector {
            display: grid;
            gap: 7px;
        }

        .spotify-quote-choice {
            position: relative;

            padding: 9px 10px;

            display: grid;
            grid-template-columns: 16px minmax(0,1fr);
            gap: 9px;

            border: 1px solid #E5D8D2;
            border-radius: 13px;

            background: #F9F5F2;

            cursor: pointer;

            transition:
                border-color .16s ease,
                background .16s ease,
                transform .16s ease;
        }

        .spotify-quote-choice:hover {
            background: #FFF8F3;
            transform: translateY(-1px);
        }

        .spotify-quote-choice.is-selected {
            border: 2px solid #F07A4A;

            background:
                linear-gradient(
                    180deg,
                    rgba(255,237,227,.74),
                    rgba(255,249,245,.92)
                );
        }

        .spotify-quote-choice.is-disabled {
            opacity: .52;
        }

        .spotify-quote-choice input {
            margin: 3px 0 0;

            accent-color: #FB4D00;
        }

        .spotify-choice-copy {
            min-width: 0;

            display: grid;
            gap: 3px;
        }

        .spotify-choice-copy strong {
            color: #4A3129;

            font-family: 'DM Sans', sans-serif;
            font-size: 9px;
            font-weight: 700;
            line-height: 1.35;
        }

        .spotify-quote-choice.is-selected
        .spotify-choice-copy strong {
            color: #49261D;
            font-weight: 800;
        }

        .spotify-choice-copy small {
            color: #9B8780;

            font-family: 'DM Sans', sans-serif;
            font-size: 6px;
            font-weight: 800;
            letter-spacing: .35px;
            text-transform: uppercase;
        }

        .spotify-quote-choice.is-selected
        .spotify-choice-copy small {
            color: #D34B14;
        }

        .spotify-selector-note {
            margin: 7px 0 0;

            color: #A18E87;

            font-family: 'DM Sans', sans-serif;
            font-size: 7px;
            line-height: 1.45;
        }


        /* Theme selector */

        .spotify-mode-status {
            padding: 3px 7px;

            border-radius: 999px;

            background: #FFEDE3;
            color: #A83A0C !important;
        }

        .spotify-theme-grid {
            display: grid;
            grid-template-columns:
                repeat(5, minmax(0,1fr));
            gap: 6px;
        }

        .spotify-theme-option {
            position: relative;

            min-width: 0;
            min-height: 60px;
            padding: 7px 4px;

            display: grid;
            justify-items: center;
            align-content: center;
            gap: 4px;

            border: 1px solid transparent;
            border-radius: 12px;

            background: #F7F2EE;
            color: #79655D;

            cursor: pointer;

            font-family: 'DM Sans', sans-serif;
            font-size: 7px;
            font-weight: 800;
        }

        .spotify-theme-option:hover:not(:disabled) {
            background: #FFF7F2;
        }

        .spotify-theme-option.is-active {
            border: 2px solid #F07A4A;

            background: #FFF5F0;
            color: #D24712;
        }

        .spotify-theme-option.is-disabled {
            cursor: not-allowed;
            opacity: .45;
        }

        .spotify-theme-option > i {
            position: absolute;
            top: 5px;
            right: 5px;

            color: #FB4D00;
            font-size: 8px;

            opacity: 0;
        }

        .spotify-theme-option.is-active > i {
            opacity: 1;
        }

        .spotify-theme-swatch {
            width: 30px;
            height: 30px;

            display: block;

            border-radius: 9px;

            background-position: center;
            background-size: cover;

            box-shadow:
                inset 0 0 0 1px rgba(73,38,29,.08);
        }

        .spotify-theme-swatch--cover {
            background:
                linear-gradient(
                    145deg,
                    #E4D7D1,
                    #B79E94
                );
        }

        .spotify-theme-swatch--warm {
            background: #D66625;
        }

        .spotify-theme-swatch--espresso {
            background: #30120A;
        }

        .spotify-theme-swatch--botanical {
            background: #17333F;
        }

        .spotify-theme-swatch--sunset {
            background: #D44000;
        }


        /* Cover tuning */

        .spotify-cover-tuning {
            margin-top: 8px;
            padding: 8px;

            border-radius: 11px;

            background: #F3EEEA;
        }

        .spotify-cover-tuning[hidden] {
            display: none !important;
        }

        .spotify-tuning-head {
            margin-bottom: 7px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .spotify-tuning-head > span {
            display: flex;
            align-items: center;
            gap: 5px;

            color: #7B665E;

            font-family: 'DM Sans', sans-serif;
            font-size: 7px;
            font-weight: 800;
        }

        .spotify-tuning-head > span i {
            color: #FB4D00;
        }

        .spotify-tuning-head > strong {
            color: #6B5148;

            font-family: 'DM Sans', sans-serif;
            font-size: 6px;
            font-weight: 800;
        }

        .spotify-tuning-grid {
            display: grid;
            grid-template-columns:
                repeat(2, minmax(0,1fr));
            gap: 6px;
        }

        .spotify-tuning-control {
            min-width: 0;

            padding: 6px 7px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;

            border: 1px solid #E3D6D0;
            border-radius: 8px;

            background: #FFFFFF;
        }

        .spotify-tuning-control > span {
            color: #8C7770;

            font-family: 'DM Sans', sans-serif;
            font-size: 6px;
            font-weight: 700;
        }

        .spotify-tuning-control > div {
            display: flex;
            gap: 2px;
        }

        .spotify-tuning-control button {
            min-height: 20px;
            padding: 0 6px;

            border: 0;
            border-radius: 5px;

            background: #F3EEEA;
            color: #8B7770;

            cursor: pointer;

            font-family: 'DM Sans', sans-serif;
            font-size: 6px;
            font-weight: 800;
        }

        .spotify-tuning-control button.is-active {
            background: #FB4D00;
            color: #FFFFFF;
        }


        /* Font + watermark */

        .spotify-detail-grid {
            display: grid;
            grid-template-columns:
                repeat(2, minmax(0,1fr));
            gap: 14px;
        }

        .spotify-font-grid {
            display: grid;
            grid-template-columns:
                repeat(3, minmax(0,1fr));
            gap: 4px;
        }

        .spotify-font-option {
            min-height: 28px;
            padding: 0 5px;

            border: 1px solid #E3D6D0;
            border-radius: 7px;

            background: #F7F2EE;
            color: #765F57;

            cursor: pointer;

            font-family: 'DM Sans', sans-serif;
            font-size: 7px;
            font-weight: 800;
        }

        .spotify-font-option--editorial {
            font-family: Georgia, serif;
            font-style: italic;
        }

        .spotify-font-option--mono {
            font-family: 'Courier New', monospace;
        }

        .spotify-font-option.is-active {
            border: 2px solid #F07A4A;

            background: #FFF3EC;
            color: #D24712;
        }

        .spotify-toggle-list {
            display: grid;
            gap: 6px;
        }

        .spotify-toggle-list label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;

            color: #765F57;

            font-family: 'DM Sans', sans-serif;
            font-size: 7px;
            font-weight: 700;

            cursor: pointer;
        }

        .spotify-toggle-list input {
            accent-color: #FB4D00;
        }


        /* ======================================================
           ACTION FOOTER
        ====================================================== */

        .spotify-share-footer {
            position: relative;
            z-index: 5;

            padding: 11px 20px 13px;

            border-top: 1px solid #E8DCD6;

            background: #FFFDFB;

            box-shadow:
                0 -10px 26px rgba(73,38,29,.05);
        }

        .spotify-primary-actions {
            display: grid;
            grid-template-columns:
                minmax(0, 1.45fr)
                minmax(150px, .75fr);
            gap: 8px;
        }

        .spotify-download-btn,
        .spotify-copy-image-btn {
            min-height: 39px;
            padding: 0 14px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;

            border-radius: 999px;

            cursor: pointer;

            font-family: 'DM Sans', sans-serif;
            font-size: 8px;
            font-weight: 800;
        }

        .spotify-download-btn {
            border: 0;

            background: #D44000;
            color: #FFFFFF;

            box-shadow:
                0 7px 16px rgba(212,64,0,.17);
        }

        .spotify-copy-image-btn {
            border: 0;

            background: #49261D;
            color: #FFFFFF;
        }

        .spotify-direct-share {
            margin-top: 8px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .spotify-direct-share > span {
            color: #8A7770;

            font-family: 'DM Sans', sans-serif;
            font-size: 6px;
            font-weight: 800;
            letter-spacing: .4px;
            text-transform: uppercase;
        }

        .spotify-direct-share > div {
            display: flex;
            align-items: center;
            gap: 5px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .spotify-direct-share button {
            min-height: 27px;
            padding: 0 9px;

            display: inline-flex;
            align-items: center;
            gap: 5px;

            border: 0;
            border-radius: 999px;

            background: #F2EDE9;
            color: #684F47;

            cursor: pointer;

            font-family: 'DM Sans', sans-serif;
            font-size: 6px;
            font-weight: 800;
        }

        .spotify-direct-share button:hover {
            background: #EAE2DD;
            color: #49261D;
        }

        .spotify-direct-share button i {
            color: #FB4D00;
        }


        /* Responsive */

        @media (max-width: 900px) {
            .quote-share-modal {
                padding: 8px;
            }

            .quote-share-dialog {
                height: calc(100vh - 16px);
                max-height: calc(100vh - 16px);

                border-radius: 16px;
            }

            .quote-share-main {
                display: block;

                overflow-y: auto;
                overscroll-behavior: contain;
            }

            .quote-preview-panel {
                min-height: auto;
                overflow: visible;

                border-right: 0;
                border-bottom: 1px solid #E8DCD6;
            }

            .quote-control-panel {
                display: block;
                overflow: visible;
            }

            .quote-control-scroll {
                overflow: visible;
            }

            .spotify-share-footer {
                position: sticky;
                bottom: 0;
            }
        }

        @media (max-width: 620px) {
            .quote-share-head {
                padding: 13px 14px;
            }

            .quote-share-heading p,
            .quote-spotify-badge {
                display: none;
            }

            .quote-share-title-row h2 {
                font-size: 15px;
            }

            .quote-preview-panel,
            .quote-control-scroll {
                padding-right: 14px;
                padding-left: 14px;
            }

            .spotify-theme-grid {
                grid-template-columns:
                    repeat(3, minmax(0,1fr));
            }

            .quote-custom-size {
                width: min(100%, 330px);
            }

            .spotify-tuning-grid,
            .spotify-detail-grid {
                grid-template-columns: 1fr;
            }

            .spotify-primary-actions {
                grid-template-columns: 1fr;
            }

            .spotify-direct-share {
                align-items: flex-start;
                flex-direction: column;
            }

            .spotify-direct-share > div {
                justify-content: flex-start;
            }
        }

</style>















        <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>







        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;















        async function toggleLike(url, button) {







            try {







            const response = await fetch(url, {







                    method: 'POST',







                    headers: {







                        'Content-Type': 'application/json',







                        'X-CSRF-TOKEN': csrfToken,







                        'Accept': 'application/json'







                    }







                });







                const data = await response.json();







                if (data.success) {







                    const icon = button.querySelector('i');







                    const count = button.querySelector('span');







                    if (data.liked) {







                        button.classList.add('active');







                        icon.className = 'fas fa-heart';







                    } else {







                        button.classList.remove('active');







                        icon.className = 'far fa-heart';







                    }







                    if (count) count.textContent = data.count;







                }







            } catch (error) {







                console.error('Error:', error);







            }







        }















        async function toggleBookmark(url) {







            try {







            const response = await fetch(url, {







                    method: 'POST',







                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }







                });







                const data = await response.json();







                if (data.success) {







                    document.querySelectorAll('[onclick*="toggleBookmark"]').forEach((button) => {







                        button.classList.toggle('active', data.bookmarked);







                        const icon = button.querySelector('i');







                        if (icon) icon.className = `${data.bookmarked ? 'fas' : 'far'} fa-bookmark`;







                    });







                }







            } catch (error) {







                console.error('Bookmark error:', error);







            }







        }















        async function shareArticle() {







            const shareData = {







                title: @js($article->title),







                text: @js($article->excerpt ?: 'Baca cerita ini di Interlude.'),







                url: window.location.href







            };















            try {







                if (navigator.share) {







                    await navigator.share(shareData);







                    return;







                }















                await navigator.clipboard.writeText(window.location.href);







                alert('Tautan artikel berhasil disalin.');







            } catch (error) {







                if (error.name !== 'AbortError') console.error('Share error:', error);







            }







        }











        /* ==========================================================

           READER / KETERBACAAN SETTINGS

        ========================================================== */



        document.addEventListener('DOMContentLoaded', function () {

            const reader =

                document.getElementById('articleReader');



            const trigger =

                document.getElementById('readerTrigger');



            const panel =

                document.getElementById('readerSettings');



            const closeButton =

                document.getElementById('readerSettingsClose');



            const decreaseButton =

                document.getElementById('decreaseFont');



            const increaseButton =

                document.getElementById('increaseFont');



            const fontSizeValue =

                document.getElementById('fontSizeValue');



            const sizeIndicator =

                document.getElementById('readerSizeIndicator');



            const resetButton =

                document.getElementById('resetReaderSettings');



            if (!reader || !trigger || !panel) {

                return;

            }



            const STORAGE_KEY =

                'interlude.readerPreferences.v1';



            const MIN_FONT_SIZE = 16;

            const MAX_FONT_SIZE = 26;



            const defaults = {

                fontSize: 20,

                font: 'serif',

                theme: 'light',

                spacing: 'normal'

            };



            let preferences = {

                ...defaults

            };



            try {

                const saved =

                    localStorage.getItem(STORAGE_KEY);



                if (saved) {

                    preferences = {

                        ...defaults,

                        ...JSON.parse(saved)

                    };

                }

            } catch (error) {

                console.warn(

                    'Preferensi bacaan tidak dapat dibaca:',

                    error

                );

            }



            function savePreferences() {

                try {

                    localStorage.setItem(

                        STORAGE_KEY,

                        JSON.stringify(preferences)

                    );

                } catch (error) {

                    console.warn(

                        'Preferensi bacaan tidak dapat disimpan:',

                        error

                    );

                }

            }



            function setActiveOption(

                selector,

                datasetKey,

                value

            ) {

                document

                    .querySelectorAll(selector)

                    .forEach(function (button) {

                        button.classList.toggle(

                            'is-active',

                            button.dataset[datasetKey]

                                === value

                        );

                    });

            }



            function applyPreferences() {

                preferences.fontSize =

                    Math.min(

                        MAX_FONT_SIZE,

                        Math.max(

                            MIN_FONT_SIZE,

                            Number(preferences.fontSize)

                                || defaults.fontSize

                        )

                    );



                reader.style.setProperty(

                    '--reader-font-size',

                    `${preferences.fontSize}px`

                );



                reader.dataset.readerFont =

                    preferences.font;



                reader.dataset.readerTheme =

                    preferences.theme;



                reader.dataset.readerSpacing =

                    preferences.spacing;



                if (fontSizeValue) {

                    fontSizeValue.textContent =

                        `${preferences.fontSize}px`;

                }



                if (sizeIndicator) {

                    const percentage =

                        (

                            (

                                preferences.fontSize

                                - MIN_FONT_SIZE

                            )

                            /

                            (

                                MAX_FONT_SIZE

                                - MIN_FONT_SIZE

                            )

                        )

                        * 100;



                    sizeIndicator.style.width =

                        `${percentage}%`;

                }



                setActiveOption(

                    '[data-reader-font-option]',

                    'readerFontOption',

                    preferences.font

                );



                setActiveOption(

                    '[data-reader-theme-option]',

                    'readerThemeOption',

                    preferences.theme

                );



                setActiveOption(

                    '[data-reader-spacing-option]',

                    'readerSpacingOption',

                    preferences.spacing

                );



                savePreferences();

            }



            function openPanel() {

                panel.hidden = false;



                trigger.setAttribute(

                    'aria-expanded',

                    'true'

                );

            }



            function closePanel() {

                panel.hidden = true;



                trigger.setAttribute(

                    'aria-expanded',

                    'false'

                );

            }



            trigger.addEventListener(

                'click',

                function (event) {

                    event.stopPropagation();



                    if (panel.hidden) {

                        openPanel();

                    } else {

                        closePanel();

                    }

                }

            );



            closeButton?.addEventListener(

                'click',

                closePanel

            );



            decreaseButton?.addEventListener(

                'click',

                function () {

                    preferences.fontSize =

                        Math.max(

                            MIN_FONT_SIZE,

                            preferences.fontSize - 1

                        );



                    applyPreferences();

                }

            );



            increaseButton?.addEventListener(

                'click',

                function () {

                    preferences.fontSize =

                        Math.min(

                            MAX_FONT_SIZE,

                            preferences.fontSize + 1

                        );



                    applyPreferences();

                }

            );



            document

                .querySelectorAll(

                    '[data-reader-font-option]'

                )

                .forEach(function (button) {

                    button.addEventListener(

                        'click',

                        function () {

                            preferences.font =

                                button.dataset

                                    .readerFontOption;



                            applyPreferences();

                        }

                    );

                });



            document

                .querySelectorAll(

                    '[data-reader-theme-option]'

                )

                .forEach(function (button) {

                    button.addEventListener(

                        'click',

                        function () {

                            preferences.theme =

                                button.dataset

                                    .readerThemeOption;



                            applyPreferences();

                        }

                    );

                });



            document

                .querySelectorAll(

                    '[data-reader-spacing-option]'

                )

                .forEach(function (button) {

                    button.addEventListener(

                        'click',

                        function () {

                            preferences.spacing =

                                button.dataset

                                    .readerSpacingOption;



                            applyPreferences();

                        }

                    );

                });



            resetButton?.addEventListener(

                'click',

                function () {

                    preferences = {

                        ...defaults

                    };



                    applyPreferences();

                }

            );



            panel.addEventListener(

                'click',

                function (event) {

                    event.stopPropagation();

                }

            );



            document.addEventListener(

                'click',

                function () {

                    if (!panel.hidden) {

                        closePanel();

                    }

                }

            );



            document.addEventListener(

                'keydown',

                function (event) {

                    if (

                        event.key === 'Escape'

                        && !panel.hidden

                    ) {

                        closePanel();

                    }

                }

            );



            applyPreferences();

        });





        /* ==========================================================
           QUOTE SHARE — SPOTIFY LYRICS SELECTOR
        ========================================================== */

        document.addEventListener('DOMContentLoaded', function () {
            const modal =
                document.getElementById('quoteShareModal');

            const openButton =
                document.getElementById('openQuoteShareModal');

            const closeButton =
                document.getElementById('closeQuoteShareModal');

            const backdrop =
                document.getElementById('quoteShareBackdrop');

            const card =
                document.getElementById('quotePreviewCard');

            const cover =
                document.getElementById('quoteCoverImage');

            const overlay =
                document.getElementById('quoteCardOverlay');

            const candidateList =
                document.getElementById('quoteCandidateList');

            const selectedCount =
                document.getElementById('selectedQuoteCount');

            const primaryQuote =
                document.getElementById('previewPrimaryQuote');

            const secondaryWrap =
                document.getElementById('previewSecondaryWrap');

            const secondaryQuote =
                document.getElementById('previewSecondaryQuote');

            const ratioBadge =
                document.getElementById('quoteRatioBadge');

            const customSizePanel =
                document.getElementById('quoteCustomSize');

            const customWidthInput =
                document.getElementById('quoteCustomWidth');

            const customHeightInput =
                document.getElementById('quoteCustomHeight');

            const customRatioValue =
                document.getElementById('quoteCustomRatioValue');

            const swapSizeButton =
                document.getElementById('quoteSwapSize');

            const themeStatus =
                document.getElementById('quoteThemeStatus');

            const coverTuning =
                document.getElementById('quoteCoverTuning');

            const coverStatus =
                document.getElementById('quoteCoverStatus');

            const authorBlock =
                document.getElementById('previewAuthorBlock');

            const qrShell =
                document.getElementById('previewQrShell');

            const qrCode =
                document.getElementById('quoteQrCode');

            const showAuthor =
                document.getElementById('quoteShowAuthor');

            const showQr =
                document.getElementById('quoteShowQr');

            const downloadButton =
                document.getElementById('downloadQuoteCardBtn');

            const copyImageButton =
                document.getElementById('copyQuoteImageBtn');

            const instagramButton =
                document.getElementById('shareQuoteInstagramBtn');

            const twitterButton =
                document.getElementById('shareQuoteTwitterBtn');

            const copyLinkButton =
                document.getElementById('copyQuoteLinkBtn');

            if (
                !modal
                || !openButton
                || !card
                || !candidateList
            ) {
                return;
            }


            const DEFAULT_QUOTE =
                @js($defaultQuote);

            const MAX_SELECTED =
                2;

            const themeLabels = {
                cover: 'Foto Sampul',
                warm: 'Hangat',
                espresso: 'Espresso',
                botanical: 'Botanical',
                sunset: 'Sunset'
            };

            let candidates = [];
            let selectedIds = [];
            let qrInitialized = false;


            function cleanText(value) {
                return String(value || '')
                    .replace(/\s+/g, ' ')
                    .replace(/[“”]/g, '"')
                    .trim();
            }


            function stripOuterQuotes(value) {
                return cleanText(value)
                    .replace(/^["']+/, '')
                    .replace(/["']+$/, '')
                    .trim();
            }


            function selectedArticleText() {
                const selection =
                    window.getSelection();

                if (
                    !selection
                    || selection.rangeCount === 0
                    || selection.isCollapsed
                ) {
                    return '';
                }

                const value =
                    stripOuterQuotes(
                        selection.toString()
                    );

                if (value.length < 12) {
                    return '';
                }

                const range =
                    selection.getRangeAt(0);

                const commonNode =
                    range.commonAncestorContainer;

                const commonElement =
                    commonNode.nodeType === Node.ELEMENT_NODE
                        ? commonNode
                        : commonNode.parentElement;

                if (
                    !commonElement
                    || !commonElement.closest('.article-text')
                ) {
                    return '';
                }

                return value.slice(0, 240);
            }


            function nearestSectionLabel(element) {
                let current =
                    element?.previousElementSibling;

                while (current) {
                    if (
                        current.matches?.('h2, h3')
                    ) {
                        return cleanText(
                            current.textContent
                        ).slice(0, 70);
                    }

                    current =
                        current.previousElementSibling;
                }

                return 'Isi artikel';
            }


            function buildCandidates() {
                const result = [];
                const seen = new Set();

                function addCandidate(
                    text,
                    label,
                    source = 'article'
                ) {
                    const clean =
                        stripOuterQuotes(text);

                    const key =
                        clean.toLowerCase();

                    if (
                        clean.length < 28
                        || clean.length > 240
                        || seen.has(key)
                    ) {
                        return;
                    }

                    seen.add(key);

                    result.push({
                        id: `quote-${result.length + 1}`,
                        text: clean,
                        label:
                            cleanText(label)
                            || 'Isi artikel',
                        source
                    });
                }


                const highlighted =
                    selectedArticleText();

                if (highlighted) {
                    addCandidate(
                        highlighted,
                        'Pilihanmu dari artikel',
                        'selection'
                    );
                }


                const articleText =
                    document.querySelector(
                        '.article-text'
                    );

                if (articleText) {
                    const blocks =
                        articleText.querySelectorAll(
                            'blockquote, h2, h3, p, li'
                        );

                    let currentSection =
                        'Pembuka';

                    blocks.forEach(function (block) {
                        if (
                            block.matches('h2, h3')
                        ) {
                            currentSection =
                                cleanText(
                                    block.textContent
                                ).slice(0, 70)
                                || currentSection;

                            return;
                        }

                        const fullText =
                            cleanText(
                                block.textContent
                            );

                        if (!fullText) {
                            return;
                        }

                        if (
                            block.matches('blockquote')
                        ) {
                            addCandidate(
                                fullText,
                                `${currentSection} · Kutipan utama`,
                                'blockquote'
                            );

                            return;
                        }


                        block
                            .querySelectorAll?.(
                                'strong, b'
                            )
                            .forEach(function (strong) {
                                addCandidate(
                                    strong.textContent,
                                    `${currentSection} · Sorotan`,
                                    'strong'
                                );
                            });


                        const sentences =
                            fullText
                                .split(
                                    /(?<=[.!?])\s+/
                                )
                                .map(
                                    item =>
                                        cleanText(item)
                                )
                                .filter(
                                    item =>
                                        item.length >= 45
                                        && item.length <= 210
                                );

                        sentences
                            .slice(0, 2)
                            .forEach(function (sentence) {
                                addCandidate(
                                    sentence,
                                    currentSection,
                                    'sentence'
                                );
                            });
                    });
                }


                const excerpt =
                    document.querySelector(
                        '.article-excerpt'
                    );

                if (excerpt) {
                    addCandidate(
                        excerpt.textContent,
                        'Ringkasan artikel',
                        'excerpt'
                    );
                }


                addCandidate(
                    DEFAULT_QUOTE,
                    'Pilihan Interlude',
                    'fallback'
                );


                /*
                | Prioritas:
                | 1. teks yang user blok,
                | 2. blockquote,
                | 3. strong/highlight,
                | 4. kalimat artikel biasa.
                */
                const priority = {
                    selection: 0,
                    blockquote: 1,
                    strong: 2,
                    excerpt: 3,
                    sentence: 4,
                    fallback: 5,
                    article: 6
                };

                result.sort(
                    (a, b) =>
                        (priority[a.source] ?? 9)
                        - (priority[b.source] ?? 9)
                );

                candidates =
                    result.slice(0, 6);

                if (candidates.length === 0) {
                    candidates = [{
                        id: 'quote-1',
                        text: DEFAULT_QUOTE,
                        label: 'Pilihan Interlude',
                        source: 'fallback'
                    }];
                }


                selectedIds =
                    highlighted
                        ? [candidates[0].id]
                        : candidates
                            .slice(
                                0,
                                Math.min(2, candidates.length)
                            )
                            .map(item => item.id);

                renderCandidateList();
                updatePreview();
            }


            function escapeHtml(value) {
                return String(value)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }


            function renderCandidateList() {
                candidateList.innerHTML =
                    candidates
                        .map(function (item) {
                            const checked =
                                selectedIds.includes(
                                    item.id
                                );

                            const disabled =
                                !checked
                                && selectedIds.length
                                    >= MAX_SELECTED;

                            return `
                                <label
                                    class="spotify-quote-choice
                                        ${checked ? 'is-selected' : ''}
                                        ${disabled ? 'is-disabled' : ''}"
                                    data-quote-choice="${item.id}"
                                >
                                    <input
                                        type="checkbox"
                                        value="${item.id}"
                                        ${checked ? 'checked' : ''}
                                        ${disabled ? 'disabled' : ''}
                                    >

                                    <span class="spotify-choice-copy">
                                        <strong>
                                            “${escapeHtml(item.text)}”
                                        </strong>

                                        <small>
                                            ${escapeHtml(item.label)}
                                        </small>
                                    </span>
                                </label>
                            `;
                        })
                        .join('');


                candidateList
                    .querySelectorAll(
                        'input[type="checkbox"]'
                    )
                    .forEach(function (input) {
                        input.addEventListener(
                            'change',
                            function () {
                                const id =
                                    input.value;

                                if (input.checked) {
                                    if (
                                        selectedIds.length
                                        >= MAX_SELECTED
                                    ) {
                                        input.checked =
                                            false;

                                        return;
                                    }

                                    selectedIds.push(id);
                                } else {
                                    selectedIds =
                                        selectedIds.filter(
                                            item =>
                                                item !== id
                                        );
                                }

                                renderCandidateList();
                                updatePreview();
                            }
                        );
                    });


                if (selectedCount) {
                    selectedCount.textContent =
                        `${selectedIds.length} Dipilih`;
                }
            }


            function selectedQuotes() {
                return selectedIds
                    .map(
                        id =>
                            candidates.find(
                                item =>
                                    item.id === id
                            )
                    )
                    .filter(Boolean);
            }


            function updateDensity() {
                const selected =
                    selectedQuotes();

                const totalLength =
                    selected.reduce(
                        (sum, item) =>
                            sum + item.text.length,
                        0
                    );

                const ratio =
                    card.dataset.ratio
                    || 'story';

                let density =
                    'normal';

                if (ratio === 'square') {
                    if (totalLength > 205) {
                        density = 'tight';
                    } else if (totalLength > 125) {
                        density = 'compact';
                    }
                } else if (ratio === 'feed') {
                    if (totalLength > 270) {
                        density = 'tight';
                    } else if (totalLength > 170) {
                        density = 'compact';
                    }
                } else {
                    if (totalLength > 340) {
                        density = 'tight';
                    } else if (totalLength > 220) {
                        density = 'compact';
                    }
                }

                card.dataset.density =
                    density;
            }


            function updatePreview() {
                const selected =
                    selectedQuotes();

                const primary =
                    selected[0];

                const secondary =
                    selected[1];

                primaryQuote.textContent =
                    primary?.text
                    || DEFAULT_QUOTE;

                if (secondary) {
                    secondaryQuote.textContent =
                        secondary.text;

                    secondaryWrap.hidden =
                        false;
                } else {
                    secondaryQuote.textContent =
                        '';

                    secondaryWrap.hidden =
                        true;
                }

                updateDensity();
            }


            function activeDimmer() {
                return Number(
                    document
                        .querySelector(
                            '[data-quote-dimmer].is-active'
                        )
                        ?.dataset.quoteDimmer
                    || 55
                );
            }


            function activeBlur() {
                return (
                    document
                        .querySelector(
                            '[data-quote-blur].is-active'
                        )
                        ?.dataset.quoteBlur
                    || 'soft'
                );
            }


            function blurPixels(value) {
                if (value === 'strong') {
                    return 10;
                }

                if (value === 'soft') {
                    return 3;
                }

                return 0;
            }


            function updateCoverStatus() {
                if (!coverStatus) {
                    return;
                }

                const blurLabel = {
                    off: 'Tanpa Blur',
                    soft: 'Blur Ringan',
                    strong: 'Blur Kuat'
                };

                coverStatus.textContent =
                    `Gelap ${activeDimmer()}% · ${blurLabel[activeBlur()]}`;
            }


            function applyCoverEffects() {
                if (
                    card.dataset.theme
                    !== 'cover'
                ) {
                    return;
                }

                const dimmer =
                    activeDimmer();

                const blur =
                    activeBlur();

                const top =
                    Math.min(
                        .82,
                        (dimmer / 100) * .82
                    );

                const middle =
                    Math.min(
                        .82,
                        top * .70
                    );

                const bottom =
                    Math.min(
                        .96,
                        (dimmer / 100) + .29
                    );

                overlay.style.background =
                    `linear-gradient(
                        180deg,
                        rgba(48,18,10,${top.toFixed(2)}) 0%,
                        rgba(48,18,10,${middle.toFixed(2)}) 45%,
                        rgba(48,18,10,${bottom.toFixed(2)}) 100%
                    )`;

                if (
                    cover
                    && cover.tagName === 'IMG'
                ) {
                    cover.style.filter =
                        `blur(${blurPixels(blur)}px)`;

                    cover.style.transform =
                        blur === 'strong'
                            ? 'scale(1.11)'
                            : blur === 'soft'
                                ? 'scale(1.08)'
                                : 'scale(1.06)';
                }

                updateCoverStatus();
            }


            function applySolidThemeOverlay(theme) {
                const overlays = {
                    warm:
                        'linear-gradient(180deg, rgba(116,49,24,.05), rgba(72,30,23,.58) 100%)',

                    espresso:
                        'linear-gradient(180deg, rgba(38,18,13,.04), rgba(16,8,7,.53) 100%)',

                    botanical:
                        'linear-gradient(180deg, rgba(22,51,35,.03), rgba(9,28,19,.55) 100%)',

                    sunset:
                        'linear-gradient(180deg, rgba(113,43,46,.04), rgba(62,23,43,.56) 100%)'
                };

                overlay.style.background =
                    overlays[theme]
                    || overlays.espresso;

                if (
                    cover
                    && cover.tagName === 'IMG'
                ) {
                    cover.style.filter =
                        'none';
                }
            }


            function setTheme(theme) {
                const button =
                    document.querySelector(
                        `[data-quote-theme="${theme}"]`
                    );

                if (
                    !button
                    || button.disabled
                ) {
                    return;
                }

                card.dataset.theme =
                    theme;

                document
                    .querySelectorAll(
                        '[data-quote-theme]'
                    )
                    .forEach(function (item) {
                        item.classList.toggle(
                            'is-active',
                            item === button
                        );
                    });


                if (themeStatus) {
                    themeStatus.textContent =
                        theme === 'cover'
                            ? 'Cover Mode Aktif'
                            : `${themeLabels[theme]} Aktif`;
                }


                const isCover =
                    theme === 'cover';

                if (coverTuning) {
                    coverTuning.hidden =
                        !isCover;
                }


                if (isCover) {
                    applyCoverEffects();
                } else {
                    applySolidThemeOverlay(theme);
                }
            }



            function gcd(a, b) {
                a = Math.abs(
                    Math.round(a)
                );

                b = Math.abs(
                    Math.round(b)
                );

                while (b) {
                    const temp = b;
                    b = a % b;
                    a = temp;
                }

                return a || 1;
            }


            function clampOutputDimension(value) {
                return Math.min(
                    3000,
                    Math.max(
                        600,
                        Number(value) || 1080
                    )
                );
            }


            function applyCustomSize() {
                if (
                    !customWidthInput
                    || !customHeightInput
                ) {
                    return;
                }

                const width =
                    clampOutputDimension(
                        customWidthInput.value
                    );

                const height =
                    clampOutputDimension(
                        customHeightInput.value
                    );

                customWidthInput.value =
                    width;

                customHeightInput.value =
                    height;

                card.style.setProperty(
                    '--custom-card-ratio',
                    `${width} / ${height}`
                );

                const divisor =
                    gcd(width, height);

                const ratioText =
                    `${width / divisor}:${height / divisor}`;

                if (customRatioValue) {
                    customRatioValue.textContent =
                        `${width} × ${height} · ${ratioText}`;
                }

                const customButton =
                    document.querySelector(
                        '[data-quote-ratio="custom"]'
                    );

                if (customButton) {
                    customButton.dataset.outputWidth =
                        width;

                    customButton.dataset.outputHeight =
                        height;

                    customButton.dataset.ratioLabel =
                        ratioText;
                }

                if (
                    card.dataset.ratio
                    === 'custom'
                ) {
                    ratioBadge.textContent =
                        ratioText;

                    updateDensity();
                }
            }


            function setRatio(ratio) {
                const button =
                    document.querySelector(
                        `[data-quote-ratio="${ratio}"]`
                    );

                if (!button) {
                    return;
                }

                card.dataset.ratio =
                    ratio;

                document
                    .querySelectorAll(
                        '[data-quote-ratio]'
                    )
                    .forEach(function (item) {
                        item.classList.toggle(
                            'is-active',
                            item === button
                        );
                    });

                if (customSizePanel) {
                    customSizePanel.hidden =
                        ratio !== 'custom';
                }

                if (ratio === 'custom') {
                    applyCustomSize();
                } else {
                    card.style.removeProperty(
                        '--custom-card-ratio'
                    );

                    ratioBadge.textContent =
                        button.dataset.ratioLabel;
                }

                updateDensity();
            }


            function setFontStyle(style) {
                card.dataset.fontStyle =
                    style;

                document
                    .querySelectorAll(
                        '[data-quote-font]'
                    )
                    .forEach(function (item) {
                        item.classList.toggle(
                            'is-active',
                            item.dataset.quoteFont
                                === style
                        );
                    });
            }


            function initQrCode() {
                if (
                    qrInitialized
                    || !qrCode
                    || typeof QRCode === 'undefined'
                ) {
                    return;
                }

                qrCode.innerHTML = '';

                new QRCode(
                    qrCode,
                    {
                        text:
                            window.location.href,
                        width: 80,
                        height: 80,
                        colorDark:
                            '#30120A',
                        colorLight:
                            '#FFFFFF',
                        correctLevel:
                            QRCode.CorrectLevel.M
                    }
                );

                qrInitialized = true;
            }


            function openModal() {
                buildCandidates();
                initQrCode();

                modal.hidden = false;

                modal.setAttribute(
                    'aria-hidden',
                    'false'
                );

                document.body.style.overflow =
                    'hidden';
            }


            function closeModal() {
                modal.hidden = true;

                modal.setAttribute(
                    'aria-hidden',
                    'true'
                );

                document.body.style.overflow =
                    '';
            }


            function activeRatioButton() {
                return document.querySelector(
                    '[data-quote-ratio].is-active'
                );
            }


            async function renderQuoteCanvas() {
                if (
                    typeof html2canvas
                    === 'undefined'
                ) {
                    throw new Error(
                        'html2canvas belum termuat.'
                    );
                }

                if (document.fonts?.ready) {
                    await document.fonts.ready;
                }

                await new Promise(resolve =>
                    requestAnimationFrame(() =>
                        requestAnimationFrame(resolve)
                    )
                );

                const ratioButton =
                    activeRatioButton();

                const outputWidth =
                    Number(
                        ratioButton
                            ?.dataset
                            .outputWidth
                        || 1080
                    );

                const outputHeight =
                    Number(
                        ratioButton
                            ?.dataset
                            .outputHeight
                        || 1920
                    );

                const rect =
                    card.getBoundingClientRect();

                const sourceCanvas =
                    await html2canvas(
                        card,
                        {
                            scale:
                                outputWidth
                                / rect.width,
                            useCORS: true,
                            allowTaint: false,
                            backgroundColor: null,
                            logging: false
                        }
                    );


                if (
                    sourceCanvas.width
                        === outputWidth
                    && sourceCanvas.height
                        === outputHeight
                ) {
                    return sourceCanvas;
                }


                const finalCanvas =
                    document.createElement(
                        'canvas'
                    );

                finalCanvas.width =
                    outputWidth;

                finalCanvas.height =
                    outputHeight;

                const context =
                    finalCanvas.getContext(
                        '2d'
                    );

                context.drawImage(
                    sourceCanvas,
                    0,
                    0,
                    outputWidth,
                    outputHeight
                );

                return finalCanvas;
            }


            function canvasToBlob(canvas) {
                return new Promise(
                    (resolve, reject) => {
                        canvas.toBlob(
                            function (blob) {
                                if (blob) {
                                    resolve(blob);
                                } else {
                                    reject(
                                        new Error(
                                            'Gagal membuat PNG.'
                                        )
                                    );
                                }
                            },
                            'image/png',
                            1
                        );
                    }
                );
            }


            function fileName() {
                const ratio =
                    card.dataset.ratio
                    || 'story';

                return `interlude-kutipan-${ratio}.png`;
            }


            function quoteShareText() {
                const selected =
                    selectedQuotes();

                return selected
                    .map(
                        item =>
                            `“${item.text}”`
                    )
                    .join('\n\n');
            }


            async function withBusy(
                button,
                label,
                action
            ) {
                if (!button) {
                    return;
                }

                const original =
                    button.innerHTML;

                button.disabled =
                    true;

                button.innerHTML =
                    `<i class="fas fa-spinner fa-spin"></i> ${label}`;

                try {
                    await action();
                } finally {
                    button.disabled =
                        false;

                    button.innerHTML =
                        original;
                }
            }


            async function downloadCard() {
                const canvas =
                    await renderQuoteCanvas();

                const link =
                    document.createElement(
                        'a'
                    );

                link.download =
                    fileName();

                link.href =
                    canvas.toDataURL(
                        'image/png'
                    );

                link.click();
            }


            async function copyCardImage() {
                const canvas =
                    await renderQuoteCanvas();

                const blob =
                    await canvasToBlob(
                        canvas
                    );

                if (
                    navigator.clipboard
                    && window.ClipboardItem
                ) {
                    await navigator.clipboard.write([
                        new ClipboardItem({
                            'image/png':
                                blob
                        })
                    ]);

                    return;
                }

                throw new Error(
                    'Browser belum mendukung salin gambar.'
                );
            }


            async function shareImageNative() {
                const canvas =
                    await renderQuoteCanvas();

                const blob =
                    await canvasToBlob(
                        canvas
                    );

                const file =
                    new File(
                        [blob],
                        fileName(),
                        {
                            type:
                                'image/png'
                        }
                    );


                if (
                    navigator.share
                    && navigator.canShare
                    && navigator.canShare({
                        files: [file]
                    })
                ) {
                    await navigator.share({
                        title:
                            'Kutipan Interlude',
                        text:
                            quoteShareText(),
                        files: [file]
                    });

                    return true;
                }

                return false;
            }


            openButton.addEventListener(
                'click',
                openModal
            );

            closeButton?.addEventListener(
                'click',
                closeModal
            );

            backdrop?.addEventListener(
                'click',
                closeModal
            );


            document
                .querySelectorAll(
                    '[data-quote-ratio]'
                )
                .forEach(function (button) {
                    button.addEventListener(
                        'click',
                        function () {
                            setRatio(
                                button.dataset
                                    .quoteRatio
                            );
                        }
                    );
                });


            document
                .querySelectorAll(
                    '[data-quote-theme]'
                )
                .forEach(function (button) {
                    button.addEventListener(
                        'click',
                        function () {
                            setTheme(
                                button.dataset
                                    .quoteTheme
                            );
                        }
                    );
                });


            document
                .querySelectorAll(
                    '[data-quote-dimmer]'
                )
                .forEach(function (button) {
                    button.addEventListener(
                        'click',
                        function () {
                            document
                                .querySelectorAll(
                                    '[data-quote-dimmer]'
                                )
                                .forEach(
                                    item =>
                                        item.classList
                                            .remove(
                                                'is-active'
                                            )
                                );

                            button.classList.add(
                                'is-active'
                            );

                            applyCoverEffects();
                        }
                    );
                });


            document
                .querySelectorAll(
                    '[data-quote-blur]'
                )
                .forEach(function (button) {
                    button.addEventListener(
                        'click',
                        function () {
                            document
                                .querySelectorAll(
                                    '[data-quote-blur]'
                                )
                                .forEach(
                                    item =>
                                        item.classList
                                            .remove(
                                                'is-active'
                                            )
                                );

                            button.classList.add(
                                'is-active'
                            );

                            applyCoverEffects();
                        }
                    );
                });


            document
                .querySelectorAll(
                    '[data-quote-font]'
                )
                .forEach(function (button) {
                    button.addEventListener(
                        'click',
                        function () {
                            setFontStyle(
                                button.dataset
                                    .quoteFont
                            );
                        }
                    );
                });


            showAuthor?.addEventListener(
                'change',
                function () {
                    authorBlock.style.display =
                        showAuthor.checked
                            ? ''
                            : 'none';
                }
            );


            showQr?.addEventListener(
                'change',
                function () {
                    qrShell.style.display =
                        showQr.checked
                            ? ''
                            : 'none';
                }
            );



            customWidthInput?.addEventListener(
                'input',
                applyCustomSize
            );

            customHeightInput?.addEventListener(
                'input',
                applyCustomSize
            );


            swapSizeButton?.addEventListener(
                'click',
                function () {
                    if (
                        !customWidthInput
                        || !customHeightInput
                    ) {
                        return;
                    }

                    const width =
                        customWidthInput.value;

                    customWidthInput.value =
                        customHeightInput.value;

                    customHeightInput.value =
                        width;

                    applyCustomSize();
                }
            );


            document
                .querySelectorAll(
                    '[data-custom-size]'
                )
                .forEach(function (button) {
                    button.addEventListener(
                        'click',
                        function () {
                            const [
                                width,
                                height
                            ] =
                                button.dataset
                                    .customSize
                                    .split('x')
                                    .map(Number);

                            if (
                                customWidthInput
                                && customHeightInput
                            ) {
                                customWidthInput.value =
                                    width;

                                customHeightInput.value =
                                    height;

                                applyCustomSize();
                            }
                        }
                    );
                });


            downloadButton?.addEventListener(
                'click',
                function () {
                    withBusy(
                        downloadButton,
                        'Membuat PNG...',
                        downloadCard
                    ).catch(function (error) {
                        console.error(
                            'Download quote error:',
                            error
                        );

                        alert(
                            'Kartu belum berhasil diunduh.'
                        );
                    });
                }
            );


            copyImageButton?.addEventListener(
                'click',
                function () {
                    withBusy(
                        copyImageButton,
                        'Menyalin...',
                        async function () {
                            await copyCardImage();

                            const oldText =
                                copyImageButton
                                    .textContent;

                            setTimeout(
                                function () {
                                    copyImageButton
                                        .textContent =
                                        oldText;
                                },
                                1200
                            );
                        }
                    ).catch(function (error) {
                        console.error(
                            'Copy image error:',
                            error
                        );

                        alert(
                            'Browser ini belum mendukung salin gambar. Gunakan Unduh Gambar.'
                        );
                    });
                }
            );


            instagramButton?.addEventListener(
                'click',
                function () {
                    withBusy(
                        instagramButton,
                        'Menyiapkan...',
                        async function () {
                            const shared =
                                await shareImageNative();

                            if (!shared) {
                                await downloadCard();

                                alert(
                                    'Browser desktop belum mendukung berbagi gambar langsung. PNG sudah diunduh; unggah ke Instagram Story secara manual.'
                                );
                            }
                        }
                    ).catch(function (error) {
                        if (
                            error.name
                            !== 'AbortError'
                        ) {
                            console.error(
                                'Instagram share error:',
                                error
                            );
                        }
                    });
                }
            );


            twitterButton?.addEventListener(
                'click',
                function () {
                    const text =
                        encodeURIComponent(
                            quoteShareText()
                                .slice(0, 220)
                        );

                    const url =
                        encodeURIComponent(
                            window.location.href
                        );

                    window.open(
                        `https://twitter.com/intent/tweet?text=${text}&url=${url}`,
                        '_blank',
                        'noopener,noreferrer'
                    );
                }
            );


            copyLinkButton?.addEventListener(
                'click',
                async function () {
                    try {
                        await navigator.clipboard
                            .writeText(
                                window.location.href
                            );

                        const original =
                            copyLinkButton.innerHTML;

                        copyLinkButton.innerHTML =
                            '<i class="fas fa-check"></i> Tersalin';

                        setTimeout(
                            function () {
                                copyLinkButton.innerHTML =
                                    original;
                            },
                            1300
                        );
                    } catch (error) {
                        console.error(
                            'Copy link error:',
                            error
                        );
                    }
                }
            );


            document.addEventListener(
                'keydown',
                function (event) {
                    if (
                        event.key === 'Escape'
                        && !modal.hidden
                    ) {
                        closeModal();
                    }
                }
            );


            applyCustomSize();
            setRatio('story');

            setTheme(
                @js($quoteCoverUrl ? 'cover' : 'espresso')
            );

            setFontStyle('modern');
        });

</script>







</x-app-layout>