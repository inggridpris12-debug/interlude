<x-app-layout>
    <main class="communication-page">
        <header class="communication-header">
            <div>
                <span class="communication-kicker"><i class="far fa-comment-dots"></i> Ruang komunikasi</span>
                <h1>Pesan.</h1>
                <p>Hubungi mahasiswa lain untuk bertukar insight, bertanya, atau melanjutkan percakapan.</p>
            </div>
        </header>

        @if(session('success'))
            <div class="communication-alert" role="status"><i class="fas fa-circle-check"></i> {{ session('success') }}</div>
        @endif

        <div class="communication-grid">
            <section class="communication-panel">
                <div class="panel-heading"><span class="panel-icon"><i class="fas fa-pen"></i></span><div><span class="communication-kicker">Mulai percakapan</span><h2>Kirim pesan</h2></div></div>
                <form method="POST" action="{{ route('messages.store') }}" class="message-form">
                    @csrf
                    <label for="recipient_id">Kepada</label>
                    <select id="recipient_id" name="recipient_id" required>
                        <option value="">Pilih mahasiswa</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('recipient_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} · {{ $user->email }}</option>
                        @endforeach
                    </select>
                    @error('recipient_id')<span class="form-error">{{ $message }}</span>@enderror
                    <label for="body">Pesan</label>
                    <textarea id="body" name="body" rows="6" maxlength="2000" placeholder="Tulis pesanmu..." required>{{ old('body') }}</textarea>
                    @error('body')<span class="form-error">{{ $message }}</span>@enderror
                    <button type="submit" class="communication-button"><i class="fas fa-paper-plane"></i> Kirim pesan</button>
                </form>
            </section>

            <section class="communication-panel">
                <div class="panel-heading"><span class="panel-icon panel-icon-blue"><i class="far fa-inbox"></i></span><div><span class="communication-kicker">Aktivitas</span><h2>Pesan terbaru</h2></div></div>
                <div class="message-list">
                    @forelse($messages as $message)
                        @php($isReceived = $message->recipient_id === auth()->id())
                        <article class="message-item {{ $isReceived && !$message->read_at ? 'message-unread' : '' }}">
                            <div class="message-avatar">{{ substr(($isReceived ? $message->sender : $message->recipient)->name, 0, 1) }}</div>
                            <div class="message-copy">
                                <div class="message-meta"><strong>{{ $isReceived ? $message->sender->name : 'Kepada '.$message->recipient->name }}</strong><time>{{ $message->created_at->locale('id')->diffForHumans() }}</time></div>
                                <p>{{ $message->body }}</p>
                            </div>
                        </article>
                    @empty
                        <div class="communication-empty"><i class="far fa-comment-dots"></i><p>Belum ada pesan. Mulai percakapan dengan mahasiswa lain.</p></div>
                    @endforelse
                </div>
                <div class="message-pagination">{{ $messages->links() }}</div>
            </section>
        </div>
    </main>
    <style>
        .communication-page{min-height:100vh;padding:52px 5% 100px;background:#f9f7f4}.communication-header,.communication-grid,.communication-alert{width:min(1080px,100%);margin:0 auto}.communication-header{padding-bottom:32px;border-bottom:1px solid var(--border)}.communication-kicker{color:var(--tangelo);font-size:11px;font-weight:800;letter-spacing:1.3px;text-transform:uppercase}.communication-header h1{margin:10px 0 0;color:var(--brown);font:800 clamp(34px,5vw,56px)/1.05 'Plus Jakarta Sans',sans-serif;letter-spacing:-1.8px}.communication-header p{max-width:560px;margin:14px 0 0;color:var(--text-soft);font-size:16px;line-height:1.6}.communication-alert{display:flex;gap:8px;align-items:center;margin-top:20px;padding:12px 15px;border-radius:12px;background:#e4f4ed;color:#226d4e;font-size:13px}.communication-grid{display:grid;grid-template-columns:minmax(280px,.82fr) minmax(0,1.18fr);gap:18px;margin-top:24px}.communication-panel{padding:24px;border:1px solid var(--border);border-radius:22px;background:#fff}.panel-heading{display:flex;align-items:center;gap:12px;margin-bottom:22px}.panel-heading h2{margin:5px 0 0;color:var(--brown);font:800 20px 'Plus Jakarta Sans',sans-serif}.panel-icon{display:grid;width:38px;height:38px;place-items:center;border-radius:13px;background:var(--linen);color:var(--tangelo)}.panel-icon-blue{background:var(--blue);color:var(--brown)}.message-form{display:grid;gap:8px}.message-form label{color:var(--brown);font-size:13px;font-weight:800}.message-form select,.message-form textarea{width:100%;box-sizing:border-box;padding:12px;border:1px solid var(--border);border-radius:12px;background:var(--cream);color:var(--brown);font:14px/1.5 'DM Sans',sans-serif}.message-form select:focus,.message-form textarea:focus{outline:0;border-color:var(--tangelo);box-shadow:0 0 0 3px rgba(251,77,0,.1)}.form-error{color:#b42318;font-size:12px}.communication-button{display:inline-flex;justify-content:center;align-items:center;gap:8px;margin-top:8px;padding:11px 15px;border:0;border-radius:999px;background:var(--brown);color:#fff;font:800 13px 'DM Sans',sans-serif;cursor:pointer}.communication-button:hover{background:var(--tangelo)}.message-list{display:grid;gap:10px}.message-item{display:flex;gap:11px;padding:13px;border:1px solid var(--border);border-radius:15px;background:#fff}.message-unread{border-color:rgba(251,77,0,.45);background:#fff8f3}.message-avatar{display:grid;width:35px;height:35px;flex:0 0 35px;place-items:center;border-radius:50%;background:var(--blue);color:var(--brown);font-weight:800}.message-copy{min-width:0;flex:1}.message-meta{display:flex;justify-content:space-between;gap:10px}.message-meta strong{color:var(--brown);font-size:13px}.message-meta time{color:var(--text-soft);font-size:11px;white-space:nowrap}.message-copy p{margin:5px 0 0;color:var(--text-soft);font-size:13px;line-height:1.5}.communication-empty{padding:36px 18px;border:1px dashed var(--border);border-radius:15px;color:var(--text-soft);text-align:center}.communication-empty i{color:var(--tangelo);font-size:23px}.communication-empty p{margin:9px 0 0;font-size:13px}.message-pagination{margin-top:18px}@media(max-width:760px){.communication-page{padding:34px 4% 80px}.communication-grid{grid-template-columns:1fr}.communication-panel{padding:19px}}
    </style>
</x-app-layout>
