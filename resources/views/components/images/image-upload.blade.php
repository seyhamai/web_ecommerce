@props([
    'name' => 'image',       // The input name (e.g., primary_image, image)
    'id' => 'imageInput',    // Unique ID so JS doesn't conflict
    'label' => 'Image',      // The label text
    'existingImage' => null  // Passes existing image URL for edit forms
])

<div class="mb-4">
    <label class="form-label fw-bold d-block">
        {{ $label }}
        @if($attributes->has('required'))
            <span class="text-danger">*</span>
        @endif
    </label>
    
    <!-- Changes border to red if there's a validation error -->
    <div class="border border-2 rounded bg-light text-center p-5 w-100 position-relative" 
         style="border-style: dashed !important; border-color: {{ $errors->has($name) ? '#dc3545' : '#dee2e6' }} !important;">
        
        <!-- HIDDEN FLAG: Tells the backend if the user removed the existing image -->
        <input type="hidden" name="remove_{{ $name }}" id="{{ $id }}_remove_flag" value="0">

        <!-- File Input -->
        <!-- Added {{ $attributes }} so you can pass 'required' or custom classes -->
        <input type="file" name="{{ $name }}" id="{{ $id }}" class="d-none" accept="image/*" onchange="previewComponentImage(event, '{{ $id }}')" {{ $attributes }}>
        
        <!-- Default State (Shows if NO existing image) -->
        <div id="{{ $id }}_prompt" class="{{ $existingImage ? 'd-none' : '' }}">
            <i class="fas fa-image fa-3x text-secondary mb-3"></i>
            <h6 class="text-dark fw-semibold">Click to upload image</h6>
            <p class="text-muted small mb-3">JPG, PNG, or WEBP (Max 2MB)</p>
            
            <label for="{{ $id }}" class="btn btn-primary btn-sm px-4 shadow-sm" style="cursor: pointer;">
                <i class="fas fa-plus me-1"></i> Add Image
            </label>
        </div>

        <!-- Preview State (Shows if existing image OR after user uploads one) -->
        <div id="{{ $id }}_preview_container" class="{{ $existingImage ? '' : 'd-none' }}">
            <img id="{{ $id }}_preview" src="{{ $existingImage ? asset('storage/' . $existingImage) : '' }}" alt="Preview" class="img-fluid rounded mb-3 shadow-sm" style="max-height: 200px; object-fit: contain;">
            <div>
                <label for="{{ $id }}" class="btn btn-outline-secondary btn-sm px-3 me-2" style="cursor: pointer;">
                    <i class="fas fa-sync-alt me-1"></i> Change
                </label>
                <button type="button" class="btn btn-outline-danger btn-sm px-3" onclick="confirmComponentImageRemoval('{{ $id }}')">
                    <i class="fas fa-trash me-1"></i> Remove
                </button>
            </div>
        </div>
    </div>
    
    <!-- Automatic Error Handling -->
    @error($name)
        <div class="text-danger fw-semibold small mt-1">
            {{ $message }}
        </div>
    @enderror
</div>


@once
@push('scripts')
<script>
    function previewComponentImage(event, id) {
        const input = event.target;
        const promptState = document.getElementById(id + '_prompt');
        const previewState = document.getElementById(id + '_preview_container');
        const previewImg = document.getElementById(id + '_preview');
        const removeFlag = document.getElementById(id + '_remove_flag');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                promptState.classList.add('d-none');
                previewState.classList.remove('d-none');
                
                // If they upload a new file, they aren't "removing" the image anymore
                if(removeFlag) removeFlag.value = "0";
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function confirmComponentImageRemoval(id) {
        const modalEl = document.getElementById('globalConfirmModal');
        
        // I added a safe fallback! If the modal doesn't exist on the page, it uses a standard alert box
        if (modalEl) {
            const confirmModal = new bootstrap.Modal(modalEl);
            document.getElementById('modalTitle').innerText = 'Remove Image';
            document.getElementById('modalMessage').innerText = 'Are you sure you want to remove this image?';
            
            document.getElementById('modalConfirmBtn').onclick = function() {
                executeImageRemoval(id);
                confirmModal.hide();
            };
            confirmModal.show();
        } else {
            if (confirm('Are you sure you want to remove this image?')) {
                executeImageRemoval(id);
            }
        }
    }

    function executeImageRemoval(id) {
        document.getElementById(id).value = ''; 
        document.getElementById(id + '_preview').src = '';
        
        document.getElementById(id + '_preview_container').classList.add('d-none');
        document.getElementById(id + '_prompt').classList.remove('d-none');

        // Tell Laravel to delete the existing image in the database!
        const removeFlag = document.getElementById(id + '_remove_flag');
        if (removeFlag) removeFlag.value = "1";
    }
</script>
@endpush
@endonce