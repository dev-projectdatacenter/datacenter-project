@props(['name', 'label', 'type' => 'text', 'placeholder' => '', 'value' => ''])

<div class="form-group">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
    </label>

    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        placeholder="{{ $placeholder }}"
        
        {{-- La valeur est soit la "vieille" valeur (si erreur), soit la valeur par défaut --}}
        value="{{ old($name, $value) }}"
        
        {{-- Fusion des classes CSS : Ajoute 'is-invalid' si il y a une erreur sur ce champ --}}
        {{ $attributes->class([
            'form-control',
            'is-invalid' => $errors->has($name)
        ]) }}
    >

    @error($name)
        <div class="invalid-feedback">
            <i class="fas fa-exclamation-circle"></i> {{ $message }}
        </div>
    @enderror
</div>