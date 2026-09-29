<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => 'image',       // The input name (e.g., primary_image, image)
    'id' => 'imageInput',    // Unique ID so JS doesn't conflict
    'label' => 'Image',      // The label text
    'existingImage' => null  // Passes existing image URL for edit forms
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'name' => 'image',       // The input name (e.g., primary_image, image)
    'id' => 'imageInput',    // Unique ID so JS doesn't conflict
    'label' => 'Image',      // The label text
    'existingImage' => null  // Passes existing image URL for edit forms
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="mb-4">
    <label class="form-label fw-bold d-block"><?php echo e($label); ?></label>
    
    <div class="border border-2 rounded bg-light text-center p-5 w-100" style="border-style: dashed !important; border-color: #dee2e6;">
        
        <!-- File Input -->
        <input type="file" name="<?php echo e($name); ?>" id="<?php echo e($id); ?>" class="d-none" accept="image/*" onchange="previewComponentImage(event, '<?php echo e($id); ?>')">
        
        <!-- Default State (Shows if NO existing image) -->
        <div id="<?php echo e($id); ?>_prompt" class="<?php echo e($existingImage ? 'd-none' : ''); ?>">
            <i class="fas fa-image fa-3x text-secondary mb-3"></i>
            <h6 class="text-dark fw-semibold">Click to upload image</h6>
            <p class="text-muted small mb-3">JPG, PNG, or WEBP (Max 2MB)</p>
            
            <label for="<?php echo e($id); ?>" class="btn btn-primary btn-sm px-4 shadow-sm" style="cursor: pointer;">
                <i class="fas fa-plus me-1"></i> Add Image
            </label>
        </div>

        <!-- Preview State (Shows if existing image OR after user uploads one) -->
        <div id="<?php echo e($id); ?>_preview_container" class="<?php echo e($existingImage ? '' : 'd-none'); ?>">
            <img id="<?php echo e($id); ?>_preview" src="<?php echo e($existingImage ? asset('storage/' . $existingImage) : ''); ?>" alt="Preview" class="img-fluid rounded mb-3 shadow-sm" style="max-height: 200px; object-fit: contain;">
            <div>
                <label for="<?php echo e($id); ?>" class="btn btn-outline-secondary btn-sm px-3 me-2" style="cursor: pointer;">
                    <i class="fas fa-sync-alt me-1"></i> Change
                </label>
                <button type="button" class="btn btn-outline-danger btn-sm px-3" onclick="confirmComponentImageRemoval('<?php echo e($id); ?>')">
                    <i class="fas fa-trash me-1"></i> Remove
                </button>
            </div>
        </div>

    </div>
</div>


<?php if (! $__env->hasRenderedOnce('7cb6a8d3-98e0-45ad-96ab-5f4cd0d72ab6')): $__env->markAsRenderedOnce('7cb6a8d3-98e0-45ad-96ab-5f4cd0d72ab6'); ?>
<script>
    function previewComponentImage(event, id) {
        const input = event.target;
        const promptState = document.getElementById(id + '_prompt');
        const previewState = document.getElementById(id + '_preview_container');
        const previewImg = document.getElementById(id + '_preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                promptState.classList.add('d-none');
                previewState.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function confirmComponentImageRemoval(id) {
        const confirmModal = new bootstrap.Modal(document.getElementById('globalConfirmModal'));
        
        document.getElementById('modalTitle').innerText = 'Remove Image';
        document.getElementById('modalMessage').innerText = 'Are you sure you want to remove this image?';
        
        document.getElementById('modalConfirmBtn').onclick = function() {
            document.getElementById(id).value = ''; 
            document.getElementById(id + '_preview').src = '';
            
            document.getElementById(id + '_preview_container').classList.add('d-none');
            document.getElementById(id + '_prompt').classList.remove('d-none');

            confirmModal.hide();
        };

        confirmModal.show();
    }
</script>
<?php endif; ?><?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/components/_image_media.blade.php ENDPATH**/ ?>