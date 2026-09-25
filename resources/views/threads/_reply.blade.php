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
                    @include('threads._reply', [
                        'reply' => $child,
                        'thread' => $thread,
                        'level' => $level + 1,
                    ])
                @endforeach
            </div>
        @endif

    </div>

</div>
