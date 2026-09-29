

<?php $__env->startPush('styles'); ?>
    <style>
        /* Category Tree Styles */
        .cursor-pointer {
            cursor: pointer;
        }

        .toggle-icon {
            transition: transform 0.2s ease-in-out;
            color: #6c757d;
        }

        .rotate-down {
            transform: rotate(90deg);
        }

        .category-tree-container {
            max-height: 250px;
            overflow-y: auto;
        }

        /* CSS for the new smooth animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        tr {
            transition: opacity 0.2s ease-out;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginal29e131625d2d43c1d7e09c28a6041b2d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal29e131625d2d43c1d7e09c28a6041b2d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components._alerts','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('_alerts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal29e131625d2d43c1d7e09c28a6041b2d)): ?>
<?php $attributes = $__attributesOriginal29e131625d2d43c1d7e09c28a6041b2d; ?>
<?php unset($__attributesOriginal29e131625d2d43c1d7e09c28a6041b2d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal29e131625d2d43c1d7e09c28a6041b2d)): ?>
<?php $component = $__componentOriginal29e131625d2d43c1d7e09c28a6041b2d; ?>
<?php unset($__componentOriginal29e131625d2d43c1d7e09c28a6041b2d); ?>
<?php endif; ?>

    <div class="container-fluid px-1 px-md-3 mb-5">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <h1 class="font-semibold fs-2 mb-0">Add New Product</h1>
            <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline-secondary shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to Products
            </a>
        </div>

        <form action="<?php echo e(route('admin.products.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="row">
                <div class="col-lg-12">
                    <?php echo $__env->make('admin.products.product_created.basic_info', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('admin.products.product_created.selected_category', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                    <!-- 🌟 ONE LINE REPLACES THE ENTIRE IMAGE SECTION 🌟 -->
                    <?php if (isset($component)) { $__componentOriginal081e7edabab5688cd64a5b5dc2b40836 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal081e7edabab5688cd64a5b5dc2b40836 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.images.product-gallery','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('images.product-gallery'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal081e7edabab5688cd64a5b5dc2b40836)): ?>
<?php $attributes = $__attributesOriginal081e7edabab5688cd64a5b5dc2b40836; ?>
<?php unset($__attributesOriginal081e7edabab5688cd64a5b5dc2b40836); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal081e7edabab5688cd64a5b5dc2b40836)): ?>
<?php $component = $__componentOriginal081e7edabab5688cd64a5b5dc2b40836; ?>
<?php unset($__componentOriginal081e7edabab5688cd64a5b5dc2b40836); ?>
<?php endif; ?>

                    <?php echo $__env->make('admin.products.product_created.variants_info', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold">Publishing Options</h5>
                        </div>
                        <div class="card-body">
                            <?php if (isset($component)) { $__componentOriginal2f9894a01a11669b094ae0763b00bdf1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2f9894a01a11669b094ae0763b00bdf1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.radio','data' => ['label' => 'Product Visibility']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('radio'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Product Visibility']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2f9894a01a11669b094ae0763b00bdf1)): ?>
<?php $attributes = $__attributesOriginal2f9894a01a11669b094ae0763b00bdf1; ?>
<?php unset($__attributesOriginal2f9894a01a11669b094ae0763b00bdf1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2f9894a01a11669b094ae0763b00bdf1)): ?>
<?php $component = $__componentOriginal2f9894a01a11669b094ae0763b00bdf1; ?>
<?php unset($__componentOriginal2f9894a01a11669b094ae0763b00bdf1); ?>
<?php endif; ?>

                            <div class="form-check form-switch mt-4 mb-2">
                                <input class="form-check-input border-secondary" type="checkbox" name="is_featured"
                                    id="isFeatured" value="1">
                                <label class="form-check-label fw-semibold" for="isFeatured">Feature on Homepage</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg w-100 py-3 fw-bold shadow-sm"
                        style="border-radius: 12px; transition: 0.2s;">
                        <i class="fas fa-save me-2"></i> Save Product
                    </button>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/modules/products.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/admin/products/create.blade.php ENDPATH**/ ?>