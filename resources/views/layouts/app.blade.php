<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Interlude') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --linen: #FFEDE3;
            --tangelo: #FB4D00;
            --tangelo-dark: #D44000;
            --brown: #49261D;
            --brown-dark: #30120A;
            --blue: #CAE7F7;
            --cream: #FFFAF6;
            --white: #FFFFFF;
            --text-soft: #705D55;
            --border: #E9DCD4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--brown);
            line-height: 1.6;
            overflow-x: hidden;
        }

        button,
        input {
            font: inherit;
        }

        button {
            border: 0;
        }

        /* =====================================================
           NAVBAR
           Tinggi desktop 90px dan logo 75px tetap dipertahankan.
        ===================================================== */
        .navbar {
            height: 90px;
            padding: 0 7%;
            display: grid;
            grid-template-columns: minmax(130px, 1fr) auto minmax(430px, 1fr);
            align-items: center;
            gap: 28px;
            background: rgba(255, 255, 255, 0.96);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        /* LOGO */
        .logo-section {
            display: flex;
            align-items: center;
            width: fit-content;
            text-decoration: none;
        }

        .logo-img {
            height: 75px;
            width: auto;
            object-fit: contain;
            display: block;
        }

        /* =====================================================
           MENU UTAMA
           Disederhanakan: Beranda, Jelajahi, Podcast
        ===================================================== */
        .nav-menu {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 6px;
            background: var(--linen);
            border: 1px solid rgba(73, 38, 29, 0.10);
            border-radius: 999px;
            box-shadow: 0 3px 12px rgba(73, 38, 29, 0.035);
            white-space: nowrap;
        }

        .nav-menu a {
            min-height: 38px;
            padding: 9px 19px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            line-height: 1;
            font-weight: 650;
            color: var(--text-soft);
            text-decoration: none;
            transition:
                background .2s ease,
                color .2s ease,
                box-shadow .2s ease,
                transform .2s ease;
        }

        .nav-menu a:hover {
            color: var(--brown);
            background: rgba(255, 255, 255, .62);
        }

        .nav-menu a.active {
            background: var(--brown);
            color: var(--white);
            font-weight: 700;
            box-shadow: 0 5px 14px rgba(73, 38, 29, 0.16);
        }

        .nav-menu a.active:hover {
            background: var(--brown-dark);
            color: var(--white);
        }

        /* =====================================================
           RIGHT ACTIONS
        ===================================================== */
        .nav-right {
            position: relative;
            min-width: 0;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 9px;
        }

        .nav-icon-btn {
            width: 46px;
            height: 46px;
            flex: 0 0 46px;
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            border-radius: 999px;
            background: var(--white);
            color: var(--brown);
            cursor: pointer;
            text-decoration: none;
            transition:
                border-color .2s ease,
                color .2s ease,
                background .2s ease,
                transform .2s ease;
        }

        .nav-icon-btn:hover {
            color: var(--tangelo);
            border-color: rgba(251, 77, 0, .38);
            background: var(--cream);
            transform: translateY(-1px);
        }

        .nav-icon-btn i {
            font-size: 18px;
        }

        .nav-icon-btn.active {
            background: var(--brown);
            color: var(--white);
            border-color: var(--brown);
        }

        .notification-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--tangelo);
            border: 2px solid var(--white);
        }

        /* CTA TULIS */
        .write-button {
            height: 46px;
            padding: 0 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 999px;
            background: var(--tangelo);
            color: var(--white);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
            box-shadow: 0 6px 18px rgba(251, 77, 0, .16);
            transition:
                background .2s ease,
                transform .2s ease,
                box-shadow .2s ease;
        }

        .write-button:hover {
            background: var(--tangelo-dark);
            transform: translateY(-1px);
            box-shadow: 0 9px 24px rgba(251, 77, 0, .22);
        }

        .write-button.active {
            background: var(--brown);
        }

        /* =====================================================
           SEARCH POPOVER
        ===================================================== */
        .search-panel {
            position: absolute;
            top: calc(100% + 14px);
            right: 196px;
            width: min(390px, calc(100vw - 32px));
            padding: 9px;
            display: none;
            border: 1px solid var(--border);
            border-radius: 22px;
            background: rgba(255, 255, 255, .98);
            box-shadow: 0 20px 50px rgba(73, 38, 29, .14);
            z-index: 1200;
        }

        .search-panel.show {
            display: block;
            animation: searchAppear .16s ease-out;
        }

        @keyframes searchAppear {
            from {
                opacity: 0;
                transform: translateY(-5px) scale(.985);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .search-form {
            position: relative;
        }

        .search-input {
            width: 100%;
            height: 48px;
            padding: 0 48px 0 17px;
            border: 1px solid transparent;
            border-radius: 16px;
            outline: none;
            background: var(--cream);
            color: var(--brown);
            font-size: 14px;
            font-weight: 500;
            transition: .2s;
        }

        .search-input::placeholder {
            color: #9A8680;
        }

        .search-input:focus {
            background: var(--white);
            border-color: rgba(251, 77, 0, .40);
            box-shadow: 0 0 0 4px rgba(251, 77, 0, .07);
        }

        .search-submit {
            position: absolute;
            top: 50%;
            right: 7px;
            width: 36px;
            height: 36px;
            transform: translateY(-50%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--brown);
            color: var(--white);
            cursor: pointer;
            transition: .2s;
        }

        .search-submit:hover {
            background: var(--tangelo);
        }

        /* =====================================================
           USER MENU
        ===================================================== */
        .user-menu {
            position: relative;
            flex-shrink: 0;
        }

        .user-button {
            min-height: 46px;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 4px 14px 4px 5px;
            border: 1px solid var(--border);
            border-radius: 999px;
            background: var(--cream);
            color: var(--brown);
            cursor: pointer;
            transition: .2s;
        }

        .user-button:hover {
            border-color: rgba(251, 77, 0, .35);
            background: var(--white);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--blue);
            color: var(--brown);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 800;
        }

        .user-name {
            max-width: 125px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: var(--brown);
            font-size: 14px;
            font-weight: 700;
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            min-width: 235px;
            padding: 9px;
            display: none;
            border: 1px solid var(--border);
            border-radius: 18px;
            background: var(--white);
            box-shadow: 0 18px 48px rgba(73, 38, 29, 0.14);
            z-index: 1200;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            width: 100%;
            padding: 12px 13px;
            display: flex;
            align-items: center;
            border: none;
            border-radius: 11px;
            background: transparent;
            color: var(--brown);
            font-size: 14px;
            font-weight: 600;
            text-align: left;
            text-decoration: none;
            cursor: pointer;
            transition: .2s;
        }

        .dropdown-item:hover {
            color: var(--tangelo);
            background: var(--linen);
        }

        .dropdown-divider {
            height: 1px;
            margin: 7px 0;
            background: var(--border);
        }

        /* =====================================================
           MOBILE
        ===================================================== */
        .mobile-nav-toggle,
        .mobile-nav {
            display: none;
        }

        @media (max-width: 1480px) {
            .navbar {
                padding-left: 4%;
                padding-right: 4%;
                gap: 18px;
                grid-template-columns: minmax(110px, 1fr) auto minmax(390px, 1fr);
            }

            .nav-menu a {
                padding-left: 16px;
                padding-right: 16px;
            }

            .write-button {
                padding-left: 15px;
                padding-right: 15px;
            }
        }

        @media (max-width: 1240px) {
            .navbar {
                display: flex;
                justify-content: space-between;
            }

            .nav-menu {
                display: none;
            }

            .mobile-nav-toggle {
                width: 44px;
                height: 44px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: 1px solid var(--border);
                border-radius: 999px;
                background: var(--white);
                color: var(--brown);
                cursor: pointer;
            }

            .mobile-nav {
                position: absolute;
                top: calc(100% + 8px);
                left: 4%;
                right: 4%;
                width: auto;
                padding: 10px;
                border: 1px solid var(--border);
                border-radius: 20px;
                background: var(--linen);
                box-shadow: 0 16px 40px rgba(73, 38, 29, .12);
            }

            .mobile-nav.open {
                display: grid;
                gap: 4px;
            }

            .mobile-nav a {
                padding: 12px 14px;
                border-radius: 14px;
                color: var(--brown);
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-size: 14px;
                font-weight: 700;
                text-decoration: none;
            }

            .mobile-nav a.active,
            .mobile-nav a:hover {
                color: var(--white);
                background: var(--brown);
            }

            .search-panel {
                right: 215px;
            }
        }

        @media (max-width: 860px) {
            .navbar {
                height: 75px;
                padding: 0 4%;
                gap: 7px;
            }

            .logo-img {
                height: 50px !important;
                max-width: 92px;
            }

            .nav-right {
                gap: 6px;
            }

            .write-button {
                width: 42px;
                height: 42px;
                padding: 0;
            }

            .write-button span {
                display: none;
            }

            .nav-icon-btn {
                width: 42px;
                height: 42px;
                flex-basis: 42px;
            }

            .message-button {
                display: none;
            }

            .user-button {
                min-height: 42px;
                padding: 2px 4px;
            }

            .user-avatar {
                width: 36px;
                height: 36px;
            }

            .user-name,
            .user-button > .fa-chevron-down {
                display: none;
            }

            .search-panel {
                position: fixed;
                top: 82px;
                left: 16px;
                right: 16px;
                width: auto;
            }
        }

        @media (max-width: 560px) {
            .notification-button {
                display: none;
            }

            .write-button {
                display: none;
            }

            .navbar {
                padding-left: 14px;
                padding-right: 14px;
            }
        }
    </style>
</head>

<body class="font-sans antialiased">
    <!-- =====================================================
         NAVBAR
    ====================================================== -->
    <nav class="navbar">

        <!-- Logo: ukuran tetap -->
        <a href="{{ route('dashboard') }}" class="logo-section" aria-label="Interlude">
            <img
                src="{{ asset('images/logo-interlude.png') }}"
                alt="Interlude"
                class="logo-img"
                style="height: 75px;"
            >
        </a>

        <!-- Menu utama: sengaja dibuat lebih ringkas -->
        <div class="nav-menu">
            <a
                href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >
                Beranda
            </a>

            <a
                href="{{ route('explore') }}"
                class="{{ request()->routeIs('explore') ? 'active' : '' }}"
            >
                Jelajahi
            </a>

            <a
                href="{{ url('/podcast') }}"
                class="{{ request()->is('podcast*') ? 'active' : '' }}"
            >
                Podcast
            </a>
        </div>

        <!-- Action area -->
        <div class="nav-right">

            <!-- Search -->
            <button
                id="searchToggle"
                type="button"
                class="nav-icon-btn"
                aria-label="Cari"
                aria-expanded="false"
                aria-controls="navSearchPanel"
            >
                <i class="fas fa-search"></i>
            </button>

            <!-- Pesan -->
            <a
                href="{{ url('/messages') }}"
                class="nav-icon-btn message-button {{ request()->is('messages*') || request()->is('pesan*') ? 'active' : '' }}"
                aria-label="Pesan"
                title="Pesan"
            >
                <i class="far fa-comment-dots"></i>
            </a>

            <!-- Notifikasi -->
            <button
                type="button"
                class="nav-icon-btn notification-button"
                aria-label="Notifikasi"
                title="Notifikasi"
            >
                <i class="far fa-bell"></i>

                {{-- Hapus span ini kalau nanti belum punya sistem unread notification --}}
                <span class="notification-dot"></span>
            </button>

            <!-- Tulis cerita -->
            <a
                href="{{ route('articles.create') }}"
                class="write-button {{ request()->routeIs('articles.create') ? 'active' : '' }}"
            >
                <i class="far fa-pen-to-square"></i>
                <span>Tulis cerita</span>
            </a>

            <!-- Mobile menu toggle -->
            <button
                class="mobile-nav-toggle"
                type="button"
                aria-label="Buka menu"
                aria-expanded="false"
                onclick="toggleMobileNav(this)"
            >
                <i class="fas fa-bars"></i>
            </button>

            <!-- User -->
            <div class="user-menu">
                <button
                    type="button"
                    class="user-button"
                    onclick="toggleDropdown()"
                    aria-label="Buka menu profil"
                    aria-expanded="false"
                    id="userMenuButton"
                >
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>

                    <span class="user-name">
                        {{ Auth::user()->name }}
                    </span>

                    <i
                        class="fas fa-chevron-down"
                        style="font-size: 10px; color: var(--text-soft);"
                    ></i>
                </button>

                <div class="dropdown-menu" id="userDropdown">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="far fa-user" style="width: 24px;"></i>
                        Profil
                    </a>

                    <a href="{{ route('articles.saved') }}" class="dropdown-item">
                        <i class="far fa-bookmark" style="width: 24px;"></i>
                        Artikel Tersimpan
                    </a>

                    <a href="{{ route('articles.manage') }}" class="dropdown-item">
                        <i class="far fa-pen-to-square" style="width: 24px;"></i>
                        Kelola Karya
                    </a>

                    <div class="dropdown-divider"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-arrow-right-from-bracket" style="width: 24px;"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Search popover -->
            <div id="navSearchPanel" class="search-panel">
                <form
                    method="GET"
                    action="{{ route('explore') }}"
                    class="search-form"
                >
                    <input
                        id="navSearchInput"
                        type="search"
                        name="q"
                        value="{{ request('q') }}"
                        class="search-input"
                        placeholder="Cari artikel, topik, atau penulis..."
                        aria-label="Cari artikel, topik, atau penulis"
                    >

                    <button
                        type="submit"
                        class="search-submit"
                        aria-label="Cari"
                    >
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Mobile navigation -->
        <div class="mobile-nav" id="mobileNav">
            <a
                href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >
                Beranda
            </a>

            <a
                href="{{ route('explore') }}"
                class="{{ request()->routeIs('explore') ? 'active' : '' }}"
            >
                Jelajahi
            </a>

            <a
                href="{{ url('/podcast') }}"
                class="{{ request()->is('podcast*') ? 'active' : '' }}"
            >
                Podcast
            </a>

            <a
                href="{{ url('/messages') }}"
                class="{{ request()->is('messages*') || request()->is('pesan*') ? 'active' : '' }}"
            >
                Pesan
            </a>

            <a
                href="{{ route('articles.create') }}"
                class="{{ request()->routeIs('articles.create') ? 'active' : '' }}"
            >
                Tulis cerita
            </a>

            <a href="{{ route('profile.edit') }}">
                Profil
            </a>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    <script>
        const searchToggle = document.getElementById('searchToggle');
        const searchPanel = document.getElementById('navSearchPanel');
        const searchInput = document.getElementById('navSearchInput');
        const userDropdown = document.getElementById('userDropdown');
        const userMenuButton = document.getElementById('userMenuButton');

        function closeSearch() {
            if (!searchPanel || !searchToggle) return;

            searchPanel.classList.remove('show');
            searchToggle.setAttribute('aria-expanded', 'false');
        }

        function toggleSearch() {
            if (!searchPanel || !searchToggle) return;

            const opening = !searchPanel.classList.contains('show');

            searchPanel.classList.toggle('show', opening);
            searchToggle.setAttribute(
                'aria-expanded',
                opening ? 'true' : 'false'
            );

            if (opening) {
                if (userDropdown) {
                    userDropdown.classList.remove('show');
                }

                if (userMenuButton) {
                    userMenuButton.setAttribute(
                        'aria-expanded',
                        'false'
                    );
                }

                setTimeout(() => {
                    if (searchInput) searchInput.focus();
                }, 50);
            }
        }

        function toggleDropdown() {
            if (!userDropdown) return;

            const opening = !userDropdown.classList.contains('show');

            userDropdown.classList.toggle('show', opening);

            if (userMenuButton) {
                userMenuButton.setAttribute(
                    'aria-expanded',
                    opening ? 'true' : 'false'
                );
            }

            if (opening) {
                closeSearch();
            }
        }

        function toggleMobileNav(button) {
            const mobileNav = document.getElementById('mobileNav');

            if (!mobileNav) return;

            const isOpen = mobileNav.classList.toggle('open');

            button.setAttribute(
                'aria-expanded',
                isOpen ? 'true' : 'false'
            );

            button.innerHTML = isOpen
                ? '<i class="fas fa-times"></i>'
                : '<i class="fas fa-bars"></i>';

            closeSearch();
        }

        if (searchToggle) {
            searchToggle.addEventListener(
                'click',
                function (event) {
                    event.stopPropagation();
                    toggleSearch();
                }
            );
        }

        if (searchPanel) {
            searchPanel.addEventListener(
                'click',
                function (event) {
                    event.stopPropagation();
                }
            );
        }

        document.addEventListener(
            'keydown',
            function (event) {
                if (event.key === 'Escape') {
                    closeSearch();

                    if (userDropdown) {
                        userDropdown.classList.remove('show');
                    }

                    if (userMenuButton) {
                        userMenuButton.setAttribute(
                            'aria-expanded',
                            'false'
                        );
                    }
                }
            }
        );

        window.addEventListener(
            'click',
            function (event) {

                if (!event.target.closest('.user-menu')) {
                    if (userDropdown) {
                        userDropdown.classList.remove('show');
                    }

                    if (userMenuButton) {
                        userMenuButton.setAttribute(
                            'aria-expanded',
                            'false'
                        );
                    }
                }

                if (
                    !event.target.closest('#navSearchPanel') &&
                    !event.target.closest('#searchToggle')
                ) {
                    closeSearch();
                }

                const nav =
                    document.getElementById('mobileNav');

                const toggle =
                    document.querySelector('.mobile-nav-toggle');

                if (
                    nav &&
                    toggle &&
                    nav.classList.contains('open') &&
                    !event.target.closest('.mobile-nav') &&
                    !event.target.closest('.mobile-nav-toggle')
                ) {
                    nav.classList.remove('open');
                    toggle.setAttribute(
                        'aria-expanded',
                        'false'
                    );
                    toggle.innerHTML =
                        '<i class="fas fa-bars"></i>';
                }
            }
        );
    </script>
</body>
</html>
