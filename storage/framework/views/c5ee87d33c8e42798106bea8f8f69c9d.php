<div class="mb-3">
    <label class="form-label fw-semibold">Total Stock Quantity</label>
    <input type="number" name="stock_quantity" class="form-control" min="0" value="<?php echo e(old('stock_quantity', $product->stock_quantity ?? 0)); ?>" required>
    <div class="form-text text-muted">
        If you generate variants below, this will auto-calculate and lock.
    </div>
</div>

<div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Colors, Sizes & Variants</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            
            <!-- COLORS -->
            <div class="col-md-6 mb-3 mb-md-0">
                <label class="form-label fw-semibold">Available Colors</label>
                <div class="border rounded p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                    <?php $__empty_1 = true; $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="form-check mb-2">
                        <?php
                            // Check old input or pre-select if the variant already uses this color on edit
                            $checkedColors = old('selected_colors', isset($product) ? $product->variants->pluck('color_id')->toArray() : []);
                        ?>
                        <input class="form-check-input color-checkbox" type="checkbox" name="selected_colors[]" value="<?php echo e($color->id); ?>" id="color_<?php echo e($color->id); ?>" data-name="<?php echo e($color->name); ?>" <?php echo e(in_array($color->id, $checkedColors) ? 'checked' : ''); ?>>
                        <label class="form-check-label d-flex align-items-center user-select-none" for="color_<?php echo e($color->id); ?>">
                            <span class="d-inline-block rounded-circle me-2 shadow-sm" style="width: 16px; height: 16px; background-color: <?php echo e($color->hex_code ?? '#ccc'); ?>; border: 1px solid #adb5bd;"></span>
                            <?php echo e($color->name); ?>

                        </label>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-muted small">No colors found.</div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- SIZES -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Available Sizes</label>
                <div class="border rounded p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                    <?php $__empty_1 = true; $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="form-check mb-2">
                        <?php
                            // Check old input or pre-select if the variant already uses this size on edit
                            $checkedSizes = old('selected_sizes', isset($product) ? $product->variants->pluck('size_id')->toArray() : []);
                        ?>
                        <input class="form-check-input size-checkbox" type="checkbox" name="selected_sizes[]" value="<?php echo e($size->id); ?>" id="size_<?php echo e($size->id); ?>" data-name="<?php echo e($size->name); ?>" <?php echo e(in_array($size->id, $checkedSizes) ? 'checked' : ''); ?>>
                        <label class="form-check-label user-select-none" for="size_<?php echo e($size->id); ?>">
                            <?php echo e($size->name); ?>

                        </label>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-muted small">No sizes found</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0">Inventory Variations</h6>
            <button type="button" class="btn btn-sm btn-primary shadow-sm" id="generateVariantsBtn">
                <i class="fas fa-magic me-1"></i> Generate Rows
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle" id="variantsTable">
                <thead class="table-light">
                    <tr>
                        <th>Variant</th>
                        <th>SKU</th>
                        <th style="width: 150px;">Price Offset (+/-)</th>
                        <th style="width: 120px;">Stock</th>
                        <th class="text-center"><i class="fas fa-trash"></i></th>
                    </tr>
                </thead>
                <tbody id="variantsBody">
                    <?php if(isset($product) && $product->variants->count() > 0): ?>
                        <!-- LOOP EXISTING VARIANTS -->
                        <?php $__currentLoopData = $product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="fw-semibold align-middle">
                                    <?php echo e($variant->color->name ?? ''); ?> <?php echo e($variant->color && $variant->size ? '/' : ''); ?> <?php echo e($variant->size->name ?? ''); ?>

                                    
                                    <!-- Critical: Pass the Variant ID so the Controller knows to UPDATE, not create -->
                                    <input type="hidden" name="variants[<?php echo e($index); ?>][id]" value="<?php echo e($variant->id); ?>">
                                    <input type="hidden" name="variants[<?php echo e($index); ?>][color_id]" value="<?php echo e($variant->color_id); ?>">
                                    <input type="hidden" name="variants[<?php echo e($index); ?>][size_id]" value="<?php echo e($variant->size_id); ?>">
                                </td>
                                <td class="align-middle">
                                    <input type="text" class="form-control form-control-sm" name="variants[<?php echo e($index); ?>][sku]" value="<?php echo e($variant->sku); ?>" required>
                                </td>
                                <td class="align-middle">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">$</span>
                                        <!-- Calculate the price offset on the fly -->
                                        <input type="number" step="0.01" class="form-control" name="variants[<?php echo e($index); ?>][price_offset]" value="<?php echo e($variant->price - $product->price); ?>" placeholder="0.00">
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <input type="number" class="form-control form-control-sm variant-stock-input" name="variants[<?php echo e($index); ?>][stock]" value="<?php echo e($variant->stock_quantity); ?>" min="0" required>
                                </td>
                                <td class="text-center align-middle">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-row-btn" title="Remove Variant"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div><?php /**PATH D:\Project\web_ecommerce\S-store\resources\views/admin/products/product_created/variants_info.blade.php ENDPATH**/ ?>