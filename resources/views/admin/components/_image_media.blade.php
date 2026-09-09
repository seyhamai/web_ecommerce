@php
    // Setup default variables in case you don't pass them
    $title = $title ?? 'Images & Media';
    $prefix = $prefix ?? uniqid('img_'); // Ensures unique IDs if used twice on one page
    
    $primaryLabel = $primaryLabel ?? 'Primary Image (Portrait)';
    $primaryName = $primaryName ?? 'primary_image';
    $primaryRequired = $primaryRequired ?? true;
    
    $showSecondary = $showSecondary ?? true;
    $secondaryName = $secondaryName ?? 'secondary_image';
    
    $showGallery = $showGallery ?? true;
    $galleryName = $galleryName ?? 'gallery_images[]';
@endphp

<div class="card mb-4 shadow-sm border-0 ">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">{{ $title }}</h5>
    </div>
    <div class="card-body bg-light">
        
        <!-- PRIMARY IMAGE -->
        <div class="mb-4">
            <label class="form-label fw-semibold">{{ $primaryLabel }}</label>
            <input type="file" name="{{ $primaryName }}" id="{{ $prefix }}_primary" class="form-control" accept="image/*" {{ $primaryRequired ? 'required' : '' }} onchange="previewSingleImage(this, '{{ $prefix }}_primary-preview')">
            @error($primaryName)
                <div class="invalid-feedback">{{ $message }}</div>
            @else
                <div class="form-text text-muted">This is the main thumbnail.</div>
            @enderror
            
            <div class="mt-3 d-none" id="{{ $prefix }}_primary-preview-container">
                <div class="position-relative d-inline-block">
                    <img id="{{ $prefix }}_primary-preview" src="" class="img-thumbnail shadow-sm rounded" style="height: 160px; object-fit: cover;">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 py-0 px-1" onclick="clearSingleImage('{{ $prefix }}_primary', '{{ $prefix }}_primary-preview')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- SECONDARY IMAGE (Conditionally rendered) -->
        @if($showSecondary)
        <div class="mb-4">
            <label class="form-label fw-semibold">Secondary Image (Landscape) <span class="text-muted fw-normal">(Optional)</span></label>
            <input type="file" name="{{ $secondaryName }}" id="{{ $prefix }}_secondary" class="form-control" accept="image/*" onchange="previewSingleImage(this, '{{ $prefix }}_secondary-preview')">
            
            <div class="mt-3 d-none" id="{{ $prefix }}_secondary-preview-container">
                <div class="position-relative d-inline-block">
                    <img id="{{ $prefix }}_secondary-preview" src="" class="img-thumbnail shadow-sm rounded" style="height: 160px; object-fit: cover;">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 py-0 px-1" onclick="clearSingleImage('{{ $prefix }}_secondary', '{{ $prefix }}_secondary-preview')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
        @endif

        <!-- GALLERY IMAGES (Conditionally rendered) -->
        @if($showGallery)
        <div class="mb-3">
            <label class="form-label fw-semibold">Gallery Detail Shots</label>
            <input type="file" name="{{ $galleryName }}" id="{{ $prefix }}_gallery" class="form-control" accept="image/*" multiple onchange="previewGallery(this, '{{ $prefix }}_gallery-container')">
            <div class="form-text text-muted">Hold CTRL (or CMD) to select multiple images.</div>
            <div class="mt-3 d-flex flex-wrap gap-2" id="{{ $prefix }}_gallery-container"></div>
        </div>
        @endif
        
    </div>
</div>

<!-- Only load the script once, even if component is used multiple times -->
@once
<script>
    function previewSingleImage(input, previewId) {
        const container = document.getElementById(previewId + '-container');
        const imgElement = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            imgElement.src = URL.createObjectURL(input.files[0]);
            container.classList.remove('d-none');
        } else {
            imgElement.src = "";
            container.classList.add('d-none');
        }
    }

    function clearSingleImage(inputId, previewId) {
        const input = document.getElementById(inputId);
        input.value = ''; 
        previewSingleImage(input, previewId); 
    }

    function previewGallery(input, containerId) {
        const container = document.getElementById(containerId);
        container.innerHTML = ''; 
        
        if (input.files) {
            Array.from(input.files).forEach((file, index) => {
                const wrapper = document.createElement('div');
                wrapper.className = 'position-relative d-inline-block';

                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = 'img-thumbnail shadow-sm rounded';
                img.style.height = '120px';
                img.style.width = '120px';
                img.style.objectFit = 'cover';

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0 m-1 py-0 px-1';
                btn.innerHTML = '<i class="fas fa-times"></i>';
                btn.onclick = () => removeGalleryImage(index, input.id, containerId);

                wrapper.appendChild(img);
                wrapper.appendChild(btn);
                container.appendChild(wrapper);
            });
        }
    }

    function removeGalleryImage(indexToRemove, inputId, containerId) {
        const input = document.getElementById(inputId);
        const dt = new DataTransfer();
        
        Array.from(input.files).forEach((file, index) => {
            if (index !== indexToRemove) {
                dt.items.add(file);
            }
        });
        
        input.files = dt.files;
        previewGallery(input, containerId); 
    }
</script>
@endonce