@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-1 px-md-2">
        <x-page-header title="Category" breadcrumb="Category" breadcrumb-url="/admin/dashboard" />

        <x-_alerts />

        <div class="card mb-4 border-0 shadow-sm">
            <div
                class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 py-3 border-bottom">
                <div class="fw-bold fs-5 d-flex align-items-center">
                    <i class="fas fa-tag text-warning me-2"></i>
                    @if ($currentCategory)
                        <a href="{{ route('admin.categories.index') }}" class="text-decoration-none text-dark">Root</a>
                        <span class="mx-2 text-muted">/</span>
                        <span class="text-primary">{{ $currentCategory->name }}</span>
                    @else
                        Root Categories
                    @endif
                </div>

                <div class="d-flex gap-2">
                    @if ($currentCategory)
                        <a href="{{ $currentCategory->parent_id ? route('admin.categories.index', ['parent_id' => $currentCategory->parent_id]) : route('admin.categories.index') }}"
                            class="btn btn-sm btn-outline-secondary fw-bold shadow-sm">
                            <i class="fas fa-level-up-alt me-1"></i> Back
                        </a>
                    @endif
                    <button type="button" class="btn btn-sm btn-success fw-bold shadow-sm" data-bs-toggle="modal"
                        data-bs-target="#createCategoryModal">
                        <i class="fas fa-plus me-1"></i> Add Category
                    </button>
                </div>
            </div>

            <div class="card-body p-0 m-0">
                <!-- 🌟 Applied the Table Component 🌟 -->
                <x-table :headers="['Category Name', 'URL Slug', 'Status', 'Action']">
                    @forelse($categories as $category)
                        <tr>
                            <td class="ps-4">
                                <a href="{{ route('admin.categories.index', ['parent_id' => $category->id]) }}"
                                    class="text-decoration-none fw-bold text-dark fs-6">
                                    <i class="fas fa-tag text-primary me-2"></i> {{ $category->name }}
                                </a>
                                @if ($category->children_count > 0)
                                    <span class="badge bg-light text-secondary border ms-2 d-none d-sm-inline">
                                        {{ $category->children_count }} nested
                                    </span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $category->slug }}</td>
                            <td>
                                <span
                                    class="badge {{ $category->is_active ? 'bg-success bg-opacity-10 text-success border border-success-subtle' : 'bg-danger bg-opacity-10 text-danger border border-danger-subtle' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <button type="button" class="btn btn-sm btn-outline-primary shadow-sm me-1"
                                    data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                                    data-action-url="{{ route('admin.categories.update', $category->id) }}"
                                    data-input-name="{{ $category->name }}"
                                    data-input-parent_id="{{ $category->parent_id }}"
                                    data-input-is_active="{{ $category->is_active }}" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm"
                                        onclick="return confirm('Delete this category?')" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-tags text-secondary opacity-50 mb-3" style="font-size: 32px;"></i>
                                <p class="mb-0 mt-2 fw-bold text-dark">No categories found in this level.</p>
                            </td>
                        </tr>
                    @endforelse
                </x-table>
            </div>
        </div>
    </div>

    <!-- 🌟 The New Create Modal Component 🌟 -->
    <x-modal id="createCategoryModal" title="Create New Category" form-action="{{ route('admin.categories.store') }}"
        submit-text="Save Category" submit-color="success">
        <!-- We use the input components we built earlier! -->
        <x-input name="name" label="Category Name" required />

        <div class="mb-3">
            <label class="form-label fw-semibold">Parent Category</label>
            <select name="parent_id" class="form-select border-secondary">
                <option value="">Root Level (Main Category)</option>
                @foreach ($allCategories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ $currentCategory && $currentCategory->id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <x-checkbox name="is_active" label="Active Status" :checked="true" :is-switch="true" />
    </x-modal>

    <!-- 🌟 The New Edit Modal Component 🌟 -->
    <!-- Note: The form-action is blank here because your JavaScript handles injecting the correct URL -->
    <x-modal id="editCategoryModal" title="Edit Category" form-action="#" form-method="PUT" submit-text="Update Category"
        submit-color="primary">
        <x-input name="name" id="editName" label="Category Name" required />

        <div class="mb-3">
            <label class="form-label fw-semibold">Parent Category</label>
            <select name="parent_id" id="editParentId" class="form-select border-secondary">
                <option value="">Root Level (Main Category)</option>
                @foreach ($allCategories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <x-checkbox name="is_active" label="Active Status" :checked="true" :is-switch="true" />
    </x-modal>
@endsection
