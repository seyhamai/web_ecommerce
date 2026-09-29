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
                    @if(isset($product) && $product->variants->count() > 0)
                        <!-- LOOP EXISTING VARIANTS -->
                        @foreach($product->variants as $index => $variant)
                            <tr>
                                <td class="fw-semibold align-middle">
                                    {{ $variant->color->name ?? '' }} {{ $variant->color && $variant->size ? '/' : '' }} {{ $variant->size->name ?? '' }}
                                    
                                    <!-- Critical: Pass the Variant ID so the Controller knows to UPDATE, not create -->
                                    <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                                    <input type="hidden" name="variants[{{ $index }}][color_id]" value="{{ $variant->color_id }}">
                                    <input type="hidden" name="variants[{{ $index }}][size_id]" value="{{ $variant->size_id }}">
                                </td>
                                <td class="align-middle">
                                    <input type="text" class="form-control form-control-sm" name="variants[{{ $index }}][sku]" value="{{ $variant->sku }}" required>
                                </td>
                                <td class="align-middle">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">$</span>
                                        <!-- Calculate the price offset on the fly -->
                                        <input type="number" step="0.01" class="form-control" name="variants[{{ $index }}][price_offset]" value="{{ $variant->price - $product->price }}" placeholder="0.00">
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <input type="number" class="form-control form-control-sm variant-stock-input" name="variants[{{ $index }}][stock]" value="{{ $variant->stock_quantity }}" min="0" required>
                                </td>
                                <td class="text-center align-middle">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-row-btn" title="Remove Variant"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>