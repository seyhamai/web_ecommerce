<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name',
    'label' => false,
    'value' => '',
    'placeholder' => '',
    'rows' => 3,
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
    'value' => '',
    'placeholder' => '',
    'rows' => 3,
    'id' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<!-- We pass the exact props down to your standard textarea component -->
<!-- We also inject a special 'rich-editor' class so our JavaScript can find it -->
<?php if (isset($component)) { $__componentOriginal4727f9fd7c3055c2cf9c658d89b16886 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.textarea','data' => ['name' => $name,'label' => $label,'value' => $value,'placeholder' => $placeholder,'rows' => $rows,'id' => $id,'attributes' => $attributes->merge(['class' => 'rich-editor'])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($name),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($label),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($value),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($placeholder),'rows' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rows),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($id),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes->merge(['class' => 'rich-editor']))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886)): ?>
<?php $attributes = $__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886; ?>
<?php unset($__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4727f9fd7c3055c2cf9c658d89b16886)): ?>
<?php $component = $__componentOriginal4727f9fd7c3055c2cf9c658d89b16886; ?>
<?php unset($__componentOriginal4727f9fd7c3055c2cf9c658d89b16886); ?>
<?php endif; ?>

<?php if (! $__env->hasRenderedOnce('7d38a112-2cca-43e7-8806-0221f6e7a935')): $__env->markAsRenderedOnce('7d38a112-2cca-43e7-8806-0221f6e7a935'); ?>
    <?php $__env->startPush('scripts'); ?>
        <style>
            /* Ensure all rich editors have a good default height */
            .ck-editor__editable_inline {
                min-height: 150px;
            }
        </style>
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Find EVERY textarea with the 'rich-editor' class and turn it into CKEditor
                document.querySelectorAll('.rich-editor').forEach((editorElement) => {
                    ClassicEditor.create(editorElement, {
                        toolbar: [ 
                            'heading', '|', 
                            'bold', 'italic', 'underline', 'strikethrough', '|', 
                            'link', 'bulletedList', 'numberedList', 'blockQuote', '|',  
                            'undo', 'redo' 
                        ]
                    }).catch(error => {
                        console.error(error);
                    });
                });
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?><?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/components/rich-textarea.blade.php ENDPATH**/ ?>