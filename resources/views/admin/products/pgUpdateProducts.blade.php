@extends('layouts.admin')

@section('content')
    <!-- 🌟 Remember which tab we were on after a form submission -->
    @php
        $activeTab = session('active_tab', 'info');
    @endphp

    <div class="container-fluid px-1 px-md-3 mb-2">

        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <h1 class="font-semibold fs-2 mb-0">Update: {{ $product->name }}</h1>
            <x-button href="{{ route('admin.products.index') }}" color="secondary" outline icon="fas fa-arrow-left">
                Back to Products
            </x-button>
        </div>

        <x-_alerts />

        <!-- 🌟 Using your new x-tabs component -->
        <x-tabs :tabs="['info' => '📝 General Information', 'inventory' => '📦 Inventory & Variants']" :active="$activeTab">

            <!-- ========================================== -->
            <!-- TAB 1: BASIC INFO FORM                     -->
            <!-- ========================================== -->
            <x-tab-pane id="info" :active="$activeTab === 'info'">
                <form action="{{ route('admin.products.updateInfo', $product->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mt-2">
                        <div class="mb-1">
                            @include('admin.products.product_created.basic_info')
                        </div>
                        <div class="mb-2">
                            @include('admin.products.product_created.selected_category')
                        </div>
                    </div>

                    <x-images.product-gallery :images="$product->images" />

                    <!-- SUBMIT BUTTON (Kept below the card to stay fixed) -->
                    <div class="position-sticky mt-3" style="top: 20px; z-index: 10;">
                        <button type="submit"
                            class="btn btn-success btn-lg w-100 py-3 shadow-lg border-0 fw-bold d-flex justify-content-center align-items-center gap-2"
                            style="border-radius: 12px; transition: 0.2s;">
                            <i class="fas fa-save fs-5"></i> Update Information
                        </button>
                    </div>
                </form>
            </x-tab-pane>

            <!-- ========================================== -->
            <!-- TAB 2: INVENTORY                           -->
            <!-- ========================================== -->
            <x-tab-pane id="inventory" :active="$activeTab === 'inventory'">
                <form action="{{ route('admin.products.updateInventory', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card shadow-sm border-0 bg-transparent">
                        <div class="card-body p-0">
                            <h4 class="mb-3 fw-bold text-dark">Manage Stock</h4>
                            @include('admin.products.product_created.variants_info')
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <x-button type="submit" color="success" size="lg" class="px-5 shadow-sm fw-bold"
                            icon="fas fa-save">
                            Update Inventory
                        </x-button>
                    </div>
                </form>
            </x-tab-pane>

        </x-tabs>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/modules/products.js') }}"></script>
    <script src="{{ asset('js/modules/attributeTabs.js') }}"></script>
@endpush
