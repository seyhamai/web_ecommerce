
<div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-white py-2">
        <h5 class="mb-0 fw-bold">Basic Information</h5>
    </div>
    <div class="card-body bg-light">

        <x-input name="name" label="Product Name" value="{{ $product->name ?? '' }}" required />

        <x-input name="sku" label="Product SKU" value="{{ $product->sku ?? '' }}" />

        <x-rich-textarea 
            name="description" 
            id="editor" 
            label="Description" 
            :value="$product->description ?? ''" 
            rows="5" 
        />
        
        <div class="row mt-2">

            <div class="col-md-5 mb-3">
                <label class="form-label fw-semibold">
                    Regular Price (Price For sale) <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text">$</span>

                    <x-input type="number" name="price" step="0.1" value="{{ $product->price ?? '' }}" :no-wrapper="true" required />
                </div>
            </div>

            <div class="col-md-7 mb-3">
                <label class="form-label fw-semibold">Compare at Price (Cost Price or Price Before discount)</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <x-input type="number" name="compare_at_price" step="0.1" value="{{ $product->compare_at_price ?? '' }}" :no-wrapper="true" />
                </div>
            </div>
        </div>
        
    </div>
</div>