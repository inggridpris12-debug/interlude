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
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --linen: #FFEDE3;
            --tangelo: #FB4D00;
            --brown: #49261D;
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

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--brown);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* NAVBAR */
        .navbar {
            padding: 20px 7%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--white);
            border-bottom: 1.5px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 1000;
            height: 90px;
        }

        /* LOGO - LEBIH BESAR */
        .logo-section {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .logo-img {
            height: 75px;  /* LEBIH BESAR */
            width: auto;
            object-fit: contain;
            display: block;
        }

        /* NAV MENU */
        .nav-menu {
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .nav-menu a {
            font-size: 18px;
            font-weight: 700;
            color: var(--brown);
            transition: 0.2s;
            text-decoration: none;
            letter-spacing: 0.3px;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            color: var(--tangelo);
        }

        /* NAV RIGHT */
        .nav-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .search-wrapper {
            position: relative;
        }

        .search {
            width: 360px;
            height: 50px;
            border: 1.5px solid var(--border);
            border-radius: 28px;
            background: var(--cream);
            padding: 0 48px 0 20px;
            outline: none;
            font-size: 16px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            transition: 0.2s;
        }

        .search:focus {
            border-color: var(--tangelo);
            background: var(--white);
        }

        .search::placeholder {
            color: var(--text-soft);
            font-weight: 400;
        }

        .search-icon {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-soft);
            font-size: 16px;
        }

        .notification-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 1.5px solid var(--border);
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.2s;
            color: var(--brown);
            position: relative;
            font-size: 20px;
        }

        .notification-btn:hover {
            border-color: var(--tangelo);
            color: var(--tangelo);
        }

        .notification-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 10px;
            height: 10px;
            background: var(--tangelo);
            border-radius: 50%;
            border: 2px solid var(--white);
        }

        .user-menu {
            position: relative;
        }

        .user-button {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 18px;
            background: var(--cream);
            border: 1.5px solid var(--border);
            border-radius: 28px;
            cursor: pointer;
            transition: 0.2s;
        }

        .user-button:hover {
            border-color: var(--tangelo);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 15px;
            color: var(--brown);
        }

        .user-name {
            font-weight: 700;
            font-size: 16px;
            color: var(--brown);
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 10px;
            min-width: 240px;
            box-shadow: 0 12px 40px rgba(73, 38, 29, 0.15);
            display: none;
            z-index: 1000;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            padding: 14px 18px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            color: var(--brown);
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .dropdown-item:hover {
            background: var(--cream);
            color: var(--tangelo);
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border);
            margin: 8px 0;
        }

        @media (max-width: 768px) {
            .navbar {
                height: 75px;
                padding: 14px 5%;
            }
            
            .logo-img {
                height: 50px;
            }
            
            .nav-menu {
                display: none;
            }
            
            .search {
                width: 220px;
                height: 44px;
            }
            
            .user-name {
                display: none; 
            }
        }

        .mobile-nav-toggle,
        .mobile-nav {
            display: none;
        }

        @media (max-width: 1024px) {
            .nav-menu { display: none; }

            .mobile-nav-toggle {
                width: 42px;
                height: 42px;
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
                top: 100%;
                left: 4%;
                right: 4%;
                width: auto;
                margin: 0;
                padding: 12px;
                border: 1px solid var(--border);
                border-radius: 18px;
                background: var(--white);
            }

            .mobile-nav.open { display: grid; gap: 4px; }

            .mobile-nav a {
                padding: 12px 14px;
                border-radius: 12px;
                color: var(--brown);
                font-weight: 700;
                font-size: 14px;
                text-decoration: none;
            }

            .mobile-nav a:hover { background: var(--linen); }
        }

        @media (max-width: 768px) {
            .navbar { padding: 10px 4%; }
            .logo-img { height: 50px !important; }
            .logo-section { min-width: 0; }
            .logo-img { max-width: 92px; }
            .nav-right { min-width: 0; gap: 6px; }
            .navbar .search-wrapper { width: 40px; flex: 0 0 40px; }
            .navbar .search { width: 40px; height: 40px; padding: 0; font-size: 0; text-indent: -9999px; }
            .navbar .search-icon { right: 0; left: 0; text-align: center; }
            .notification-btn { display: none; }
            .user-button { padding-right: 6px; }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Navbar -->
    <nav class="navbar">
        <!-- LOGO - LEBIH BESAR -->
        <a href="/" class="logo-section">
            <img src="{{ asset('images/logo-interlude.png') }}" alt="Interlude" class="logo-img" style="height: 75px;">
        </a>

        <div class="nav-menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('explore') }}" class="{{ request()->routeIs('explore') ? 'active' : '' }}">Jelajahi</a>
            <a href="{{ route('explore') }}">Topik</a>
            <a href="{{ route('articles.create') }}">Tulis</a>
        </div>

        <div class="nav-right">
            <div class="search-wrapper">
                <input type="text" class="search" placeholder="Cari artikel, topik, atau penulis...">
                <i class="fas fa-search search-icon"></i>
            </div>

            <button class="notification-btn">
                <i class="far fa-bell"></i>
                <span class="notification-badge"></span>
            </button>

            <button class="mobile-nav-toggle" type="button" aria-label="Buka menu" aria-expanded="false" onclick="toggleMobileNav(this)">
                <i class="fas fa-bars"></i>
            </button>

            <div class="user-menu">
                <div class="user-button" onclick="toggleDropdown()">
                    <div class="user-avatar">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <i class="fas fa-chevron-down" style="font-size: 12px; color: var(--text-soft);"></i>
                </div>

                <div class="dropdown-menu" id="userDropdown">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="fas fa-user" style="margin-right: 10px;"></i> Profil
                    </a>
                    <a href="{{ route('articles.saved') }}" class="dropdown-item">
                        <i class="fas fa-bookmark" style="margin-right: 10px;"></i> Artikel Tersimpan
                    </a>
                    <a href="{{ route('articles.manage') }}" class="dropdown-item">
                        <i class="fas fa-pen-to-square" style="margin-right: 10px;"></i> Kelola Karya
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt" style="margin-right: 10px;"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="mobile-nav" id="mobileNav">
            <a href="{{ route('dashboard') }}">Beranda</a>
            <a href="{{ route('explore') }}">Jelajahi</a>
            <a href="{{ route('explore') }}">Topik</a>
            <a href="{{ route('articles.create') }}">Tulis pengalaman</a>
            <a href="{{ route('profile.edit') }}">Profil</a>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    <script>
        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('show');
        }

        function toggleMobileNav(button) {
            const mobileNav = document.getElementById('mobileNav');
            const isOpen = mobileNav.classList.toggle('open');
            button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            button.innerHTML = isOpen ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.closest('.user-menu')) {
                var dropdowns = document.getElementsByClassName('dropdown-menu');
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>
</html>