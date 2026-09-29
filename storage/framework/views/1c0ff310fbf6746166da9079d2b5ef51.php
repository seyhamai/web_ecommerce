

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-2">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Product Management','breadcrumb' => 'Products','breadcrumbUrl' => '/admin/dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Product Management','breadcrumb' => 'Products','breadcrumb-url' => '/admin/dashboard']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
        </div>
        <div>
            <a href="<?php echo e(route('admin.products.trash')); ?>" class="btn btn-outline-danger shadow-sm me-2">
                <i class="fas fa-trash-alt me-2"></i>View Trash
            </a>
            <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-2"></i>Add New Product
            </a>
        </div>
    </div>

    <!-- Success Message Component -->
    <?php echo $__env->make('components._alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- 🌟 The Reusable Table Component 🌟 -->
    <?php if (isset($component)) { $__componentOriginal163c8ba6efb795223894d5ffef5034f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal163c8ba6efb795223894d5ffef5034f5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table','data' => ['headers' => ['Image', 'Product Name', 'Main Category', 'Category', 'Price', 'Stock', 'Actions']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['headers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Image', 'Product Name', 'Main Category', 'Category', 'Price', 'Stock', 'Actions'])]); ?>
        
        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="ps-3" style="width: 120px;">
                    <?php if($product->primary_image): ?>
                        <img src="<?php echo e(asset('storage/' . $product->primary_image)); ?>" 
                            alt="<?php echo e($product->name); ?>" 
                            class="img-thumbnail rounded shadow-sm" 
                            style="width: 80px; height: 80px; object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted shadow-sm" style="width: 80px; height: 80px;">
                            <i class="fas fa-image fa-2x opacity-50"></i>
                        </div>
                    <?php endif; ?>
                </td>
                
                <td class="fw-semibold">
                    <?php echo e($product->name); ?>

                    <div class="text-muted small fw-normal">SKU: <?php echo e($product->sku); ?></div>
                </td>
                
                <td>
                    <span class="fw-semibold text-dark">
                        <?php echo e($product->category && $product->category->parent ? $product->category->parent->name : 'None'); ?>

                    </span>
                </td>
                
                <td>
                    <span class="badge bg-secondary"><?php echo e($product->category->name ?? 'Uncategorized'); ?></span>
                </td>
                
                <td class="fw-bold text-dark">
                    $<?php echo e(number_format($product->price, 2)); ?>

                </td>
                
                <td>
                    <?php if($product->stock_quantity > 10): ?>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-2 py-1"><?php echo e($product->stock_quantity); ?> in stock</span>
                    <?php elseif($product->stock_quantity > 0): ?>
                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning-subtle px-2 py-1"><?php echo e($product->stock_quantity); ?> Low stock</span>
                    <?php else: ?>
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2 py-1">Out of stock</span>
                    <?php endif; ?>
                </td>
                
                <td class="text-end pe-4">
                    <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn btn-sm btn-outline-primary me-1 shadow-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST" class="d-inline-block">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        
                        <button type="button" class="btn btn-sm btn-outline-danger shadow-sm requires-confirmation" 
                                data-title="Move to Trash?" 
                                data-message="Are you sure you want to send this product to the trash?"
                                data-btn-text="Move to Trash">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" class="text-center py-5 text-muted">
                    <i class="fas fa-box-open fs-1 mb-3 text-secondary opacity-25"></i>
                    <h5 class="text-dark fw-bold">No products found</h5>
                    <p>You haven't added any products yet.</p>
                </td>
            </tr>
        <?php endif; ?>
        
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal163c8ba6efb795223894d5ffef5034f5)): ?>
<?php $attributes = $__attributesOriginal163c8ba6efb795223894d5ffef5034f5; ?>
<?php unset($__attributesOriginal163c8ba6efb795223894d5ffef5034f5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal163c8ba6efb795223894d5ffef5034f5)): ?>
<?php $component = $__componentOriginal163c8ba6efb795223894d5ffef5034f5; ?>
<?php unset($__componentOriginal163c8ba6efb795223894d5ffef5034f5); ?>
<?php endif; ?>

    <!-- Pagination -->
    <?php if($products->hasPages()): ?>
        <div class="mt-3 d-flex justify-content-end">
            <?php echo e($products->links()); ?>

        </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/admin/products/index.blade.php ENDPATH**/ ?>