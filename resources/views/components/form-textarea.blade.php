@props(['name', 'label', 'value' => '', 'placeholder' => '', 'rows' => 5])

<div class="form-group">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
    </label>

    <textarea 
        name="{{ $name }}" 
        id="{{ $name }}" 
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->class([
            'form-control',
            'is-invalid' => $errors->has($name)
        ]) }}
    >{{ old($name, $value) }}</textarea>

    @error($name)
        <div class="invalid-feedback">
            <i class="fas fa-exclamation-circle"></i> {{ $message }}
        </div>
    @enderror
</div>