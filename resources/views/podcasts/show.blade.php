<x-app-layout>
    @if($podcast->media_type === 'video')
        @include('podcasts.partials.video-detail', ['podcast' => $podcast, 'relatedEpisodes' => $relatedEpisodes])
    @else
        @include('podcasts.partials.audio-detail', ['podcast' => $podcast, 'relatedEpisodes' => $relatedEpisodes])
    @endif
</x-app-layout>
