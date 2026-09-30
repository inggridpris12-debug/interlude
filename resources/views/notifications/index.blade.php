<x-app-layout>
    <main class="notification-page">
        <header class="notification-header">
            <div>
                <span class="notification-kicker"><i class="far fa-bell"></i> Pusat aktivitas</span>
                <h1>Notifikasi.</h1>
                <p>Lihat kabar terbaru tentang interaksi di akun dan karya kamu.</p>
            </div>
            @if($notifications->whereNull('read_at')->isNotEmpty())
                <form method="POST" action="{{ route('notifications.read-all') }}">@csrf<button class="read-all-button" type="submit"><i class="fas fa-check-double"></i> Tandai semua dibaca</button></form>
            @endif
        </header>

        <section class="notification-list">
            @forelse($notifications as $notification)
                @php($data = $notification->data)
                <article class="notification-item {{ $notification->read_at ? '' : 'notification-unread' }}">
                    <span class="notification-icon"><i class="fas {{ $data['type'] === 'message' ? 'fa-comment-dots' : ($data['type'] === 'follow' ? 'fa-user-plus' : ($data['type'] === 'like' ? 'fa-heart' : 'fa-comment')) }}"></i></span>
                    <div class="notification-copy"><p>{{ $data['message'] ?? 'Ada aktivitas baru di akunmu.' }}</p><time>{{ $notification->created_at->locale('id')->diffForHumans() }}</time></div>
                    @if(!$notification->read_at)
                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">@csrf @method('PATCH')<button class="mark-read-button" type="submit" aria-label="Tandai dibaca"><i class="fas fa-check"></i></button></form>
                    @endif
                    @if(!empty($data['url']))<a class="notification-open" href="{{ $data['url'] }}" aria-label="Buka aktivitas"><i class="fas fa-arrow-up-right-from-square"></i></a>@endif
                </article>
            @empty
                <div class="notification-empty"><span><i class="far fa-bell-slash"></i></span><h2>Belum ada notifikasi.</h2><p>Interaksi baru akan muncul di sini.</p></div>
            @endforelse
        </section>
        <div class="notification-pagination">{{ $notifications->links() }}</div>
    </main>
    <style>
        .notification-page{min-height:100vh;padding:52px 5% 100px;background:#f9f7f4}.notification-header,.notification-list,.notification-pagination{width:min(820px,100%);margin:0 auto}.notification-header{display:flex;align-items:end;justify-content:space-between;gap:20px;padding-bottom:32px;border-bottom:1px solid var(--border)}.notification-kicker{color:var(--tangelo);font-size:11px;font-weight:800;letter-spacing:1.3px;text-transform:uppercase}.notification-header h1{margin:10px 0 0;color:var(--brown);font:800 clamp(34px,5vw,56px)/1.05 'Plus Jakarta Sans',sans-serif;letter-spacing:-1.8px}.notification-header p{margin:14px 0 0;color:var(--text-soft);font-size:15px}.read-all-button{display:inline-flex;align-items:center;gap:7px;padding:10px 13px;border:1px solid var(--border);border-radius:999px;background:#fff;color:var(--brown);font:800 12px 'DM Sans',sans-serif;cursor:pointer}.read-all-button:hover{border-color:var(--tangelo);color:var(--tangelo)}.notification-list{display:grid;gap:10px;margin-top:24px}.notification-item{display:flex;align-items:center;gap:12px;padding:15px;border:1px solid var(--border);border-radius:16px;background:#fff}.notification-unread{border-color:rgba(251,77,0,.42);background:#fff8f3}.notification-icon{display:grid;width:38px;height:38px;flex:0 0 38px;place-items:center;border-radius:13px;background:var(--linen);color:var(--tangelo)}.notification-copy{min-width:0;flex:1}.notification-copy p{margin:0;color:var(--brown);font-size:14px;font-weight:700}.notification-copy time{display:block;margin-top:4px;color:var(--text-soft);font-size:11px}.mark-read-button,.notification-open{display:grid;width:31px;height:31px;place-items:center;border:0;border-radius:50%;background:var(--cream);color:var(--text-soft);cursor:pointer}.mark-read-button:hover,.notification-open:hover{color:var(--tangelo)}.notification-open{text-decoration:none}.notification-empty{display:grid;justify-items:center;padding:70px 20px;border:1px dashed var(--border);border-radius:20px;text-align:center}.notification-empty span{display:grid;width:54px;height:54px;place-items:center;border-radius:50%;background:var(--blue);color:var(--brown);font-size:22px}.notification-empty h2{margin:16px 0 5px;color:var(--brown);font:800 20px 'Plus Jakarta Sans',sans-serif}.notification-empty p{margin:0;color:var(--text-soft);font-size:13px}.notification-pagination{margin-top:20px}@media(max-width:650px){.notification-page{padding:34px 4% 80px}.notification-header{align-items:flex-start;flex-direction:column}.read-all-button{width:100%;justify-content:center}}
    </style>
</x-app-layout>
