@props([
    'name',
    'label' => false,
    'existingImages' => [], // Expects an array of objects/arrays with 'id' and 'url'
    'id' => null,
])

@php
    $inputId = $id ?? $name;
@endphp

<div class="mb-3 multi-image-uploader">
    @if($label)
        <label for="{{ $inputId }}" class="form-label fw-semibold">
            {{ $label }}
            @if($attributes->has('required'))
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <!-- The File Input (Notice name="[]" and the 'multi-upload-input' class) -->
    <input 
        type="file" 
        name="{{ $name }}[]" 
        id="{{ $inputId }}" 
        multiple 
        accept="image/*"
        {{ $attributes->merge(['class' => 'form-control multi-upload-input ' . ($errors->has($name) ? 'is-invalid' : '')]) }}
    >

    @error($name)
        <div class="invalid-feedback fw-semibold">
            {{ $message }}
        </div>
    @enderror

    <!-- Existing Images Grid (Shown only when editing) -->
    @if(count($existingImages) > 0)
        <div class="mt-3 p-3 bg-white border rounded shadow-sm">
            <label class="form-label text-muted small fw-bold mb-2">Currently Saved Images</label>
            <div class="d-flex flex-wrap gap-3">
                @foreach($existingImages as $image)
                    <div class="position-relative text-center">
                        <img src="{{ asset($image['url']) }}" alt="Product Image" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                        <!-- Auto-generates a delete checkbox for the backend -->
                        <div class="form-check mt-1 text-start">
                            <input class="form-check-input border-danger" type="checkbox" name="delete_images[]" value="{{ $image['id'] }}" id="del_{{ $image['id'] }}">
                            <label class="form-check-label text-danger small fw-semibold" for="del_{{ $image['id'] }}">Remove</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Container where our JavaScript will instantly preview newly selected files -->
    <div class="mt-3 new-image-previews d-flex flex-wrap gap-2"></div>
</div>