@props(['name', 'label', 'options' => [], 'value' => '', 'placeholder' => 'Sélectionnez une option'])

<div class="form-group">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
    </label>

    <select 
        name="{{ $name }}" 
        id="{{ $name }}" 
        {{ $attributes->class([
            'form-control',
            'is-invalid' => $errors->has($name)
        ]) }}
    >
        <option value="" disabled {{ old($name, $value) === '' ? 'selected' : '' }}>
            {{ $placeholder }}
        </option>

        @foreach($options as $key => $optionLabel)
            <option 
                value="{{ $key }}" 
                
                {{--  garder la sélection --}}
                @selected(old($name, $value) == $key)
            >
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>

    @error($name)
        <div class="invalid-feedback">
            <i class="fas fa-exclamation-circle"></i> {{ $message }}
        </div>
    @enderror
</div>