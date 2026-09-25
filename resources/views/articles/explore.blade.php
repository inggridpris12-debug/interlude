<x-app-layout>
    @php
        $categoryGradients = [
            'Penelitian' => 'linear-gradient(135deg, #CAE7F7, #8FC6DE)',
            'Tugas Kuliah' => 'linear-gradient(135deg, #FFEDE3, #FFB89D)',
            'Magang' => 'linear-gradient(135deg, #D8F1E4, #93D1AE)',
            'Organisasi' => 'linear-gradient(135deg, #FFF0C7, #F2C96D)',
            'Tips Belajar' => 'linear-gradient(135deg, #EAE4FA, #BFB0E8)',
            'Kehidupan Kampus' => 'linear-gradient(135deg, #F9DCE8, #E8A9C2)',
        ];

        /*
        |--------------------------------------------------------------------------
        | CATATAN PENTING
        |--------------------------------------------------------------------------
        | Blade ini HANYA menampilkan data yang sudah dipilih controller.
        | Jangan melakukan algoritma rekomendasi/saved/history/download/follow
        | di Blade.
        |
        | Controller nantinya harus mengirim:
        | $articles         -> paginator sesuai section aktif
        | $search           -> string
        | $selectedCategory -> nullable string
        | $categories       -> array / collection kategori
        |
        | section:
        | untukmu, terbaru, tersimpan, riwayat, unduhan, langganan
        */

        $activeSection = request('section', 'untukmu');

        $sections = [
            'untukmu' => [
                'label' => 'Untukmu',
                'title' => 'Pilihan untukmu',
                'description' => 'Disusun dari topik dan cerita yang paling sering kamu baca.',
                'emptyTitle' => 'Belum ada rekomendasi untukmu.',
                'emptyText' => 'Mulai baca beberapa cerita dulu. Semakin sering kamu membaca, rekomendasinya akan semakin relevan.',
            ],
            'terbaru' => [
                'label' => 'Terbaru',
                'title' => 'Baru dipublikasikan',
                'description' => 'Artikel terbaru dari seluruh komunitas Interlude.',
                'emptyTitle' => 'Belum ada artikel terbaru.',
                'emptyText' => 'Artikel yang baru dipublikasikan akan muncul di sini.',
            ],
            'tersimpan' => [
                'label' => 'Tersimpan',
                'title' => 'Cerita tersimpan',
                'description' => 'Artikel yang kamu simpan dari akunmu.',
                'emptyTitle' => 'Belum ada cerita tersimpan.',
                'emptyText' => 'Saat kamu menyimpan sebuah artikel, artikel itu akan muncul di sini.',
            ],
            'riwayat' => [
                'label' => 'Riwayat',
                'title' => 'Riwayat bacaan',
                'description' => 'Artikel yang sebelumnya pernah kamu buka.',
                'emptyTitle' => 'Riwayat bacaanmu masih kosong.',
                'emptyText' => 'Artikel yang kamu baca akan tercatat dan muncul di sini.',
            ],
            'unduhan' => [
                'label' => 'Unduhan',
                'title' => 'Unduhanmu',
                'description' => 'Konten yang sudah kamu unduh dari akun ini.',
                'emptyTitle' => 'Belum ada unduhan.',
                'emptyText' => 'Konten yang kamu unduh akan tersimpan di bagian ini.',
            ],
            'langganan' => [
                'label' => 'Langganan',
                'title' => 'Dari akun yang kamu ikuti',
                'description' => 'Artikel terbaru dari penulis yang kamu follow.',
                'emptyTitle' => 'Belum ada artikel dari akun yang kamu ikuti.',
                'emptyText' => 'Ikuti penulis yang kamu suka agar tulisan terbaru mereka muncul di sini.',
            ],
        ];

        $currentSection = $sections[$activeSection] ?? $sections['untukmu'];
    @endphp

    <main class="explore-page">

        <!-- =====================================================
             HEADER: NO HERO
        ====================================================== -->
        <section class="explore-header">

            <div class="explore-heading">
                <span class="explore-kicker">
                    <i class="far fa-compass"></i>
                    Ruang jelajah
                </span>

                <h1>Jelajahi</h1>

                <p>
                    Temukan pengalaman, catatan, dan cerita mahasiswa
                    yang relevan dengan perjalananmu.
                </p>
            </div>

            <!-- PRIMARY EXPLORE TABS -->
            <nav class="explore-tabs" aria-label="Menu Jelajahi">
                @foreach($sections as $key => $section)
                    <a
                        href="{{ route('explore', array_filter([
                            'section' => $key,
                            'q' => $search,
                            'category' => $selectedCategory,
                        ])) }}"
                        class="explore-tab {{ $activeSection === $key ? 'is-active' : '' }}"
                    >
                        {{ $section['label'] }}
                    </a>
                @endforeach
            </nav>

        </section>


        <!-- =====================================================
             SEARCH + TOPIC FILTER
        ====================================================== -->
        <section class="explore-tools">

            <form
                method="GET"
                action="{{ route('explore') }}"
                class="explore-search-form"
            >
                <input type="hidden" name="section" value="{{ $activeSection }}">

                @if($selectedCategory)
                    <input type="hidden" name="category" value="{{ $selectedCategory }}">
                @endif

                <div class="explore-search-box">
                    <i class="fas fa-search"></i>

                    <input
                        id="explore-search"
                        type="search"
                        name="q"
                        value="{{ $search }}"
                        placeholder="Cari artikel, topik, atau penulis..."
                    >

                    @if($search !== '')
                        <a
                            href="{{ route('explore', array_filter([
                                'section' => $activeSection,
                                'category' => $selectedCategory,
                            ])) }}"
                            class="clear-search"
                            aria-label="Hapus pencarian"
                        >
                            <i class="fas fa-times"></i>
                        </a>
                    @endif

                    <button type="submit">
                        Cari
                    </button>
                </div>
            </form>


            <!-- CATEGORY FILTER -->
            <div class="topic-area">
                <span class="topic-label">Topik</span>

                <div class="topic-scroll">
                    <a
                        href="{{ route('explore', array_filter([
                            'section' => $activeSection,
                            'q' => $search,
                        ])) }}"
                        class="topic-chip {{ !$selectedCategory ? 'is-active' : '' }}"
                    >
                        Semua
                    </a>

                    @foreach($categories as $category)
                        <a
                            href="{{ route('explore', array_filter([
                                'section' => $activeSection,
                                'q' => $search,
                                'category' => $category,
                            ])) }}"
                            class="topic-chip {{ $selectedCategory === $category ? 'is-active' : '' }}"
                        >
                            {{ $category }}
                        </a>
                    @endforeach
                </div>
            </div>

        </section>


        <!-- =====================================================
             SECTION HEADING
        ====================================================== -->
        <section class="feed-section">

            <div class="feed-section-head">
                <div>
                    <span class="section-kicker">
                        {{ $currentSection['label'] }}
                    </span>

                    <h2>{{ $currentSection['title'] }}</h2>

                    <p>{{ $currentSection['description'] }}</p>
                </div>

                @if($search !== '' || $selectedCategory)
                    <a
                        class="reset-filter"
                        href="{{ route('explore', ['section' => $activeSection]) }}"
                    >
                        Reset filter
                    </a>
                @endif
            </div>


            <!-- =================================================
                 ARTICLES
            ================================================== -->
            @if($articles->isNotEmpty())

                <div class="article-feed">

                    @foreach($articles as $article)

                        <a
                            href="{{ route('articles.show', $article->slug) }}"
                            class="article-row"
                        >

                            <!-- TEXT -->
                            <div class="article-copy">

                                <div class="article-author">
                                    <span class="author-avatar">
                                        {{ strtoupper(substr($article->user->name, 0, 1)) }}
                                    </span>

                                    <div class="author-lines">
                                        <span class="author-name">
                                            {{ $article->user->name }}
                                        </span>

                                        <span class="article-date">
                                            {{ optional($article->created_at)->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>


                                <span class="article-category">
                                    {{ $article->category }}
                                </span>


                                <h3>{{ $article->title }}</h3>


                                <p class="article-excerpt">
                                    {{ Str::limit(
                                        $article->excerpt ?: strip_tags($article->content),
                                        175
                                    ) }}
                                </p>


                                <div class="article-meta">

                                    <span>
                                        <i class="far fa-clock"></i>
                                        {{ $article->reading_time }} menit baca
                                    </span>

                                    <span>
                                        <i class="far fa-heart"></i>
                                        {{ $article->likes_count }}
                                    </span>

                                    <span>
                                        <i class="far fa-comment"></i>
                                        {{ $article->comments_count }}
                                    </span>

                                    @if(isset($article->views_count))
                                        <span>
                                            <i class="far fa-eye"></i>
                                            {{ $article->views_count }}
                                        </span>
                                    @endif

                                </div>

                            </div>


                            <!-- THUMBNAIL -->
                            <div class="article-visual">

                                @if($article->cover_image)

                                    <img
                                        src="{{ asset('storage/' . $article->cover_image) }}"
                                        alt="{{ $article->title }}"
                                    >

                                @else

                                    <div
                                        class="article-placeholder"
                                        style="background: {{ $categoryGradients[$article->category] ?? 'linear-gradient(135deg, #FFEDE3, #CAE7F7)' }};"
                                    >
                                        <i class="far fa-file-lines"></i>
                                    </div>

                                @endif

                                <span class="bookmark-visual">
                                    <i class="far fa-bookmark"></i>
                                </span>

                            </div>

                        </a>

                    @endforeach

                </div>


                @if($articles->hasPages())
                    <div class="explore-pagination">
                        {{ $articles->appends(request()->query())->links() }}
                    </div>
                @endif


            @else

                <!-- EMPTY STATE: BENAR-BENAR KOSONG JIKA AKUN TIDAK PUNYA DATA -->
                <div class="empty-state">

                    <div class="empty-icon">
                        @switch($activeSection)
                            @case('tersimpan')
                                <i class="far fa-bookmark"></i>
                                @break

                            @case('riwayat')
                                <i class="fas fa-clock-rotate-left"></i>
                                @break

                            @case('unduhan')
                                <i class="fas fa-arrow-down"></i>
                                @break

                            @case('langganan')
                                <i class="far fa-user"></i>
                                @break

                            @default
                                <i class="far fa-compass"></i>
                        @endswitch
                    </div>

                    <h3>{{ $currentSection['emptyTitle'] }}</h3>

                    <p>{{ $currentSection['emptyText'] }}</p>

                    @if($activeSection !== 'terbaru')
                        <a href="{{ route('explore', ['section' => 'terbaru']) }}">
                            Lihat artikel terbaru
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    @endif

                </div>

            @endif

        </section>

    </main>


    <style>
        /*
        |--------------------------------------------------------------------------
        | EXPLORE
        |--------------------------------------------------------------------------
        | Ukuran dibuat lebih besar dan ritmenya disamakan dengan dashboard:
        | large Plus Jakarta Sans heading + DM Sans body.
        */

        .explore-page {
            min-height: 100vh;
            padding: 52px 5% 110px;
            background: var(--cream);
            color: var(--brown);
        }

        .explore-header,
        .explore-tools,
        .feed-section {
            width: min(1180px, 100%);
            margin-inline: auto;
        }


        /* =====================================================
           HEADER
        ====================================================== */

        .explore-header {
            padding-bottom: 28px;
            border-bottom: 1px solid var(--border);
        }

        .explore-kicker,
        .section-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--tangelo);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.35px;
            text-transform: uppercase;
        }

        .explore-heading h1 {
            margin: 9px 0 0;
            color: var(--brown);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(44px, 5.4vw, 64px);
            font-weight: 800;
            line-height: 1.03;
            letter-spacing: -2.2px;
        }

        .explore-heading p {
            max-width: 690px;
            margin: 13px 0 0;
            color: var(--text-soft);
            font-size: 17px;
            line-height: 1.65;
        }


        /* =====================================================
           TABS
        ====================================================== */

        .explore-tabs {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 32px;
            overflow-x: auto;
            padding-bottom: 2px;
            scrollbar-width: none;
        }

        .explore-tabs::-webkit-scrollbar {
            display: none;
        }

        .explore-tab {
            flex: 0 0 auto;
            min-height: 44px;
            padding: 12px 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            color: var(--text-soft);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 700;
            line-height: 1;
            text-decoration: none;
            transition: .2s;
        }

        .explore-tab:hover {
            color: var(--brown);
            background: var(--linen);
        }

        .explore-tab.is-active {
            color: var(--brown);
            background: var(--linen);
            box-shadow: inset 0 0 0 1px rgba(73, 38, 29, .035);
        }


        /* =====================================================
           TOOLS
        ====================================================== */

        .explore-tools {
            display: grid;
            gap: 20px;
            padding: 30px 0 38px;
        }

        .explore-search-form {
            width: min(800px, 100%);
        }

        .explore-search-box {
            min-height: 58px;
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 6px 7px 6px 20px;
            border: 1px solid var(--border);
            border-radius: 999px;
            background: var(--white);
            box-shadow: 0 8px 22px rgba(73, 38, 29, .045);
        }

        .explore-search-box > i {
            color: var(--tangelo);
            font-size: 16px;
        }

        .explore-search-box input {
            min-width: 0;
            flex: 1;
            border: 0;
            outline: none;
            background: transparent;
            color: var(--brown);
            font: 500 15px 'DM Sans', sans-serif;
        }

        .explore-search-box input::placeholder {
            color: #A08D85;
        }

        .clear-search {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            color: var(--text-soft);
            text-decoration: none;
        }

        .explore-search-box button {
            height: 46px;
            padding: 0 23px;
            border: 0;
            border-radius: 999px;
            background: var(--brown);
            color: var(--white);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            transition: .2s;
        }

        .explore-search-box button:hover {
            background: var(--tangelo);
        }

        .topic-area {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .topic-label {
            flex: 0 0 auto;
            color: var(--brown);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 800;
        }

        .topic-scroll {
            min-width: 0;
            display: flex;
            gap: 9px;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .topic-scroll::-webkit-scrollbar {
            display: none;
        }

        .topic-chip {
            flex: 0 0 auto;
            padding: 9px 15px;
            border: 1px solid var(--border);
            border-radius: 999px;
            background: var(--white);
            color: var(--text-soft);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: .2s;
        }

        .topic-chip:hover,
        .topic-chip.is-active {
            border-color: var(--brown);
            background: var(--brown);
            color: var(--white);
        }


        /* =====================================================
           FEED HEADING
        ====================================================== */

        .feed-section-head {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 30px;
            margin-bottom: 18px;
        }

        .feed-section-head h2 {
            margin: 7px 0 0;
            color: var(--brown);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(27px, 3vw, 34px);
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -1px;
        }

        .feed-section-head p {
            margin: 8px 0 0;
            color: var(--text-soft);
            font-size: 15px;
            line-height: 1.55;
        }

        .reset-filter {
            flex: 0 0 auto;
            color: var(--tangelo);
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
        }

        .reset-filter:hover {
            text-decoration: underline;
        }


        /* =====================================================
           ARTICLE FEED
        ====================================================== */

        .article-feed {
            display: grid;
            border-top: 1px solid var(--border);
        }

        .article-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 215px;
            gap: 34px;
            min-height: 220px;
            padding: 28px 0;
            border-bottom: 1px solid var(--border);
            color: inherit;
            text-decoration: none;
            transition: .2s;
        }

        .article-row:hover h3 {
            color: var(--tangelo);
        }

        .article-copy {
            min-width: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .article-author {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
        }

        .author-avatar {
            width: 36px;
            height: 36px;
            flex: 0 0 auto;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: var(--blue);
            color: var(--brown);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px;
            font-weight: 800;
        }

        .author-lines {
            display: grid;
            gap: 1px;
        }

        .author-name {
            color: var(--brown);
            font-size: 13px;
            font-weight: 700;
        }

        .article-date {
            color: #9B8981;
            font-size: 11px;
        }

        .article-category {
            margin-bottom: 8px;
            color: var(--tangelo);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .article-row h3 {
            max-width: 760px;
            margin: 0;
            color: var(--brown);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 25px;
            font-weight: 800;
            line-height: 1.25;
            letter-spacing: -.75px;
            transition: .2s;
        }

        .article-excerpt {
            max-width: 780px;
            margin: 10px 0 0;
            color: var(--text-soft);
            font-size: 15px;
            line-height: 1.6;
        }

        .article-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: auto;
            padding-top: 18px;
            color: #88766F;
            font-size: 12px;
        }

        .article-meta span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .article-visual {
            position: relative;
            width: 215px;
            height: 160px;
            align-self: center;
        }

        .article-visual img,
        .article-placeholder {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
        }

        .article-placeholder {
            display: grid;
            place-items: center;
            color: rgba(73, 38, 29, .36);
            font-size: 34px;
        }

        .bookmark-visual {
            position: absolute;
            right: 10px;
            bottom: 10px;
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 11px;
            background: rgba(255, 255, 255, .92);
            color: var(--brown);
            box-shadow: 0 3px 12px rgba(73, 38, 29, .09);
        }


        /* =====================================================
           EMPTY
        ====================================================== */

        .empty-state {
            display: grid;
            justify-items: center;
            padding: 82px 30px;
            border-top: 1px solid var(--border);
            text-align: center;
        }

        .empty-icon {
            width: 64px;
            height: 64px;
            display: grid;
            place-items: center;
            border-radius: 20px;
            background: var(--linen);
            color: var(--brown);
            font-size: 23px;
        }

        .empty-state h3 {
            margin: 20px 0 7px;
            color: var(--brown);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .empty-state p {
            max-width: 520px;
            margin: 0;
            color: var(--text-soft);
            font-size: 14px;
            line-height: 1.6;
        }

        .empty-state a {
            margin-top: 20px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--tangelo);
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
        }

        .explore-pagination {
            margin-top: 34px;
        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 840px) {
            .explore-page {
                padding: 38px 5% 90px;
            }

            .explore-heading h1 {
                font-size: 48px;
            }

            .article-row {
                grid-template-columns: minmax(0, 1fr) 150px;
                gap: 20px;
            }

            .article-visual {
                width: 150px;
                height: 125px;
            }

            .article-row h3 {
                font-size: 21px;
            }

            .article-excerpt {
                font-size: 14px;
            }
        }

        @media (max-width: 620px) {
            .explore-page {
                padding: 30px 16px 78px;
            }

            .explore-heading h1 {
                font-size: 40px;
                letter-spacing: -1.4px;
            }

            .explore-heading p {
                font-size: 15px;
            }

            .explore-tabs {
                margin-top: 25px;
                gap: 6px;
            }

            .explore-tab {
                min-height: 40px;
                padding: 10px 14px;
                font-size: 13px;
            }

            .topic-area {
                align-items: flex-start;
                flex-direction: column;
                gap: 9px;
            }

            .feed-section-head {
                align-items: flex-start;
                flex-direction: column;
                gap: 10px;
            }

            .feed-section-head h2 {
                font-size: 25px;
            }

            .article-row {
                grid-template-columns: minmax(0, 1fr) 100px;
                gap: 14px;
                min-height: 0;
                padding: 22px 0;
            }

            .article-visual {
                width: 100px;
                height: 96px;
            }

            .article-visual img,
            .article-placeholder {
                border-radius: 14px;
            }

            .bookmark-visual {
                width: 30px;
                height: 30px;
                right: 6px;
                bottom: 6px;
                border-radius: 9px;
                font-size: 12px;
            }

            .article-row h3 {
                font-size: 18px;
                line-height: 1.28;
            }

            .article-excerpt {
                display: none;
            }

            .article-meta {
                gap: 10px;
                padding-top: 12px;
            }

            .article-meta span:nth-child(n+2) {
                display: none;
            }

            .author-avatar {
                width: 30px;
                height: 30px;
            }

            .article-date {
                display: none;
            }

            .explore-search-box {
                min-height: 52px;
                padding-left: 15px;
            }

            .explore-search-box button {
                height: 40px;
                padding-inline: 16px;
            }
        }
    </style>
</x-app-layout>
