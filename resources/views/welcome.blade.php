<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interlude — Jeda untuk berbagi cerita</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#49261D',
                        'primary-container': '#30120A',
                        secondary: '#FB4D00',
                        'secondary-container': '#D44000',
                        'secondary-fixed': '#FFDBD0',
                        'on-secondary-fixed': '#3A0B00',
                        'tertiary-fixed': '#CAE7F7',
                        'tertiary-fixed-dim': '#AECBDA',
                        'on-tertiary-fixed': '#001F2A',
                        surface: '#FFFAF6',
                        'surface-container-lowest': '#FFFFFF',
                        'surface-container-low': '#FFEDE3',
                        'surface-container': '#F5E9E0',
                        'surface-container-high': '#ECE0D6',
                        'on-surface': '#1C1B19',
                        'on-surface-variant': '#514441',
                        outline: '#837470',
                        'outline-variant': '#D5C2BE'
                    },
                    borderRadius: {
                        DEFAULT: '1rem',
                        lg: '1.75rem',
                        xl: '2.5rem',
                        '2xl': '3rem',
                        full: '9999px'
                    },
                    fontFamily: {
                        headline: ['Plus Jakarta Sans', 'sans-serif'],
                        body: ['DM Sans', 'sans-serif']
                    }
                }
            }
        };
    </script>

    <style>
        html { scroll-behavior: smooth; }
        body { margin: 0; overscroll-behavior: none; }
        ::-webkit-scrollbar { display: none; }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 450, 'GRAD' 0, 'opsz' 24;
        }

        @keyframes pulseSlow {
            0%, 100% { transform: scale(1); opacity: .9; }
            50% { transform: scale(1.04); opacity: .72; }
        }

        .animate-pulse-slow {
            animation: pulseSlow 6s ease-in-out infinite;
        }

        @keyframes floatGentle {
            0%, 100% { transform: translateY(0) rotate(var(--rot, 0deg)); }
            50% { transform: translateY(-6px) rotate(var(--rot, 0deg)); }
        }

        .animate-float {
            animation: floatGentle 5s ease-in-out infinite;
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                scroll-behavior: auto !important;
                animation-duration: .001ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .001ms !important;
            }
        }
    </style>
</head>

<body class="bg-surface font-body text-on-surface antialiased selection:bg-secondary selection:text-white">

<!-- =========================================================
     NAVBAR
========================================================= -->
<header class="fixed inset-x-0 top-0 z-50 border-b border-outline-variant/30 bg-surface/95 backdrop-blur-md">
    <div class="mx-auto flex h-20 w-full max-w-[1320px] items-center justify-between gap-4 px-5 md:px-8 lg:px-12">

        <a href="#beranda" class="shrink-0 font-headline text-2xl font-extrabold tracking-[-1px] text-primary">
            Interlude<span class="text-secondary">.</span>
        </a>

        <nav class="hidden items-center gap-1 rounded-full border border-outline-variant/40 bg-surface-container-low px-2 py-1.5 lg:flex">
            <a href="#beranda" class="rounded-full bg-primary px-5 py-2 font-headline text-sm font-bold text-white">Beranda</a>
            <a href="#eksplorasi" class="rounded-full px-5 py-2 font-headline text-sm font-semibold text-on-surface-variant transition hover:bg-surface-container hover:text-primary">Jelajahi</a>
            <a href="#cerita-nyata" class="rounded-full px-5 py-2 font-headline text-sm font-semibold text-on-surface-variant transition hover:bg-surface-container hover:text-primary">Cerita</a>
            <a href="#audio-stream" class="rounded-full px-5 py-2 font-headline text-sm font-semibold text-on-surface-variant transition hover:bg-surface-container hover:text-primary">Podcast</a>
            <a href="#cara-kerja" class="rounded-full px-5 py-2 font-headline text-sm font-semibold text-on-surface-variant transition hover:bg-surface-container hover:text-primary">Cara Kerja</a>
        </nav>

        <div class="flex shrink-0 items-center gap-2">
            <button type="button" aria-label="Pencarian" class="hidden h-10 w-10 items-center justify-center rounded-full text-on-surface-variant transition hover:bg-surface-container hover:text-primary sm:flex">
                <span class="material-symbols-outlined text-[20px]">search</span>
            </button>

            <a href="{{ url('/login') }}" class="hidden rounded-full px-4 py-2 font-headline text-sm font-bold text-primary transition hover:bg-surface-container sm:inline-flex">Masuk</a>

            <a href="{{ url('/register') }}" class="hidden items-center justify-center gap-1 rounded-full bg-primary px-5 py-2.5 font-headline text-sm font-extrabold text-white transition hover:-translate-y-0.5 hover:bg-primary-container sm:inline-flex">
                Mulai Cerita
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>

            <button id="mobileMenuButton" type="button" aria-label="Buka menu" aria-expanded="false" class="flex h-10 w-10 items-center justify-center rounded-full border border-outline-variant/50 bg-white text-primary lg:hidden">
                <span id="mobileMenuIcon" class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </div>

    <div id="mobileMenu" class="hidden border-t border-outline-variant/30 bg-surface lg:hidden">
        <nav class="mx-auto flex max-w-[1320px] flex-col px-5 py-5 md:px-8">
            <a href="#beranda" class="mobile-link border-b border-outline-variant/25 py-3 font-headline text-sm font-bold text-primary">Beranda</a>
            <a href="#eksplorasi" class="mobile-link border-b border-outline-variant/25 py-3 font-headline text-sm font-bold text-primary">Jelajahi</a>
            <a href="#cerita-nyata" class="mobile-link border-b border-outline-variant/25 py-3 font-headline text-sm font-bold text-primary">Cerita</a>
            <a href="#audio-stream" class="mobile-link border-b border-outline-variant/25 py-3 font-headline text-sm font-bold text-primary">Podcast</a>
            <a href="#cara-kerja" class="mobile-link py-3 font-headline text-sm font-bold text-primary">Cara Kerja</a>

            <div class="mt-5 grid grid-cols-2 gap-3">
                <a href="{{ url('/login') }}" class="flex items-center justify-center rounded-full border border-primary px-4 py-3 text-sm font-bold text-primary">Masuk</a>
                <a href="{{ url('/register') }}" class="flex items-center justify-center rounded-full bg-primary px-4 py-3 text-sm font-bold text-white">Daftar gratis</a>
            </div>
        </nav>
    </div>
