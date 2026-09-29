@extends('layouts.admin')

@push('styles')
    <style>
        /* Category Tree Styles */
        .cursor-pointer {
            cursor: pointer;
        }

        .toggle-icon {
            transition: transform 0.2s ease-in-out;
            color: #6c757d;
        }

        .rotate-down {
            transform: rotate(90deg);
        }

        .category-tree-container {
            max-height: 250px;
            overflow-y: auto;
        }

        /* CSS for the new smooth animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        tr {
            transition: opacity 0.2s ease-out;
        }
    </style>
@endpush

@section('content')
    <x-_alerts />

    <div class="container-fluid px-1 px-md-3 mb-5">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <h1 class="font-semibold fs-2 mb-0">Add New Product</h1>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to Products
            </a>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-12">
                    @include('admin.products.product_created.basic_info')
                    @include('admin.products.product_created.selected_category')

                    <!-- 🌟 ONE LINE REPLACES THE ENTIRE IMAGE SECTION 🌟 -->
                    <x-images.product-gallery />

                    @include('admin.products.product_created.variants_info')

                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold">Publishing Options</h5>
                        </div>
                        <div class="card-body">
                            <x-radio label="Product Visibility" />

                            <div class="form-check form-switch mt-4 mb-2">
                                <input class="form-check-input border-secondary" type="checkbox" name="is_featured"
                                    id="isFeatured" value="1">
                                <label class="form-check-label fw-semibold" for="isFeatured">Feature on Homepage</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg w-100 py-3 fw-bold shadow-sm"
                        style="border-radius: 12px; transition: 0.2s;">
                        <i class="fas fa-save me-2"></i> Save Product
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/modules/products.js') }}"></script>
@endpush
