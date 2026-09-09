<style>
    .ck-editor__editable_inline {
        min-height: 150px;
    }
</style>
<div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-white py-2">
        <h5 class="mb-0 fw-bold">Basic Information</h5>
    </div>
    <div class="card-body bg-light">
        <div class="mb-3">
            <label class="form-label fw-semibold">Product Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Product SKU</label>
            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku ?? '') }}">
            @error('sku')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" class="form-control" id="editor" rows="5">{!! old('description', $product->description ?? '') !!}</textarea>
        </div>
        
        <div class="row">
            <div class="col-md-5 mb-3">
                <label class="form-label fw-semibold">Regular Price (Price For sale)</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" name="price" class="form-control" step="0.1" value="{{ old('price', $product->price ?? '') }}" required>
                </div>
            </div>
            <div class="col-md-7 mb-3">
                <label class="form-label fw-semibold">Compare at Price (Cost Price or Price Before discount)</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" name="compare_at_price" class="form-control" step="0.1" value="{{ old('compare_at_price', $product->compare_at_price ?? '') }}">
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        ClassicEditor.create(document.querySelector('#editor'), {
               toolbar: [ 
                'heading', 
                '|', 
                'bold', 'italic', 'underline', 'strikethrough', 
                '|', 
                'link', 'bulletedList', 'numberedList', 'blockQuote', 
                '|',  
                'undo', 'redo' 
                ]
        })
        .catch(error => {
            console.error(error);
        });
        const firstError = document.querySelector('.is-invalid');
        
        if (firstError) {
            // Scroll to it and put the typing cursor inside it!
            firstError.focus();
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>