</header>

<main id="beranda" class="min-h-screen w-full overflow-x-hidden bg-surface pt-20">

<!-- =========================================================
     HERO
========================================================= -->
<section class="relative w-full overflow-hidden pb-16 pt-9 lg:pb-28 lg:pt-16">
    <div class="pointer-events-none absolute -top-32 left-1/4 -z-10 h-[580px] w-[580px] rounded-full bg-secondary/10 blur-[130px] animate-pulse-slow"></div>
    <div class="pointer-events-none absolute -right-[100px] top-20 -z-10 h-[500px] w-[500px] rounded-full bg-tertiary-fixed/60 blur-[110px]"></div>

    <div class="mx-auto max-w-[1320px] px-5 md:px-8 lg:px-12">
        <div class="mb-7 flex flex-wrap items-center gap-3">
            <div class="inline-flex items-center gap-2 rounded-full bg-secondary-fixed px-3.5 py-1.5 font-headline text-xs font-extrabold uppercase tracking-wide text-on-secondary-fixed">
                <span class="h-2.5 w-2.5 rounded-full bg-secondary"></span>
                Pengalaman mahasiswa, disimpan lebih rapi
            </div>

            <div class="inline-flex items-center gap-1.5 rounded-full bg-tertiary-fixed px-3 py-1 font-headline text-xs font-bold text-on-tertiary-fixed">
                <span class="material-symbols-outlined text-[16px] text-secondary">auto_stories</span>
                Baca, dengarkan, simpan, dan bagikan
            </div>
        </div>

        <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-12 lg:gap-12">

            <!-- COPY -->
            <div class="flex flex-col items-start lg:col-span-7">
                <h1 class="font-headline text-[42px] font-extrabold leading-[1.05] tracking-[-2px] text-primary sm:text-[55px] lg:text-[66px]">
                    Apa yang kamu pelajari,
                    <span class="relative inline-block whitespace-nowrap text-secondary">
                        <span class="relative z-10">bisa membantu</span>
                        <span class="absolute inset-x-0 bottom-1.5 -z-0 h-3 -rotate-1 rounded-sm bg-tertiary-fixed md:h-4"></span>
                    </span>
                    perjalanan mahasiswa lain.
                </h1>

                <p class="mt-7 max-w-xl text-lg leading-relaxed text-on-surface-variant sm:text-xl">
                    Interlude adalah ruang bagi mahasiswa untuk berbagi pengalaman, catatan, insight, dan percakapan tentang penelitian, magang, organisasi, tugas akhir, dan kehidupan kampus.
                </p>

                <div class="mt-8 flex w-full flex-wrap items-center gap-4 sm:w-auto">
                    <a href="#cerita-nyata" class="inline-flex items-center justify-center gap-2 rounded-full bg-secondary px-8 py-4 font-headline text-base font-extrabold text-white shadow-[0_6px_22px_rgba(251,77,0,0.25)] transition hover:-translate-y-1 hover:bg-secondary-container">
                        <span class="material-symbols-outlined text-[22px]">explore</span>
                        Jelajahi Sekarang
                    </a>

                    <a href="{{ url('/register') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-outline-variant/50 bg-surface-container-low px-7 py-4 font-headline text-base font-bold text-primary transition hover:-translate-y-0.5 hover:bg-surface-container-high">
                        <span class="material-symbols-outlined text-[20px] text-secondary">edit_square</span>
                        Tulis Pengalamanmu
                    </a>
                </div>

                <div class="mt-10 flex max-w-xl items-start gap-3 border-t border-outline-variant/30 pt-6">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-tertiary-fixed text-primary">
                        <span class="material-symbols-outlined text-[20px]">hub</span>
                    </div>
                    <p class="text-sm leading-6 text-on-surface-variant">
                        Fokusnya bukan siapa yang paling sukses, tapi apa yang bisa dipelajari dari proses yang sudah dijalani.
                    </p>
                </div>
            </div>

            <!-- PRODUCT COLLAGE -->
            <div class="relative mt-4 lg:col-span-5 lg:mt-0">
                <div class="absolute -right-8 -top-10 -z-10 h-64 w-64 rounded-full bg-tertiary-fixed opacity-70 blur-2xl"></div>

                <!-- STORY CARD -->
                <div class="relative -rotate-1 rounded-3xl border border-outline-variant/40 bg-surface-container-low p-6 shadow-md transition-transform duration-300 hover:rotate-0">
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <span class="rounded-full bg-tertiary-fixed px-3 py-1 font-headline text-[11px] font-extrabold uppercase tracking-wider text-on-tertiary-fixed">#Penelitian</span>
                        <span class="text-xs font-bold text-on-surface-variant">7 menit baca</span>
                    </div>

                    <h3 class="mb-2 font-headline text-xl font-extrabold leading-snug text-primary">
                        Hal yang Aku Harap Tahu Sebelum Penelitian Pertamaku
                    </h3>

                    <p class="mb-4 text-sm leading-relaxed text-on-surface-variant">
                        Mulai dari menentukan fokus, membaca jurnal tanpa tenggelam, sampai menerima kalau revisi memang bagian dari proses.
                    </p>

                    <div class="mb-4 flex items-start gap-2.5 rounded-2xl border border-secondary/15 bg-white/90 p-3">
                        <span class="material-symbols-outlined mt-0.5 shrink-0 text-[20px] text-secondary">tips_and_updates</span>
                        <p class="text-xs font-medium italic text-primary">
                            “Mulai dari pertanyaan yang bikin kamu penasaran, bukan dari judul yang terdengar paling akademik.”
                        </p>
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <div class="flex items-center gap-2.5">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary font-headline text-xs font-bold text-white">N</div>
                            <div>
                                <div class="font-headline text-xs font-bold text-primary">Nadine</div>
                                <div class="text-[11px] text-on-surface-variant">Cerita penelitian</div>
                            </div>
                        </div>

                        <button type="button" class="flex items-center gap-1 rounded-full bg-secondary-fixed/60 px-2.5 py-1 text-xs font-bold text-secondary">
                            <span class="material-symbols-outlined text-[16px]">bookmark</span>
                            Simpan
                        </button>
                    </div>
                </div>

                <!-- AUDIO CARD -->
                <div class="relative z-10 -mt-6 ml-4 rotate-1 rounded-3xl border-2 border-white/80 bg-primary p-5 text-white shadow-2xl transition-transform duration-300 hover:rotate-0 sm:ml-8">
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-secondary"></span>
                            <span class="font-headline text-[11px] font-black uppercase tracking-widest text-secondary">Jeda Audio</span>
                        </div>
                        <span class="rounded-full bg-white/10 px-2.5 py-0.5 text-xs text-tertiary-fixed">18:24</span>
                    </div>

                    <h4 class="mb-3 font-headline text-sm font-bold text-white">
                        “Minggu Pertama Magang: Apa yang Sebenarnya Perlu Disiapkan?”
                    </h4>

                    <div id="heroWaveform" class="mb-4 flex h-8 items-center gap-1.5 rounded-xl bg-primary-container px-3 py-1">
                        <span class="h-3 w-1.5 rounded-full bg-secondary"></span>
                        <span class="h-6 w-1.5 rounded-full bg-secondary"></span>
                        <span class="h-7 w-1.5 rounded-full bg-secondary"></span>
                        <span class="h-4 w-1.5 rounded-full bg-secondary"></span>
                        <span class="h-6 w-1.5 rounded-full bg-tertiary-fixed"></span>
                        <span class="h-5 w-1.5 rounded-full bg-tertiary-fixed"></span>
                        <span class="h-7 w-1.5 rounded-full bg-tertiary-fixed"></span>
                        <span class="h-3 w-1.5 rounded-full bg-white/35"></span>
                        <span class="h-6 w-1.5 rounded-full bg-white/35"></span>
                        <span class="h-4 w-1.5 rounded-full bg-white/35"></span>
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <button id="heroPlayToggle" type="button" class="flex h-9 w-9 items-center justify-center rounded-full bg-secondary text-white shadow-md transition hover:scale-110">
                                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings:'FILL' 1;">play_arrow</span>
                            </button>
                            <span class="font-headline text-xs font-semibold text-tertiary-fixed">Interlude Talks</span>
                        </div>
                        <span class="text-xs text-white/60">Episode pilihan</span>
                    </div>
                </div>

                <div class="animate-float absolute -bottom-5 -left-3 z-20 hidden items-center gap-2.5 rounded-2xl border border-white bg-tertiary-fixed px-4 py-2.5 text-primary shadow-xl sm:flex" style="--rot:-2deg;">
                    <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-primary text-white">
                        <span class="material-symbols-outlined text-[18px]">forum</span>
                    </div>
                    <div class="leading-tight">
                        <div class="font-headline text-xs font-extrabold">Baca atau dengarkan</div>
                        <div class="text-[11px] font-medium text-on-tertiary-fixed">pilih format yang kamu suka</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================
     QUICK SITUATIONS
