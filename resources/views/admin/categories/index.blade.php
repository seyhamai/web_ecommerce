@extends('layouts.admin')

@section('content')

<div class="container-fluid px-1 px-md-2">
    <h1 class="mt-4 font-semibold fs-2">Manage Categories</h1>
    
 @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-5 mt-md-2 shadow-sm" role="alert" style="position: relative; z-index: 10;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    <div class="card mb-4">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 py-3">
            
            <div class="fw-bold fs-5 d-flex align-items-center">
                <i class="fas fa-tag text-warning me-2"></i>
                @if($currentCategory)
                    <a href="{{ route('admin.categories.index') }}" class="text-decoration-none text-dark">Root</a>
                    <span class="mx-2 text-muted">/</span>
                    <span class="text-primary">{{ $currentCategory->name }}</span>
                @else
                    Root Categories
                @endif
            </div>

            <div class="d-flex gap-2">
                @if($currentCategory)
                    <a href="{{ $currentCategory->parent_id ? route('admin.categories.index', ['parent_id' => $currentCategory->parent_id]) : route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-level-up-alt"></i> Back
                    </a>
                @endif
                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                    <i class="fas fa-plus"></i> Add Category
                </button>
            </div>
        </div>

        <div class="card-body p-0 m-0">
            <div class="table-responsive text-nowrap">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th class="ps-4">Category Name</th>
                <th>URL Slug</th>
                <th>Status</th>
                <th class="text-end pe-4">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td class="ps-4">
    <a href="{{ route('admin.categories.index', ['parent_id' => $category->id]) }}" class="text-decoration-none fw-bold text-dark fs-6">
        <i class="fas fa-tag text-primary me-2"></i> {{ $category->name }}
    </a>
    @if($category->children_count > 0)
        <span class="badge bg-light text-secondary border ms-2 d-none d-sm-inline">
            {{ $category->children_count }} nested
        </span>
    @endif
</td>
                <td>{{ $category->slug }}</td>
                <td>
                    <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }}">
                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="text-end pe-4">
                    <button type="button" 
                            class="btn btn-sm btn-primary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editCategoryModal"
                            data-id="{{ $category->id }}"
                            data-name="{{ $category->name }}"
                            data-parent="{{ $category->parent_id }}"
                            data-active="{{ $category->is_active }}">
                        Edit
                    </button>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-5 text-muted">
                    <i class="fas fa-tag text-warning mb-2" style="font-size: 32px;"></i>
                    <p class="mb-0 mt-2">No categories found in this field.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
        </div>
    </div>
</div>

<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold">Create New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Parent Category</label>
                        <select name="parent_id" class="form-select">
                            <option value="">Root Level (Main Category)</option>
                            @foreach($allCategories as $cat)
                                <option value="{{ $cat->id }}" {{ ($currentCategory && $currentCategory->id == $cat->id) ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked value="1">
                        <label class="form-check-label" for="isActive">Active Status</label>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCategoryForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category Name</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Parent Category</label>
                        <select name="parent_id" id="editParentId" class="form-select">
                            <option value="">Root Level (Main Category)</option>
                            @foreach($allCategories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" name="is_active" id="editIsActive" value="1">
                        <label class="form-check-label" for="editIsActive">Active Status</label>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editCategoryModal = document.getElementById('editCategoryModal');
        
        if (editCategoryModal) {
            editCategoryModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                
                var id = button.getAttribute('data-id');
                var name = button.getAttribute('data-name');
                var parentId = button.getAttribute('data-parent');
                var isActive = button.getAttribute('data-active');
                
                var form = document.getElementById('editCategoryForm');
                var nameInput = document.getElementById('editName');
                var parentSelect = document.getElementById('editParentId');
                var activeCheckbox = document.getElementById('editIsActive');
                
                form.action = '/admin/categories/' + id;
                nameInput.value = name;
                parentSelect.value = parentId ? parentId : '';
                activeCheckbox.checked = isActive == '1';
                
                Array.from(parentSelect.options).forEach(function(option) {
                    if (option.value === id) {
                        option.disabled = true;
                    } else {
                        option.disabled = false;
                    }
                });
            });
        }
    });
</script>
@endsection