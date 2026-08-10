<div class="mb-3 ">    
    <label class="form-label fw-semibold text-decoration-underline text-center fs-4  d-block ">Category</label>
    <div class="category-tree-container border rounded p-3 bg-light overflow-auto">
        <ul class="list-unstyled mb-0 d-flex flex-row flex-wrap gap-3 align-items-start">
            @foreach($allCategories->whereNull('parent_id') as $category)
                <li class="bg-white border rounded p-2 shadow-sm" style="min-width: 220px;">
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
                            <input class="form-check-input" type="radio" name="category_id" id="cat-{{ $category->id }}" value="{{ $category->id }}" required>
                            <label class="form-check-label fw-bold cursor-pointer text-dark" for="cat-{{ $category->id }}">
                                {{ $category->name }}
                            </label>
                        </div>
                    </div>

                    @if($category->children && $category->children->count() > 0)
                        <ul class="list-unstyled collapse ms-2 mt-3 border-start ps-3" id="child-cats-{{ $category->id }}">
                            @foreach($category->children as $child)
                                @include('admin.products.product_created.category_node', ['cat' => $child])
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>