========================================================= -->
<section id="topik-hangat" class="w-full border-y border-outline-variant/30 bg-surface-container-low py-10">
    <div class="mx-auto max-w-[1320px] px-5 md:px-8 lg:px-12">
        <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <span class="font-headline text-xs font-black uppercase tracking-widest text-secondary">Lagi Hadapi Ini?</span>
                <h2 class="font-headline text-xl font-black text-primary md:text-2xl">Cari dari hal yang paling dekat dengan keseharianmu.</h2>
            </div>
            <span class="text-xs font-medium text-on-surface-variant">Klik untuk lompat ke contoh cerita ↓</span>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="#cerita-nyata" class="group inline-flex items-center gap-2 rounded-full border border-outline-variant/40 bg-white px-5 py-3 shadow-sm transition hover:-translate-y-1 hover:bg-primary hover:text-white">
                <span class="h-2.5 w-2.5 rounded-full bg-secondary group-hover:bg-tertiary-fixed"></span>
                <span class="font-headline text-xs font-bold text-primary group-hover:text-white sm:text-sm">“Bingung mulai skripsi dari mana?”</span>
                <span class="material-symbols-outlined text-[16px] text-secondary group-hover:text-white">arrow_forward</span>
            </a>

            <a href="#cerita-nyata" class="group inline-flex items-center gap-2 rounded-full bg-tertiary-fixed px-5 py-3 text-on-tertiary-fixed shadow-sm transition hover:-translate-y-1 hover:bg-secondary hover:text-white">
                <span class="material-symbols-outlined text-[18px]">work</span>
                <span class="font-headline text-xs font-black sm:text-sm">“Magang pertama harus siap apa?”</span>
            </a>

            <a href="#cerita-nyata" class="group inline-flex items-center gap-2 rounded-full border border-outline-variant/40 bg-white px-5 py-3 shadow-sm transition hover:-translate-y-1 hover:bg-primary hover:text-white">
                <span class="material-symbols-outlined text-[18px] text-secondary group-hover:text-white">schedule</span>
                <span class="font-headline text-xs font-bold text-primary group-hover:text-white sm:text-sm">“Gimana bagi waktu kuliah dan organisasi?”</span>
            </a>
        </div>
    </div>
</section>

<!-- =========================================================
     WHY / CORE VALUE BENTO
