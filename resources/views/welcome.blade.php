<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interlude — Jeda untuk berbagi cerita</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
        }

        a { text-decoration: none; color: inherit; }

        /* NAVBAR */
        .navbar {
            padding: 20px 7%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--cream);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--border);
        }

        .logo-section {
            display: flex;
            flex-direction: column;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 900;
            letter-spacing: -1px;
            color: var(--brown);
        }

        .logo span { color: var(--tangelo); }

        .tagline {
            font-size: 12px;
            color: var(--text-soft);
            margin-top: -4px;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 36px;
        }

        .nav-menu a {
            font-size: 15px;
            font-weight: 500;
            color: var(--brown);
            transition: 0.2s;
            position: relative;
            padding-bottom: 4px;
        }

        .nav-menu a:hover { color: var(--tangelo); }

        .nav-menu a.active {
            color: var(--tangelo);
        }

        .nav-menu a.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--tangelo);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-wrapper {
            position: relative;
        }

        .search {
            width: 320px;
            height: 44px;
            border: 1.5px solid var(--border);
            border-radius: 30px;
            background: var(--white);
            padding: 0 44px 0 20px;
            outline: none;
            font-size: 14px;
            font-weight: 400;
            font-family: 'DM Sans', sans-serif;
        }

        .search::placeholder { color: #9C8B83; }

        .search-icon {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #9C8B83;
            font-size: 14px;
        }

        .btn-login {
            font-size: 15px;
            font-weight: 500;
            color: var(--brown);
        }

        .btn-signup {
            background: var(--tangelo);
            color: var(--white);
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-signup:hover {
            background: #e04400;
        }

        /* HERO SECTION */
        .hero {
            padding: 60px 7% 80px;
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 60px;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: var(--blue);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            opacity: 0.5;
            z-index: 0;
        }

        .hero::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border: 2px dashed var(--tangelo);
            border-radius: 50%;
            bottom: -50px;
            right: 200px;
            opacity: 0.4;
            z-index: 0;
        }

        .hero > * {
            position: relative;
            z-index: 1;
        }

        .hero-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(48px, 5.5vw, 72px);
            font-weight: 900;
            line-height: 1.05;
            letter-spacing: -2px;
            margin-bottom: 24px;
        }

        .hero-content h1 .highlight {
            color: var(--tangelo);
        }

        .hero-description {
            font-size: 17px;
            line-height: 1.7;
            color: var(--text-soft);
            margin-bottom: 32px;
            max-width: 480px;
        }

        .hero-buttons {
            display: flex;
            gap: 14px;
            margin-bottom: 40px;
        }

        .btn {
            padding: 14px 28px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: 0.2s;
            border: none;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-primary {
            background: var(--tangelo);
            color: var(--white);
        }

        .btn-primary:hover {
            background: #e04400;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--white);
            border: 1.5px solid var(--border);
            color: var(--brown);
        }

        .btn-secondary:hover {
            border-color: var(--brown);
        }

        .hero-stats {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .avatars {
            display: flex;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid var(--white);
            margin-left: -10px;
            overflow: hidden;
            background: var(--blue);
        }

        .avatar:first-child { margin-left: 0; }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .stars { 
            color: #FFB800;
            font-size: 14px;
        }

        .rating-text {
            color: var(--text-soft);
        }

        .rating-text strong {
            color: var(--brown);
            font-weight: 700;
        }

        /* ARTICLES SECTION */
        .articles-section {
            position: relative;
        }

        .articles-card {
            background: var(--white);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 10px 40px rgba(73, 38, 29, 0.08);
            border: 1px solid var(--border);
        }

        .articles-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .articles-title {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
        }

        .nav-arrows {
            display: flex;
            gap: 8px;
        }

        .nav-arrow {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1.5px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.2s;
            background: var(--white);
            font-size: 14px;
        }

        .nav-arrow:hover {
            background: var(--linen);
            border-color: var(--tangelo);
        }

        .articles-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .article-card {
            background: var(--white);
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid var(--border);
            transition: 0.3s;
        }

        .article-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(73, 38, 29, 0.1);
        }

        .article-image {
            height: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .article-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .article-card:nth-child(1) .article-image {
            background: #FFF0E8;
        }

        .article-card:nth-child(2) .article-image {
            background: #E0EEF7;
        }

        .article-card:nth-child(3) .article-image {
            background: #F5F0E8;
        }

        .article-content {
            padding: 16px;
        }

        .article-tag {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            color: var(--tangelo);
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .article-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 15px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 12px;
            color: var(--brown);
        }

        .article-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            color: var(--text-soft);
        }

        .author {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .author-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            overflow: hidden;
        }

        .author-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .author-info {
            display: flex;
            flex-direction: column;
            line-height: 1.3;
        }

        .author-name {
            font-weight: 600;
            color: var(--brown);
            font-size: 12px;
        }

        .author-date {
            font-size: 11px;
            color: var(--text-soft);
        }

        .article-stats {
            display: flex;
            gap: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .stat {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* INSIGHT BOX */
        .insight-box {
            background: var(--white);
            border-radius: 16px;
            padding: 24px;
            margin-top: 20px;
            border: 1px solid var(--border);
            box-shadow: 0 10px 40px rgba(73, 38, 29, 0.06);
            position: absolute;
            right: -50px;
            bottom: -40px;
            width: 320px;
            z-index: 10;
        }

        .insight-title {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .insight-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 20px;
        }

        .insight-item {
            padding: 14px;
            background: var(--cream);
            border-radius: 10px;
            border: 1px solid var(--border);
        }

        .insight-label {
            font-size: 10px;
            font-weight: 600;
            color: var(--text-soft);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .insight-number {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 900;
            margin-bottom: 8px;
            line-height: 1;
        }

        .insight-number.orange { color: var(--tangelo); }
        .insight-number.blue { color: #4A90E2; }

        .mini-chart {
            height: 30px;
            width: 100%;
        }

        .mini-chart svg {
            width: 100%;
            height: 100%;
        }

        .popular-list {
            margin-top: 16px;
        }

        .popular-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            font-size: 13px;
        }

        .popular-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .rank {
            width: 20px;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-soft);
        }

        .topic-name {
            font-weight: 500;
        }

        .popular-count {
            color: var(--text-soft);
            font-size: 12px;
        }

        .view-all-link {
            text-align: center;
            padding-top: 16px;
            font-size: 13px;
            font-weight: 600;
            color: var(--brown);
            cursor: pointer;
            border-top: 1px solid var(--border);
            margin-top: 12px;
        }

        /* SPARKLE DECORATIONS */
        .sparkle {
            position: absolute;
            color: var(--tangelo);
            opacity: 0.4;
            font-size: 12px;
        }

        .sparkle-1 { top: 20%; right: 5%; }
        .sparkle-2 { top: 40%; right: 2%; }
        .sparkle-3 { bottom: 30%; right: 8%; }

        /* TOPICS SECTION */
        .topics {
            padding: 80px 7%;
            background: var(--linen);
        }

        .topics-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
        }

        .section-link {
            font-size: 14px;
            font-weight: 600;
            color: var(--tangelo);
        }

        .topics-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 16px;
        }

        .topic-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: 0.2s;
            cursor: pointer;
        }

        .topic-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(73, 38, 29, 0.08);
        }

        .topic-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .topic-card:nth-child(1) .topic-icon { 
            background: #FFE5E0; 
            color: var(--tangelo);
        }
        .topic-card:nth-child(2) .topic-icon { 
            background: #CAE7F7; 
            color: #4A90E2;
        }
        .topic-card:nth-child(3) .topic-icon { 
            background: #E0F5E9; 
            color: #2D8B5E;
        }
        .topic-card:nth-child(4) .topic-icon { 
            background: #F0E6FF; 
            color: #8B5CF6;
        }
        .topic-card:nth-child(5) .topic-icon { 
            background: #FFF4E0; 
            color: #D97706;
        }
        .topic-card:nth-child(6) .topic-icon { 
            background: #E0F0F5; 
            color: #0891B2;
        }

        .topic-info h3 {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .topic-info p {
            font-size: 12px;
            color: var(--text-soft);
        }

        /* CTA SECTION */
        .cta-section {
            padding: 80px 7%;
            background: #FFF0E8;
            text-align: center;
        }

        .cta-section h2 {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 16px;
            color: var(--brown);
        }

        .cta-section p {
            font-size: 16px;
            color: var(--text-soft);
            margin-bottom: 32px;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--tangelo);
            color: var(--white);
            padding: 14px 28px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            transition: 0.2s;
            border: none;
            cursor: pointer;
        }

        .cta-button:hover {
            background: #e04400;
            transform: translateY(-2px);
        }

        /* FOOTER */
        footer {
            padding: 50px 7%;
            background: var(--brown);
            text-align: center;
        }

        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 8px;
        }

        .footer-tagline {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }

        /* RESPONSIVE */
        @media (max-width: 1200px) {
            .hero {
                grid-template-columns: 1fr;
                gap: 60px;
            }

            .insight-box {
                position: relative;
                right: auto;
                bottom: auto;
                width: 100%;
            }

            .topics-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .search {
                width: 240px;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 16px 5%;
            }

            .nav-menu {
                display: none;
            }

            .search {
                display: none;
            }

            .hero {
                padding: 40px 5% 60px;
            }

            .hero-content h1 {
                font-size: 48px;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .articles-grid {
                grid-template-columns: 1fr;
            }

            .topics-grid {
                grid-template-columns: 1fr;
            }

            .cta-section h2 {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="logo-section">
            <div class="logo">Interlude<span>.</span></div>
            <div class="tagline">jeda untuk berbagi cerita.</div>
        </div>

        <div class="nav-menu">
            <a href="#" class="active">Beranda</a>
            <a href="#">Jelajahi</a>
            <a href="#">Topik</a>
            <a href="#">Tulis</a>
            <a href="#">Tentang</a>
        </div>

        <div class="nav-right">
            <div class="search-wrapper">
                <input type="text" class="search" placeholder="Cari artikel, topik, atau penulis...">
                <i class="fas fa-search search-icon"></i>
            </div>
            <a href="#" class="btn-login">Masuk</a>
            <a href="#" class="btn-signup">Daftar gratis</a>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="sparkle sparkle-1">✦</div>
        <div class="sparkle sparkle-2">✦</div>
        <div class="sparkle sparkle-3">✦</div>

        <div class="hero-content">
            <h1>
                Jeda.<br>
                Berbagi cerita.<br>
                <span class="highlight">Tumbuh bersama.</span>
            </h1>

            <p class="hero-description">
                Platform komunitas mahasiswa untuk berbagi pengalaman, catatan, dan insight akademik. 
                Tulis, temukan, dan terhubung dalam satu tempat.
            </p>

            <div class="hero-buttons">
                <button class="btn btn-primary">
                    <i class="fas fa-pen"></i> Mulai menulis
                </button>
                <button class="btn btn-secondary">
                    Jelajahi topik
                </button>
            </div>

            <div class="hero-stats">
                <div class="avatars">
                    <div class="avatar">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&h=100&fit=crop" alt="User">
                    </div>
                    <div class="avatar">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop" alt="User">
                    </div>
                    <div class="avatar">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop" alt="User">
                    </div>
                    <div class="avatar">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop" alt="User">
                    </div>
                </div>
                <div class="rating">
                    <span class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </span>
                    <span class="rating-text"><strong>4.9/5</strong> dari 28,479 mahasiswa</span>
                </div>
            </div>
        </div>

        <div class="articles-section">
            <div class="articles-card">
                <div class="articles-header">
                    <h3 class="articles-title">Artikel pilihan</h3>
                    <div class="nav-arrows">
                        <div class="nav-arrow">
                            <i class="fas fa-chevron-left"></i>
                        </div>
                        <div class="nav-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </div>

                <div class="articles-grid">
                    <article class="article-card">
                        <div class="article-image">
                            <img src="https://images.unsplash.com/photo-1456324504439-367cee13d656?w=400&h=300&fit=crop" alt="Notebook">
                        </div>
                        <div class="article-content">
                            <div class="article-tag">Tugas Akhir</div>
                            <h3>Tips Menyusun Latar Belakang yang Kuat</h3>
                            <div class="article-meta">
                                <div class="author">
                                    <div class="author-avatar">
                                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop" alt="Ahmad">
                                    </div>
                                    <div class="author-info">
                                        <span class="author-name">Ahmad Farhan</span>
                                        <span class="author-date">2 hari lalu</span>
                                    </div>
                                </div>
                                <div class="article-stats">
                                    <span class="stat"><i class="far fa-heart"></i> 1.2K</span>
                                    <span class="stat"><i class="far fa-comment"></i> 45</span>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="article-card">
                        <div class="article-image">
                            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=400&h=300&fit=crop" alt="Meeting">
                        </div>
                        <div class="article-content">
                            <div class="article-tag" style="color: #4A90E2;">Magang</div>
                            <h3>Pengalaman Magang di Startup EdTech</h3>
                            <div class="article-meta">
                                <div class="author">
                                    <div class="author-avatar">
                                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&h=100&fit=crop" alt="Putri">
                                    </div>
                                    <div class="author-info">
                                        <span class="author-name">Putri Aulia</span>
                                        <span class="author-date">3 hari lalu</span>
                                    </div>
                                </div>
                                <div class="article-stats">
                                    <span class="stat"><i class="far fa-heart"></i> 892</span>
                                    <span class="stat"><i class="far fa-comment"></i> 32</span>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="article-card">
                        <div class="article-image">
                            <img src="https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=400&h=300&fit=crop" alt="Research">
                        </div>
                        <div class="article-content">
                            <div class="article-tag">Penelitian</div>
                            <h3>Cara Menentukan Topik Penelitian</h3>
                            <div class="article-meta">
                                <div class="author">
                                    <div class="author-avatar">
                                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop" alt="Ricky">
                                    </div>
                                    <div class="author-info">
                                        <span class="author-name">Ricky Pan</span>
                                        <span class="author-date">5 hari lalu</span>
                                    </div>
                                </div>
                                <div class="article-stats">
                                    <span class="stat"><i class="far fa-heart"></i> 654</span>
                                    <span class="stat"><i class="far fa-comment"></i> 28</span>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>

            <!-- INSIGHT BOX -->
            <div class="insight-box">
                <h4 class="insight-title">Insight Komunitas</h4>
                
                <div class="insight-grid">
                    <div class="insight-item">
                        <div class="insight-label">Artikel bulan ini</div>
                        <div class="insight-number orange">1,248</div>
                        <div class="mini-chart">
                            <svg viewBox="0 0 100 30" preserveAspectRatio="none">
                                <polyline 
                                    points="0,25 15,22 30,20 45,18 60,15 75,10 90,5 100,2" 
                                    fill="none" 
                                    stroke="#FB4D00" 
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </div>
                    </div>
                    <div class="insight-item">
                        <div class="insight-label">Pembaca aktif</div>
                        <div class="insight-number blue">8,563</div>
                        <div class="mini-chart">
                            <svg viewBox="0 0 100 30" preserveAspectRatio="none">
                                <polyline 
                                    points="0,25 15,23 30,20 45,18 60,15 75,12 90,8 100,5" 
                                    fill="none" 
                                    stroke="#4A90E2" 
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="popular-list">
                    <div class="popular-item">
                        <div class="popular-left">
                            <span class="rank">01</span>
                            <span class="topic-name">Tugas Akhir</span>
                        </div>
                        <span class="popular-count">1.2K artikel</span>
                    </div>
                    <div class="popular-item">
                        <div class="popular-left">
                            <span class="rank">02</span>
                            <span class="topic-name">Penelitian</span>
                        </div>
                        <span class="popular-count">842 artikel</span>
                    </div>
                    <div class="popular-item">
                        <div class="popular-left">
                            <span class="rank">03</span>
                            <span class="topic-name">Magang</span>
                        </div>
                        <span class="popular-count">952 artikel</span>
                    </div>
                </div>

                <div class="view-all-link">
                    Lihat semua insight <i class="fas fa-arrow-right" style="margin-left: 4px;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- TOPICS -->
    <section class="topics">
        <div class="topics-container">
            <div class="section-header">
                <h2 class="section-title">Topik populer</h2>
                <a href="#" class="section-link">Lihat semua topik <i class="fas fa-arrow-right" style="margin-left: 4px;"></i></a>
            </div>

            <div class="topics-grid">
                <div class="topic-card">
                    <div class="topic-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="topic-info">
                        <h3>Tugas Akhir</h3>
                        <p>1.2K artikel</p>
                    </div>
                </div>
                <div class="topic-card">
                    <div class="topic-icon">
                        <i class="fas fa-microscope"></i>
                    </div>
                    <div class="topic-info">
                        <h3>Penelitian</h3>
                        <p>842 artikel</p>
                    </div>
                </div>
                <div class="topic-card">
                    <div class="topic-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="topic-info">
                        <h3>Magang</h3>
                        <p>952 artikel</p>
                    </div>
                </div>
                <div class="topic-card">
                    <div class="topic-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="topic-info">
                        <h3>Organisasi</h3>
                        <p>1.1K artikel</p>
                    </div>
                </div>
                <div class="topic-card">
                    <div class="topic-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="topic-info">
                        <h3>Beasiswa</h3>
                        <p>732 artikel</p>
                    </div>
                </div>
                <div class="topic-card">
                    <div class="topic-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="topic-info">
                        <h3>Study Tips</h3>
                        <p>689 artikel</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="cta-section">
        <h2>Siap berbagi cerita?</h2>
        <p>Bergabung dengan ribuan mahasiswa lainnya dan mulai menulis sekarang.</p>
        <button class="cta-button">Daftar gratis <i class="fas fa-arrow-right"></i></button>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-logo">Interlude.</div>
        <div class="footer-tagline">jeda untuk berbagi cerita.</div>
    </footer>
</body>
</html>