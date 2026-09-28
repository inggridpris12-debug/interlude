<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Panel Kurator' }} - {{ config('app.name', 'Interlude') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#FFFAF6] font-['DM_Sans'] text-[#49261D] antialiased">

    <div
        x-data="{ sidebarOpen: false }"
        class="min-h-screen"
    >

        {{-- Mobile backdrop --}}
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-[#49261D]/40 lg:hidden"
            aria-hidden="true"
        ></div>

        {{-- =========================================================
            SIDEBAR
        ========================================================== --}}
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 flex w-[270px] flex-col border-r border-[#E9DCD4] bg-white transition-transform duration-200 ease-out"
        >

            {{-- Brand --}}
            <div class="px-5 pb-4 pt-6">

                <a
                    href="{{ url('/') }}"
                    class="flex items-center gap-3"
                >
                    <img
                        src="{{ asset('images/logo-interlude.png') }}"
                        alt="Interlude"
                        class="h-10 w-auto object-contain"
                    >

                    <div>
                        <div class="font-['Plus_Jakarta_Sans'] text-xl font-extrabold tracking-[-0.03em] text-[#49261D]">
                            Interlude
                        </div>

                        <div class="mt-0.5 text-[9px] font-extrabold uppercase tracking-[0.14em] text-[#FB4D00]">
                            Panel Kurator
                        </div>
                    </div>
                </a>

            </div>

            {{-- Portal --}}
            <div class="px-4 pb-4">

                <a
                    href="{{ url('/') }}"
                    target="_blank"
                    rel="noopener"
                    class="flex items-center justify-center gap-2 rounded-xl bg-[#49261D] px-4 py-3 text-sm font-bold text-white transition hover:bg-[#FB4D00]"
                >
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    Kunjungi Portal
                </a>

            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto px-3 pb-5">

                <p class="px-3 pb-2 pt-3 text-[10px] font-extrabold uppercase tracking-[0.13em] text-[#796B65]">
                    Menu Kurator
                </p>

                {{-- Ringkasan --}}
                <a
                    href="{{ route('admin.dashboard_admin') }}"
                    class="group mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition {{ request()->routeIs('admin.dashboard_admin') ? 'bg-[#49261D] text-white shadow-[0_10px_24px_rgba(73,38,29,0.16)]' : 'text-[#49261D] hover:bg-[#FFFAF6]' }}"
                >
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-[10px] transition {{ request()->routeIs('admin.dashboard_admin') ? 'bg-white/15 text-white' : 'bg-[#FFEDE3] text-[#49261D] group-hover:bg-white' }}">
                        <i class="fa-solid fa-chart-pie text-sm"></i>
                    </span>

                    <span>Ringkasan</span>
                </a>

                {{-- Pengguna --}}
                <a
                    href="{{ route('admin.users') }}"
                    class="group mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition {{ request()->routeIs('admin.users') ? 'bg-[#49261D] text-white shadow-[0_10px_24px_rgba(73,38,29,0.16)]' : 'text-[#49261D] hover:bg-[#FFFAF6]' }}"
                >
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-[10px] transition {{ request()->routeIs('admin.users') ? 'bg-white/15 text-white' : 'bg-[#FFEDE3] text-[#49261D] group-hover:bg-white' }}">
                        <i class="fa-solid fa-users text-sm"></i>
                    </span>

                    <span>Pengguna</span>
                </a>

                {{-- Artikel --}}
                <a
                    href="#"
                    class="group mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold text-[#49261D] transition hover:bg-[#FFFAF6]"
                >
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-[10px] bg-[#FFEDE3] text-[#49261D] transition group-hover:bg-white">
                        <i class="fa-solid fa-newspaper text-sm"></i>
                    </span>

                    <span>Artikel &amp; Kurasi</span>
                </a>

                {{-- Podcast --}}
                <div class="mb-1 flex cursor-not-allowed items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold text-[#49261D]/45">

                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-[10px] bg-[#FFEDE3]/60">
                        <i class="fa-solid fa-podcast text-sm"></i>
                    </span>

                    <span>Podcast Hub</span>

                    <span class="ml-auto rounded-full bg-[#F1ECE8] px-2 py-1 text-[8px] font-extrabold uppercase tracking-wide text-[#796B65]">
                        Segera
                    </span>

                </div>

                {{-- Reports --}}
                <a
                    href="{{ route('admin.reports') }}"
                    class="group mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition {{ request()->routeIs('admin.reports*') ? 'bg-[#49261D] text-white shadow-[0_10px_24px_rgba(73,38,29,0.16)]' : 'text-[#49261D] hover:bg-[#FFFAF6]' }}"
                >
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-[10px] transition {{ request()->routeIs('admin.reports*') ? 'bg-white/15 text-white' : 'bg-[#FFEDE3] text-[#49261D] group-hover:bg-white' }}">
                        <i class="fa-solid fa-shield-halved text-sm"></i>
                    </span>

                    <span>Moderasi &amp; Laporan</span>
                </a>


                {{-- Settings --}}
                <a
                    href="#"
                    class="group mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold text-[#49261D] transition hover:bg-[#FFFAF6]"
                >
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-[10px] bg-[#FFEDE3] text-[#49261D] transition group-hover:bg-white">
                        <i class="fa-solid fa-sliders text-sm"></i>
                    </span>

                    <span>Pengaturan</span>
                </a>

            </nav>

            {{-- Admin profile --}}
            <div class="border-t border-[#E9DCD4] bg-[#FFFAF6] p-3">

                <div class="flex items-center gap-3 rounded-xl bg-white p-3">

                    <div class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#FB4D00] font-['Plus_Jakarta_Sans'] text-sm font-extrabold text-white">
                        {{ strtoupper(substr(auth('admin')->user()->name ?? 'A', 0, 1)) }}
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="truncate font-['Plus_Jakarta_Sans'] text-sm font-bold text-[#49261D]">
                            {{ auth('admin')->user()->name ?? 'Admin' }}
                        </p>

                        <p class="truncate text-xs text-[#796B65]">
                            Kurator Interlude
                        </p>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('admin.logout') }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            title="Keluar"
                            class="grid h-9 w-9 place-items-center rounded-lg border border-[#E9DCD4] bg-white text-[#49261D] transition hover:border-[#49261D] hover:bg-[#49261D] hover:text-white"
                        >
                            <i class="fa-solid fa-right-from-bracket text-xs"></i>
                        </button>
                    </form>

                </div>

            </div>

        </aside>


        {{-- =========================================================
            MAIN
        ========================================================== --}}
        <main class="min-h-screen lg:pl-[270px]">

            {{-- Topbar --}}
            <header class="sticky top-0 z-30 flex h-[72px] items-center justify-between border-b border-[#E9DCD4]/70 bg-[#FFFAF6]/90 px-4 backdrop-blur-md sm:px-6 lg:px-10">

                <div class="flex min-w-0 items-center gap-3">

                    <button
                        type="button"
                        @click="sidebarOpen = !sidebarOpen"
                        class="grid h-10 w-10 shrink-0 place-items-center rounded-xl border border-[#E9DCD4] bg-white text-[#49261D] lg:hidden"
                        aria-label="Buka menu"
                    >
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <div class="min-w-0">
                        <p class="text-[9px] font-extrabold uppercase tracking-[0.13em] text-[#FB4D00]">
                            Dewan Kurasi Kampus
                        </p>

                        <p class="truncate font-['Plus_Jakarta_Sans'] text-sm font-bold text-[#49261D] sm:text-base">
                            Panel Kurator
                        </p>
                    </div>

                </div>

                <div class="flex items-center gap-2 sm:gap-4">

                    <span class="hidden rounded-full bg-[#CAE7F7] px-3 py-1.5 text-[10px] font-bold text-[#31515D] sm:inline-flex">
                        Admin Mode
                    </span>

                    <a
                        href="{{ url('/') }}"
                        target="_blank"
                        rel="noopener"
                        class="hidden items-center gap-2 text-xs font-bold text-[#49261D] transition hover:text-[#FB4D00] sm:inline-flex"
                    >
                        Lihat Portal
                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                    </a>

                    <div class="grid h-9 w-9 place-items-center rounded-xl bg-[#49261D] font-['Plus_Jakarta_Sans'] text-xs font-extrabold text-white">
                        {{ strtoupper(substr(auth('admin')->user()->name ?? 'A', 0, 1)) }}
                    </div>

                </div>

            </header>

            {{-- Content --}}
            <div class="px-4 py-6 sm:px-6 lg:px-10 lg:py-8">

                <div class="mx-auto w-full max-w-[1280px]">
                    {{ $slot }}
                </div>

            </div>

        </main>

    </div>

    @stack('scripts')

</body>
</html>