========================================================= -->
<section id="eksplorasi" class="w-full py-16 lg:py-24">
    <div class="mx-auto max-w-[1320px] px-5 md:px-8 lg:px-12">
        <div class="mb-12 max-w-3xl">
            <div class="mb-3 inline-flex items-center gap-1.5 rounded-full bg-secondary-fixed px-3 py-1 font-headline text-xs font-black uppercase tracking-wider text-on-secondary-fixed">
                Kenapa Interlude?
            </div>

            <h2 class="font-headline text-3xl font-black leading-tight tracking-tight text-primary sm:text-4xl lg:text-5xl">
                Banyak hal berguna berhenti di notes, chat, dan obrolan.
            </h2>

            <p class="mt-4 max-w-2xl text-base leading-7 text-on-surface-variant">
                Interlude membantu pengalaman mahasiswa tetap hidup, lebih terstruktur, dan lebih mudah ditemukan oleh orang yang sedang membutuhkannya.
            </p>
        </div>

        <div class="grid grid-cols-1 items-stretch gap-6 md:grid-cols-12">

            <!-- 01 -->
            <div class="group relative flex flex-col justify-between overflow-hidden rounded-3xl bg-primary p-8 text-white shadow-xl md:col-span-8 lg:p-12">
                <div class="pointer-events-none absolute -right-16 -top-16 h-80 w-80 rounded-full bg-secondary/15 blur-3xl"></div>
                <div class="relative">
                    <div class="mb-8 flex items-center justify-between">
                        <span class="rounded-full border border-white/10 bg-white/10 px-4 py-1 font-headline text-xs font-extrabold uppercase tracking-wider text-tertiary-fixed">Pengetahuan yang bisa ditemukan lagi</span>
                        <span class="font-headline text-3xl font-black text-secondary">01</span>
                    </div>

                    <h3 class="mb-4 max-w-xl font-headline text-2xl font-black leading-snug text-white sm:text-3xl lg:text-4xl">
                        Bukan cuma hasil akhirnya. Prosesnya juga layak dibagikan.
                    </h3>

                    <p class="mb-8 max-w-lg text-base leading-relaxed text-white/70 sm:text-lg">
                        Ceritakan apa yang kamu coba, apa yang gagal, bagaimana kamu memperbaikinya, dan apa yang akhirnya kamu pelajari.
                    </p>
                </div>

                <div class="relative rounded-2xl border border-white/10 bg-primary-container/80 p-4 backdrop-blur-sm sm:p-5">
                    <div class="mb-3 flex items-center gap-2 overflow-x-auto pb-2">
                        <span class="shrink-0 rounded-full bg-secondary px-3.5 py-1.5 font-headline text-xs font-bold text-white">Tugas Akhir</span>
                        <span class="shrink-0 rounded-full bg-white/10 px-3.5 py-1.5 font-headline text-xs font-medium text-white">Magang & Karier</span>
                        <span class="shrink-0 rounded-full bg-white/10 px-3.5 py-1.5 font-headline text-xs font-medium text-white">Organisasi</span>
                        <span class="shrink-0 rounded-full bg-white/10 px-3.5 py-1.5 font-headline text-xs font-medium text-white">Student Exchange</span>
                    </div>
                    <div class="flex items-center gap-1.5 text-xs font-medium text-tertiary-fixed">
                        <span class="material-symbols-outlined text-[16px] text-secondary">check_circle</span>
                        Terstruktur berdasarkan topik supaya lebih mudah ditemukan kembali.
                    </div>
                </div>
            </div>

            <!-- 02 -->
            <div class="relative flex flex-col justify-between overflow-hidden rounded-3xl bg-secondary p-8 text-white shadow-xl md:col-span-4">
                <div class="mb-6 flex items-center justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20">
                        <span class="material-symbols-outlined text-[28px] text-white">chat_bubble</span>
                    </div>
                    <span class="font-headline text-3xl font-black text-white/40">02</span>
                </div>

                <div>
                    <span class="mb-2 block font-headline text-xs font-black uppercase tracking-widest text-white/75">Bahasa yang dekat</span>
                    <h3 class="mb-3 font-headline text-2xl font-black leading-tight text-white">Nggak harus terdengar seperti jurnal.</h3>
                    <p class="mb-6 text-sm leading-relaxed text-white/90">
                        Tulis dengan gaya yang nyaman, selama tetap jelas, bermanfaat, dan menghargai orang lain.
                    </p>
                </div>

                <div class="flex items-center justify-between rounded-2xl border border-white/20 bg-white/15 p-3">
                    <span class="font-headline text-xs font-bold text-white">Personal, tapi tetap informatif</span>
                    <span class="material-symbols-outlined text-[20px] text-white">draw</span>
                </div>
            </div>

            <!-- 03 -->
            <div class="relative flex flex-col justify-between overflow-hidden rounded-3xl bg-tertiary-fixed p-8 text-on-tertiary-fixed shadow-md md:col-span-5">
                <div>
                    <div class="mb-6 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary text-white">
                            <span class="material-symbols-outlined text-[26px]">headphones</span>
                        </div>
                        <span class="rounded-full bg-white/80 px-3 py-1 font-headline text-xs font-black text-primary">JEDA AUDIO</span>
                    </div>

                    <h3 class="mb-3 font-headline text-2xl font-black text-primary">Kalau lagi capek membaca, dengarkan aja.</h3>
                    <p class="mb-6 text-sm leading-relaxed text-on-tertiary-fixed">
                        Podcast menjadi format lain untuk berbagi pengalaman, refleksi, dan percakapan mahasiswa.
                    </p>
                </div>

                <div class="flex items-center justify-between rounded-2xl border border-outline-variant/40 bg-white p-4 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-secondary text-white">
                            <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 1;">play_arrow</span>
                        </div>
                        <div>
                            <div class="max-w-[160px] truncate font-headline text-xs font-bold text-primary">Interlude Talks</div>
                            <div class="text-[11px] text-on-surface-variant">Dilema kerja vs lanjut studi</div>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-secondary">24:10</span>
                </div>
            </div>

            <!-- 04 -->
            <div class="flex flex-col justify-between rounded-3xl border border-outline-variant/40 bg-surface-container-low p-8 shadow-md md:col-span-7">
                <div>
                    <div class="mb-6 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary text-white">
                            <span class="material-symbols-outlined text-[26px]">bookmarks</span>
                        </div>
                        <span class="rounded-full bg-surface-container-high px-3 py-1 font-headline text-xs font-black text-primary">SAVED</span>
                    </div>

                    <h3 class="mb-3 font-headline text-2xl font-black text-primary">Simpan insight supaya nggak hilang di timeline.</h3>
                    <p class="mb-6 text-sm leading-relaxed text-on-surface-variant sm:text-base">
                        Bookmark artikel dan episode podcast, lalu kelompokkan berdasarkan kebutuhanmu sendiri.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2 pt-2">
                    <span class="flex items-center gap-1.5 rounded-full border border-outline-variant/40 bg-white px-3.5 py-1.5 font-headline text-xs font-bold text-primary shadow-sm">
                        <span class="material-symbols-outlined text-[16px] text-secondary">folder</span> Skripsi
                    </span>
                    <span class="flex items-center gap-1.5 rounded-full border border-outline-variant/40 bg-white px-3.5 py-1.5 font-headline text-xs font-bold text-primary shadow-sm">
                        <span class="material-symbols-outlined text-[16px] text-secondary">folder</span> Magang
                    </span>
                    <span class="flex items-center gap-1.5 rounded-full border border-outline-variant/40 bg-white px-3.5 py-1.5 font-headline text-xs font-bold text-primary shadow-sm">
                        <span class="material-symbols-outlined text-[16px] text-secondary">folder</span> Baca Nanti
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================
     HOW IT WORKS
