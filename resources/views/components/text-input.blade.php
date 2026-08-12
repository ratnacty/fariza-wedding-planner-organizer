@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-blush-200 focus:border-rose-400 focus:ring-rose-300 rounded-lg shadow-sm']) }}>
