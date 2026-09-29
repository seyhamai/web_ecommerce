

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-1 px-md-3 mb-5">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1 class="font-semibold fs-2 mb-0 text-danger">
            <i class="fas fa-trash-alt me-2"></i>Trashed Products
        </h1>
        <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Back to Products
        </a>
    </div>

    <!-- Success Message Component -->
    <?php echo $__env->make('components._alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Product Table -->
    <div class="card shadow-sm border-0 border-top border-danger border-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4" style="width: 180px;">Image</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Main Category</th>
                            <th scope="col">Category</th>
                            <th scope="col">Price</th>
                            <th scope="col" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-2">
                                <?php if($product->primary_image): ?>
                                    <img src="<?php echo e(asset('storage/' . $product->primary_image)); ?>" alt="<?php echo e($product->name); ?>" class="img-thumbnail rounded grayscale" style="width: 90%; height: 80px; object-fit: cover; filter: grayscale(100%); opacity: 0.7;">
                                <?php else: ?>
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="fw-semibold text-muted">
                                <del><?php echo e($product->name); ?></del>
                                <div class="small fw-normal">SKU: <?php echo e($product->sku); ?></div>
                            </td>
                            <td>
                                <span class="text-muted"><?php echo e($product->category && $product->category->parent ? $product->category->parent->name : 'None'); ?></span>
                            </td>
                            <td>
                                <span class="badge bg-secondary opacity-75"><?php echo e($product->category->name ?? 'Uncategorized'); ?></span>
                            </td>
                            <td class="text-muted">$<?php echo e(number_format($product->price, 2)); ?></td>
                            <td class="text-end pe-4">
                                <!-- RESTORE BUTTON -->
                                <form action="<?php echo e(route('admin.products.restore', $product->id)); ?>" method="POST" class="d-inline-block">
                                    <?php echo csrf_field(); ?>
                                    <button type="button" class="btn btn-sm btn-outline-success me-1 shadow-sm requires-confirmation"
                                        data-title="Restore Product"
                                        data-message="Are you sure you want to restore this product to active?" 
                                        data-btn-text="Yes, Restore"
                                        data-btn-class="btn-success"> 
                                        <i class="fas fa-undo me-1"></i> Restore
                                    </button>                      
                                </form>

                                <!-- FORCE DELETE BUTTON -->
                                <form action="<?php echo e(route('admin.products.forceDelete', $product->id)); ?>" method="POST" class="d-inline-block">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    
                                    <!-- Add 'requires-confirmation' and the data attributes here -->
                                    <button type="button" class="btn btn-sm btn-danger shadow-sm requires-confirmation" 
                                            data-title="Delete Forever?" 
                                            data-message="This will permanently delete this product and all its variants. This cannot be undone."
                                            data-btn-text="Yes, Delete Forever">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-wind fs-1 mb-3 text-light"></i>
                                <h5>The trash is empty</h5>
                                <p>No products have been deleted recently.</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <?php if($products->hasPages()): ?>
            <div class="card-footer bg-light py-3 border-top-0">
                <?php echo e($products->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/admin/products/pgTrashProducts.blade.php ENDPATH**/ ?>