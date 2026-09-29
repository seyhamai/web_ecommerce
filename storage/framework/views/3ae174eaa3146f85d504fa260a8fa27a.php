<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'button',     // button, submit, reset
    'color' => 'primary',   // primary, success, danger, secondary, etc.
    'size' => null,         // sm, lg
    'icon' => null,         // e.g., 'fas fa-save'
    'href' => null,         // If passed, it becomes an <a> tag automatically
    'outline' => false,     // True makes it btn-outline-*
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
    'type' => 'button',     // button, submit, reset
    'color' => 'primary',   // primary, success, danger, secondary, etc.
    'size' => null,         // sm, lg
    'icon' => null,         // e.g., 'fas fa-save'
    'href' => null,         // If passed, it becomes an <a> tag automatically
    'outline' => false,     // True makes it btn-outline-*
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    // Automatically build the Bootstrap class list
    $baseClass = 'btn shadow-sm fw-semibold d-inline-flex align-items-center justify-content-center';
    $colorClass = $outline ? "btn-outline-{$color}" : "btn-{$color}";
    $sizeClass = $size ? "btn-{$size}" : '';
    
    $mergedClasses = trim("{$baseClass} {$colorClass} {$sizeClass}");
?>

<?php if($href): ?>
    <a href="<?php echo e($href); ?>" <?php echo e($attributes->merge(['class' => $mergedClasses])); ?>>
        <?php if($icon): ?> <i class="<?php echo e($icon); ?> me-1"></i> <?php endif; ?>
        <?php echo e($slot); ?>

    </a>
<?php else: ?>
    <button type="<?php echo e($type); ?>" <?php echo e($attributes->merge(['class' => $mergedClasses])); ?>>
        <?php if($icon): ?> <i class="<?php echo e($icon); ?> me-1"></i> <?php endif; ?>
        <?php echo e($slot); ?>

    </button>
<?php endif; ?><?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/components/button.blade.php ENDPATH**/ ?>