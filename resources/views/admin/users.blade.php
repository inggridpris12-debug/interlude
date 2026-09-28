<x-admin-layout :title="'Kelola Pengguna - Panel Kurator'">

    <div class="space-y-6">

        {{-- Header --}}
        <section class="flex flex-col justify-between gap-5 md:flex-row md:items-end">

            <div>
                <p class="mb-2 font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-[0.14em] text-[#FB4D00]">
                    Panel Kurator
                </p>

                <h1 class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold tracking-[-0.04em] text-[#49261D] sm:text-4xl">
                    Daftar Pengguna
                </h1>

                <p class="mt-2 max-w-2xl text-sm text-[#796B65]">
                    Kelola dan pantau mahasiswa yang terdaftar di platform Interlude lintas kampus.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-2 rounded-full border border-[#E9DCD4] bg-white px-3.5 py-2 text-xs font-bold text-[#49261D] shadow-sm">
                    <i class="fa-solid fa-users text-[#FB4D00]"></i>
                    {{ number_format($users->total()) }} Mahasiswa
                </span>
            </div>

        </section>

        {{-- Search & Filters --}}
        <section class="rounded-2xl border border-[#E9DCD4] bg-white p-4 shadow-sm">
            <form method="GET" action="{{ route('admin.users') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="relative flex-1 max-w-lg">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[#796B65]">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input
                        type="search"
                        name="q"
                        value="{{ $search }}"
                        placeholder="Cari berdasarkan nama atau email pengguna..."
                        class="w-full rounded-full border border-[#E9DCD4] bg-[#FFFAF6] py-2.5 pl-10 pr-4 text-xs text-[#49261D] placeholder-[#796B65]/70 focus:border-[#FB4D00] focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#FB4D00]"
                    >
                </div>

                <div class="flex items-center gap-2">
                    @if($search)
                        <a
                            href="{{ route('admin.users') }}"
                            class="inline-flex items-center gap-1.5 rounded-full border border-[#E9DCD4] bg-white px-3 py-2 text-xs font-bold text-[#796B65] transition hover:bg-[#F1ECE8]"
                        >
                            <i class="fa-solid fa-xmark text-[10px]"></i>
                            Reset
                        </a>
                    @endif

                    <button
                        type="submit"
                        class="inline-flex items-center gap-1.5 rounded-full bg-[#49261D] px-5 py-2.5 text-xs font-bold text-white transition hover:bg-[#FB4D00]"
                    >
                        <i class="fa-solid fa-filter text-[10px]"></i>
                        Cari
                    </button>
                </div>
            </form>
        </section>

        {{-- Users Table --}}
        <section class="overflow-hidden rounded-2xl border border-[#E9DCD4] bg-white shadow-sm">

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-[#E9DCD4] bg-[#FFFAF6]">
                            <th class="px-5 py-3.5 font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-wider text-[#796B65]">
                                Mahasiswa
                            </th>
                            <th class="px-5 py-3.5 font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-wider text-[#796B65]">
                                Email Kampus / Kontak
                            </th>
                            <th class="px-5 py-3.5 font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-wider text-[#796B65] text-center">
                                Artikel Terbit
                            </th>
                            <th class="px-5 py-3.5 font-['Plus_Jakarta_Sans'] text-[10px] font-extrabold uppercase tracking-wider text-[#796B65]">
                                Bergabung Sejak
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E9DCD4]/70">
                        @forelse($users as $user)
                            <tr class="transition hover:bg-[#FFFAF6]/80">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="grid h-10 w-10 shrink-0 place-items-center rounded-xl font-['Plus_Jakarta_Sans'] text-sm font-extrabold text-[#49261D]
                                            {{ $loop->iteration % 3 === 0 ? 'bg-[#CAE7F7] text-[#001E29]' : ($loop->iteration % 3 === 1 ? 'bg-[#FFEDE3] text-[#FB4D00]' : 'bg-[#F1ECE8] text-[#49261D]') }}">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="truncate font-['Plus_Jakarta_Sans'] text-sm font-bold text-[#49261D]">
                                                {{ $user->name }}
                                            </p>
                                            <p class="text-[11px] text-[#796B65]">
                                                ID: #{{ $user->id }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-xs text-[#796B65]">
                                    <div class="flex items-center gap-1.5 font-medium text-[#49261D]">
                                        <i class="fa-regular fa-envelope text-[11px] text-[#796B65]"></i>
                                        <span>{{ $user->email }}</span>
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-bold
                                        {{ $user->articles_count > 0 ? 'bg-[#FFEDE3] text-[#FB4D00]' : 'bg-[#F1ECE8] text-[#796B65]' }}">
                                        <i class="fa-solid fa-book-open text-[9px]"></i>
                                        {{ number_format($user->articles_count) }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-xs text-[#796B65]">
                                    {{ $user->created_at?->format('d M Y') ?? '-' }}
                                    <span class="block text-[10px] text-[#796B65]/70">
                                        {{ $user->created_at?->diffForHumans() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-12 text-center">
                                    <div class="mx-auto max-w-sm">
                                        <div class="mx-auto mb-3 grid h-12 w-12 place-items-center rounded-full bg-[#F1ECE8] text-[#796B65]">
                                            <i class="fa-solid fa-user-slash text-lg"></i>
                                        </div>
                                        <h3 class="font-['Plus_Jakarta_Sans'] text-sm font-bold text-[#49261D]">
                                            Tidak Ada Pengguna Ditemukan
                                        </h3>
                                        <p class="mt-1 text-xs text-[#796B65]">
                                            @if($search)
                                                Tidak ada hasil untuk pencarian "<span class="font-bold text-[#49261D]">{{ $search }}</span>".
                                            @else
                                                Belum ada pengguna yang terdaftar di platform.
                                            @endif
                                        </p>
                                        @if($search)
                                            <a
                                                href="{{ route('admin.users') }}"
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

            @if($users->hasPages())
                <div class="border-t border-[#E9DCD4] bg-[#FFFAF6] p-4">
                    {{ $users->appends(['q' => $search])->links() }}
                </div>
            @endif

        </section>

    </div>

</x-admin-layout>
