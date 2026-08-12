@props(['color' => 'rose', 'label' => null, 'class' => '', 'src' => null])

@php
    $gradients = [
        'rose' => 'from-rose-200 via-rose-100 to-blush-100',
        'blush' => 'from-blush-200 via-blush-100 to-rose-100',
    ];
    $gradient = $gradients[$color] ?? $gradients['rose'];
    // Tailwind's stylesheet order puts .relative after .absolute/.fixed, so a caller-supplied
    // positioning class would silently lose to a hardcoded "relative" here — only default to
    // relative when the caller hasn't already established a position of their own.
    $needsPositioning = ! preg_match('/\b(absolute|fixed|sticky|static)\b/', $class);
@endphp

<div {{ $attributes->merge(['class' => trim(($needsPositioning ? 'relative ' : '')."overflow-hidden bg-gradient-to-br {$gradient} {$class}")]) }}>
    @if($src)
        <img src="{{ $src }}" alt="{{ $label ?? '' }}" class="absolute inset-0 w-full h-full object-cover">
    @else
        <div class="absolute inset-0 opacity-40" style="background-image: radial-gradient(circle at 20% 20%, rgba(255,255,255,.6) 0, transparent 40%), radial-gradient(circle at 80% 70%, rgba(255,255,255,.5) 0, transparent 45%);"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <svg viewBox="0 0 64 64" class="w-12 h-12 md:w-14 md:h-14 text-white/70" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M32 44c-8-6-16-11-16-20a9 9 0 0 1 16-6 9 9 0 0 1 16 6c0 9-8 14-16 20Z" stroke-linejoin="round"/>
                <circle cx="32" cy="12" r="4"/>
            </svg>
        </div>
    @endif
    @if($label)
        <span class="absolute bottom-3 left-3 text-[11px] font-medium text-white/90 bg-black/10 backdrop-blur-sm rounded-full px-3 py-1">{{ $label }}</span>
    @endif
</div>
