<li class="mb-2">
    <div class="d-flex align-items-center">
        @if($cat->children && $cat->children->count() > 0)
            <button class="btn btn-sm btn-link p-0 me-2 text-decoration-none" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#sub-cats-{{ $cat->id }}" 
                    aria-expanded="false" 
                    onclick="toggleIcon(this)">
                <i class="fas fa-chevron-right toggle-icon text-muted"></i>
            </button>
        @else
            <span class="ms-3 me-2" style="width: 14px;"></span> 
        @endif

        <div class="form-check mb-0">
            <!-- ADDED THE CHECKED LOGIC HERE -->
            <input class="form-check-input @error('category_id') is-invalid @enderror" 
                   type="radio" 
                   name="category_id" 
                   id="cat-{{ $cat->id }}" 
                   value="{{ $cat->id }}"
                   {{ (string) old('category_id', $product->category_id ?? '') === (string) $cat->id ? 'checked' : '' }}>
                   
            <label class="form-check-label cursor-pointer text-secondary" for="cat-{{ $cat->id }}" >
                {{ $cat->name }}
            </label>
        </div>
    </div>

    @if($cat->children && $cat->children->count() > 0)
        <ul class="list-unstyled collapse ms-4 mt-2 border-start ps-3" id="sub-cats-{{ $cat->id }}">
            @foreach($cat->children as $child)
                @include('admin.products.product_created.category_node', ['cat' => $child])
            @endforeach
        </ul>
    @endif
</li>