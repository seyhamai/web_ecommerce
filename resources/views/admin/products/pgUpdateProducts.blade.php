@extends('layouts.admin')

@section('content')
<div class="container-fluid px-1 px-md-3 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1 class="font-semibold fs-2 mb-0">Update: {{ $product->name }}</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Back to Products
        </a>
    </div>

    <!-- Bootstrap Tabs Navigation -->
    <ul class="nav nav-tabs mb-4" id="editProductTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-semibold" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                <i class="fas fa-info-circle me-2"></i>General Information
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold" id="inventory-tab" data-bs-toggle="tab" data-bs-target="#inventory" type="button" role="tab">
                <i class="fas fa-boxes me-2"></i>Inventory & Variants
            </button>
        </li>
    </ul>

    <!-- Tab Content Area -->
    <div class="tab-content" id="editProductTabsContent">
        
        <!-- TAB 1: BASIC INFO FORM -->
        <div class="tab-pane fade show active" id="info" role="tabpanel">
            <form action="{{ route('admin.products.updateInfo', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-lg-8">
                        @include('admin.products.product_created.basic_info')
                    </div>
                    <div class="col-lg-4">
                        @include('admin.components._image_media', ['primaryRequired' => false])
                    </div>
                    <div class="col-lg-8">
                        @include('admin.products.product_created.selected_category')
                        <button type="submit" class="btn btn-primary btn-lg w-100 mt-4 shadow-sm">Update Information</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- TAB 2: INVENTORY FORM -->
        <div class="tab-pane fade" id="inventory" role="tabpanel">
            <form action="{{ route('admin.products.updateInventory', $product->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Your colors, sizes, and variants table goes here -->
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h4>Manage Stock</h4>
                        <!-- Paste your variants block here -->
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg mt-4 shadow-sm">Update Inventory</button>
            </form>
        </div>

    </div>
</div>
@endsection