@props([
    'name',
    'label' => false,
    'value' => '',
    'placeholder' => '',
    'rows' => 3,
    'id' => null,
])

@php
    $textareaId = $id ?? $name;
@endphp

<div class="mb-3">
    @if($label)
        <label for="{{ $textareaId }}" class="form-label fw-semibold">
            {{ $label }}
            @if($attributes->has('required'))
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <textarea 
        name="{{ $name }}" 
        id="{{ $textareaId }}" 
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'form-control ' . ($errors->has($name) ? 'is-invalid' : '')]) }}
    >{!! old($name, $value) !!}</textarea>

    @error($name)
        <div class="invalid-feedback fw-semibold">
            {{ $message }}
        </div>
    @enderror
</div>