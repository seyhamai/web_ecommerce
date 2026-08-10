@extends('layouts.admin')

@section('content')
<style>
    /* Category Tree Styles */
    .cursor-pointer { cursor: pointer; }
    .toggle-icon { transition: transform 0.2s ease-in-out; color: #6c757d; }
    .rotate-down { transform: rotate(90deg); }
    .category-tree-container { max-height: 250px; overflow-y: auto; }
</style>

<div class="container-fluid px-1 px-md-3 mb-5">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1 class="font-semibold fs-2 mb-0">Add New Product</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Products
        </a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <div class="col-lg-12">
                @include('admin.products.product_created.basic_info')
                @include('admin.products.product_created.selected_category')

                {{-- <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Images & Media</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                                <label class="form-label fw-semibold">Primary Image (Portrait)</label>
                                <input type="file" name="primary_image" class="form-control" accept="image/*" required>
                                <div class="form-text text-muted">Recommended size: 800x1200px. This is the main thumbnail on the storefront.</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Secondary Image (Landscape) <span class="text-muted fw-normal">(Optional)</span></label>
                                <input type="file" name="secondary_image" class="form-control" accept="image/*">
                                <div class="form-text text-muted">Recommended size: 1200x800px. Used for hover effects or top banners.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Gallery Detail Shots</label>
                                <input type="file" name="gallery_images[]" class="form-control" accept="image/*" multiple>
                                <div class="form-text text-muted">Hold CTRL (or CMD) to select multiple images at once.</div>
                            </div>
                    </div>
                </div>

                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Colors, Sizes & Variants</h5>
                    </div>
                    <div class="card-body">
                        

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-semibold">Available Colors</label>
                                <div class="border rounded p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                                    @forelse($colors as $color)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input color-checkbox" type="checkbox" name="selected_colors[]" value="{{ $color->id }}" id="color_{{ $color->id }}" data-name="{{ $color->name }}">
                                        <label class="form-check-label d-flex align-items-center user-select-none" for="color_{{ $color->id }}">
                                            <span class="d-inline-block rounded-circle me-2 shadow-sm" style="width: 16px; height: 16px; background-color: {{ $color->hex_code ?? '#ccc' }}; border: 1px solid #adb5bd;"></span>
                                            {{ $color->name }}
                                        </label>
                                    </div>
                                    @empty
                                    <div class="text-muted small">No colors found in database.</div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Available Sizes</label>
                                <div class="border rounded p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                                    @forelse($sizes as $size)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input size-checkbox" type="checkbox" name="selected_sizes[]" value="{{ $size->id }}" id="size_{{ $size->id }}" data-name="{{ $size->name }}">
                                        <label class="form-check-label user-select-none" for="size_{{ $size->id }}">
                                            {{ $size->name }}
                                        </label>
                                    </div>
                                    @empty
                                    <div class="text-muted small">No sizes found in database.</div>
                                    @endforelse
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
                                    <tr id="noVariantsRow">
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="fas fa-layer-group fs-3 mb-2 text-light"></i>
                                            <p class="mb-0">Select colors and sizes above, then click <strong>Generate Rows</strong> to set your inventory.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> --}}
            </div>

            <!-- NEW CATEGORY COMPONENT -->
            <div class="col-lg-12">
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Publishing & Category</h5>
                    </div>
                    <div class="card-body">
                        

                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked value="1">
                            <label class="form-check-label fw-semibold" for="isActive">Product is Active</label>
                        </div>

                        <div class="form-check form-switch mt-3 mb-2">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="isFeatured" value="1">
                            <label class="form-check-label fw-semibold" for="isFeatured">Feature on Homepage</label>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-success w-100 py-3 fw-bold shadow-sm">
                    <i class="fas fa-save me-2"></i> Save Product
                </button>
            </div>
        </div>
    </form>
</div>

<script>
// Category Dropdown Icon Animation
function toggleIcon(button) {
    let icon = button.querySelector('.toggle-icon');
    if(icon) {
        icon.classList.toggle('rotate-down');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const generateBtn = document.getElementById('generateVariantsBtn');
    const variantsBody = document.getElementById('variantsBody');
    const noVariantsRow = document.getElementById('noVariantsRow');

    generateBtn.addEventListener('click', function() {
        const selectedColors = Array.from(document.querySelectorAll('.color-checkbox:checked'));
        const selectedSizes = Array.from(document.querySelectorAll('.size-checkbox:checked'));
        const baseSku = document.querySelector('input[name="sku"]').value || 'SKU';

        // Clear table, but keep the 'No Variants' row hidden in memory
        variantsBody.innerHTML = '';
        
        if (selectedColors.length === 0 && selectedSizes.length === 0) {
            variantsBody.appendChild(noVariantsRow);
            return;
        }

        let combinations = [];

        // Matrix logic: If both exist, combine them. If only one exists, just use that one.
        if (selectedColors.length > 0 && selectedSizes.length > 0) {
            selectedColors.forEach(color => {
                selectedSizes.forEach(size => {
                    combinations.push({ color: color, size: size });
                });
            });
        } else if (selectedColors.length > 0) {
            selectedColors.forEach(color => combinations.push({ color: color, size: null }));
        } else if (selectedSizes.length > 0) {
            selectedSizes.forEach(size => combinations.push({ color: null, size: size }));
        }

        // Build the HTML rows
        combinations.forEach((combo, index) => {
            let variantName = '';
            let variantSkuSuffix = '';
            
            if (combo.color && combo.size) {
                variantName = `${combo.color.dataset.name} — ${combo.size.dataset.name}`;
                variantSkuSuffix = `-${combo.color.dataset.name.substring(0,3).toUpperCase()}-${combo.size.dataset.name.toUpperCase()}`;
            } else if (combo.color) {
                variantName = combo.color.dataset.name;
                variantSkuSuffix = `-${combo.color.dataset.name.substring(0,3).toUpperCase()}`;
            } else {
                variantName = combo.size.dataset.name;
                variantSkuSuffix = `-${combo.size.dataset.name.toUpperCase()}`;
            }

            const cleanSku = (baseSku + variantSkuSuffix).replace(/\s+/g, '');

            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="fw-semibold">
                    ${variantName}
                    ${combo.color ? `<input type="hidden" name="variants[${index}][color_id]" value="${combo.color.value}">` : ''}
                    ${combo.size ? `<input type="hidden" name="variants[${index}][size_id]" value="${combo.size.value}">` : ''}
                </td>
                <td>
                    <input type="text" name="variants[${index}][sku]" class="form-control form-control-sm" value="${cleanSku}" required>
                </td>
                <td>
                    <input type="number" name="variants[${index}][price]" class="form-control form-control-sm" placeholder="0.00" step="0.01">
                </td>
                <td>
                    <input type="number" name="variants[${index}][stock_quantity]" class="form-control form-control-sm" value="0" min="0" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-row"><i class="fas fa-times"></i></button>
                </td>
            `;
            variantsBody.appendChild(row);
        });
    });

    // Handle row deletion
    variantsBody.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            e.target.closest('tr').remove();
            if (variantsBody.children.length === 0) {
                variantsBody.appendChild(noVariantsRow);
            }
        }
    });
});
</script>
@endsection