========================================================= -->
<section id="cara-kerja" class="w-full bg-tertiary-fixed py-16 lg:py-20">
    <div class="mx-auto max-w-[1320px] px-5 md:px-8 lg:px-12">
        <div class="mb-10 max-w-2xl">
            <span class="font-headline text-xs font-black uppercase tracking-widest text-secondary">Cara Kerja</span>
            <h2 class="mt-2 font-headline text-3xl font-black tracking-tight text-primary sm:text-4xl">Sederhana, supaya fokusnya tetap pada hal yang ingin kamu pelajari.</h2>
        </div>

        <div class="grid grid-cols-1 border-y border-primary/20 md:grid-cols-4">
            <div class="border-b border-primary/20 py-7 md:border-b-0 md:border-r md:pr-7">
                <div class="font-headline text-4xl font-black text-primary/25">01</div>
                <h3 class="mt-5 font-headline text-xl font-black text-primary">Temukan</h3>
                <p class="mt-2 text-sm leading-6 text-primary/65">Cari topik yang sedang kamu butuhkan.</p>
            </div>

            <div class="border-b border-primary/20 py-7 md:border-b-0 md:border-r md:px-7">
                <div class="font-headline text-4xl font-black text-primary/25">02</div>
                <h3 class="mt-5 font-headline text-xl font-black text-primary">Baca / Dengarkan</h3>
                <p class="mt-2 text-sm leading-6 text-primary/65">Pilih format yang paling nyaman buatmu.</p>
            </div>

            <div class="border-b border-primary/20 py-7 md:border-b-0 md:border-r md:px-7">
                <div class="font-headline text-4xl font-black text-primary/25">03</div>
                <h3 class="mt-5 font-headline text-xl font-black text-primary">Simpan</h3>
                <p class="mt-2 text-sm leading-6 text-primary/65">Kumpulkan insight yang ingin kamu buka lagi.</p>
            </div>

            <div class="py-7 md:pl-7">
                <div class="font-headline text-4xl font-black text-primary/25">04</div>
                <h3 class="mt-5 font-headline text-xl font-black text-primary">Bagikan</h3>
                <p class="mt-2 text-sm leading-6 text-primary/65">Tambahkan pengalamanmu ke percakapan.</p>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================
     REAL STORIES
