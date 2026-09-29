@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-0 mb-3">
    
    <div class="d-flex justify-content-between align-items-center mb-4">      
        <x-page-header title="Sliders" breadcrumb="Sliders List"/>
        
        <!-- Replaced with x-button -->
        <x-button href="{{ route('admin.sliders.create') }}" color="primary" icon="fas fa-plus">
            Add New Slider
        </x-button>
    </div>

    <div class="row g-4">
        @forelse($sliders as $slider)
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden">

                    <div class="position-relative bg-light text-center" style="height: 250px;">
                        <img src="{{ asset('storage/' . $slider->image) }}" alt="Slider" class="img-fluid w-100 h-100" style="object-fit: scale-down;">

                        @if($slider->link_url)
                            <div class="position-absolute top-0 end-0 m-3">
                                <!-- Replaced with x-button -->
                                <x-button href="{{ $slider->link_url }}" target="_blank" color="dark" size="sm" icon="fas fa-link" class="bg-opacity-75 rounded-pill">
                                    Test Link
                                </x-button>
                            </div>
                        @endif
                    </div>
    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark mb-1">{{ $slider->title ?: 'No Title' }}</h5>
                        <p class="card-text text-muted small mb-4">{{ $slider->subtitle ?: 'No Subtitle provided.' }}</p>

                        <div class="mt-auto d-flex justify-content-between align-items-center border-top pt-3">
                            
                            <!-- Consolidated Public / Hidden Toggle -->
                            <form action="{{ route('admin.sliders.toggle', $slider->id) }}" method="POST" class="m-0">
                                @csrf
                                @method('PATCH')
                                <div class="form-check form-switch mt-1">
                                    <input class="form-check-input custom-switch" type="checkbox" name="is_active" id="isactive_{{ $slider->id }}" value="1" {{ $slider->is_active ? 'checked' : '' }} onchange="this.form.submit()" style="cursor: pointer;">
                                    <label class="form-check-label fw-semibold {{ $slider->is_active ? 'text-dark' : 'text-muted' }}" for="isactive_{{ $slider->id }}" style="cursor: pointer;">
                                        {{ $slider->is_active ? 'Public' : 'Hidden' }}
                                    </label>
                                </div>
                            </form>

                            <div class="d-flex gap-2">
                                <!-- NEW: Edit Action Placeholder -->
                                <x-button href="{{ route('admin.sliders.edit', $slider->id) }}" color="primary" outline size="sm" class="rounded-circle px-2" icon="fas fa-edit" title="Edit Slider" />

                                <!-- Delete Action -->
                                <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this slider? This cannot be undone.');" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" color="danger" outline size="sm" class="rounded-circle px-2" icon="fas fa-trash" title="Delete Slider" />
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-4 text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-images fs-1 text-secondary opacity-50 mb-3 d-block" style="font-size: 3rem;"></i>
                        <h4 class="text-dark fw-bold">No sliders uploaded yet</h4>
                        <p class="text-muted mb-4">Click the button above to add your first visually stunning slider.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection