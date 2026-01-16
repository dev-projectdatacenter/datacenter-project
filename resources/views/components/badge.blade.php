@props(['status'])

@php
    // Logique pour déterminer la couleur selon le mot clé
    $colorClass = match(strtolower($status)) {
        'active', 'approuvée', 'validée', 'en ligne' => 'badge-success',
        'refusée', 'panne', 'inactif' => 'badge-danger',
        'en attente', 'maintenance' => 'badge-warning',
        default => 'badge-info',
    };
@endphp

<span class="badge {{ $colorClass }}">
    {{ $status }}
</span>