========================================================= -->
<section id="cerita-nyata" class="w-full bg-surface-container-low/60 py-16 lg:py-24">
    <div class="mx-auto max-w-[1320px] px-5 md:px-8 lg:px-12">
        <div class="mb-12 flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <span class="mb-2 block font-headline text-xs font-black uppercase tracking-widest text-secondary">Contoh Cerita</span>
                <h2 class="font-headline text-3xl font-black tracking-tight text-primary sm:text-4xl lg:text-5xl">Pengalaman yang benar-benar dijalani.</h2>
            </div>

            <a href="#" class="inline-flex shrink-0 items-center gap-1.5 font-headline text-sm font-extrabold text-secondary hover:underline">
                <span>Jelajahi cerita</span>
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-12">
            <article class="flex h-full flex-col justify-between rounded-3xl border border-outline-variant/40 bg-white p-8 shadow-md transition hover:shadow-xl lg:col-span-7 lg:p-10">
                <div>
                    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <span class="rounded-full bg-secondary-fixed px-3.5 py-1 font-headline text-xs font-black uppercase tracking-wide text-on-secondary-fixed">Pilihan Minggu Ini</span>
                            <span class="text-xs font-medium text-on-surface-variant">Magang & Karier</span>
                        </div>
                        <span class="flex items-center gap-1 text-xs text-on-surface-variant">
                            <span class="material-symbols-outlined text-[16px]">schedule</span> 7 menit baca
                        </span>
                    </div>

                    <h3 class="mb-4 cursor-pointer font-headline text-2xl font-black leading-tight text-primary transition hover:text-secondary sm:text-3xl">
                        Minggu Pertamaku Magang Tidak Seperti yang Kubayangkan
                    </h3>

                    <div class="my-6 rounded-2xl border-l-4 border-secondary bg-surface-container-low p-5">
                        <p class="text-base italic leading-relaxed text-primary">
                            “Kupikir hari pertama akan pelan-pelan. Ternyata aku langsung masuk ke ritme kerja yang jauh berbeda dari kelas.”
                        </p>
                    </div>

                    <p class="mb-6 text-base leading-relaxed text-on-surface-variant">
                        Dari cara bertanya tanpa takut terlihat tidak tahu, mencatat hasil meeting, sampai belajar menyesuaikan ekspektasi dengan realita kerja.
                    </p>
                </div>

                <div class="flex items-center justify-between border-t border-outline-variant/30 pt-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-full bg-primary font-headline text-sm font-black text-white">P</div>
                        <div>
                            <div class="font-headline text-sm font-bold text-primary">Putri Aulia</div>
                            <div class="text-xs text-on-surface-variant">Pengalaman magang</div>
                        </div>
                    </div>

                    <button type="button" aria-label="Simpan artikel" class="rounded-full bg-surface-container p-2 text-primary transition hover:bg-secondary hover:text-white">
                        <span class="material-symbols-outlined text-[18px]">bookmark</span>
                    </button>
                </div>
            </article>

            <div class="flex flex-col gap-6 lg:col-span-5">
                <article class="rounded-3xl border border-outline-variant/40 bg-white p-6 shadow-sm transition hover:shadow-md">
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <span class="rounded-full bg-tertiary-fixed px-3 py-0.5 font-headline text-[11px] font-black uppercase text-on-tertiary-fixed">Tugas Akhir & Riset</span>
                        <span class="text-xs text-on-surface-variant">5 menit baca</span>
                    </div>

                    <h4 class="mb-2 cursor-pointer font-headline text-lg font-bold text-primary transition hover:text-secondary">
                        Cara Menentukan Fokus Penelitian Saat Semuanya Terasa Menarik
                    </h4>

                    <p class="mb-4 text-xs leading-relaxed text-on-surface-variant">
                        Beberapa pertanyaan yang bisa membantu mempersempit topik tanpa merasa kehilangan semua ide yang sudah terkumpul.
                    </p>

                    <div class="flex items-center justify-between border-t border-outline-variant/20 pt-3">
                        <div class="flex items-center gap-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-tertiary-fixed font-headline text-xs font-black text-primary">R</div>
                            <span class="font-headline text-xs font-bold text-primary">Raka</span>
                        </div>
                        <span class="material-symbols-outlined text-[18px] text-secondary">arrow_outward</span>
                    </div>
                </article>

                <article class="rounded-3xl border border-outline-variant/40 bg-white p-6 shadow-sm transition hover:shadow-md">
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <span class="rounded-full bg-secondary-fixed px-3 py-0.5 font-headline text-[11px] font-black uppercase text-on-secondary-fixed">Organisasi & Waktu</span>
                        <span class="text-xs text-on-surface-variant">4 menit baca</span>
                    </div>

                    <h4 class="mb-2 cursor-pointer font-headline text-lg font-bold text-primary transition hover:text-secondary">
                        Belajar Bilang “Nggak” Tanpa Merasa Jadi Teman yang Buruk
                    </h4>

                    <p class="mb-4 text-xs leading-relaxed text-on-surface-variant">
                        Tentang membagi energi antara kelas, kepanitiaan, pertemanan, dan waktu untuk diri sendiri.
                    </p>

                    <div class="flex items-center justify-between border-t border-outline-variant/20 pt-3">
                        <div class="flex items-center gap-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-secondary-fixed font-headline text-xs font-black text-on-secondary-fixed">D</div>
                            <span class="font-headline text-xs font-bold text-primary">Dinda</span>
                        </div>
                        <span class="material-symbols-outlined text-[18px] text-secondary">arrow_outward</span>
                    </div>
                </article>

                <div class="flex items-center justify-between rounded-3xl bg-primary p-5 text-white shadow-md">
                    <div>
                        <div class="mb-0.5 font-headline text-xs font-bold text-tertiary-fixed">Punya pengalaman yang ingin dibagikan?</div>
                        <div class="font-headline text-sm font-black text-white">Tulis dengan gayamu sendiri.</div>
                    </div>
                    <a href="{{ url('/register') }}" class="rounded-full bg-secondary px-4 py-2 font-headline text-xs font-black text-white transition hover:bg-secondary-container">Mulai Tulis</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================
     PODCAST
