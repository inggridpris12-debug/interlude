<x-admin-layout :title="'Ringkasan Interlude'">

    <div class="space-y-6">

        {{-- Header / Welcome --}}
        <section class="flex flex-col justify-between gap-5 md:flex-row md:items-end">

            <div>
                <p class="mb-2 font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-[0.14em] text-[#FB4D00]">
                    Panel Kurator
                </p>

                <h1 class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold tracking-[-0.04em] text-[#49261D] sm:text-4xl">
                    Ringkasan Interlude
                </h1>

                <p class="mt-2 max-w-2xl text-sm text-[#796B65]">
                    Pantau aktivitas komunitas, publikasi cerita, dan antrean moderasi kampus dari satu tempat.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a
                    href="{{ url('/') }}"
                    target="_blank"
                    rel="noopener"
                    class="inline-flex items-center gap-2 rounded-full border border-[#E9DCD4] bg-white px-4 py-2.5 text-xs font-bold text-[#49261D] transition hover:bg-[#FFFAF6]"
                >
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    Lihat Situs
                </a>

                <a
                    href="{{ route('admin.reports') }}"
                    class="inline-flex items-center gap-2 rounded-full bg-[#49261D] px-4 py-2.5 text-xs font-bold text-white transition hover:bg-[#FB4D00]"
                >
                    <i class="fa-solid fa-shield-halved text-xs"></i>
                    Buka Moderasi
                </a>
            </div>

        </section>

        {{-- Statistics Cards --}}
        <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Metric 1: Total Mahasiswa / Users --}}
            <article class="rounded-2xl border border-[#E9DCD4] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-wider text-[#796B65]">
                            Total Mahasiswa
                        </p>
                        <p class="mt-2 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold tracking-tight text-[#49261D]">
                            {{ number_format($stats['total_users']) }}
                        </p>
                        <p class="mt-1 text-[11px] text-[#796B65]">
                            Pengguna terdaftar
                        </p>
                    </div>
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#CAE7F7] text-[#17333F]">
                        <i class="fa-solid fa-graduation-cap text-base"></i>
                    </span>
                </div>
            </article>

            {{-- Metric 2: Total Artikel / Cerita Terbit --}}
            <article class="rounded-2xl border border-[#E9DCD4] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-wider text-[#796B65]">
                            Cerita Disetujui
                        </p>
                        <p class="mt-2 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold tracking-tight text-[#49261D]">
                            {{ number_format($stats['total_articles']) }}
                        </p>
                        <p class="mt-1 text-[11px] text-[#796B65]">
                            Artikel yang dipublikasi
                        </p>
                    </div>
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#FFEDE3] text-[#FB4D00]">
                        <i class="fa-solid fa-book-open text-base"></i>
                    </span>
                </div>
            </article>

            {{-- Metric 3: Laporan Pending (Highlight) --}}
            <article class="rounded-2xl border border-[#E9DCD4] bg-[#F1ECE8] p-5 transition hover:-translate-y-0.5 hover:shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-wider text-[#A93100]">
                            Antrean Pending
                        </p>
                        <p class="mt-2 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold tracking-tight text-[#FB4D00]">
                            {{ number_format($stats['pending_reports']) }}
                        </p>
                        <p class="mt-1 text-[11px] text-[#796B65]">
                            Kasus aktif mendesak
                        </p>
                    </div>
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#FFE0D8] text-[#A93100]">
                        <i class="fa-solid fa-flag text-base"></i>
                    </span>
                </div>
            </article>

            {{-- Metric 4: Total Laporan --}}
            <article class="rounded-2xl border border-[#E9DCD4] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-wider text-[#796B65]">
                            Total Laporan
                        </p>
                        <p class="mt-2 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold tracking-tight text-[#49261D]">
                            {{ number_format($stats['total_reports']) }}
                        </p>
                        <p class="mt-1 text-[11px] text-[#796B65]">
                            Semua status peninjauan
                        </p>
                    </div>
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#FFEDE3] text-[#49261D]">
                        <i class="fa-solid fa-shield-halved text-base"></i>
                    </span>
                </div>
            </article>

        </section>

        {{-- Main Section: Recent Reports + Guide --}}
        <section class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1.7fr)_minmax(300px,0.9fr)]">

            {{-- Recent Reports --}}
            <article class="rounded-2xl border border-[#E9DCD4] bg-white p-5 sm:p-6 shadow-sm">

                <div class="flex items-start justify-between gap-4 border-b border-[#E9DCD4] pb-4">
                    <div>
                        <h2 class="font-['Plus_Jakarta_Sans'] text-lg font-extrabold tracking-tight text-[#49261D]">
                            Laporan Terbaru
                        </h2>
                        <p class="mt-0.5 text-xs text-[#796B65]">
                            Aktivitas pengaduan dan moderasi terakhir dari komunitas
                        </p>
                    </div>

                    <a
                        href="{{ route('admin.reports') }}"
                        class="inline-flex shrink-0 items-center gap-1.5 text-xs font-bold text-[#FB4D00] hover:underline"
                    >
                        Lihat semua
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <div class="divide-y divide-[#E9DCD4]/70">
                    @forelse($recentReports as $report)
                        <div class="flex flex-col justify-between gap-4 py-4 sm:flex-row sm:items-center">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-[9px] font-extrabold uppercase tracking-wide
                                        {{ $report->status === 'pending' ? 'bg-[#FFE0D8] text-[#A93100]' : ($report->status === 'resolved' ? 'bg-[#DDF3E4] text-[#18794E]' : 'bg-[#F1ECE8] text-[#796B65]') }}">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                    <span class="text-[11px] text-[#796B65]">
                                        {{ $report->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <h3 class="mt-2 truncate font-['Plus_Jakarta_Sans'] text-sm font-bold text-[#49261D]">
                                    {{ $report->article?->title ?? 'Artikel telah dihapus' }}
                                </h3>

                                <p class="mt-1 text-xs text-[#796B65]">
                                    Alasan: <strong class="text-[#49261D]">{{ $report->reason }}</strong>
                                    @if($report->reporter)
                                        <span class="px-1 text-[#E9DCD4]">•</span> Pelapor: {{ $report->reporter->name }}
                                    @endif
                                </p>
                            </div>

                            <div class="shrink-0">
                                @if($report->status === 'pending')
                                    <a
                                        href="{{ route('admin.reports', ['status' => 'pending']) }}"
                                        class="inline-flex items-center gap-1.5 rounded-full bg-[#49261D] px-3.5 py-2 text-xs font-bold text-white transition hover:bg-[#FB4D00]"
                                    >
                                        <i class="fa-solid fa-magnifying-glass text-[10px]"></i>
                                        Tinjau
                                    </a>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-[#796B65]">
                                        <i class="fa-solid fa-check text-[#18794E]"></i> Ditangani
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="grid min-h-[180px] place-items-center py-10 text-center">
                            <div>
                                <i class="fa-solid fa-inbox text-3xl text-[#E9DCD4]"></i>
                                <p class="mt-3 text-xs font-medium text-[#796B65]">
                                    Belum ada antrean laporan saat ini.
                                </p>
                            </div>
                        </div>
                    @endforelse
                </div>

            </article>

            {{-- Alur Panel Kurator & Quick Access --}}
            <div class="space-y-4">

                <article class="rounded-2xl border border-transparent bg-[#CAE7F7] p-5 sm:p-6 text-[#17333F]">
                    <span class="grid h-10 w-10 place-items-center rounded-full bg-white text-[#FB4D00] shadow-sm">
                        <i class="fa-solid fa-compass text-base"></i>
                    </span>

                    <h2 class="mt-4 font-['Plus_Jakarta_Sans'] text-lg font-extrabold tracking-tight text-[#001E29]">
                        Alur Panel Kurator
                    </h2>

                    <p class="mt-2 text-xs leading-5 text-[#31515D]">
                        Gunakan menu di sebelah kiri untuk mengawasi ketertiban ruang publik mahasiswa Interlude. Pastikan setiap aduan ditinjau secara objektif dan berkeadilan.
                    </p>

                    <div class="mt-5 grid gap-2.5">
                        <a
                            href="{{ route('admin.users') }}"
                            class="flex items-center justify-between rounded-xl bg-white/90 px-3.5 py-3 text-xs font-bold text-[#49261D] shadow-sm transition hover:bg-white"
                        >
                            <span class="flex items-center gap-2.5">
                                <i class="fa-solid fa-users text-[#FB4D00]"></i>
                                Kelola Pengguna Mahasiswa
                            </span>
                            <i class="fa-solid fa-chevron-right text-[10px] text-[#796B65]"></i>
                        </a>

                        <a
                            href="{{ route('admin.reports') }}"
                            class="flex items-center justify-between rounded-xl bg-white/90 px-3.5 py-3 text-xs font-bold text-[#49261D] shadow-sm transition hover:bg-white"
                        >
                            <span class="flex items-center gap-2.5">
                                <i class="fa-solid fa-shield-halved text-[#FB4D00]"></i>
                                Moderasi &amp; Laporan Masuk
                            </span>
                            <i class="fa-solid fa-chevron-right text-[10px] text-[#796B65]"></i>
                        </a>
                    </div>
                </article>

                <article class="rounded-2xl border border-[#E9DCD4] bg-white p-5">
                    <div class="flex items-center gap-2 text-xs font-bold text-[#49261D]">
                        <i class="fa-solid fa-circle-info text-[#FB4D00]"></i>
                        <span>Status Sistem Moderasi</span>
                    </div>
                    <p class="mt-2 text-[11px] leading-relaxed text-[#796B65]">
                        Sistem laporan memantau artikel secara berkala. Pelapor yang telah terverifikasi mendapatkan prioritas penanganan lebih cepat.
                    </p>
                </article>

            </div>

        </section>

    </div>

</x-admin-layout>
