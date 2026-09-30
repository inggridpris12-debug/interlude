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
