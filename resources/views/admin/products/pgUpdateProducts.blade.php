@php

    $secondaryImg = $product->images->where('type', 'secondary_landscape')->first();

    $galleryImgs = $product->images->where('type', 'gallery'); 
@endphp
@extends('layouts.admin')
@section('content')
<div class="container-fluid px-1 px-md-3 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1 class="font-semibold fs-2 mb-0">Update: {{ $product->name }}</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Back to Products
        </a>
    </div>

    @include('admin.components._alerts')

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
                <div class="row gx-4">
                    <div class="col-lg-8">

                        <div class="mb-4">
                            @include('admin.products.product_created.basic_info')
                        </div>

                        <div class="mb-4">
                            @include('admin.products.product_created.selected_category')
                        </div>
                        
                    </div>
                        <div class="col-lg-4">
                            @if(isset($product) && $product->primary_image)
                                <div class="card mb-4 shadow-sm border-0 rounded-4">
                                    <div class="card-header bg-white py-3 border-bottom-0">
                                        <h5 class="mb-0 fw-bold text-dark">
                                            <i class="fas fa-image me-2 text-primary"></i>Current Image
                                        </h5>
                                    </div>
                                    <div class="card-body text-center bg-light rounded-bottom-4 pt-0">
                                        <!-- Image preview with a neat frame -->
                                        <div class="bg-white p-2 rounded shadow-sm d-inline-block mb-3 border">
                                            <img src="{{ asset($product->primary_image) }}" alt="Current Image" class="img-fluid rounded" style="max-height: 220px; object-fit: contain;">
                                        </div>
                                        
                                        <!-- Nicer informational alert -->
                                        <div class="alert alert-primary py-2 px-3 mb-0 small text-start d-flex align-items-center border-0 shadow-sm">
                                            <i class="fas fa-info-circle fs-5 me-2"></i> 
                                            <span>Uploading a new image below will replace this one.</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <!-- DISPLAY CURRENT SECONDARY IMAGE -->
                            @if($secondaryImg)
                                <div class="card mb-4 shadow-sm border-0 rounded-4">
                                    <div class="card-header bg-white py-3 border-bottom-0">
                                        <h5 class="mb-0 fw-bold text-dark">
                                            <i class="fas fa-image me-2 text-info"></i>Secondary Image
                                        </h5>
                                    </div>
                                    <div class="card-body text-center bg-light rounded-bottom-4 pt-0">
                                        <div class="bg-white p-2 rounded shadow-sm d-inline-block mb-3 border">
                                            <img src="{{ asset($secondaryImg->image_path) }}" class="img-fluid rounded" style="max-height: 150px; object-fit: contain;">
                                        </div>
                                        <div class="alert alert-info py-2 px-3 mb-0 small text-start border-0 shadow-sm">
                                            <i class="fas fa-info-circle me-1"></i> Uploading a new secondary image will replace this one.
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <!-- DISPLAY EXISTING GALLERY IMAGES -->
                            @if(isset($product) && $product->images && $product->images->count() > 0)
                                <div class="card mb-4 shadow-sm border-0 rounded-4">
                                    <div class="card-header bg-white py-3 border-bottom-0">
                                        <h5 class="mb-0 fw-bold text-dark">
                                            <i class="fas fa-images me-2 text-primary"></i>Current Gallery
                                        </h5>
                                    </div>
                                    <div class="card-body bg-light rounded-bottom-4 pt-0">
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($galleryImgs as $galleryImage)
                                                <div class="position-relative border rounded p-1 bg-white shadow-sm">
                                                    <img src="{{ asset($galleryImage->image_path) }}" class="rounded" style="height: 80px; width: 80px; object-fit: cover;">
                                                    <!-- Optional: A button to delete a specific gallery image -->
                                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 py-0 px-1" style="font-size: 0.7rem;">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="alert alert-primary py-2 px-3 mt-3 mb-0 small text-start d-flex align-items-center border-0 shadow-sm">
                                            <i class="fas fa-plus-circle fs-5 me-2"></i> 
                                            <span>Uploading new gallery images will ADD to this list.</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- 2. THE FILE UPLOAD COMPONENT -->
                            <div class="mb-4">
                                @include('admin.components._image_media', [
                                    'primaryRequired' => false 
                                ])
                            </div>
                            
                            <!-- 3. SUBMIT BUTTON (Sticky so it scrolls with the user) -->
                            <div class="position-sticky" style="top: 20px; z-index: 10;">
                                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 shadow border-0 fw-bold d-flex justify-content-center align-items-center gap-2" style="border-radius: 12px; transition: 0.2s;">
                                    <i class="fas fa-save fs-5"></i> 
                                    Update Information
                                </button>
                            </div>
                            
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
                        @include('admin.products.product_created.variants_info')
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm px-5 fw-bold">
                        <i class="fas fa-save me-2"></i>Update Inventory
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection