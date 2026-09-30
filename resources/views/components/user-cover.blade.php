@props(['user'])

@php
    $preset = $user->cover_preset ?: 'jeda-blue';
    $styles = [
        'jeda-blue' => 'background: radial-gradient(circle at 82% 28%, rgba(255,255,255,.72) 0 7%, transparent 7.4%), radial-gradient(circle at 14% 78%, rgba(251,77,0,.16) 0 11%, transparent 11.5%), linear-gradient(135deg,#CAE7F7 0%,#EAF6FC 48%,#FFEDE3 100%);',
        'linen-wave' => 'background: radial-gradient(ellipse at 12% 20%, rgba(251,77,0,.18) 0 16%, transparent 16.5%), radial-gradient(ellipse at 88% 76%, rgba(202,231,247,.92) 0 24%, transparent 24.5%), linear-gradient(135deg,#FFF7F2,#FFEDE3);',
        'tangelo-dawn' => 'background: radial-gradient(circle at 78% 16%, rgba(255,255,255,.72) 0 9%, transparent 9.5%), linear-gradient(120deg,#FB4D00 0%,#FF8C5A 38%,#FFD7C5 100%);',
        'brown-study' => 'background: radial-gradient(circle at 20% 22%, rgba(202,231,247,.30) 0 12%, transparent 12.5%), radial-gradient(circle at 78% 72%, rgba(255,237,227,.18) 0 20%, transparent 20.5%), linear-gradient(135deg,#30120A,#49261D 52%,#73483C);',
        'sage-notes' => 'background: radial-gradient(circle at 72% 22%, rgba(255,255,255,.60) 0 8%, transparent 8.5%), linear-gradient(135deg,#DDF4E7,#B9DEC7 52%,#CAE7F7);',
    ];
    $style = $styles[$preset] ?? $styles['jeda-blue'];
@endphp

@if(!empty($user->cover_image))
    <img
        src="{{ asset('storage/' . $user->cover_image) }}"
        alt="Sampul profil {{ $user->name }}"
        {{ $attributes->merge(['class' => 'interlude-user-cover']) }}
        style="width:100%;height:100%;object-fit:cover;display:block;"
    >
@else
    <div
        {{ $attributes->merge(['class' => 'interlude-user-cover']) }}
        style="width:100%;height:100%;{{ $style }} position:relative;overflow:hidden;"
    >
        <span style="position:absolute;right:5%;bottom:10%;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;letter-spacing:.16em;text-transform:uppercase;color:rgba(73,38,29,.36);">Interlude</span>
    </div>
@endif
