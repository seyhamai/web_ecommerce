

<?php $__env->startSection('content'); ?>
    <!-- 🌟 Remember which tab we were on after a form submission -->
    <?php
        $activeTab = session('active_tab', 'info');
    ?>

    <div class="container-fluid px-1 px-md-3 mb-2">

        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <h1 class="font-semibold fs-2 mb-0">Update: <?php echo e($product->name); ?></h1>
            <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('admin.products.index')).'','color' => 'secondary','outline' => true,'icon' => 'fas fa-arrow-left']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('admin.products.index')).'','color' => 'secondary','outline' => true,'icon' => 'fas fa-arrow-left']); ?>
                Back to Products
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
        </div>

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

        <!-- 🌟 Using your new x-tabs component -->
        <?php if (isset($component)) { $__componentOriginalb5964ceaff5596b67291a601bad6f23f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb5964ceaff5596b67291a601bad6f23f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tabs','data' => ['tabs' => ['info' => '📝 General Information', 'inventory' => '📦 Inventory & Variants'],'active' => $activeTab]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tabs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tabs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['info' => '📝 General Information', 'inventory' => '📦 Inventory & Variants']),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeTab)]); ?>

            <!-- ========================================== -->
            <!-- TAB 1: BASIC INFO FORM                     -->
            <!-- ========================================== -->
            <?php if (isset($component)) { $__componentOriginala2fc8c31fffe07bae4aa4430d1a6d2b3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala2fc8c31fffe07bae4aa4430d1a6d2b3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tab-pane','data' => ['id' => 'info','active' => $activeTab === 'info']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tab-pane'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'info','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeTab === 'info')]); ?>
                <form action="<?php echo e(route('admin.products.updateInfo', $product->id)); ?>" method="POST"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row mt-2">
                        <div class="mb-1">
                            <?php echo $__env->make('admin.products.product_created.basic_info', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                        <div class="mb-2">
                            <?php echo $__env->make('admin.products.product_created.selected_category', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>

                    <?php if (isset($component)) { $__componentOriginal081e7edabab5688cd64a5b5dc2b40836 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal081e7edabab5688cd64a5b5dc2b40836 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.images.product-gallery','data' => ['images' => $product->images]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('images.product-gallery'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['images' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->images)]); ?>
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

                    <!-- SUBMIT BUTTON (Kept below the card to stay fixed) -->
                    <div class="position-sticky mt-3" style="top: 20px; z-index: 10;">
                        <button type="submit"
                            class="btn btn-success btn-lg w-100 py-3 shadow-lg border-0 fw-bold d-flex justify-content-center align-items-center gap-2"
                            style="border-radius: 12px; transition: 0.2s;">
                            <i class="fas fa-save fs-5"></i> Update Information
                        </button>
                    </div>
                </form>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala2fc8c31fffe07bae4aa4430d1a6d2b3)): ?>
<?php $attributes = $__attributesOriginala2fc8c31fffe07bae4aa4430d1a6d2b3; ?>
<?php unset($__attributesOriginala2fc8c31fffe07bae4aa4430d1a6d2b3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala2fc8c31fffe07bae4aa4430d1a6d2b3)): ?>
<?php $component = $__componentOriginala2fc8c31fffe07bae4aa4430d1a6d2b3; ?>
<?php unset($__componentOriginala2fc8c31fffe07bae4aa4430d1a6d2b3); ?>
<?php endif; ?>

            <!-- ========================================== -->
            <!-- TAB 2: INVENTORY                           -->
            <!-- ========================================== -->
            <?php if (isset($component)) { $__componentOriginala2fc8c31fffe07bae4aa4430d1a6d2b3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala2fc8c31fffe07bae4aa4430d1a6d2b3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tab-pane','data' => ['id' => 'inventory','active' => $activeTab === 'inventory']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tab-pane'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'inventory','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeTab === 'inventory')]); ?>
                <form action="<?php echo e(route('admin.products.updateInventory', $product->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="card shadow-sm border-0 bg-transparent">
                        <div class="card-body p-0">
                            <h4 class="mb-3 fw-bold text-dark">Manage Stock</h4>
                            <?php echo $__env->make('admin.products.product_created.variants_info', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','color' => 'success','size' => 'lg','class' => 'px-5 shadow-sm fw-bold','icon' => 'fas fa-save']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','color' => 'success','size' => 'lg','class' => 'px-5 shadow-sm fw-bold','icon' => 'fas fa-save']); ?>
                            Update Inventory
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                    </div>
                </form>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala2fc8c31fffe07bae4aa4430d1a6d2b3)): ?>
<?php $attributes = $__attributesOriginala2fc8c31fffe07bae4aa4430d1a6d2b3; ?>
<?php unset($__attributesOriginala2fc8c31fffe07bae4aa4430d1a6d2b3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala2fc8c31fffe07bae4aa4430d1a6d2b3)): ?>
<?php $component = $__componentOriginala2fc8c31fffe07bae4aa4430d1a6d2b3; ?>
<?php unset($__componentOriginala2fc8c31fffe07bae4aa4430d1a6d2b3); ?>
<?php endif; ?>

         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb5964ceaff5596b67291a601bad6f23f)): ?>
<?php $attributes = $__attributesOriginalb5964ceaff5596b67291a601bad6f23f; ?>
<?php unset($__attributesOriginalb5964ceaff5596b67291a601bad6f23f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb5964ceaff5596b67291a601bad6f23f)): ?>
<?php $component = $__componentOriginalb5964ceaff5596b67291a601bad6f23f; ?>
<?php unset($__componentOriginalb5964ceaff5596b67291a601bad6f23f); ?>
<?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/modules/products.js')); ?>"></script>
    <script src="<?php echo e(asset('js/modules/attributeTabs.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/admin/products/pgUpdateProducts.blade.php ENDPATH**/ ?>