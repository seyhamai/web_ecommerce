<div class="mb-3">    
    <label class="form-label fw-semibold text-decoration-underline text-center fs-4 d-block">Category</label>
    <div class="category-tree-container border rounded p-3 bg-light overflow-auto">
        <!-- 1. Changed to a Bootstrap Row with g-2 (small gap) -->
        <ul class="list-unstyled mb-0 row g-2 align-items-start">
            @foreach($allCategories->whereNull('parent_id') as $category)
                <!-- 2. Grid classes: col-6 (2 cols mobile), col-md-4 (3 cols tablet), col-lg-3 (4 cols desktop) -->
                <li class="col-6 col-md-4 col-lg-3">
                    <!-- 3. Moved background/border to this inner div -->
                    <div class="bg-white border rounded p-2 shadow-sm h-100">
                        <div class="d-flex align-items-center">
                            @if($category->children && $category->children->count() > 0)
                                <button class="btn btn-sm btn-link p-0 me-2 text-decoration-none" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#child-cats-{{ $category->id }}" 
                                        aria-expanded="false" 
                                        onclick="toggleIcon(this)">
                                    <i class="fas fa-chevron-right toggle-icon"></i>
                                </button>
                            @else
                                <span class="ms-3 me-2" style="width: 14px;"></span> 
                            @endif

                            <div class="form-check mb-0">
                                <input class="form-check-input @error('category_id') is-invalid @enderror" 
                                    type="radio" 
                                    name="category_id" 
                                    id="cat-{{ $category->id }}" 
                                    value="{{ $category->id }}" 
                                    {{ (string) old('category_id', $product->category_id ?? '') === (string) $category->id ? 'checked' : '' }} 
                                    required>
                                    
                                <!-- Added text-break and slightly smaller font to prevent long words from breaking the mobile layout -->
                                <label class="form-check-label fw-bold cursor-pointer text-dark text-break" style="font-size: 13px;" for="cat-{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            </div>
                        </div>

                        @if($category->children && $category->children->count() > 0)
                            <ul class="list-unstyled collapse ms-2 mt-2 border-start ps-2" id="child-cats-{{ $category->id }}">
                                @foreach($category->children as $child)
                                    @include('admin.products.product_created.category_node', ['cat' => $child])
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>