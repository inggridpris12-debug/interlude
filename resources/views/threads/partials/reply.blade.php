@php
    $level = $level ?? 0;
    $children = $reply->childrenRecursive ?? collect();
@endphp

<div
    class="comment-node"
    style="--reply-depth: {{ min($level, 4) }};"
>

    <div class="comment-rail">

        <div class="comment-avatar">
            {{ strtoupper(substr($reply->user->name, 0, 1)) }}
        </div>

        @if($children->isNotEmpty())
            <div class="comment-line"></div>
        @endif

    </div>


    <div class="comment-content">

        <div class="comment-byline">
            <strong>{{ $reply->user->name }}</strong>

            <span>
                {{ $reply->created_at->locale('id')->diffForHumans() }}
            </span>
        </div>


        <p>{{ $reply->body }}</p>


        @include('threads.partials.attachments', [
            'attachments' => $reply->attachments,
        ])


        <button
            type="button"
            class="comment-reply-btn"
            data-toggle-comment-reply="{{ $reply->id }}"
        >
            <i class="fas fa-reply"></i>
            Balas
        </button>


        <form
            method="POST"
            action="{{ route('threads.replies.store', $thread) }}"
            enctype="multipart/form-data"
            class="nested-reply-form"
            id="commentReply{{ $reply->id }}"
            hidden
        >
            @csrf

            <input
                type="hidden"
                name="parent_id"
                value="{{ $reply->id }}"
            >

            <textarea
                name="body"
                rows="2"
                maxlength="280"
                placeholder="Balas {{ $reply->user->name }}..."
                required
            ></textarea>

            <div class="reply-attachment-row">
                <label title="Foto/GIF">
                    <i class="far fa-image"></i>
                    <input
                        type="file"
                        name="reply_images[]"
                        accept="image/*,.gif"
                        multiple
                    >
                </label>

                <label title="Dokumen">
                    <i class="fas fa-paperclip"></i>
                    <input
                        type="file"
                        name="reply_files[]"
                        accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt"
                        multiple
                    >
                </label>

                <label title="Video">
                    <i class="fas fa-video"></i>
                    <input
                        type="file"
                        name="reply_video"
                        accept="video/mp4,video/webm,video/quicktime"
                    >
                </label>

                <label title="Audio">
                    <i class="fas fa-headphones"></i>
                    <input
                        type="file"
                        name="reply_audio"
                        accept="audio/*"
                    >
                </label>

                <input
                    class="reply-link-input"
                    type="url"
                    name="reply_link"
                    placeholder="Tempel link..."
                >
            </div>

            <div class="nested-reply-footer">
                <span>Maks. 280 karakter</span>

                <button type="submit">
                    Balas
                </button>
            </div>
        </form>


        @if($children->isNotEmpty())
            <div class="comment-children">

                @foreach($children as $child)

                    @include('threads.partials.reply', [
                        'reply' => $child,
                        'thread' => $thread,
                        'level' => $level + 1,
                    ])

                @endforeach

            </div>
        @endif

    </div>

</div>
