@extends('layouts.admin')

@section('content')
<div class="container mb-1">

    <div class="d-flex justify-content-between align-items-center mb-0">
        <div class="d-flex justify-content-between w-100">
            <div>
                <x-page-header title="Add Slider" breadcrumb="Sliders / Create"/>
            </div>
            <div class="d-flex align-items-center">
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <x-_alerts />

    <div class="row mt-3">
        <div class="col-12 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-image me-2"></i>Upload New Slider</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <x-images.image-upload
                            name="image" 
                            id="sliderImage" 
                            label="Slider Image" 
                            required 
                        />
                        
                        <x-input name="title" label="Title (Optional)" placeholder="e.g. Summer Sale" />
                        
                        <x-input name="subtitle" label="Subtitle (Optional)" placeholder="e.g. 50% off all T-shirts" />
                        
                        <x-input type="url" name="link_url" label="Link URL (Optional)" placeholder="https://yoursite.com/category/shirts" />

                        <x-radio />

                        <div class="mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">
                                <i class="fas fa-cloud-upload-alt me-2"></i>Upload Slider
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection