<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'breadcrumb' => null,
    'breadcrumbUrl' => null,
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
    'title',
    'breadcrumb' => null,
    'breadcrumbUrl' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div>
<h1 class="mt-4 font-semibold fs-2"><?php echo e($title); ?></h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">
        <a href="<?php echo e($breadcrumbUrl ? url($breadcrumbUrl) : url('/admin/dashboard')); ?>">
            Dashboard
        </a>
    </li>

    <?php if($breadcrumb): ?>
        <li class="breadcrumb-item active">
            <?php echo e($breadcrumb); ?>

        </li>
    <?php endif; ?>
</ol>
</div>

<?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/components/page-header.blade.php ENDPATH**/ ?>