========================================================= -->
<section id="audio-stream" class="relative w-full overflow-hidden bg-tertiary-fixed py-16 text-on-tertiary-fixed lg:py-24">
    <div class="mx-auto max-w-[1320px] px-5 md:px-8 lg:px-12">
        <div class="mb-12 max-w-2xl">
            <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-primary px-3.5 py-1.5 font-headline text-xs font-black uppercase tracking-wider text-white">
                <span class="h-2 w-2 rounded-full bg-secondary"></span>
                Jeda Audio
            </div>

            <h2 class="font-headline text-3xl font-black leading-tight tracking-tight text-primary sm:text-4xl lg:text-5xl">Capek menatap layar? Dengarkan aja.</h2>

            <p class="mt-3 text-base leading-7 text-on-tertiary-fixed sm:text-lg">
                Percakapan tentang kuliah, penelitian, karier, organisasi, dan kehidupan mahasiswa dalam format yang lebih santai.
            </p>
        </div>

        <div class="grid grid-cols-1 items-stretch gap-8 lg:grid-cols-12">
            <!-- MAIN PLAYER -->
            <div class="flex flex-col justify-between rounded-3xl border border-outline-variant/30 bg-white p-8 shadow-lg lg:col-span-8 lg:p-10">
                <div>
                    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <span class="rounded-full bg-secondary-fixed px-3.5 py-1 font-headline text-xs font-black uppercase text-on-secondary-fixed">Episode Pilihan</span>
                            <span class="text-xs font-medium text-on-surface-variant">Interlude Talks</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <button id="speedButton" type="button" class="rounded-full bg-surface-container px-3 py-1 font-headline text-xs font-extrabold text-primary transition hover:bg-secondary hover:text-white">1.0x</button>
                            <button type="button" aria-label="Bagikan audio" class="rounded-full p-1.5 text-on-surface-variant transition hover:bg-surface-container hover:text-secondary">
                                <span class="material-symbols-outlined text-[20px]">share</span>
                            </button>
                        </div>
                    </div>

                    <h3 class="mb-3 font-headline text-2xl font-black leading-snug text-primary sm:text-3xl">
                        “Bingung Pilih Jalan Setelah Kuliah Itu Normal?”
                    </h3>

                    <p class="mb-6 text-sm leading-relaxed text-on-surface-variant sm:text-base">
                        Obrolan tentang tekanan untuk cepat punya arah, membandingkan diri dengan teman, dan bagaimana memulai dari langkah yang lebih realistis.
                    </p>

                    <div class="mb-6 rounded-2xl border border-outline-variant/40 bg-surface-container-low p-5">
                        <div id="podcastVisualizer" class="flex h-20 w-full items-end justify-between gap-1.5 px-2">
                            <span class="h-8 w-2 rounded-full bg-secondary transition-all duration-300"></span>
                            <span class="h-16 w-2 rounded-full bg-secondary transition-all duration-300"></span>
                            <span class="h-12 w-2 rounded-full bg-secondary transition-all duration-300"></span>
                            <span class="h-20 w-2 rounded-full bg-secondary transition-all duration-300"></span>
                            <span class="h-10 w-2 rounded-full bg-secondary transition-all duration-300"></span>
                            <span class="h-14 w-2 rounded-full bg-secondary transition-all duration-300"></span>
                            <span class="h-8 w-2 rounded-full bg-primary transition-all duration-300"></span>
                            <span class="h-12 w-2 rounded-full bg-primary transition-all duration-300"></span>
                            <span class="h-7 w-2 rounded-full bg-primary transition-all duration-300"></span>
                            <span class="h-14 w-2 rounded-full bg-outline-variant transition-all duration-300"></span>
                            <span class="h-9 w-2 rounded-full bg-outline-variant transition-all duration-300"></span>
                            <span class="h-16 w-2 rounded-full bg-outline-variant transition-all duration-300"></span>
                            <span class="h-6 w-2 rounded-full bg-outline-variant transition-all duration-300"></span>
                            <span class="h-11 w-2 rounded-full bg-outline-variant transition-all duration-300"></span>
                        </div>
                        <div class="mt-3 flex items-center justify-between px-1 text-xs font-bold text-on-surface-variant">
                            <span id="playerCurrentTime">14:08</span>
                            <span>38:12</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-4 pt-2">
                    <div class="flex items-center gap-4">
                        <button type="button" aria-label="Mundur 10 detik" class="text-on-surface-variant transition hover:text-primary">
                            <span class="material-symbols-outlined text-[28px]">replay_10</span>
                        </button>

                        <button id="podcastPlayMaster" type="button" class="flex h-14 w-14 items-center justify-center rounded-full bg-secondary text-white shadow-lg transition hover:scale-105 active:scale-95">
                            <span class="material-symbols-outlined text-[32px]" style="font-variation-settings:'FILL' 1;">play_arrow</span>
                        </button>

                        <button type="button" aria-label="Maju 10 detik" class="text-on-surface-variant transition hover:text-primary">
                            <span class="material-symbols-outlined text-[28px]">forward_10</span>
                        </button>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary font-headline text-sm font-black text-white">I</div>
                        <div>
                            <div class="font-headline text-xs font-black text-primary">Interlude Talks</div>
                            <div class="text-xs text-on-surface-variant">Percakapan mahasiswa</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- EPISODE LIST -->
            <div class="flex flex-col justify-between rounded-3xl bg-primary p-7 text-white shadow-xl lg:col-span-4">
                <div>
                    <div class="mb-5 flex items-center justify-between">
                        <span class="font-headline text-xs font-black uppercase tracking-wider text-secondary">Episode Lain</span>
                        <span class="material-symbols-outlined text-[20px] text-white/60">queue_music</span>
                    </div>

                    <div class="flex flex-col gap-3">
                        <div class="group cursor-pointer rounded-2xl border border-white/5 bg-white/10 p-3.5 transition hover:bg-white/15">
                            <div class="mb-1 flex items-center justify-between text-[11px] text-tertiary-fixed">
                                <span>EP. 12</span><span>26:40</span>
                            </div>
                            <h4 class="font-headline text-xs font-bold text-white transition group-hover:text-secondary">Magang Pertama: Apa yang Sebenarnya Perlu Disiapkan?</h4>
                            <p class="mt-1 text-[11px] text-white/55">Dari ekspektasi sampai hari pertama kerja.</p>
                        </div>

                        <div class="group cursor-pointer rounded-2xl border border-white/5 bg-white/10 p-3.5 transition hover:bg-white/15">
                            <div class="mb-1 flex items-center justify-between text-[11px] text-tertiary-fixed">
                                <span>EP. 11</span><span>31:15</span>
                            </div>
                            <h4 class="font-headline text-xs font-bold text-white transition group-hover:text-secondary">Saat Topik Penelitian Harus Diganti di Tengah Jalan</h4>
                            <p class="mt-1 text-[11px] text-white/55">Tentang revisi arah tanpa merasa mulai dari nol.</p>
                        </div>

                        <div class="group cursor-pointer rounded-2xl border border-white/5 bg-white/10 p-3.5 transition hover:bg-white/15">
                            <div class="mb-1 flex items-center justify-between text-[11px] text-tertiary-fixed">
                                <span>EP. 10</span><span>21:08</span>
                            </div>
                            <h4 class="font-headline text-xs font-bold text-white transition group-hover:text-secondary">Organisasi Kampus dan Belajar Menentukan Batas</h4>
                            <p class="mt-1 text-[11px] text-white/55">Saat semua hal terasa penting di waktu yang sama.</p>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <a href="#" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-secondary py-3 font-headline text-xs font-black text-white shadow-md transition hover:bg-secondary-container">
                        Jelajahi Semua Podcast
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================
     FINAL CTA
========================================================= -->
<section id="tulis-cerita" class="w-full py-16 lg:py-20">
    <div class="mx-auto max-w-[1320px] px-5 md:px-8 lg:px-12">
        <div class="relative flex flex-col items-center overflow-hidden rounded-[2.5rem] bg-primary p-8 text-center text-white shadow-2xl sm:p-12 lg:p-20">
            <div class="pointer-events-none absolute -top-20 left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-secondary/25 blur-[110px]"></div>

            <span class="relative mb-6 rounded-full bg-secondary px-4 py-1.5 font-headline text-xs font-extrabold uppercase tracking-widest text-white">Mulai dari satu cerita</span>

            <h2 class="relative mb-6 max-w-3xl font-headline text-3xl font-black leading-tight text-white sm:text-4xl lg:text-6xl">
                Punya sesuatu yang kamu pelajari pekan ini?
            </h2>

            <p class="relative mb-10 max-w-2xl text-base leading-relaxed text-white/65 sm:text-xl">
                Hal yang terasa kecil buatmu mungkin menjadi insight yang sedang dicari mahasiswa lain.
            </p>

            <div class="relative flex w-full flex-wrap items-center justify-center gap-4 sm:w-auto">
                <a href="{{ url('/register') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-secondary px-8 py-4 font-headline text-base font-extrabold text-white shadow-[0_6px_22px_rgba(251,77,0,0.3)] transition hover:-translate-y-1 hover:bg-secondary-container">
                    Mulai Berbagi
                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                </a>

                <a href="#eksplorasi" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/20 bg-white/10 px-8 py-4 font-headline text-base font-bold text-white transition hover:bg-white/20">
                    <span class="material-symbols-outlined text-[20px]">explore</span>
                    Jelajahi Dulu
                </a>
            </div>
        </div>
    </div>
