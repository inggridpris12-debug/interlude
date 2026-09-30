@props([
    'user',
    'size' => 40,
])

@php
    $presets = [
        'botticelli' => ['#CAE7F7', '#8FC6DE', '#49261D'],
        'linen' => ['#FFEDE3', '#FFCBB7', '#49261D'],
        'tangelo' => ['#FB4D00', '#FF8C5A', '#FFFFFF'],
        'sage' => ['#DDF4E7', '#9FD0B3', '#315B43'],
        'chocolate' => ['#49261D', '#7D4A3D', '#FFFFFF'],
    ];

    $fallbackKeys = array_keys($presets);
    $presetKey = $user->profile_avatar_preset
        ?: $fallbackKeys[((int) $user->id) % count($fallbackKeys)];
    $palette = $presets[$presetKey] ?? $presets['botticelli'];
    $initial = strtoupper(mb_substr(trim($user->name ?? 'I'), 0, 1));
    $px = is_numeric($size) ? (int) $size : 40;
@endphp

@if(!empty($user->profile_photo))
    <img
        src="{{ asset('storage/' . $user->profile_photo) }}"
        alt="Foto profil {{ $user->name }}"
        {{ $attributes->merge(['class' => 'interlude-user-avatar']) }}
        style="width: {{ $px }}px; height: {{ $px }}px; border-radius: 999px; object-fit: cover; display:block;"
    >
@else
    <span
        {{ $attributes->merge(['class' => 'interlude-user-avatar']) }}
        aria-label="Avatar {{ $user->name }}"
        style="width: {{ $px }}px; height: {{ $px }}px; border-radius: 999px; display:inline-flex; align-items:center; justify-content:center; flex:0 0 {{ $px }}px; background:linear-gradient(135deg, {{ $palette[0] }}, {{ $palette[1] }}); color:{{ $palette[2] }}; font-family:'Plus Jakarta Sans',sans-serif; font-size:{{ max(12, (int) round($px * .32)) }}px; font-weight:800; overflow:hidden;"
    >
        {{ $initial }}
    </span>
@endif
