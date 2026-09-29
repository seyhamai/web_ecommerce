<div class="mb-3">    
    <label class="form-label fw-semibold text-decoration-underline text-center fs-4 d-block">Category</label>
    <div class="category-tree-container border rounded p-3 bg-light overflow-auto">
        <!-- 1. Changed to a Bootstrap Row with g-2 (small gap) -->
        <ul class="list-unstyled mb-0 row g-2 align-items-start">
            <?php $__currentLoopData = $allCategories->whereNull('parent_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!-- 2. Grid classes: col-6 (2 cols mobile), col-md-4 (3 cols tablet), col-lg-3 (4 cols desktop) -->
                <li class="col-6 col-md-4 col-lg-3">
                    <!-- 3. Moved background/border to this inner div -->
                    <div class="bg-white border rounded p-2 shadow-sm h-100">
                        <div class="d-flex align-items-center">
                            <?php if($category->children && $category->children->count() > 0): ?>
                                <button class="btn btn-sm btn-link p-0 me-2 text-decoration-none" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#child-cats-<?php echo e($category->id); ?>" 
                                        aria-expanded="false" 
                                        onclick="toggleIcon(this)">
                                    <i class="fas fa-chevron-right toggle-icon"></i>
                                </button>
                            <?php else: ?>
                                <span class="ms-3 me-2" style="width: 14px;"></span> 
                            <?php endif; ?>

                            <div class="form-check mb-0">
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
                                    id="cat-<?php echo e($category->id); ?>" 
                                    value="<?php echo e($category->id); ?>" 
                                    <?php echo e((string) old('category_id', $product->category_id ?? '') === (string) $category->id ? 'checked' : ''); ?> 
                                    required>
                                    
                                <!-- Added text-break and slightly smaller font to prevent long words from breaking the mobile layout -->
                                <label class="form-check-label fw-bold cursor-pointer text-dark text-break" style="font-size: 13px;" for="cat-<?php echo e($category->id); ?>">
                                    <?php echo e($category->name); ?>

                                </label>
                            </div>
                        </div>

                        <?php if($category->children && $category->children->count() > 0): ?>
                            <ul class="list-unstyled collapse ms-2 mt-2 border-start ps-2" id="child-cats-<?php echo e($category->id); ?>">
                                <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('admin.products.product_created.category_node', ['cat' => $child], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</div><?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/admin/products/product_created/selected_category.blade.php ENDPATH**/ ?>