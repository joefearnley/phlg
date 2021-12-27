@props(['active'])

@php
$classes = ($active ?? false)
            ? 'font-semi-bold inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-blue focus:outline-none'
            : 'inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-blue focus:outline-none';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
