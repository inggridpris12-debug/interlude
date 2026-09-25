@php
    $poll = $poll ?? null;
@endphp

@if($poll)
    @php
        $totalVotes = $poll->votes->count();
        $myVote = $poll->votes->firstWhere('user_id', Auth::id());
    @endphp

    <div class="thread-poll" data-stop-thread-click>

        <strong class="thread-poll-question">
            {{ $poll->question }}
        </strong>

        <div class="thread-poll-options">

            @foreach($poll->options as $option)

                @php
                    $votes = $option->votes->count();

                    $percent = $totalVotes > 0
                        ? round(($votes / $totalVotes) * 100)
                        : 0;

                    $selected = $myVote
                        && $myVote->thread_poll_option_id === $option->id;
                @endphp

                <form
                    method="POST"
                    action="{{ route('threads.poll.vote', [$thread, $poll]) }}"
                >
                    @csrf

                    <input
                        type="hidden"
                        name="option_id"
                        value="{{ $option->id }}"
                    >

                    <button
                        type="submit"
                        class="poll-option {{ $selected ? 'is-selected' : '' }}"
                    >
                        <span
                            class="poll-option-fill"
                            style="width: {{ $percent }}%;"
                        ></span>

                        <span class="poll-option-label">
                            {{ $option->label }}
                        </span>

                        <span class="poll-option-percent">
                            {{ $percent }}%
                        </span>
                    </button>
                </form>

            @endforeach

        </div>

        <span class="thread-poll-total">
            {{ $totalVotes }} suara
        </span>

    </div>
@endif
