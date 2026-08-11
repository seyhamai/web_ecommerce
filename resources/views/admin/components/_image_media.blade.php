<div class="card mb-4 shadow-sm border-0 ">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Images & Media</h5>
    </div>
    <div class="card-body bg-light">
        
        <div class="mb-4">
            <label class="form-label fw-semibold">Primary Image (Portrait)</label>
            <input type="file" name="primary_image" id="primary_input" class="form-control" accept="image/*" required onchange="previewSingleImage(this, 'primary-preview')">
            <div class="form-text text-muted">Recommended size: 250x300px. This is the main thumbnail on the storefront.</div>
            <div class="mt-3 d-none" id="primary-preview-container">
                <div class="position-relative d-inline-block">
                    <img id="primary-preview" src="" class="img-thumbnail shadow-sm rounded" style="height: 160px; object-fit: cover;">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 py-0 px-1" onclick="clearSingleImage('primary_input', 'primary-preview')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Secondary Image (Landscape) <span class="text-muted fw-normal">(Optional)</span></label>
            <input type="file" name="secondary_image" id="secondary_input" class="form-control" accept="image/*" onchange="previewSingleImage(this, 'secondary-preview')">
            <div class="form-text text-muted">Recommended size: 400x500px. Used for hover effects on product display</div>
            <div class="mt-3 d-none" id="secondary-preview-container">
                <div class="position-relative d-inline-block">
                    <img id="secondary-preview" src="" class="img-thumbnail shadow-sm rounded" style="height: 160px; object-fit: cover;">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 py-0 px-1" onclick="clearSingleImage('secondary_input', 'secondary-preview')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Gallery Detail Shots</label>
            <input type="file" name="gallery_images[]" id="gallery_input" class="form-control" accept="image/*" multiple onchange="previewGallery(this)">
            <div class="form-text text-muted">Hold CTRL (or CMD) to select multiple images at once.</div>
            <div class="mt-3 d-flex flex-wrap gap-2" id="gallery-preview-container"></div>
        </div>
        
    </div>
</div>

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

    function previewGallery(input) {
        const container = document.getElementById('gallery-preview-container');
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
                btn.onclick = () => removeGalleryImage(index, input.id);

                wrapper.appendChild(img);
                wrapper.appendChild(btn);
                container.appendChild(wrapper);
            });
        }
    }

    function removeGalleryImage(indexToRemove, inputId) {
        const input = document.getElementById(inputId);
        const dt = new DataTransfer();
        
        Array.from(input.files).forEach((file, index) => {
            if (index !== indexToRemove) {
                dt.items.add(file);
            }
        });
        
        input.files = dt.files;
        previewGallery(input); 
    }
</script>