<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'tabs' => [],      // Array of tab IDs and labels: ['colors' => '🎨 Manage Colors']
    'active' => null   // The ID of the tab that should be open by default
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
    'tabs' => [],      // Array of tab IDs and labels: ['colors' => '🎨 Manage Colors']
    'active' => null   // The ID of the tab that should be open by default
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white pt-3 pb-0 border-bottom-0">
        <ul class="nav nav-tabs" role="tablist">
            <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo e($active === $id ? 'active fw-bold text-primary border-bottom-0' : 'fw-bold text-secondary'); ?>" 
                            id="<?php echo e($id); ?>-tab" 
                            data-bs-toggle="tab" 
                            data-bs-target="#<?php echo e($id); ?>" 
                            type="button" 
                            role="tab">
                        <?php echo $label; ?>

                    </button>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <div class="card-body bg-light rounded-bottom">
        <div class="tab-content">
            <?php echo e($slot); ?>

        </div>
    </div>
</div><?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/components/tabs.blade.php ENDPATH**/ ?>