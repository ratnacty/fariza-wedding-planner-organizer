@props(['flip' => false])

<svg viewBox="0 0 220 200" aria-hidden="true" {{ $attributes->merge(['class' => 'w-24 sm:w-32 lg:w-40 h-auto '.($flip ? '-scale-x-100' : '')]) }}>
    <defs>
        <path id="corner-rose-petal" d="M0,-2 C -7,-9 -8,-20 0,-27 C 8,-20 7,-9 0,-2 Z" />
        <g id="corner-rose-petals">
            <use href="#corner-rose-petal" transform="rotate(0)" />
            <use href="#corner-rose-petal" transform="rotate(60)" />
            <use href="#corner-rose-petal" transform="rotate(120)" />
            <use href="#corner-rose-petal" transform="rotate(180)" />
            <use href="#corner-rose-petal" transform="rotate(240)" />
            <use href="#corner-rose-petal" transform="rotate(300)" />
        </g>
    </defs>

    {{-- stems --}}
    <path d="M10 196 C 45 150, 78 128, 122 136" stroke="#f6cdd6" stroke-width="2.5" stroke-linecap="round" fill="none" opacity="0.45" />
    <path d="M20 199 C 58 168, 96 160, 138 176" stroke="#f5d6c9" stroke-width="2.5" stroke-linecap="round" fill="none" opacity="0.4" />
    <path d="M40 178 q 14 -18 30 -10" stroke="#f6cdd6" stroke-width="2.5" stroke-linecap="round" fill="none" opacity="0.4" />

    {{-- leaves --}}
    <path d="M60 172 C 68 160, 82 158, 88 168 C 80 174, 66 178, 60 172 Z" fill="#f5d6c9" opacity="0.35" />
    <path d="M96 186 C 104 176, 118 175, 122 184 C 114 190, 100 192, 96 186 Z" fill="#eea3b3" opacity="0.3" />

    {{-- roses: an outer <g> fixes each bloom's position/scale via an SVG attribute so the
         inner .footer-bloom <g> is free to animate its own CSS transform for the float,
         without the animation clobbering the placement. --}}
    <g transform="translate(52,150) scale(1.5)">
        <g class="footer-bloom">
            <use href="#corner-rose-petals" fill="#fdf6f3" opacity="0.9" />
            <use href="#corner-rose-petals" fill="#f6cdd6" opacity="0.75" transform="scale(0.55) rotate(30)" />
            <circle r="3.2" fill="#fff" opacity="0.9" />
        </g>
    </g>

    <g transform="translate(106,178) scale(1.15)">
        <g class="footer-bloom" style="animation-delay:.7s">
            <use href="#corner-rose-petals" fill="#fbe7ea" opacity="0.85" />
            <use href="#corner-rose-petals" fill="#eea3b3" opacity="0.7" transform="scale(0.55) rotate(20)" />
            <circle r="2.8" fill="#fff" opacity="0.85" />
        </g>
    </g>

    <g transform="translate(152,142) scale(0.85)">
        <g class="footer-bloom" style="animation-delay:1.4s">
            <use href="#corner-rose-petals" fill="#fdf6f3" opacity="0.8" />
            <use href="#corner-rose-petals" fill="#f6cdd6" opacity="0.65" transform="scale(0.55) rotate(15)" />
            <circle r="2.4" fill="#fff" opacity="0.85" />
        </g>
    </g>

    <g transform="translate(26,186) scale(0.6)">
        <g class="footer-bloom" style="animation-delay:.35s">
            <use href="#corner-rose-petals" fill="#f5d6c9" opacity="0.75" />
            <circle r="2.2" fill="#fff" opacity="0.8" />
        </g>
    </g>
</svg>
