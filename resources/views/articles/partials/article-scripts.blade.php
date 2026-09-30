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
