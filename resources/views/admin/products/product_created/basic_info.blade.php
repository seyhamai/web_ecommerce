<div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-white py-2">
        <h5 class="mb-0 fw-bold">Basic Information</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label fw-semibold">Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Product SKU</label>
            <input type="text" name="sku" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" class="form-control" rows="5"></textarea>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Regular Price</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" name="price" class="form-control" step="0.01" required>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Compare at Price (Optional)</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" name="compare_at_price" class="form-control" step="0.01">
                </div>
            </div>
        </div>
    </div>
</div>