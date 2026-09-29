<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'status' => null, 
    'name' => 'is_active',
    'label' => 'Visibility'
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
    'status' => null, 
    'name' => 'is_active',
    'label' => 'Visibility'
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
    <div class="d-flex gap-4 mt-2">
        <div class="form-check">
            <input class="form-check-input border-secondary" type="radio" name="<?php echo e($name); ?>" id="<?php echo e($name); ?>_public" value="1" 
                   <?php echo e($status === 1 || $status === true || $status === null ? 'checked' : ''); ?>>
            <label class="form-check-label text-success fw-semibold" for="<?php echo e($name); ?>_public">
                <i class="fas fa-globe-americas me-1"></i> Public
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input border-secondary" type="radio" name="<?php echo e($name); ?>" id="<?php echo e($name); ?>_hidden" value="0" 
                   <?php echo e($status === 0 || $status === false ? 'checked' : ''); ?>>
            <label class="form-check-label text-muted fw-semibold" for="<?php echo e($name); ?>_hidden">
                <i class="fas fa-eye-slash me-1"></i> Hidden
            </label>
        </div>
    </div>
</div><?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/components/radio.blade.php ENDPATH**/ ?>