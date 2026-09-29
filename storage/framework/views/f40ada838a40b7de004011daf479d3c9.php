<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'images' => collect(), 
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
    'images' => collect(), 
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $primaryId =$images->where('type', 'primary_portrait')->first()->id ?? '';
    $secondaryId =$images->where('type', 'secondary_landscape')->first()->id ?? '';
?>

<div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-header bg-white py-3 border-bottom-0">
        <h5 class="mb-0 fw-bold text-dark">
            <i class="fas fa-images me-2 text-primary"></i>Manage Images
        </h5>
    </div>
    <div class="card-body bg-light rounded-bottom-4">
        
        <div id="deletedImagesContainer"></div>
        <input type="hidden" name="primary_selection" id="primarySelection" value="<?php echo e($primaryId ? 'existing_'.$primaryId : ''); ?>">
        <input type="hidden" name="secondary_selection" id="secondarySelection" value="<?php echo e($secondaryId ? 'existing_'.$secondaryId : ''); ?>">

        <div class="row g-2" id="unifiedImageGrid">
            
            <!-- 1. EXISTING IMAGES -->
            <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-6 col-md-3 existing-image-card" id="existing_img_<?php echo e($img->id); ?>">
                    <div class="card h-150 shadow-sm border-secondary position-relative">
                        
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 rounded-circle p-1 shadow" style="width: 24px; height: 24px; line-height: 1; z-index: 50;" onclick="removeExistingImage(<?php echo e($img->id); ?>)">
                            <i class="fas fa-times" style="font-size: 11px;"></i>
                        </button>

                        <img src="<?php echo e(asset('storage/' . $img->image_path)); ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                        
                        <div class="card-body p-2 text-center bg-white">
                            <div class="form-check text-start mb-1">
                                <input class="form-check-input border-primary" type="radio" name="primary_choice" id="prim_ex_<?php echo e($img->id); ?>" value="existing_<?php echo e($img->id); ?>" onchange="document.getElementById('primarySelection').value = this.value" <?php echo e($img->type === 'primary_portrait' ? 'checked' : ''); ?>>
                                <label class="form-check-label small fw-bold text-primary" for="prim_ex_<?php echo e($img->id); ?>" style="font-size:11px;"><i class="fas fa-star me-1"></i>Primary</label>
                            </div>
                            <div class="form-check text-start mb-0">
                                <input class="form-check-input border-secondary" type="radio" name="secondary_choice" id="sec_ex_<?php echo e($img->id); ?>" value="existing_<?php echo e($img->id); ?>" onchange="document.getElementById('secondarySelection').value = this.value" <?php echo e($img->type === 'secondary_landscape' ? 'checked' : ''); ?>>
                                <label class="form-check-label small text-secondary" for="sec_ex_<?php echo e($img->id); ?>" style="font-size:11px;">Secondary</label>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- 2. UPLOAD BOX -->
            <div class="col-12" id="addMoreBox">
                <div class="card shadow-sm border border-2 border-primary d-flex align-items-center justify-content-center bg-white" style="border-style: dashed !important; min-height: 120px;">
                    <input type="file" name="images[]" id="productImages" class="d-none" multiple accept="image/*" onchange="renderNewImages(this)">
                    <label for="productImages" class="text-center w-100 h-100 d-flex flex-column align-items-center justify-content-center m-0 p-3" style="cursor: pointer;">
                        <i class="fas fa-plus-circle fa-2x text-primary mb-2"></i>
                        <span class="small fw-bold text-primary">Upload New</span>
                    </label>
                </div>
            </div>

        </div> 
    </div>
</div>

<?php if (! $__env->hasRenderedOnce('e672cd4f-e765-4f0a-8677-b10759c98ac7')): $__env->markAsRenderedOnce('e672cd4f-e765-4f0a-8677-b10759c98ac7'); ?>
<?php $__env->startPush('scripts'); ?>
<script>
function removeExistingImage(id) {
    document.getElementById('existing_img_' + id).style.display = 'none';
    
    const container = document.getElementById('deletedImagesContainer');
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'deleted_image_ids[]';
    input.value = id;
    container.appendChild(input);

    const primRadio = document.getElementById('prim_ex_' + id);
    if(primRadio && primRadio.checked) document.getElementById('primarySelection').value = '';
    
    const secRadio = document.getElementById('sec_ex_' + id);
    if(secRadio && secRadio.checked) document.getElementById('secondarySelection').value = '';
}

