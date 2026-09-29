<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'id',               // Required: The ID to trigger the modal (e.g., 'createCategoryModal')
    'title',            // Required: The text in the header
    'formAction' => '', // Optional: If provided, wraps the body in a form
    'formMethod' => 'POST',
    'submitText' => 'Save Changes',
    'submitColor' => 'primary', // e.g., 'success', 'primary', 'danger'
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
    'id',               // Required: The ID to trigger the modal (e.g., 'createCategoryModal')
    'title',            // Required: The text in the header
    'formAction' => '', // Optional: If provided, wraps the body in a form
    'formMethod' => 'POST',
    'submitText' => 'Save Changes',
    'submitColor' => 'primary', // e.g., 'success', 'primary', 'danger'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div <?php echo e($attributes->merge(['class' => 'modal fade'])); ?> id="<?php echo e($id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold"><?php echo e($title); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <?php if($formAction): ?>
                <!-- If formAction is provided, wrap the content in a form -->
                <form action="<?php echo e($formAction); ?>" method="POST" id="<?php echo e($id); ?>Form">
                    <?php echo csrf_field(); ?>
                    <?php if(strtoupper($formMethod) !== 'POST'): ?>
                        <?php echo method_field($formMethod); ?>
                    <?php endif; ?>
                    
                    <div class="modal-body">
                        <?php echo e($slot); ?>

                    </div>
                    
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-<?php echo e($submitColor); ?> shadow-sm fw-bold"><?php echo e($submitText); ?></button>
                    </div>
                </form>
            <?php else: ?>
                <!-- If no form Action is provided, just render the content normally -->
                <div class="modal-body">
                    <?php echo e($slot); ?>

                </div>
            <?php endif; ?>
            
        </div>
    </div>
</div><?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/components/modal.blade.php ENDPATH**/ ?>