</section>

</main>

<!-- =========================================================
     FOOTER
========================================================= -->
<footer class="w-full border-t border-outline-variant/30 bg-surface-container-low">
    <div class="mx-auto max-w-[1320px] px-5 pb-12 pt-16 md:px-8 lg:px-12">
        <div class="mb-12 grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-4">
            <div class="flex flex-col gap-3">
                <a href="#beranda" class="font-headline text-2xl font-extrabold tracking-[-1px] text-primary">Interlude<span class="text-secondary">.</span></a>
                <p class="mt-1 max-w-sm text-sm leading-relaxed text-on-surface-variant">
                    Jeda untuk berbagi pengetahuan, pengalaman, dan percakapan dari perjalanan mahasiswa.
                </p>
            </div>

            <div class="flex flex-col gap-3">
                <span class="font-headline text-xs font-black uppercase tracking-wider text-primary">Jelajahi</span>
                <nav class="flex flex-col gap-2 text-sm text-on-surface-variant">
                    <a href="#cerita-nyata" class="transition hover:text-secondary">Cerita</a>
                    <a href="#audio-stream" class="transition hover:text-secondary">Podcast</a>
                    <a href="#topik-hangat" class="transition hover:text-secondary">Topik</a>
                    <a href="#cara-kerja" class="transition hover:text-secondary">Cara Kerja</a>
                </nav>
            </div>

            <div class="flex flex-col gap-3">
                <span class="font-headline text-xs font-black uppercase tracking-wider text-primary">Komunitas</span>
                <nav class="flex flex-col gap-2 text-sm text-on-surface-variant">
                    <a href="{{ url('/register') }}" class="transition hover:text-secondary">Mulai Menulis</a>
                    <a href="#" class="transition hover:text-secondary">Panduan Komunitas</a>
                    <a href="#" class="transition hover:text-secondary">Pusat Bantuan</a>
                </nav>
            </div>

            <div class="flex flex-col gap-3">
                <span class="font-headline text-xs font-black uppercase tracking-wider text-primary">Tentang Interlude</span>
                <p class="text-xs leading-relaxed text-on-surface-variant">
                    Dibangun sebagai ruang berbagi yang membantu pengalaman mahasiswa lebih mudah ditemukan kembali.
                </p>
            </div>
        </div>

        <div class="flex flex-col items-center justify-between gap-4 border-t border-outline-variant/30 pt-8 text-center text-xs text-on-surface-variant sm:flex-row sm:text-left">
            <p>© {{ date('Y') }} Interlude.</p>
            <div class="flex items-center gap-6">
                <a href="#" class="transition hover:text-secondary">Privasi</a>
                <a href="#" class="transition hover:text-secondary">Ketentuan</a>
                <a href="#" class="transition hover:text-secondary">Etika Berbagi</a>
            </div>
        </div>
    </div>
</footer>

<!-- =========================================================
     MICRO-INTERACTIONS
========================================================= -->
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // MOBILE NAV
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileMenuIcon = document.getElementById('mobileMenuIcon');
        const mobileLinks = document.querySelectorAll('.mobile-link');

        function closeMobileMenu() {
            if (!mobileMenu) return;
            mobileMenu.classList.add('hidden');
            mobileMenuButton?.setAttribute('aria-expanded', 'false');
            if (mobileMenuIcon) mobileMenuIcon.textContent = 'menu';
        }

        mobileMenuButton?.addEventListener('click', function () {
            const isHidden = mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden');
            mobileMenuButton.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
            mobileMenuIcon.textContent = isHidden ? 'close' : 'menu';
        });

        mobileLinks.forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });

        // HERO PLAYER UI
        const heroToggle = document.getElementById('heroPlayToggle');
        let heroPlaying = false;

        heroToggle?.addEventListener('click', function () {
            heroPlaying = !heroPlaying;
            const icon = heroToggle.querySelector('.material-symbols-outlined');
            if (icon) icon.textContent = heroPlaying ? 'pause' : 'play_arrow';
            heroToggle.classList.toggle('bg-secondary-container', heroPlaying);
        });

        // MAIN PODCAST UI PROTOTYPE
        const podcastMaster = document.getElementById('podcastPlayMaster');
        const visualizer = document.getElementById('podcastVisualizer');
        let podcastPlaying = false;
        let podcastInterval = null;

        podcastMaster?.addEventListener('click', function () {
            podcastPlaying = !podcastPlaying;

            const icon = podcastMaster.querySelector('.material-symbols-outlined');
            if (icon) icon.textContent = podcastPlaying ? 'pause' : 'play_arrow';

            if (podcastPlaying && visualizer) {
                podcastInterval = setInterval(() => {
                    visualizer.querySelectorAll('span').forEach(bar => {
                        const height = Math.floor(Math.random() * 58) + 14;
                        bar.style.height = height + 'px';
                    });
                }, 300);
            } else if (podcastInterval) {
                clearInterval(podcastInterval);
                podcastInterval = null;
            }
        });

        // SPEED BUTTON
        const speedButton = document.getElementById('speedButton');
        const speeds = ['1.0x', '1.25x', '1.5x', '2.0x'];
        let speedIndex = 0;

        speedButton?.addEventListener('click', function () {
            speedIndex = (speedIndex + 1) % speeds.length;
            speedButton.textContent = speeds[speedIndex];
        });
    });
</script>

</body>
</html>