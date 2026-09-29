<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name',
    'label' => false,
    'value' => '1', // Default value sent when checked
    'checked' => false, // Initial state from database
    'isSwitch' => false, // Turn into a toggle switch?
    'id' => null,
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
    'name',
    'label' => false,
    'value' => '1', // Default value sent when checked
    'checked' => false, // Initial state from database
    'isSwitch' => false, // Turn into a toggle switch?
    'id' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $checkboxId = $id ?? $name;
    $isChecked = old() ? old($name) == $value : $checked;
?>

<div class="mb-3 form-check <?php echo e($isSwitch ? 'form-switch' : ''); ?>">

    <input type="hidden" name="<?php echo e($name); ?>" value="0">
    
    <input 
        type="checkbox" 
        name="<?php echo e($name); ?>" 
        id="<?php echo e($checkboxId); ?>" 
        value="<?php echo e($value); ?>"
        <?php echo e($isChecked ? 'checked' : ''); ?>

        <?php echo e($attributes->merge(['class' => 'form-check-input ' . ($errors->has($name) ? 'is-invalid' : '')])); ?>

    >
    
    <?php if($label): ?>
        <label class="form-check-label fw-semibold" for="<?php echo e($checkboxId); ?>">
            <?php echo e($label); ?>

            <?php if($attributes->has('required')): ?>
                <span class="text-danger">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>

    <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback fw-semibold d-block">
            <?php echo e($message); ?>

        </div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div><?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/components/checkbox.blade.php ENDPATH**/ ?>