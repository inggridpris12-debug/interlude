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
        .avatar-photo {
            background-image: var(--avatar-photo) !important;
            background-position: center;
            background-size: cover;
            color: transparent;
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
