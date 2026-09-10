<div class="mb-3">
    <label class="form-label fw-semibold">Total Stock Quantity</label>
    <input type="number" name="stock_quantity" class="form-control" min="0" value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}" required>
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
                        @php
                            // Check old input or pre-select if the variant already uses this color on edit
                            $checkedColors = old('selected_colors', isset($product) ? $product->variants->pluck('color_id')->toArray() : []);
                        @endphp
                        <input class="form-check-input color-checkbox" type="checkbox" name="selected_colors[]" value="{{ $color->id }}" id="color_{{ $color->id }}" data-name="{{ $color->name }}" {{ in_array($color->id, $checkedColors) ? 'checked' : '' }}>
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
                        @php
                            // Check old input or pre-select if the variant already uses this size on edit
                            $checkedSizes = old('selected_sizes', isset($product) ? $product->variants->pluck('size_id')->toArray() : []);
                        @endphp
                        <input class="form-check-input size-checkbox" type="checkbox" name="selected_sizes[]" value="{{ $size->id }}" id="size_{{ $size->id }}" data-name="{{ $size->name }}" {{ in_array($size->id, $checkedSizes) ? 'checked' : '' }}>
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
                    
                    @php
                        // Determine whether to loop through validation errors (old) or database variants (edit)
                        $variantsToDisplay = old('variants', (isset($product) ? $product->variants->toArray() : []));
                    @endphp

                    @if(!empty($variantsToDisplay) && count($variantsToDisplay) > 0)
                        @foreach($variantsToDisplay as $index => $variant)
                            <tr>
                                <td class="align-middle fw-semibold text-dark">
                                    <span class="badge bg-secondary">Variant</span>
                                    
                                    <!-- Hidden inputs to preserve IDs -->
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
                                    @php
                                        // Handle price offset mapping if loaded from database vs old request
                                        $priceOffset = isset($variant['price_offset']) ? $variant['price_offset'] : (isset($variant['price']) && isset($product) ? $variant['price'] - $product->price : 0);
                                    @endphp
                                    <input type="number" step="0.01" class="form-control form-control-sm" name="variants[{{ $index }}][price_offset]" value="{{ $priceOffset }}">
                                </td>
                                <td>
                                    @php
                                        $stockVal = $variant['stock'] ?? ($variant['stock_quantity'] ?? 0);
                                    @endphp
                                    <input type="number" class="form-control form-control-sm @error("variants.$index.stock") is-invalid @enderror" name="variants[{{ $index }}][stock]" value="{{ $stockVal }}" min="0" required>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-variant-btn" onclick="this.closest('tr').remove()"><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    
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