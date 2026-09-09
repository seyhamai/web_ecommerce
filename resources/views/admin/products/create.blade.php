@extends('layouts.admin')

@section('content')
<style>
    /* Category Tree Styles */
    .cursor-pointer { cursor: pointer; }
    .toggle-icon { transition: transform 0.2s ease-in-out; color: #6c757d; }
    .rotate-down { transform: rotate(90deg); }
    .category-tree-container { max-height: 250px; overflow-y: auto; }
</style>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="container-fluid px-1 px-md-3 mb-5">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1 class="font-semibold fs-2 mb-0">Add New Product</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Products
        </a>
    </div>

    <!-- Notice the enctype is correct here! -->
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <div class="col-lg-12">
                @include('admin.products.product_created.basic_info')
                @include('admin.products.product_created.selected_category')
                @include('admin.components._image_media')
                
               <div class="mb-3">
                    <label class="form-label fw-semibold">Total Stock Quantity</label>
                    <input type="number" name="stock_quantity" class="form-control" value="0" min="0" value="{{ old('stock_quantity') }}" required>
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
                                    @forelse($colors as $color)
                                    <div class="form-check mb-2">
                                        <!-- Added in_array() check for old() values -->
                                        <input class="form-check-input color-checkbox" type="checkbox" name="selected_colors[]" value="{{ $color->id }}" id="color_{{ $color->id }}" data-name="{{ $color->name }}" {{ in_array($color->id, old('selected_colors', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label d-flex align-items-center user-select-none" for="color_{{ $color->id }}">
                                            <span class="d-inline-block rounded-circle me-2 shadow-sm" style="width: 16px; height: 16px; background-color: {{ $color->hex_code ?? '#ccc' }}; border: 1px solid #adb5bd;"></span>
                                            {{ $color->name }}
                                        </label>
                                    </div>
                                    @empty
                                    <div class="text-muted small">No colors found.</div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- SIZES -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Available Sizes</label>
                                <div class="border rounded p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                                    @forelse($sizes as $size)
                                    <div class="form-check mb-2">
                                        <!-- Added in_array() check for old() values -->
                                        <input class="form-check-input size-checkbox" type="checkbox" name="selected_sizes[]" value="{{ $size->id }}" id="size_{{ $size->id }}" data-name="{{ $size->name }}" {{ in_array($size->id, old('selected_sizes', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label user-select-none" for="size_{{ $size->id }}">
                                            {{ $size->name }}
                                        </label>
                                    </div>
                                    @empty
                                    <div class="text-muted small">No sizes found</div>
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
                                    
                                    <!-- IF THERE ARE OLD VARIANTS FROM A FAILED SUBMISSION -->
                                    @if(old('variants'))
                                        @foreach(old('variants') as $index => $variant)
                                            <tr>
                                                <td class="align-middle fw-semibold text-dark">
                                                    <span class="badge bg-secondary">Saved Variant</span>
                                                    
                                                    <!-- Hidden inputs to remember IDs -->
                                                    @if(!empty($variant['color_id']))
                                                        <input type="hidden" name="variants[{{ $index }}][color_id]" value="{{ $variant['color_id'] }}">
                                                    @endif
                                                    @if(!empty($variant['size_id']))
                                                        <input type="hidden" name="variants[{{ $index }}][size_id]" value="{{ $variant['size_id'] }}">
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm @error("variants.$index.sku") is-invalid @enderror" name="variants[{{ $index }}][sku]" value="{{ $variant['sku'] ?? '' }}" required>
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control form-control-sm" name="variants[{{ $index }}][price_offset]" value="{{ $variant['price_offset'] ?? 0 }}">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm @error("variants.$index.stock") is-invalid @enderror" name="variants[{{ $index }}][stock]" value="{{ $variant['stock'] ?? 0 }}" min="0" required>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-variant-btn" onclick="this.closest('tr').remove()"><i class="fas fa-times"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                    <!-- DEFAULT STATE (No old variants) -->
                                    @else
                                        <tr id="noVariantsRow">
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="fas fa-layer-group fs-3 mb-2 text-light"></i>
                                                <p class="mb-0">Select colors and sizes above, then click <strong>Generate Rows</strong> to set your inventory.</p>
                                            </td>
                                        </tr>
                                    @endif
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- NEW CATEGORY COMPONENT (Publishing) -->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Publishing Options</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
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

// Unified Variants & Stock Logic
document.addEventListener('DOMContentLoaded', function () {
    const generateBtn = document.getElementById('generateVariantsBtn');
    const variantsBody = document.getElementById('variantsBody');
    const noVariantsRow = document.getElementById('noVariantsRow');
    
    // Grab main fields from basic_info include
    const mainStockInput = document.querySelector('input[name="stock_quantity"]');
    const mainSkuInput = document.querySelector('input[name="sku"]'); 

    // --- 1. GENERATE ROWS LOGIC ---
    generateBtn.addEventListener('click', function () {
        const colors = Array.from(document.querySelectorAll('.color-checkbox:checked'));
        const sizes = Array.from(document.querySelectorAll('.size-checkbox:checked'));

        if (colors.length === 0 && sizes.length === 0) {
            alert('Please select at least one color or size!');
            return;
        }

        variantsBody.innerHTML = ''; // Clear table
        let variantIndex = 0;
        let baseSku = mainSkuInput && mainSkuInput.value ? mainSkuInput.value : 'SKU';

        const addRow = (color, size) => {
            const colorName = color ? color.dataset.name : '';
            const colorId = color ? color.value : '';
            const sizeName = size ? size.dataset.name : '';
            const sizeId = size ? size.value : '';

            // Title
            let variantTitleParts = [];
            if (colorName) variantTitleParts.push(colorName);
            if (sizeName) variantTitleParts.push(sizeName);
            const variantTitle = variantTitleParts.join(' / ');

            // SKU
            let generatedSku = baseSku;
            if (colorName) generatedSku += '-' + colorName.substring(0, 3).toUpperCase();
            if (sizeName) generatedSku += '-' + sizeName.toUpperCase();
            generatedSku = generatedSku.replace(/\s+/g, '');

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="fw-semibold">
                    ${variantTitle}
                    <input type="hidden" name="variants[${variantIndex}][color_id]" value="${colorId}">
                    <input type="hidden" name="variants[${variantIndex}][size_id]" value="${sizeId}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="variants[${variantIndex}][sku]" value="${generatedSku}" required>
                </td>
                <td>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" class="form-control" name="variants[${variantIndex}][price_offset]" value="0" placeholder="0.00">
                    </div>
                </td>
                <td>
                    <!-- IMPORTANT: The name is [stock] so validation passes -->
                    <input type="number" class="form-control form-control-sm variant-stock-input" name="variants[${variantIndex}][stock]" value="0" min="0" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-row-btn"><i class="fas fa-trash"></i></button>
                </td>
            `;
            variantsBody.appendChild(tr);
            variantIndex++;
        };

        if (colors.length > 0 && sizes.length > 0) {
            colors.forEach(c => sizes.forEach(s => addRow(c, s))); 
        } else if (colors.length > 0) {
            colors.forEach(c => addRow(c, null)); 
        } else if (sizes.length > 0) {
            sizes.forEach(s => addRow(null, s)); 
        }

        calculateTotalStock();
    });

    // --- 2. DELETE ROW LOGIC ---
    variantsBody.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row-btn')) {
            e.target.closest('tr').remove();
            if (variantsBody.children.length === 0) {
                variantsBody.appendChild(noVariantsRow);
            }
            calculateTotalStock();
        }
    });

    // --- 3. AUTO-CALCULATE TOTAL STOCK ---
    function calculateTotalStock() {
        if (!mainStockInput) return;

        let total = 0;
        const stockInputs = variantsBody.querySelectorAll('.variant-stock-input');
        
        if (stockInputs.length > 0) {
            stockInputs.forEach(input => total += parseInt(input.value) || 0);
            mainStockInput.value = total;
            mainStockInput.setAttribute('readonly', true);
            mainStockInput.classList.add('bg-light'); 
        } else {
            mainStockInput.removeAttribute('readonly');
            mainStockInput.classList.remove('bg-light');
        }
    }

    // Trigger calculation when typing in stock fields
    variantsBody.addEventListener('input', function (e) {
        if (e.target.classList.contains('variant-stock-input')) {
            calculateTotalStock();
        }
    });
});
</script>
@endsection