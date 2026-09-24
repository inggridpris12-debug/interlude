<x-app-layout>
    <div class="profile-page">
        <section class="profile-hero">
            <div class="profile-avatar">{{ substr($user->name, 0, 1) }}</div>
            <div>
                <span class="profile-kicker">Ruang pribadimu</span>
                <h1>{{ $user->name }}</h1>
                <p>Atur identitas dan keamanan akunmu sebelum kembali berbagi cerita.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="profile-backlink">
                <i class="fas fa-arrow-left"></i>
                Kembali membaca
            </a>
        </section>

        <div class="profile-grid">
            <section class="profile-panel profile-panel-main">
                <div class="profile-panel-heading">
                    <span class="panel-icon"><i class="fas fa-user-pen"></i></span>
                    <div>
                        <span class="profile-kicker">Identitas akun</span>
                        <h2>Profil dan email</h2>
                    </div>
                </div>
                @include('profile.partials.update-profile-information-form')
            </section>

            <section class="profile-panel">
                <div class="profile-panel-heading">
                    <span class="panel-icon panel-icon-blue"><i class="fas fa-shield-halved"></i></span>
                    <div>
                        <span class="profile-kicker">Tetap aman</span>
                        <h2>Kata sandi</h2>
                    </div>
                </div>
                @include('profile.partials.update-password-form')
            </section>

            <section class="profile-panel profile-panel-danger">
                <div class="profile-panel-heading">
                    <span class="panel-icon panel-icon-danger"><i class="fas fa-triangle-exclamation"></i></span>
                    <div>
                        <span class="profile-kicker">Zona sensitif</span>
                        <h2>Hapus akun</h2>
                    </div>
                </div>
                @include('profile.partials.delete-user-form')
            </section>
        </div>
    </div>

    <style>
        .profile-page {
            width: min(1120px, 100%);
            margin: 0 auto;
            padding: 54px 5% 100px;
        }

        .profile-hero {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 20px;
            margin-bottom: 36px;
            padding-bottom: 32px;
            border-bottom: 1px solid var(--border);
        }

        .profile-avatar {
            width: 74px;
            height: 74px;
            display: grid;
            place-items: center;
            border-radius: 24px;
            background: var(--blue);
            color: var(--brown);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 28px;
            font-weight: 800;
        }

        .profile-kicker {
            color: var(--tangelo);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.3px;
            text-transform: uppercase;
        }

        .profile-hero h1,
        .profile-panel h2 {
            margin: 5px 0 0;
            color: var(--brown);
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: -.7px;
        }

        .profile-hero h1 { font-size: 32px; }
        .profile-hero p { margin: 7px 0 0; color: var(--text-soft); font-size: 15px; }
        .profile-backlink { display: inline-flex; align-items: center; gap: 8px; color: var(--brown); font-size: 13px; font-weight: 800; text-decoration: none; }
        .profile-backlink:hover { color: var(--tangelo); }
        .profile-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
        .profile-panel { padding: 26px; border: 1px solid var(--border); border-radius: 22px; background: var(--white); }
        .profile-panel-main { grid-column: 1 / -1; }
        .profile-panel-danger { border-color: rgba(186, 26, 26, .22); }
        .profile-panel-heading { display: flex; align-items: center; gap: 12px; margin-bottom: 22px; }
        .profile-panel-heading h2 { font-size: 20px; }
        .panel-icon { width: 38px; height: 38px; display: grid; place-items: center; border-radius: 13px; background: var(--linen); color: var(--tangelo); }
        .panel-icon-blue { background: var(--blue); color: var(--brown); }
        .panel-icon-danger { background: #FDE7E4; color: #BA1A1A; }
        .profile-panel section header h2 { color: var(--brown); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 17px; }
        .profile-panel section header p,
        .profile-panel section p { color: var(--text-soft); }
        .profile-panel input { border-color: var(--border); border-radius: 12px; background: var(--cream); }
        .profile-panel input:focus { border-color: var(--tangelo); box-shadow: 0 0 0 3px rgba(251, 77, 0, .1); --tw-ring-color: rgba(251, 77, 0, .1); }
        .profile-panel button[type='submit'] { border-radius: 999px; background: var(--brown); }
        .profile-panel button[type='submit']:hover { background: var(--tangelo); }

        @media (max-width: 720px) {
            .profile-page { padding-top: 32px; }
            .profile-hero { grid-template-columns: auto 1fr; }
            .profile-backlink { grid-column: 1 / -1; }
            .profile-hero h1 { font-size: 26px; }
            .profile-grid { grid-template-columns: 1fr; }
            .profile-panel-main { grid-column: auto; }
        }
    </style>
</x-app-layout>
