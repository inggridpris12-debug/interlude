<x-admin-layout :title="'Podcast Hub - Panel Kurator'">

    <div class="space-y-6">

        @include('admin.partials.flash')

        {{-- Header --}}
        <section class="flex flex-col justify-between gap-5 md:flex-row md:items-end">

            <div>
                <p class="mb-2 font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-[0.14em] text-[#FB4D00]">
                    Panel Kurator
                </p>

                <h1 class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold tracking-[-0.04em] text-[#49261D] sm:text-4xl">
                    Podcast Hub
                </h1>

                <p class="mt-2 max-w-2xl text-sm text-[#796B65]">
                    Awasi seluruh episode audio dan video mahasiswa, lalu tentukan mana yang layak tampil di portal.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-2 rounded-full border border-[#E9DCD4] bg-white px-3.5 py-2 text-xs font-bold text-[#49261D] shadow-sm">
                    <i class="fa-solid fa-podcast text-[#FB4D00]"></i>
                    {{ number_format($stats['total']) }} Episode
                </span>
            </div>

        </section>

        {{-- Stat Cards --}}
        <section class="grid grid-cols-2 gap-4 xl:grid-cols-4">

            <article class="rounded-2xl border border-[#E9DCD4] bg-white p-5">
                <p class="font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-wider text-[#796B65]">
                    Terpublikasi
                </p>
                <p class="mt-2 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold tracking-tight text-[#49261D]">
                    {{ number_format($stats['published']) }}
                </p>
            </article>

            <article class="rounded-2xl border border-[#E9DCD4] bg-white p-5">
                <p class="font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-wider text-[#796B65]">
                    Draf
                </p>
                <p class="mt-2 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold tracking-tight text-[#49261D]">
                    {{ number_format($stats['draft']) }}
                </p>
            </article>

            <article class="rounded-2xl border border-[#E9DCD4] bg-white p-5">
                <p class="font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-wider text-[#796B65]">
                    Audio
                </p>
                <p class="mt-2 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold tracking-tight text-[#49261D]">
                    {{ number_format($stats['audio']) }}
                </p>
            </article>

            <article class="rounded-2xl border border-[#E9DCD4] bg-[#CAE7F7] p-5">
                <p class="font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-wider text-[#31515D]">
                    Video
                </p>
                <p class="mt-2 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold tracking-tight text-[#001E29]">
                    {{ number_format($stats['video']) }}
                </p>
            </article>

        </section>

        {{-- Status Tabs --}}
        @php
            $statusTabs = [
                'all' => 'Semua Status',
                'published' => 'Terpublikasi',
                'draft' => 'Draf',
            ];

            $typeTabs = [
                'all' => 'Semua Format',
                'audio' => 'Audio',
                'video' => 'Video',
            ];
        @endphp

        <section class="flex flex-wrap items-center gap-2">
            @foreach($statusTabs as $key => $label)
                <a
                    href="{{ route('admin.podcasts', array_filter(['status' => $key, 'type' => $type !== 'all' ? $type : null, 'q' => $search ?: null])) }}"
                    class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-bold transition {{ $status === $key ? 'bg-[#49261D] text-white' : 'border border-[#E9DCD4] bg-white text-[#49261D] hover:bg-[#FFFAF6]' }}"
                >
                    {{ $label }}
                </a>
            @endforeach
        </section>

        {{-- Search & Filter --}}
        <section class="rounded-2xl border border-[#E9DCD4] bg-white p-4 shadow-sm">
            <form method="GET" action="{{ route('admin.podcasts') }}" class="flex flex-col gap-3 lg:flex-row lg:items-center">
                <input type="hidden" name="status" value="{{ $status }}">

                <div class="relative flex-1">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#796B65]">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input
                        type="search"
                        name="q"
                        value="{{ $search }}"
                        placeholder="Cari judul episode, kategori, atau kreator..."
                        class="w-full rounded-full border border-[#E9DCD4] bg-[#FFFAF6] py-2.5 pl-10 pr-4 text-xs text-[#49261D] placeholder-[#796B65]/70 focus:border-[#FB4D00] focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#FB4D00]"
                    >
                </div>

                <select
                    name="type"
                    class="rounded-full border border-[#E9DCD4] bg-[#FFFAF6] px-4 py-2.5 text-xs font-bold text-[#49261D] focus:border-[#FB4D00] focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#FB4D00]"
                >
                    @foreach($typeTabs as $key => $label)
                        <option value="{{ $key }}" @selected($type === $key)>{{ $label }}</option>
                    @endforeach
                </select>

                <div class="flex items-center gap-2">
                    <button
                        type="submit"
                        class="inline-flex items-center gap-1.5 rounded-full bg-[#49261D] px-5 py-2.5 text-xs font-bold text-white transition hover:bg-[#FB4D00]"
                    >
                        <i class="fa-solid fa-filter text-[10px]"></i>
                        Terapkan
                    </button>

                    @if($search || $type !== 'all' || $status !== 'all')
                        <a
                            href="{{ route('admin.podcasts') }}"
                            class="inline-flex items-center gap-1.5 rounded-full border border-[#E9DCD4] bg-white px-3 py-2 text-xs font-bold text-[#796B65] transition hover:bg-[#F1ECE8]"
                        >
                            <i class="fa-solid fa-xmark text-[10px]"></i>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </section>

        {{-- Podcasts Table --}}
        <section class="overflow-hidden rounded-2xl border border-[#E9DCD4] bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="border-b border-[#E9DCD4] bg-[#FFFAF6] text-[10px] font-extrabold uppercase tracking-wider text-[#796B65]">
                            <th class="px-5 py-3.5">Episode</th>
                            <th class="px-5 py-3.5">Format</th>
                            <th class="px-5 py-3.5 text-center">Status</th>
                            <th class="px-5 py-3.5 text-center">Statistik</th>
                            <th class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E9DCD4]/70">
                        @forelse($podcasts as $podcast)
                            @php
                                $cover = $podcast->cover_image ?: $podcast->thumbnail_image;
                            @endphp

                            <tr class="align-top hover:bg-[#FFFAF6]">
                                <td class="px-5 py-4">
                                    <div class="flex items-start gap-3">
                                        <div class="grid h-12 w-12 shrink-0 place-items-center overflow-hidden rounded-xl bg-[#CAE7F7] text-[#17333F]">
                                            @if($cover)
                                                <img src="{{ asset('storage/'.$cover) }}" alt="" class="h-full w-full object-cover">
                                            @else
                                                <i class="fa-solid fa-podcast"></i>
                                            @endif
                                        </div>

                                        <div class="min-w-0 max-w-xs">
                                            <p class="truncate font-['Plus_Jakarta_Sans'] text-sm font-bold text-[#49261D]">
                                                {{ $podcast->title }}
                                            </p>
                                            <p class="mt-0.5 text-[11px] text-[#796B65]">
                                                <i class="fa-regular fa-user text-[9px]"></i>
                                                {{ $podcast->user->name ?? 'Tanpa kreator' }}
                                                @if($podcast->series)
                                                    <span class="px-1 text-[#E9DCD4]">•</span>
                                                    {{ $podcast->series->title }}
                                                @endif
                                            </p>
                                            @if($podcast->episode_number)
                                                <p class="mt-0.5 text-[10px] font-bold text-[#796B65]/80">
                                                    Episode #{{ $podcast->episode_number }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex flex-col items-start gap-1.5">
                                        <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wide {{ $podcast->media_type === 'video' ? 'bg-[#CAE7F7] text-[#001E29]' : 'bg-[#FFEDE3] text-[#FB4D00]' }}">
                                            <i class="fa-solid {{ $podcast->media_type === 'video' ? 'fa-video' : 'fa-headphones' }} text-[9px]"></i>
                                            {{ $podcast->media_type === 'video' ? 'Video' : 'Audio' }}
                                        </span>

                                        @if($podcast->duration_seconds)
                                            <span class="inline-flex items-center gap-1 text-[11px] text-[#796B65]">
                                                <i class="fa-regular fa-clock text-[9px]"></i>
                                                {{ $podcast->formatted_duration }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-wide {{ $podcast->is_published ? 'bg-[#DDF3E4] text-[#18794E]' : 'bg-[#F1ECE8] text-[#796B65]' }}">
                                        {{ $podcast->is_published ? 'Publik' : 'Draf' }}
                                    </span>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-3 text-[11px] text-[#796B65]">
                                        <span class="inline-flex items-center gap-1" title="Diputar">
                                            <i class="fa-regular fa-eye"></i>{{ number_format($podcast->views_count) }}
                                        </span>
                                        <span class="inline-flex items-center gap-1" title="Suka">
                                            <i class="fa-regular fa-heart"></i>{{ number_format($podcast->likes_count) }}
                                        </span>
                                        <span class="inline-flex items-center gap-1" title="Komentar">
                                            <i class="fa-regular fa-comment"></i>{{ number_format($podcast->comments_count) }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex flex-wrap items-center justify-end gap-1.5">

                                        {{-- Publikasi --}}
                                        <form method="POST" action="{{ route('admin.podcasts.publish', $podcast) }}">
                                            @csrf
                                            <button
                                                type="submit"
                                                title="{{ $podcast->is_published ? 'Sembunyikan dari publik' : 'Publikasikan' }}"
                                                class="grid h-8 w-8 place-items-center rounded-lg border border-[#E9DCD4] bg-white text-[#49261D] transition hover:border-[#49261D] hover:bg-[#49261D] hover:text-white"
                                            >
                                                <i class="fa-solid {{ $podcast->is_published ? 'fa-eye-slash' : 'fa-eye' }} text-[11px]"></i>
                                            </button>
                                        </form>

                                        {{-- Lihat --}}
                                        <a
                                            href="{{ route('podcasts.show', $podcast->slug) }}"
                                            target="_blank"
                                            rel="noopener"
                                            title="Buka episode"
                                            class="grid h-8 w-8 place-items-center rounded-lg border border-[#E9DCD4] bg-white text-[#49261D] transition hover:border-[#49261D] hover:bg-[#49261D] hover:text-white"
                                        >
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                        </a>

                                        {{-- Hapus --}}
                                        <form
                                            method="POST"
                                            action="{{ route('admin.podcasts.destroy', $podcast) }}"
                                            onsubmit="return confirm('Hapus episode podcast ini beserta berkas medianya?');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                title="Hapus episode"
                                                class="grid h-8 w-8 place-items-center rounded-lg border border-[#FFD0C3] bg-white text-[#A93100] transition hover:border-[#A93100] hover:bg-[#A93100] hover:text-white"
                                            >
                                                <i class="fa-solid fa-trash text-[11px]"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-14 text-center">
                                    <div class="mx-auto max-w-sm">
                                        <div class="mx-auto mb-3 grid h-12 w-12 place-items-center rounded-full bg-[#F1ECE8] text-[#796B65]">
                                            <i class="fa-solid fa-podcast text-lg"></i>
                                        </div>
                                        <h3 class="font-['Plus_Jakarta_Sans'] text-sm font-bold text-[#49261D]">
                                            Tidak Ada Episode Ditemukan
                                        </h3>
                                        <p class="mt-1 text-xs text-[#796B65]">
                                            @if($search || $type !== 'all' || $status !== 'all')
                                                Belum ada episode yang cocok dengan filter saat ini.
                                            @else
                                                Belum ada podcast yang diunggah mahasiswa.
                                            @endif
                                        </p>
                                        @if($search || $type !== 'all' || $status !== 'all')
                                            <a
                                                href="{{ route('admin.podcasts') }}"
                                                class="mt-3 inline-flex items-center gap-1.5 rounded-full bg-[#49261D] px-4 py-1.5 text-xs font-bold text-white hover:bg-[#FB4D00]"
                                            >
                                                Tampilkan Semua
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($podcasts->hasPages())
                <div class="border-t border-[#E9DCD4] bg-[#FFFAF6] p-4">
                    {{ $podcasts->links() }}
                </div>
            @endif
        </section>

    </div>

</x-admin-layout>