@props(['type' => 'info'])

@php
    // 1. On définit les couleurs dynamiques
    $theme = match($type) {
        'success' => 'background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0;',
        'error', 'danger' => 'background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca;',
        'warning' => 'background-color: #fef9c3; color: #854d0e; border: 1px solid #fde047;',
        default => 'background-color: #e0f2fe; color: #075985; border: 1px solid #bae6fd;',
    };

    // 2. On combine avec le style de base (padding, radius, etc.)
    // Comme ça, tout est dans une variable PHP, VS Code ne râlera plus !
    $style = "padding: 1rem; border-radius: 8px; margin-bottom: 1rem; display: flex; align-items: center; {$theme}";
@endphp

<div style="{{ $style }}" {{ $attributes }}>
    
    <span style="margin-right: 10px; font-size: 1.2em;">
        @if($type === 'success')
            <i class="fas fa-check-circle"></i>
        @elseif($type === 'error' || $type === 'danger')
            <i class="fas fa-exclamation-circle"></i>
        @elseif($type === 'warning')
            <i class="fas fa-exclamation-triangle"></i>
        @else
            <i class="fas fa-info-circle"></i>
        @endif
    </span>

    <div>
        {{ $slot }}
    </div>
    
</div>