@extends('layouts.admin')

@section('content')
@php
    $isEdit = isset($slider);
    $actionUrl = $isEdit ? route('admin.sliders.update', $slider->id) : route('admin.sliders.store');
    $pageTitle = $isEdit ? 'Update Slider' : 'Add New Slider';
@endphp

<div class="container-fluid mt-0 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <x-page-header :title="$pageTitle" breadcrumb="Sliders / Form"/>
        
        <x-button href="{{ route('admin.sliders.index') }}" color="secondary" outline icon="fas fa-arrow-left">
            Back to Sliders
        </x-button>
    </div>

    <x-_alerts />

    <div class="row">
        <div class="col-12 col-lg-8 mx-auto">
            <div class="card shadow-sm border-0 rounded-4">
                
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas {{ $isEdit ? 'fa-edit' : 'fa-image' }} me-2 text-primary"></i>
                        {{ $pageTitle }}
                    </h5>
                </div>
                
                <div class="card-body bg-light rounded-bottom-4 p-4">
                    <form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if($isEdit)
                            @method('PUT')
                        @endif

                        <!-- 🌟 Utilizing your reusable image component seamlessly 🌟 -->
                        <x-images.image-upload 
                            name="image" 
                            label="Slider Image" 
                            :existing-image="$isEdit ? $slider->image : null"
                            :required="!$isEdit" 
                        />

                        <!-- Text Inputs -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <x-input name="title" label="Slider Title" :value="$slider->title ?? old('title')" placeholder="e.g., Summer Collection 2026" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-input name="link_url" label="Target Link URL (Optional)" :value="$slider->link_url ?? old('link_url')" placeholder="https://..." />
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-input name="subtitle" label="Subtitle / Description" :value="$slider->subtitle ?? old('subtitle')" placeholder="e.g., Discover our newest arrivals with up to 50% off." />
                        </div>

                        <!-- Status Switch -->
                        <div class="mb-4 p-3 bg-white border rounded shadow-sm">
                            <x-checkbox 
                                name="is_active" 
                                label="Publish this slider immediately" 
                                :checked="$isEdit ? $slider->is_active : true" 
                                :is-switch="true" 
                            />
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-4">
                            <x-button href="{{ route('admin.sliders.index') }}" color="secondary" outline>
                                Cancel
                            </x-button>
                            <x-button type="submit" color="success" icon="fas fa-save">
                                {{ $isEdit ? 'Update Slider' : 'Save Slider' }}
                            </x-button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection