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
