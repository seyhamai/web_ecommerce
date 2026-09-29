@props([
    'name',
    'label' => false,
    'id' => null,
    'noWrapper' => false,
])

@php
    $selectId = $id ?? $name;
@endphp

@if(!$noWrapper)
<div class="mb-3">
@endif

    @if($label)
        <label for="{{ $selectId }}" class="form-label fw-semibold">
            {{ $label }}
            @if($attributes->has('required'))
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <select 
        name="{{ $name }}" 
        id="{{ $selectId }}" 
        {{ $attributes->merge(['class' => 'form-select ' . ($errors->has($name) ? 'is-invalid' : '')]) }}
    >
        <!-- The $slot variable allows us to put <option> tags inside the component -->
        {{ $slot }}
    </select>

    @error($name)
        <div class="invalid-feedback fw-semibold">
            {{ $message }}
        </div>
    @enderror

@if(!$noWrapper)
</div>
@endif