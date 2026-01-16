@props(['variant' => 'primary'])

@php
    // On définit la classe CSS en fonction de la variante choisie
    $class = match($variant) {
        'primary' => 'btn btn-primary',
        'danger' => 'btn btn-danger',
        'secondary' => 'btn', // par défaut gris/blanc selon ton CSS
        default => 'btn btn-primary',
    };
@endphp

<button {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</button>