function renderNewImages(inputElement) {
    const files = inputElement.files;
    const grid = document.getElementById('unifiedImageGrid');
    const addMoreBox = document.getElementById('addMoreBox');

    // Clear old previews
    document.querySelectorAll('.new-image-preview').forEach(e => e.remove());

    // Check if a primary image is already selected anywhere on the page
    let currentPrimary = document.getElementById('primarySelection').value;

    Array.from(files).forEach((file, index) => {
        // Only auto-check the very first new image, and ONLY if there isn't a primary image already
        let isPrimary = false;
        if (!currentPrimary && index === 0) {
            isPrimary = true;
            currentPrimary = `new_${index}`;
            document.getElementById('primarySelection').value = currentPrimary;
        }

        // Build the HTML immediately so images stay in the exact order selected
        const col = document.createElement('div');
        col.className = 'col-6 col-md-3 new-image-preview'; 
        col.innerHTML = `
            <div class="card border border-success h-150 shadow-sm position-relative">
                
                <span class="badge bg-success position-absolute top-0 start-0 m-2" style="z-index: 5;">New</span>
                
                <!-- ID added to the image so we can update it asynchronously -->
                <img id="new_img_preview_${index}" src="" class="card-img-top w-100 bg-light" style="height: 150px; object-fit: cover;">
                
                <!-- FIX: Z-index increased to 50, moved after the image to ensure it's visible -->
                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle shadow d-flex justify-content-center align-items-center" style="width: 26px; height: 26px; z-index: 50;" onclick="removeNewImage(${index})">
                    <i class="fas fa-times" style="font-size: 12px;"></i>
                </button>

                <div class="card-body p-2 text-center bg-white">
                    <div class="form-check text-start mb-1">
                        <!-- FIX: Added conditional 'checked' for the primary radio only -->
                        <input class="form-check-input border-primary" type="radio" name="primary_choice" id="prim_new_${index}" value="new_${index}" onchange="document.getElementById('primarySelection').value = this.value" ${isPrimary ? 'checked' : ''}>
                        <label class="form-check-label small fw-bold text-primary" for="prim_new_${index}" style="font-size:11px;"><i class="fas fa-star me-1"></i>Primary</label>
                    </div>
                    <div class="form-check text-start mb-0">
                        <input class="form-check-input border-secondary" type="radio" name="secondary_choice" id="sec_new_${index}" value="new_${index}" onchange="document.getElementById('secondarySelection').value = this.value">
                        <label class="form-check-label small text-secondary" for="sec_new_${index}" style="font-size:11px;">Secondary</label>
                    </div>
                </div>
            </div>
        `;
        grid.insertBefore(col, addMoreBox);

        // Load the actual image picture in the background
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(`new_img_preview_${index}`).src = e.target.result;
        }
        reader.readAsDataURL(file);
    });
}

function removeNewImage(indexToRemove) {
    const input = document.getElementById('productImages');
    
    // Clear hidden inputs if the user deletes the currently checked new image
    const primRadio = document.getElementById('prim_new_' + indexToRemove);
    if (primRadio && primRadio.checked) document.getElementById('primarySelection').value = '';
    
    const secRadio = document.getElementById('sec_new_' + indexToRemove);
    if (secRadio && secRadio.checked) document.getElementById('secondarySelection').value = '';

    const dt = new DataTransfer();
    for (let i = 0; i < input.files.length; i++) {
        if (i !== indexToRemove) {
            dt.items.add(input.files[i]); 
        }
    }
    
    input.files = dt.files;
    renderNewImages(input);
}
</script>
<?php $__env->stopPush(); ?>
<?php endif; ?><?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/components/images/product-gallery.blade.php ENDPATH**/ ?>