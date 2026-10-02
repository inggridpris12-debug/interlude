<x-app-layout>
    <main class="messages-page">

        @if(session('success'))
            <div class="messages-toast" id="messagesToast">
                <i class="fas fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="messages-error">
                <i class="fas fa-circle-exclamation"></i>

                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <section class="messenger-shell">

            {{-- =========================================================
                 LEFT — DAFTAR PERCAKAPAN
            ========================================================== --}}
            <aside class="conversation-sidebar">

                <div class="conversation-header">
                    <div>
                        <span class="messages-kicker">
                            Pesan
                        </span>

                        <h1>Obrolan</h1>

                        <p>
                            Percakapanmu di Interlude.
                        </p>
                    </div>

                    <button
                        type="button"
                        class="new-message-button"
                        id="openNewMessage"
                        title="Pesan baru"
                        aria-label="Pesan baru"
                    >
                        <i class="far fa-pen-to-square"></i>
                    </button>
                </div>

                {{-- Search --}}
                <div class="conversation-search">
                    <div class="conversation-search-box">
                        <i class="fas fa-search"></i>

                        <input
                            type="search"
                            id="conversationSearch"
                            placeholder="Cari percakapan..."
                            autocomplete="off"
                        >

                        <button
                            type="button"
                            id="clearConversationSearch"
                            aria-label="Hapus pencarian"
                        >
                            <i class="fas fa-xmark"></i>
                        </button>
                    </div>
                </div>

                {{-- Conversation list --}}
                <div
                    class="conversation-list"
                    id="conversationList"
                >
                    @forelse($conversations as $conversation)

                        @php
                            $partner = $conversation['user'];
                            $lastMessage = $conversation['last_message'];
                            $unreadCount = $conversation['unread_count'];

                            $isActive = $activeUser
                                && $activeUser->id === $partner->id;

                            $lastMessageMine = $lastMessage
                                && $lastMessage->sender_id === auth()->id();

                            $searchText = strtolower(
                                trim(
                                    $partner->name . ' ' .
                                    ($partner->username ?? '') . ' ' .
                                    ($partner->university ?? '') . ' ' .
                                    ($partner->major ?? '') . ' ' .
                                    ($lastMessage?->body ?? '')
                                )
                            );
                        @endphp

                        <a
                            href="{{ route('messages.index', ['user' => $partner->id]) }}"
                            class="conversation-item {{ $isActive ? 'active' : '' }}"
                            data-conversation-item
                            data-search="{{ $searchText }}"
                        >
                            <div class="conversation-avatar-wrap">

                                <x-user-avatar
                                    :user="$partner"
                                    :size="48"
                                    class="conversation-avatar"
                                />

                            </div>

                            <div class="conversation-copy">

                                <div class="conversation-topline">

                                    <strong>
                                        {{ $partner->name }}
                                    </strong>

                                    @if($lastMessage)
                                        <time>
                                            @if($lastMessage->created_at->isToday())
                                                {{ $lastMessage->created_at->format('H:i') }}
                                            @elseif($lastMessage->created_at->isYesterday())
                                                Kemarin
                                            @else
                                                {{ $lastMessage->created_at->format('d/m') }}
                                            @endif
                                        </time>
                                    @endif

                                </div>

                                <div class="conversation-preview-row">

                                    <p class="{{ $unreadCount > 0 ? 'unread-preview' : '' }}">

                                        @if($lastMessageMine)
                                            <span class="you-prefix">Kamu:</span>
                                        @endif

                                        {{ $lastMessage?->body ?? 'Mulai percakapan' }}

                                    </p>

                                    @if($unreadCount > 0)
                                        <span class="unread-badge">
                                            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                        </span>
                                    @endif

                                </div>

                            </div>
                        </a>

                    @empty

                        <div class="conversation-empty">
                            <div class="conversation-empty-icon">
                                <i class="far fa-comment-dots"></i>
                            </div>

                            <strong>Belum ada percakapan</strong>

                            <p>
                                Mulai ngobrol dengan mahasiswa lain di Interlude.
                            </p>

                            <button
                                type="button"
                                onclick="document.getElementById('openNewMessage').click()"
                            >
                                Mulai percakapan
                            </button>
                        </div>

                    @endforelse

                    <div
                        class="conversation-empty search-empty"
                        id="conversationSearchEmpty"
                        hidden
                    >
                        <div class="conversation-empty-icon">
                            <i class="fas fa-search"></i>
                        </div>

                        <strong>Percakapan tidak ditemukan</strong>

                        <p>
                            Coba gunakan nama atau kata kunci lain.
                        </p>
                    </div>

                </div>

            </aside>

            {{-- =========================================================
                 RIGHT — ACTIVE CHAT
            ========================================================== --}}
            <section class="chat-panel">

                @if($activeUser)

                    {{-- Header --}}
                    <header class="chat-header">

                        <div class="chat-user">

                            <x-user-avatar
                                :user="$activeUser"
                                :size="46"
                                class="chat-user-avatar"
                            />

                            <div class="chat-user-copy">

                                <div class="chat-user-name-row">

                                    <h2>
                                        {{ $activeUser->name }}
                                    </h2>

                                </div>

                                @php
                                    $profileMeta = collect([
                                        $activeUser->major ?? null,
                                        $activeUser->university ?? null,
                                    ])->filter()->implode(' · ');
                                @endphp

                                <p>
                                    {{ $profileMeta ?: ($activeUser->username ? '@'.$activeUser->username : $activeUser->email) }}
                                </p>

                            </div>

                        </div>

                        @if(Route::has('users.show'))
                            <a
                                href="{{ route('users.show', $activeUser) }}"
                                class="chat-profile-link"
                                title="Lihat profil"
                            >
                                <i class="far fa-user"></i>
                            </a>
                        @endif

                    </header>

                    {{-- Messages --}}
                    <div
                        class="chat-stream"
                        id="chatStream"
                    >

                        @if($conversationMessages->isEmpty())

                            <div class="chat-start-empty">

                                <x-user-avatar
                                    :user="$activeUser"
                                    :size="72"
                                    class="chat-empty-avatar"
                                />

                                <h3>
                                    {{ $activeUser->name }}
                                </h3>

                                @php
                                    $emptyMeta = collect([
                                        $activeUser->major ?? null,
                                        $activeUser->university ?? null,
                                    ])->filter()->implode(' · ');
                                @endphp

                                @if($emptyMeta)
                                    <p>{{ $emptyMeta }}</p>
                                @endif

                                <span>
                                    Belum ada pesan. Mulai percakapan dari sini.
                                </span>

                            </div>

                        @else

                            @php
                                $lastDate = null;
                            @endphp

                            @foreach($conversationMessages as $message)

                                @php
                                    $isMine = $message->sender_id === auth()->id();

                                    $messageDate = $message->created_at
                                        ->locale('id')
                                        ->translatedFormat('Y-m-d');
                                @endphp

                                @if($lastDate !== $messageDate)

                                    <div class="chat-date">

                                        @if($message->created_at->isToday())
                                            Hari ini
                                        @elseif($message->created_at->isYesterday())
                                            Kemarin
                                        @else
                                            {{ $message->created_at
                                                ->locale('id')
                                                ->translatedFormat('d F Y') }}
                                        @endif

                                    </div>

                                    @php
                                        $lastDate = $messageDate;
                                    @endphp

                                @endif

                                <div class="message-row {{ $isMine ? 'mine' : 'theirs' }}">

                                    @unless($isMine)

                                        <x-user-avatar
                                            :user="$activeUser"
                                            :size="28"
                                            class="message-small-avatar"
                                        />

                                    @endunless

                                    <div class="message-bubble">

                                        <p>{{ $message->body }}</p>

                                        <div class="message-time">

                                            <span>
                                                {{ $message->created_at->format('H:i') }}
                                            </span>

                                            @if($isMine)

                                                @if($message->read_at)
                                                    <i
                                                        class="fas fa-check-double"
                                                        title="Sudah dibaca"
                                                    ></i>
                                                @else
                                                    <i
                                                        class="fas fa-check"
                                                        title="Terkirim"
                                                    ></i>
                                                @endif

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        @endif

                    </div>

                    {{-- Composer --}}
                    <footer class="chat-composer">

                        <form
                            method="POST"
                            action="{{ route('messages.store') }}"
                            id="messageForm"
                            class="composer-form"
                        >
                            @csrf

                            <input
                                type="hidden"
                                name="recipient_id"
                                value="{{ $activeUser->id }}"
                            >

                            <div class="composer-input-wrap">

                                <textarea
                                    name="body"
                                    id="messageBody"
                                    rows="1"
                                    maxlength="2000"
                                    placeholder="Ketik pesan untuk {{ $activeUser->name }}..."
                                    required
                                >{{ old('recipient_id') == $activeUser->id ? old('body') : '' }}</textarea>

                            </div>

                            <button
                                type="submit"
                                class="send-message-button"
                                id="sendMessageButton"
                                title="Kirim pesan"
                                aria-label="Kirim pesan"
                            >
                                <i class="fas fa-paper-plane"></i>
                            </button>

                        </form>

                        <p class="composer-hint">
                            Enter untuk kirim · Shift + Enter untuk baris baru
                        </p>

                    </footer>

                @else

                    {{-- No active conversation --}}
                    <div class="no-chat-selected">

                        <div class="no-chat-art">
                            <i class="far fa-comments"></i>
                        </div>

                        <span class="messages-kicker">
                            Pesan Interlude
                        </span>

                        <h2>
                            Mulai sebuah percakapan.
                        </h2>

                        <p>
                            Pilih percakapan di sebelah kiri atau kirim pesan baru
                            ke mahasiswa lain.
                        </p>

                        <button
                            type="button"
                            onclick="document.getElementById('openNewMessage').click()"
                            class="start-chat-button"
                        >
                            <i class="far fa-pen-to-square"></i>
                            Pesan baru
                        </button>

                    </div>

                @endif

            </section>

        </section>

    </main>


    {{-- =============================================================
         MODAL PESAN BARU
    ============================================================== --}}
    <dialog
        class="new-message-dialog"
        id="newMessageDialog"
    >

        <div class="new-message-dialog-inner">

            <header class="new-message-dialog-header">

                <div>
                    <span class="messages-kicker">
                        Percakapan baru
                    </span>

                    <h2>
                        Kirim pesan
                    </h2>
                </div>

                <button
                    type="button"
                    id="closeNewMessage"
                    aria-label="Tutup"
                >
                    <i class="fas fa-xmark"></i>
                </button>

            </header>

            <form
                method="GET"
                action="{{ route('messages.index') }}"
                class="new-message-form"
            >

                <label for="newRecipient">
                    Pilih mahasiswa
                </label>

                <select
                    name="user"
                    id="newRecipient"
                    required
                >
                    <option value="">
                        Pilih mahasiswa
                    </option>

                    @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                            @if($user->university ?? null)
                                · {{ $user->university }}
                            @endif
                        </option>
                    @endforeach

                </select>

                <button
                    type="submit"
                    class="open-conversation-button"
                >
                    Mulai percakapan
                    <i class="fas fa-arrow-right"></i>
                </button>

            </form>

        </div>

    </dialog>


    <style>
        :root {
            --msg-brown: #49261D;
            --msg-tangelo: #FB4D00;
            --msg-tangelo-dark: #D94200;
            --msg-linen: #FFEDE3;
            --msg-blue: #CAE7F7;
            --msg-cream: #FFF9F4;
            --msg-white: #FFFFFF;
            --msg-text-soft: #75645E;
            --msg-border: #E8DDD7;
            --msg-surface: #F7F3F0;
        }

        .messages-page {
            min-height: calc(100vh - 80px);
            padding: 28px 4% 48px;
            background: var(--msg-cream);
            font-family: 'DM Sans', sans-serif;
        }

        .messenger-shell {
            width: min(1180px, 100%);
            height: calc(100vh - 150px);
            min-height: 620px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 350px minmax(0, 1fr);
            overflow: hidden;
            border: 1px solid var(--msg-border);
            border-radius: 24px;
            background: var(--msg-white);
            box-shadow: 0 18px 50px rgba(73, 38, 29, .07);
        }

        /* LEFT ====================================================== */

        .conversation-sidebar {
            min-width: 0;
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--msg-border);
            background: #FBF8F6;
        }

        .conversation-header {
            padding: 22px 20px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            background: var(--msg-white);
        }

        .messages-kicker {
            display: block;
            margin-bottom: 4px;
            color: var(--msg-tangelo);
            font: 800 10px/1.2 'Plus Jakarta Sans', sans-serif;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        .conversation-header h1 {
            margin: 0;
            color: var(--msg-brown);
            font: 800 25px/1.15 'Plus Jakarta Sans', sans-serif;
            letter-spacing: -.6px;
        }

        .conversation-header p {
            margin: 5px 0 0;
            color: var(--msg-text-soft);
            font-size: 12px;
        }

        .new-message-button {
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            display: grid;
            place-items: center;
            border: 0;
            border-radius: 50%;
            background: var(--msg-tangelo);
            color: #fff;
            font-size: 15px;
            cursor: pointer;
            box-shadow: 0 5px 14px rgba(251, 77, 0, .2);
            transition: .2s ease;
        }

        .new-message-button:hover {
            background: var(--msg-tangelo-dark);
            transform: translateY(-1px);
        }

        .conversation-search {
            padding: 12px 14px;
            background: var(--msg-white);
            border-top: 1px solid #F3EBE7;
        }

        .conversation-search-box {
            height: 42px;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 0 13px;
            border: 1px solid transparent;
            border-radius: 14px;
            background: var(--msg-surface);
            transition: .2s ease;
        }

        .conversation-search-box:focus-within {
            border-color: rgba(251, 77, 0, .35);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(251, 77, 0, .07);
        }

        .conversation-search-box > i {
            color: #9B8D87;
            font-size: 13px;
        }

        .conversation-search-box input {
            min-width: 0;
            flex: 1;
            border: 0;
            outline: 0;
            background: transparent;
            color: var(--msg-brown);
            font: 13px 'DM Sans', sans-serif;
        }

        .conversation-search-box input::placeholder {
            color: #A99B95;
        }

        .conversation-search-box button {
            display: grid;
            place-items: center;
            padding: 3px;
            border: 0;
            background: transparent;
            color: #A99B95;
            cursor: pointer;
        }

        .conversation-list {
            flex: 1;
            overflow-y: auto;
            padding: 8px;
        }

        .conversation-list::-webkit-scrollbar,
        .chat-stream::-webkit-scrollbar {
            width: 5px;
        }

        .conversation-list::-webkit-scrollbar-thumb,
        .chat-stream::-webkit-scrollbar-thumb {
            background: #DED3CE;
            border-radius: 99px;
        }

        .conversation-item {
            position: relative;
            display: flex;
            gap: 12px;
            padding: 12px;
            margin-bottom: 3px;
            border-radius: 15px;
            color: inherit;
            text-decoration: none;
            transition: .18s ease;
        }

        .conversation-item:hover {
            background: #F1EAE6;
        }

        .conversation-item.active {
            background: var(--msg-white);
            box-shadow: 0 2px 10px rgba(73, 38, 29, .06);
        }

        .conversation-item.active::before {
            content: '';
            position: absolute;
            top: 15px;
            bottom: 15px;
            left: 0;
            width: 3px;
            border-radius: 0 10px 10px 0;
            background: var(--msg-tangelo);
        }

        .conversation-avatar-wrap {
            flex: 0 0 48px;
        }

        .conversation-copy {
            min-width: 0;
            flex: 1;
        }

        .conversation-topline,
        .conversation-preview-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .conversation-topline strong {
            min-width: 0;
            overflow: hidden;
            color: var(--msg-brown);
            font: 700 13px/1.35 'Plus Jakarta Sans', sans-serif;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .conversation-topline time {
            flex: 0 0 auto;
            color: #988983;
            font-size: 10px;
        }

        .conversation-preview-row {
            margin-top: 5px;
        }

        .conversation-preview-row p {
            min-width: 0;
            margin: 0;
            overflow: hidden;
            color: #8B7C76;
            font-size: 12px;
            line-height: 1.4;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .conversation-preview-row p.unread-preview {
            color: var(--msg-brown);
            font-weight: 700;
        }

        .you-prefix {
            color: #6D5E59;
            font-weight: 600;
        }

        .unread-badge {
            min-width: 19px;
            height: 19px;
            padding: 0 5px;
            flex: 0 0 auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 99px;
            background: var(--msg-tangelo);
            color: #fff;
            font: 800 9px 'Plus Jakarta Sans', sans-serif;
        }

        .conversation-empty {
            padding: 45px 22px;
            text-align: center;
            color: var(--msg-text-soft);
        }

        .conversation-empty-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 13px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: var(--msg-linen);
            color: var(--msg-tangelo);
            font-size: 18px;
        }

        .conversation-empty strong {
            display: block;
            color: var(--msg-brown);
            font: 700 14px 'Plus Jakarta Sans', sans-serif;
        }

        .conversation-empty p {
            margin: 7px auto 14px;
            max-width: 220px;
            font-size: 12px;
            line-height: 1.55;
        }

        .conversation-empty button {
            border: 0;
            background: transparent;
            color: var(--msg-tangelo);
            font-weight: 800;
            cursor: pointer;
        }

        /* CHAT ====================================================== */

        .chat-panel {
            min-width: 0;
            display: flex;
            flex-direction: column;
            background: var(--msg-white);
        }

        .chat-header {
            min-height: 74px;
            padding: 13px 19px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            border-bottom: 1px solid var(--msg-border);
            background: rgba(255, 255, 255, .96);
        }

        .chat-user {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .chat-user-copy {
            min-width: 0;
        }

        .chat-user-copy h2 {
            margin: 0;
            overflow: hidden;
            color: var(--msg-brown);
            font: 800 15px/1.3 'Plus Jakarta Sans', sans-serif;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .chat-user-copy p {
            margin: 3px 0 0;
            overflow: hidden;
            color: var(--msg-text-soft);
            font-size: 11px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .chat-profile-link {
            width: 38px;
            height: 38px;
            flex: 0 0 38px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            color: var(--msg-text-soft);
            text-decoration: none;
            transition: .2s ease;
        }

        .chat-profile-link:hover {
            background: var(--msg-linen);
            color: var(--msg-tangelo);
        }

        .chat-stream {
            flex: 1;
            overflow-y: auto;
            padding: 25px 24px;
            background:
                radial-gradient(circle at top right, rgba(202,231,247,.16), transparent 30%),
                #FAF7F5;
        }

        .chat-date {
            width: fit-content;
            margin: 5px auto 20px;
            padding: 5px 10px;
            border-radius: 999px;
            background: #EEE8E4;
            color: #8A7A74;
            font: 700 9px 'Plus Jakarta Sans', sans-serif;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        .message-row {
            width: 100%;
            display: flex;
            align-items: flex-end;
            gap: 8px;
            margin: 7px 0;
        }

        .message-row.mine {
            justify-content: flex-end;
        }

        .message-row.theirs {
            justify-content: flex-start;
        }

        .message-small-avatar {
            flex: 0 0 28px;
            margin-bottom: 3px;
        }

        .message-bubble {
            max-width: min(520px, 72%);
            padding: 10px 12px 7px;
            border-radius: 17px;
            box-shadow: 0 2px 7px rgba(73, 38, 29, .04);
        }

        .message-row.theirs .message-bubble {
            border-bottom-left-radius: 5px;
            background: var(--msg-white);
            color: #382721;
        }

        .message-row.mine .message-bubble {
            border-bottom-right-radius: 5px;
            background: var(--msg-tangelo);
            color: #fff;
        }

        .message-bubble p {
            margin: 0;
            font-size: 13px;
            line-height: 1.55;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
        }

        .message-time {
            margin-top: 4px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 4px;
            font-size: 9px;
        }

        .message-row.theirs .message-time {
            color: #A1938D;
        }

        .message-row.mine .message-time {
            color: rgba(255,255,255,.78);
        }

        .message-time i {
            font-size: 9px;
        }

        .chat-start-empty {
            min-height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--msg-text-soft);
        }

        .chat-start-empty h3 {
            margin: 14px 0 3px;
            color: var(--msg-brown);
            font: 800 18px 'Plus Jakarta Sans', sans-serif;
        }

        .chat-start-empty p,
        .chat-start-empty span {
            margin: 3px 0;
            font-size: 12px;
        }

        /* Composer ================================================== */

        .chat-composer {
            padding: 13px 18px 11px;
            border-top: 1px solid var(--msg-border);
            background: var(--msg-white);
        }

        .composer-form {
            display: flex;
            align-items: flex-end;
            gap: 9px;
        }

        .composer-input-wrap {
            min-height: 45px;
            flex: 1;
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border: 1px solid transparent;
            border-radius: 18px;
            background: var(--msg-surface);
            transition: .2s ease;
        }

        .composer-input-wrap:focus-within {
            border-color: rgba(251,77,0,.28);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(251,77,0,.06);
        }

        .composer-input-wrap textarea {
            width: 100%;
            max-height: 120px;
            padding: 0;
            resize: none;
            overflow-y: auto;
            border: 0;
            outline: 0;
            background: transparent;
            color: var(--msg-brown);
            font: 13px/1.5 'DM Sans', sans-serif;
        }

        .composer-input-wrap textarea::placeholder {
            color: #A1938D;
        }

        .send-message-button {
            width: 45px;
            height: 45px;
            flex: 0 0 45px;
            display: grid;
            place-items: center;
            border: 0;
            border-radius: 50%;
            background: var(--msg-tangelo);
            color: #fff;
            cursor: pointer;
            box-shadow: 0 5px 13px rgba(251, 77, 0, .22);
            transition: .2s ease;
        }

        .send-message-button:hover {
            transform: translateY(-1px);
            background: var(--msg-tangelo-dark);
        }

        .composer-hint {
            margin: 6px 5px 0;
            color: #AA9C96;
            font-size: 9px;
        }

        /* no chat ================================================== */

        .no-chat-selected {
            height: 100%;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            background:
                radial-gradient(circle at center, rgba(202,231,247,.2), transparent 34%),
                #FAF7F5;
        }

        .no-chat-art {
            width: 78px;
            height: 78px;
            margin-bottom: 18px;
            display: grid;
            place-items: center;
            border-radius: 25px;
            background: var(--msg-blue);
            color: var(--msg-brown);
            font-size: 28px;
            transform: rotate(-3deg);
        }

        .no-chat-selected h2 {
            max-width: 430px;
            margin: 4px 0 8px;
            color: var(--msg-brown);
            font: 800 clamp(25px, 3vw, 36px)/1.15 'Plus Jakarta Sans', sans-serif;
            letter-spacing: -1px;
        }

        .no-chat-selected p {
            max-width: 430px;
            margin: 0 0 20px;
            color: var(--msg-text-soft);
            font-size: 13px;
            line-height: 1.6;
        }

        .start-chat-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 17px;
            border: 0;
            border-radius: 999px;
            background: var(--msg-brown);
            color: #fff;
            font-weight: 800;
            cursor: pointer;
        }

        /* Alerts =================================================== */

        .messages-toast,
        .messages-error {
            width: min(1180px, 100%);
            margin: 0 auto 12px;
            padding: 11px 14px;
            display: flex;
            align-items: center;
            gap: 9px;
            border-radius: 12px;
            font-size: 12px;
        }

        .messages-toast {
            background: #E8F4ED;
            color: #286749;
        }

        .messages-error {
            background: #FFF0ED;
            color: #A93624;
        }

        /* Dialog =================================================== */

        .new-message-dialog {
            width: min(440px, calc(100% - 32px));
            margin: auto;
            padding: 0;
            border: 0;
            border-radius: 22px;
            background: var(--msg-white);
            box-shadow: 0 30px 80px rgba(48,18,10,.22);
            overflow: hidden;
        }

        .new-message-dialog::backdrop {
            background: rgba(48,18,10,.3);
            backdrop-filter: blur(4px);
        }

        .new-message-dialog-inner {
            padding: 23px;
        }

        .new-message-dialog-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
        }

        .new-message-dialog-header h2 {
            margin: 4px 0 0;
            color: var(--msg-brown);
            font: 800 23px 'Plus Jakarta Sans', sans-serif;
        }

        .new-message-dialog-header button {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border: 0;
            border-radius: 50%;
            background: var(--msg-surface);
            color: var(--msg-text-soft);
            cursor: pointer;
        }

        .new-message-form {
            margin-top: 24px;
            display: grid;
            gap: 9px;
        }

        .new-message-form label {
            color: var(--msg-brown);
            font-size: 12px;
            font-weight: 800;
        }

        .new-message-form select {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid var(--msg-border);
            border-radius: 13px;
            outline: 0;
            background: var(--msg-cream);
            color: var(--msg-brown);
            font: 13px 'DM Sans', sans-serif;
        }

        .new-message-form select:focus {
            border-color: var(--msg-tangelo);
            box-shadow: 0 0 0 3px rgba(251,77,0,.08);
        }

        .open-conversation-button {
            margin-top: 8px;
            padding: 12px 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border: 0;
            border-radius: 999px;
            background: var(--msg-brown);
            color: #fff;
            font-weight: 800;
            cursor: pointer;
        }

        .open-conversation-button:hover {
            background: var(--msg-tangelo);
        }

        /* Responsive ============================================== */

        @media (max-width: 820px) {
            .messages-page {
                padding: 14px 3% 40px;
            }

            .messenger-shell {
                height: auto;
                min-height: 0;
                grid-template-columns: 1fr;
                border-radius: 19px;
            }

            .conversation-sidebar {
                max-height: 420px;
                border-right: 0;
                border-bottom: 1px solid var(--msg-border);
            }

            .chat-panel {
                min-height: 620px;
            }

            .message-bubble {
                max-width: 82%;
            }
        }

        @media (max-width: 520px) {
            .conversation-header {
                padding: 18px 16px 15px;
            }

            .chat-header {
                padding: 11px 14px;
            }

            .chat-stream {
                padding: 20px 12px;
            }

            .chat-composer {
                padding: 11px;
            }

            .composer-hint {
                display: none;
            }

            .message-bubble {
                max-width: 88%;
            }
        }
    </style>


    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | Scroll chat langsung ke pesan terakhir
            |--------------------------------------------------------------------------
            */

            const chatStream = document.getElementById('chatStream');

            if (chatStream) {
                chatStream.scrollTop = chatStream.scrollHeight;
            }


            /*
            |--------------------------------------------------------------------------
            | Search conversation
            |--------------------------------------------------------------------------
            */

            const searchInput = document.getElementById('conversationSearch');
            const clearSearch = document.getElementById('clearConversationSearch');
            const conversationItems = document.querySelectorAll('[data-conversation-item]');
            const searchEmpty = document.getElementById('conversationSearchEmpty');

            function filterConversations() {
                if (!searchInput) return;

                const query = searchInput.value
                    .trim()
                    .toLowerCase();

                let visibleCount = 0;

                conversationItems.forEach(function (item) {
                    const searchText = (
                        item.dataset.search || ''
                    ).toLowerCase();

                    const visible = searchText.includes(query);

                    item.style.display = visible
                        ? 'flex'
                        : 'none';

                    if (visible) {
                        visibleCount++;
                    }
                });

                if (searchEmpty) {
                    searchEmpty.hidden =
                        query === ''
                        || visibleCount > 0;
                }
            }

            if (searchInput) {
                searchInput.addEventListener(
                    'input',
                    filterConversations
                );
            }

            if (clearSearch && searchInput) {
                clearSearch.addEventListener('click', function () {
                    searchInput.value = '';
                    filterConversations();
                    searchInput.focus();
                });
            }


            /*
            |--------------------------------------------------------------------------
            | New message dialog
            |--------------------------------------------------------------------------
            */

            const dialog = document.getElementById('newMessageDialog');
            const openDialog = document.getElementById('openNewMessage');
            const closeDialog = document.getElementById('closeNewMessage');

            if (dialog && openDialog) {
                openDialog.addEventListener('click', function () {
                    dialog.showModal();
                });
            }

            if (dialog && closeDialog) {
                closeDialog.addEventListener('click', function () {
                    dialog.close();
                });
            }

            if (dialog) {
                dialog.addEventListener('click', function (event) {
                    const rect = dialog.getBoundingClientRect();

                    const outside =
                        event.clientX < rect.left
                        || event.clientX > rect.right
                        || event.clientY < rect.top
                        || event.clientY > rect.bottom;

                    if (outside) {
                        dialog.close();
                    }
                });
            }


            /*
            |--------------------------------------------------------------------------
            | Auto grow textarea
            |--------------------------------------------------------------------------
            */

            const messageBody = document.getElementById('messageBody');
            const messageForm = document.getElementById('messageForm');

            function resizeMessageInput() {
                if (!messageBody) return;

                messageBody.style.height = 'auto';

                messageBody.style.height =
                    Math.min(
                        messageBody.scrollHeight,
                        120
                    ) + 'px';
            }

            if (messageBody) {
                messageBody.addEventListener(
                    'input',
                    resizeMessageInput
                );

                resizeMessageInput();

                /*
                 * Enter = kirim
                 * Shift + Enter = baris baru
                 */
                messageBody.addEventListener('keydown', function (event) {

                    if (
                        event.key === 'Enter'
                        && !event.shiftKey
                    ) {
                        event.preventDefault();

                        if (
                            messageBody.value.trim() !== ''
                            && messageForm
                        ) {
                            messageForm.requestSubmit();
                        }
                    }

                });
            }


            /*
            |--------------------------------------------------------------------------
            | Hindari double submit
            |--------------------------------------------------------------------------
            */

            if (messageForm) {
                messageForm.addEventListener('submit', function () {

                    const sendButton =
                        document.getElementById('sendMessageButton');

                    if (sendButton) {
                        sendButton.disabled = true;
                        sendButton.style.opacity = '.65';
                    }

                });
            }


            /*
            |--------------------------------------------------------------------------
            | Hilangkan toast otomatis
            |--------------------------------------------------------------------------
            */

            const toast = document.getElementById('messagesToast');

            if (toast) {
                setTimeout(function () {
                    toast.style.transition = '.25s ease';
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(-5px)';

                    setTimeout(function () {
                        toast.remove();
                    }, 250);

                }, 2800);
            }

        });
    </script>

</x-app-layout>