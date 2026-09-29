@props([
    'name',
    'label' => false,
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'id' => null,
    'noWrapper' => false, // <-- NEW PROP
])

@php
    $inputId = $id ?? $name;
@endphp

<!-- Only wrap in a div if we ARE NOT in an input-group -->
@if(!$noWrapper)
<div class="mb-3">
@endif

    <!-- Optional Label -->
    @if($label)
        <label for="{{ $inputId }}" class="form-label fw-semibold">
            {{ $label }}
            @if($attributes->has('required'))
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <!-- The Input Field -->
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $inputId }}" 
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'form-control ' . ($errors->has($name) ? 'is-invalid' : '')]) }}
    >

    <!-- Automatic Error Handling -->
    @error($name)
        <div class="invalid-feedback fw-semibold">
            {{ $message }}
        </div>
    @enderror

@if(!$noWrapper)
</div>
@endif