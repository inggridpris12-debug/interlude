<x-admin-layout :title="'Moderasi & Laporan - Panel Kurator'">

    <div class="space-y-6">

        {{-- Flash Notification --}}
        @if(session('success'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-transition
                class="flex items-center justify-between rounded-2xl border border-[#DDF3E4] bg-[#EDF9F1] px-5 py-4 text-[#18794E] shadow-sm"
            >
                <div class="flex items-center gap-3">
                    <span class="grid h-8 w-8 place-items-center rounded-full bg-[#DDF3E4] text-[#18794E]">
                        <i class="fa-solid fa-check text-sm"></i>
                    </span>
                    <p class="font-['Plus_Jakarta_Sans'] text-xs font-bold sm:text-sm">
                        {{ session('success') }}
                    </p>
                </div>
                <button
                    type="button"
                    @click="show = false"
                    class="text-[#18794E]/70 hover:text-[#18794E]"
                >
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        @endif

        {{-- =========================================================
            BANNER / HEADER RINGKASAN EKOSISTEM
        ========================================================== --}}
        <div class="relative overflow-hidden rounded-3xl bg-[#49261D] p-6 text-white shadow-md sm:p-8">
            {{-- Decorative ambient glow --}}
            <div class="pointer-events-none absolute -right-12 -top-12 h-64 w-64 rounded-full bg-[#FB4D00] opacity-20 blur-3xl"></div>

            <div class="relative z-10 flex flex-col justify-between gap-6 md:flex-row md:items-center">
                <div class="max-w-2xl space-y-2">
                    <div class="inline-flex items-center gap-2 rounded-full bg-[#17333F] px-3.5 py-1 text-[10px] font-extrabold uppercase tracking-wider text-[#CAE7F7]">
                        <span class="h-2 w-2 animate-pulse rounded-full bg-[#FB4D00]"></span>
                        Pusat Kendali Etika Komunitas
                    </div>

                    <h1 class="font-['Plus_Jakarta_Sans'] text-2xl font-extrabold tracking-tight text-white sm:text-3xl lg:text-4xl">
                        Moderasi &amp; Penjagaan Integritas Kampus
                    </h1>

                    <p class="text-xs leading-relaxed text-[#FFEDE3]/90 sm:text-sm">
                        Tinjau laporan masuk, verifikasi integritas karya ilmiah mahasiswa, serta pastikan ruang tukar cerita tetap sehat dan suportif antar-universitas.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
                    <div class="inline-flex items-center gap-2 rounded-full bg-[#30120A] px-4 py-2 text-xs font-bold text-[#FFEDE3]">
                        <i class="fa-solid fa-shield-halved text-[#FB4D00]"></i>
                        <span>Standar Etik v2.4</span>
                    </div>

                    <a
                        href="{{ route('admin.reports') }}"
                        class="inline-flex items-center gap-2 rounded-full bg-[#FB4D00] px-4 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-[#D44000]"
                    >
                        <i class="fa-solid fa-arrows-rotate text-xs"></i>
                        <span>Segarkan Antrean</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- =========================================================
            METRIK KARTU SOROTAN EKOSISTEM
        ========================================================== --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

            {{-- Metrik 1: Mahasiswa --}}
            <div class="flex flex-col justify-between rounded-2xl border border-[#E9DCD4] bg-white p-5 shadow-sm transition hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <span class="font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-wider text-[#796B65]">
                        Total Mahasiswa
                    </span>
                    <div class="grid h-10 w-10 place-items-center rounded-xl bg-[#CAE7F7] text-[#17333F]">
                        <i class="fa-solid fa-graduation-cap text-base"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold tracking-tight text-[#49261D]">
                        {{ number_format($stats['total_users']) }}
                    </div>
                    <div class="mt-1 flex items-center gap-1.5 text-xs text-[#796B65]">
                        <i class="fa-solid fa-arrow-trend-up text-[#FB4D00]"></i>
                        <span class="font-bold text-[#FB4D00]">Aktif</span>
                        <span class="opacity-60">• Komunitas Kampus</span>
                    </div>
                </div>
            </div>

            {{-- Metrik 2: Cerita Dipublikasi --}}
            <div class="flex flex-col justify-between rounded-2xl border border-[#E9DCD4] bg-white p-5 shadow-sm transition hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <span class="font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-wider text-[#796B65]">
                        Cerita Disetujui
                    </span>
                    <div class="grid h-10 w-10 place-items-center rounded-xl bg-[#FFEDE3] text-[#FB4D00]">
                        <i class="fa-solid fa-book-open text-base"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold tracking-tight text-[#49261D]">
                        {{ number_format($stats['total_articles']) }}
                    </div>
                    <div class="mt-1 flex items-center gap-1.5 text-xs text-[#796B65]">
                        <i class="fa-solid fa-check-circle text-[#18794E]"></i>
                        <span class="font-bold text-[#49261D]">Terpublikasi</span>
                        <span class="opacity-60">• Lolos Kurasi</span>
                    </div>
                </div>
            </div>

            {{-- Metrik 3: Audio Stories --}}
            <div class="flex flex-col justify-between rounded-2xl border border-[#E9DCD4] bg-white p-5 shadow-sm transition hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <span class="font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-wider text-[#796B65]">
                        Audio Stories (Jeda)
                    </span>
                    <div class="grid h-10 w-10 place-items-center rounded-xl bg-[#CAE7F7] text-[#17333F]">
                        <i class="fa-solid fa-podcast text-base"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold tracking-tight text-[#49261D]">
                        Podcast Hub
                    </div>
                    <div class="mt-1 flex items-center gap-1.5 text-xs text-[#796B65]">
                        <i class="fa-solid fa-clock text-[#FB4D00]"></i>
                        <span class="font-bold text-[#FB4D00]">Segera Hadir</span>
                        <span class="opacity-60">• Audio Kampus</span>
                    </div>
                </div>
            </div>

            {{-- Metrik 4: Antrean Pending --}}
            <div class="flex flex-col justify-between rounded-2xl border border-[#E9DCD4] bg-[#F1ECE8] p-5 shadow-sm transition hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <span class="font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-wider text-[#FB4D00]">
                        Antrean Pending
                    </span>
                    <div class="grid h-10 w-10 place-items-center rounded-xl bg-[#FFE0D8] text-[#FB4D00]">
                        <i class="fa-solid fa-flag text-base"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-baseline gap-2">
                        <span class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold tracking-tight text-[#FB4D00]">
                            {{ number_format($stats['pending_reports']) }}
                        </span>
                        <span class="text-xs text-[#796B65]">kasus aktif</span>
                    </div>
                    <div class="mt-1 flex items-center gap-1.5 text-xs text-[#FB4D00]">
                        <span class="h-2 w-2 rounded-full bg-[#FB4D00]"></span>
                        <span class="font-bold">Butuh Tinjauan Cepat</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- =========================================================
            WORKFLOW ANTREAN MODERASI & KONTROL FILTER
        ========================================================== --}}
        <div class="space-y-5 rounded-2xl border border-[#E9DCD4] bg-white p-5 sm:p-6 shadow-sm">

            {{-- Header & Filter Bar --}}
            <div class="flex flex-col justify-between gap-4 border-b border-[#E9DCD4] pb-5 lg:flex-row lg:items-center">
                <div class="space-y-1">
                    <div class="flex items-center gap-2.5">
                        <h2 class="font-['Plus_Jakarta_Sans'] text-lg font-extrabold tracking-tight text-[#49261D] sm:text-xl">
                            Antrean Laporan Masuk
                        </h2>
                        <span class="rounded-full bg-[#FB4D00] px-2.5 py-0.5 text-[10px] font-extrabold text-white">
                            {{ $reports->total() }} Kasus
                        </span>
                    </div>
                    <p class="text-xs text-[#796B65]">
                        Periksa konten yang dilaporkan anggota dewan kurator atau sesama mahasiswa demi menjaga standar platform.
                    </p>
                </div>

                {{-- Filter Tabs --}}
                <div class="flex flex-wrap items-center gap-1.5 rounded-full bg-[#FFFAF6] p-1 border border-[#E9DCD4]">
                    <a
                        href="{{ route('admin.reports', ['status' => 'all']) }}"
                        class="rounded-full px-4 py-1.5 text-xs font-bold transition
                        {{ $status === 'all' ? 'bg-[#49261D] text-white shadow-sm' : 'text-[#796B65] hover:bg-[#F1ECE8] hover:text-[#49261D]' }}"
                    >
                        Semua
                    </a>

                    <a
                        href="{{ route('admin.reports', ['status' => 'pending']) }}"
                        class="rounded-full px-4 py-1.5 text-xs font-bold transition
                        {{ $status === 'pending' ? 'bg-[#FB4D00] text-white shadow-sm' : 'text-[#796B65] hover:bg-[#F1ECE8] hover:text-[#49261D]' }}"
                    >
                        Butuh Tinjauan Cepat
                        @if($stats['pending_reports'] > 0)
                            <span class="ml-1 inline-flex h-4 w-4 items-center justify-center rounded-full {{ $status === 'pending' ? 'bg-white text-[#FB4D00]' : 'bg-[#FB4D00] text-white' }} text-[9px] font-extrabold">
                                {{ $stats['pending_reports'] }}
                            </span>
                        @endif
                    </a>

                    <a
                        href="{{ route('admin.reports', ['status' => 'resolved']) }}"
                        class="rounded-full px-4 py-1.5 text-xs font-bold transition
                        {{ $status === 'resolved' ? 'bg-[#49261D] text-white shadow-sm' : 'text-[#796B65] hover:bg-[#F1ECE8] hover:text-[#49261D]' }}"
                    >
                        Terselesaikan
                    </a>

                    <a
                        href="{{ route('admin.reports', ['status' => 'rejected']) }}"
                        class="rounded-full px-4 py-1.5 text-xs font-bold transition
                        {{ $status === 'rejected' ? 'bg-[#49261D] text-white shadow-sm' : 'text-[#796B65] hover:bg-[#F1ECE8] hover:text-[#49261D]' }}"
                    >
                        Ditolak / Aman
                    </a>
                </div>
            </div>

            {{-- Moderation Cards Queue --}}
            <div class="space-y-4">
                @forelse($reports as $report)
                    <div class="flex flex-col justify-between gap-5 rounded-2xl border border-[#E9DCD4] bg-[#FFFAF6]/60 p-5 transition hover:border-[#FB4D00]/40 hover:bg-[#FFFAF6] lg:flex-row lg:items-start">

                        {{-- Left Column: Details & Evidence --}}
                        <div class="flex-1 space-y-3">

                            {{-- Tag Alasan, Urgensi, Waktu --}}
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center gap-1 rounded-full bg-[#FFE0D8] px-3 py-1 font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase text-[#A93100]">
                                    <i class="fa-solid fa-triangle-exclamation text-[10px]"></i>
                                    {{ $report->reason }}
                                </span>

                                @if($report->status === 'pending')
                                    <span class="rounded-full bg-[#FFEDE3] px-3 py-1 font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase text-[#FB4D00]">
                                        Tingkat Urgensi: Tinggi
                                    </span>
                                @elseif($report->status === 'resolved')
                                    <span class="rounded-full bg-[#DDF3E4] px-3 py-1 font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase text-[#18794E]">
                                        Selesai Ditindak
                                    </span>
                                @else
                                    <span class="rounded-full bg-[#F1ECE8] px-3 py-1 font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase text-[#796B65]">
                                        Ditolak (Aman)
                                    </span>
                                @endif

                                <span class="text-xs text-[#796B65]">
                                    • Dilaporkan {{ $report->created_at->diffForHumans() }}
                                </span>
                            </div>

                            {{-- Judul Materi Dilaporkan --}}
                            <div>
                                @if($report->article)
                                    <h3 class="font-['Plus_Jakarta_Sans'] text-base font-extrabold text-[#49261D] transition hover:text-[#FB4D00] sm:text-lg">
                                        <a href="{{ route('articles.show', $report->article->slug) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2">
                                            <span>{{ $report->article->title }}</span>
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[11px] text-[#796B65]"></i>
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-xs text-[#796B65]">
                                        Kategori: <strong class="text-[#49261D]">{{ $report->article->category }}</strong>
                                        <span class="px-1 text-[#E9DCD4]">•</span>
                                        Status Terbit:
                                        <strong class="{{ $report->article->is_published ? 'text-[#18794E]' : 'text-[#A93100]' }}">
                                            {{ $report->article->is_published ? 'Aktif Tayang' : 'Disembunyikan (Non-publik)' }}
                                        </strong>
                                    </p>
                                @else
                                    <h3 class="font-['Plus_Jakarta_Sans'] text-base font-extrabold text-[#796B65]">
                                        Artikel Telah Dihapus dari Sistem (ID #{{ $report->article_id }})
                                    </h3>
                                @endif
                            </div>

                            {{-- Bukti & Catatan Aduan --}}
                            <div class="space-y-2 rounded-xl border border-[#E9DCD4]/80 bg-white p-4">
                                <div class="flex items-center justify-between text-[10px] font-extrabold uppercase tracking-wider text-[#796B65]">
                                    <span>Konteks &amp; Catatan Aduan</span>
                                    <span class="text-[#FB4D00] font-bold">Laporan #{{ $report->id }}</span>
                                </div>

                                <p class="text-xs leading-relaxed text-[#49261D]">
                                    <strong class="font-bold text-[#FB4D00]">Catatan Pelapor:</strong>
                                    {{ $report->description ?? 'Tidak ada deskripsi rincian dari pelapor.' }}
                                </p>

                                @if($report->article?->excerpt)
                                    <blockquote class="rounded-lg bg-[#FFFAF6] p-2.5 text-xs italic text-[#796B65] border-l-2 border-[#FB4D00]">
                                        "{{ Str::limit($report->article->excerpt, 200) }}"
                                    </blockquote>
                                @endif
                            </div>

                            {{-- Profil Pelapor & Penulis Asli --}}
                            <div class="flex flex-wrap items-center gap-4 pt-1 text-xs">
                                <div class="flex items-center gap-2">
                                    <div class="grid h-7 w-7 place-items-center rounded-full bg-[#CAE7F7] font-['Plus_Jakarta_Sans'] text-[11px] font-extrabold text-[#001E29]">
                                        {{ strtoupper(substr($report->reporter->name ?? 'P', 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="block font-bold leading-tight text-[#49261D]">
                                            {{ $report->reporter->name ?? 'Mahasiswa Anonim' }}
                                        </span>
                                        <span class="text-[10px] text-[#796B65]">Pelapor</span>
                                    </div>
                                </div>

                                <span class="h-3 w-px bg-[#E9DCD4]"></span>

                                <div class="text-[#796B65]">
                                    Penulis Karya:
                                    <strong class="font-bold text-[#49261D]">
                                        {{ $report->article?->user?->name ?? 'Tidak diketahui' }}
                                    </strong>
                                </div>
                            </div>

                        </div>

                        {{-- Right Column: Moderator Actions --}}
                        <div class="w-full shrink-0 space-y-2 lg:w-60 pt-2 lg:pt-0">
                            <p class="font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-wider text-[#796B65]">
                                Keputusan Moderator
                            </p>

                            @if($report->status === 'pending')
                                {{-- Action 1: Hide --}}
                                <form method="POST" action="{{ route('admin.reports.resolve', $report) }}">
                                    @csrf
                                    <input type="hidden" name="action" value="hide">
                                    <button
                                        type="submit"
                                        onclick="return confirm('Sembunyikan artikel ini dari publik?')"
                                        class="flex w-full items-center justify-center gap-2 rounded-full bg-[#FB4D00] px-4 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-[#D44000]"
                                    >
                                        <i class="fa-solid fa-eye-slash text-xs"></i>
                                        Sembunyikan Konten
                                    </button>
                                </form>

                                {{-- Action 2: Delete --}}
                                <form method="POST" action="{{ route('admin.reports.resolve', $report) }}">
                                    @csrf
                                    <input type="hidden" name="action" value="delete">
                                    <button
                                        type="submit"
                                        onclick="return confirm('PERINGATAN: Artikel akan dihapus permanen. Lanjutkan?')"
                                        class="flex w-full items-center justify-center gap-2 rounded-full border border-[#E9DCD4] bg-white px-4 py-2 text-xs font-bold text-[#A93100] transition hover:border-[#A93100] hover:bg-[#FFE0D8]"
                                    >
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                        Hapus Permanen
                                    </button>
                                </form>

                                {{-- Action 3: Safe / Reject report --}}
                                <form method="POST" action="{{ route('admin.reports.resolve', $report) }}">
                                    @csrf
                                    <input type="hidden" name="action" value="safe">
                                    <button
                                        type="submit"
                                        class="flex w-full items-center justify-center gap-2 rounded-full border border-[#E9DCD4] bg-white px-4 py-2 text-xs font-bold text-[#49261D] transition hover:bg-[#F1ECE8]"
                                    >
                                        <i class="fa-solid fa-check text-xs text-[#18794E]"></i>
                                        Tandai Aman (Lolos)
                                    </button>
                                </form>
                            @else
                                <div class="rounded-xl border border-[#E9DCD4] bg-white p-3 space-y-1">
                                    <span class="inline-flex items-center gap-1 text-[11px] font-bold {{ $report->status === 'resolved' ? 'text-[#18794E]' : 'text-[#796B65]' }}">
                                        <i class="fa-solid fa-circle-check text-xs"></i>
                                        Status: {{ ucfirst($report->status) }}
                                    </span>
                                    @if($report->resolved_at)
                                        <p class="text-[10px] text-[#796B65]">
                                            Diproses: {{ $report->resolved_at->format('d M Y, H:i') }} WIB
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                    </div>
                @empty
                    <div class="py-12 text-center">
                        <div class="mx-auto grid h-16 w-16 place-items-center rounded-full bg-[#CAE7F7] text-[#001E29]">
                            <i class="fa-solid fa-clipboard-check text-2xl text-[#FB4D00]"></i>
                        </div>
                        <h4 class="mt-4 font-['Plus_Jakarta_Sans'] text-lg font-bold text-[#49261D]">
                            Semua Laporan Telah Tuntas
                        </h4>
                        <p class="mt-1 text-xs text-[#796B65] max-w-md mx-auto leading-relaxed">
                            Tidak ada aduan yang tertunda pada kategori ini. Ekosistem percakapan mahasiswa berjalan sesuai standar etika komunitas Interlude.
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination & Audit Log Mini Footer --}}
            <div class="flex flex-col justify-between gap-4 border-t border-[#E9DCD4] pt-5 text-xs text-[#796B65] sm:flex-row sm:items-center">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-[#FB4D00]"></i>
                    <span>Terakhir diaudit: Hari ini pukul {{ now()->format('H.i') }} WIB oleh {{ auth('admin')->user()->name ?? 'Administrator' }}</span>
                </div>

                @if($reports->hasPages())
                    <div>
                        {{ $reports->appends(['status' => $status])->links() }}
                    </div>
                @endif
            </div>

        </div>

        {{-- =========================================================
            PANEL CATATAN DEWAN ETIKA & PANDUAN CEPAT KAMPUS
        ========================================================== --}}
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">

            <div class="space-y-2 rounded-2xl border border-[#E9DCD4] bg-white p-5 shadow-sm">
                <div class="flex items-center gap-2 font-['Plus_Jakarta_Sans'] text-sm font-bold text-[#49261D]">
                    <i class="fa-solid fa-book text-[#FB4D00]"></i>
                    <span>Protokol Hak Cipta &amp; Sitasi</span>
                </div>
                <p class="text-xs leading-relaxed text-[#796B65]">
                    Artikel esai atau ringkasan skripsi dengan kemiripan di atas 30% tanpa kutipan wajib disembunyikan sementara sampai mahasiswa menyertakan surat revisi orisinalitas.
                </p>
            </div>

            <div class="space-y-2 rounded-2xl border border-[#E9DCD4] bg-white p-5 shadow-sm">
                <div class="flex items-center gap-2 font-['Plus_Jakarta_Sans'] text-sm font-bold text-[#49261D]">
                    <i class="fa-solid fa-podcast text-[#FB4D00]"></i>
                    <span>Standar Verifikasi Audio Podcast</span>
                </div>
                <p class="text-xs leading-relaxed text-[#796B65]">
                    Segmen audio yang memuat tautan komersial, donasi ilegal, atau ujaran kebencian antar-fakultas langsung dialihkan ke status non-publik untuk review dewan pleno.
                </p>
            </div>

            <div class="space-y-2 rounded-2xl border border-transparent bg-[#CAE7F7] p-5 shadow-sm text-[#17333F]">
                <div class="flex items-center gap-2 font-['Plus_Jakarta_Sans'] text-sm font-extrabold text-[#001E29]">
                    <i class="fa-solid fa-circle-question text-[#FB4D00]"></i>
                    <span>Bantuan Dewan Editor</span>
                </div>
                <p class="text-xs leading-relaxed text-[#31515D]">
                    Butuh konfirmasi hukum kampus atau koordinasi dengan BEM terkait? Hubungi hotline kurasi etik di Telegram internal <strong class="underline font-bold">@InterludeEthicsHQ</strong>.
                </p>
            </div>

        </div>

    </div>

</x-admin-layout>
