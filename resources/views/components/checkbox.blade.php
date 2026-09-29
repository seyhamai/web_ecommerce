@props([
    'name',
    'label' => false,
    'value' => '1', // Default value sent when checked
    'checked' => false, // Initial state from database
    'isSwitch' => false, // Turn into a toggle switch?
    'id' => null,
])

@php
    $checkboxId = $id ?? $name;
    $isChecked = old() ? old($name) == $value : $checked;
@endphp

<div class="mb-3 form-check {{ $isSwitch ? 'form-switch' : '' }}">

    <input type="hidden" name="{{ $name }}" value="0">
    
    <input 
        type="checkbox" 
        name="{{ $name }}" 
        id="{{ $checkboxId }}" 
        value="{{ $value }}"
        {{ $isChecked ? 'checked' : '' }}
        {{ $attributes->merge(['class' => 'form-check-input ' . ($errors->has($name) ? 'is-invalid' : '')]) }}
    >
    
    @if($label)
        <label class="form-check-label fw-semibold" for="{{ $checkboxId }}">
            {{ $label }}
            @if($attributes->has('required'))
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    @error($name)
        <div class="invalid-feedback fw-semibold d-block">
            {{ $message }}
        </div>
    @enderror
</div>