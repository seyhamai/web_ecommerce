<li class="mb-2">
    <div class="d-flex align-items-center">
        <?php if($cat->children && $cat->children->count() > 0): ?>
            <button class="btn btn-sm btn-link p-0 me-2 text-decoration-none" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#sub-cats-<?php echo e($cat->id); ?>" 
                    aria-expanded="false" 
                    onclick="toggleIcon(this)">
                <i class="fas fa-chevron-right toggle-icon text-muted"></i>
            </button>
        <?php else: ?>
            <span class="ms-3 me-2" style="width: 14px;"></span> 
        <?php endif; ?>

        <div class="form-check mb-0">
            <!-- ADDED THE CHECKED LOGIC HERE -->
            <input class="form-check-input <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                   type="radio" 
                   name="category_id" 
                   id="cat-<?php echo e($cat->id); ?>" 
                   value="<?php echo e($cat->id); ?>"
                   <?php echo e((string) old('category_id', $product->category_id ?? '') === (string) $cat->id ? 'checked' : ''); ?>>
                   
            <label class="form-check-label cursor-pointer text-secondary" for="cat-<?php echo e($cat->id); ?>" >
                <?php echo e($cat->name); ?>

            </label>
        </div>
    </div>

    <?php if($cat->children && $cat->children->count() > 0): ?>
        <ul class="list-unstyled collapse ms-4 mt-2 border-start ps-3" id="sub-cats-<?php echo e($cat->id); ?>">
            <?php $__currentLoopData = $cat->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('admin.products.product_created.category_node', ['cat' => $child], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>
</li><?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/admin/products/product_created/category_node.blade.php ENDPATH**/ ?>