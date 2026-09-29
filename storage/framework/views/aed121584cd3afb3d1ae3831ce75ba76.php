<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name',
    'label' => false,
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'id' => null,
    'noWrapper' => false, // <-- NEW PROP
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
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'id' => null,
    'noWrapper' => false, // <-- NEW PROP
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $inputId = $id ?? $name;
?>

<!-- Only wrap in a div if we ARE NOT in an input-group -->
<?php if(!$noWrapper): ?>
<div class="mb-3">
<?php endif; ?>

    <!-- Optional Label -->
    <?php if($label): ?>
        <label for="<?php echo e($inputId); ?>" class="form-label fw-semibold">
            <?php echo e($label); ?>

            <?php if($attributes->has('required')): ?>
                <span class="text-danger">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>

    <!-- The Input Field -->
    <input 
        type="<?php echo e($type); ?>" 
        name="<?php echo e($name); ?>" 
        id="<?php echo e($inputId); ?>" 
        value="<?php echo e(old($name, $value)); ?>"
        placeholder="<?php echo e($placeholder); ?>"
        <?php echo e($attributes->merge(['class' => 'form-control ' . ($errors->has($name) ? 'is-invalid' : '')])); ?>

    >

    <!-- Automatic Error Handling -->
    <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback fw-semibold">
            <?php echo e($message); ?>

        </div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

<?php if(!$noWrapper): ?>
</div>
<?php endif; ?><?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/components/input.blade.php ENDPATH**/ ?>