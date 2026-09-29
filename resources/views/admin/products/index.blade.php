@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <x-page-header
                title="Product Management"
                breadcrumb="Products"
                breadcrumb-url="/admin/dashboard"
            />
        </div>
        <div>
            <a href="{{ route('admin.products.trash') }}" class="btn btn-outline-danger shadow-sm me-2">
                <i class="fas fa-trash-alt me-2"></i>View Trash
            </a>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-2"></i>Add New Product
            </a>
        </div>
    </div>

    <!-- Success Message Component -->
    @include('components._alerts')

    <!-- 🌟 The Reusable Table Component 🌟 -->
    <x-table :headers="['Image', 'Product Name', 'Main Category', 'Category', 'Price', 'Stock', 'Actions']">
        
        @forelse($products as $product)
            <tr>
                <td class="ps-3" style="width: 120px;">
                    @if($product->primary_image)
                        <img src="{{ asset('storage/' . $product->primary_image) }}" 
                            alt="{{ $product->name }}" 
                            class="img-thumbnail rounded shadow-sm" 
                            style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted shadow-sm" style="width: 80px; height: 80px;">
                            <i class="fas fa-image fa-2x opacity-50"></i>
                        </div>
                    @endif
                </td>
                
                <td class="fw-semibold">
                    {{ $product->name }}
                    <div class="text-muted small fw-normal">SKU: {{ $product->sku }}</div>
                </td>
                
                <td>
                    <span class="fw-semibold text-dark">
                        {{ $product->category && $product->category->parent ? $product->category->parent->name : 'None' }}
                    </span>
                </td>
                
                <td>
                    <span class="badge bg-secondary">{{ $product->category->name ?? 'Uncategorized' }}</span>
                </td>
                
                <td class="fw-bold text-dark">
                    ${{ number_format($product->price, 2) }}
                </td>
                
                <td>
                    @if($product->stock_quantity > 10)
                        <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-2 py-1">{{ $product->stock_quantity }} in stock</span>
                    @elseif($product->stock_quantity > 0)
                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning-subtle px-2 py-1">{{ $product->stock_quantity }} Low stock</span>
                    @else
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2 py-1">Out of stock</span>
                    @endif
                </td>
                
                <td class="text-end pe-4">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary me-1 shadow-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        
                        <button type="button" class="btn btn-sm btn-outline-danger shadow-sm requires-confirmation" 
                                data-title="Move to Trash?" 
                                data-message="Are you sure you want to send this product to the trash?"
                                data-btn-text="Move to Trash">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center py-5 text-muted">
                    <i class="fas fa-box-open fs-1 mb-3 text-secondary opacity-25"></i>
                    <h5 class="text-dark fw-bold">No products found</h5>
                    <p>You haven't added any products yet.</p>
                </td>
            </tr>
        @endforelse
        
    </x-table>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="mt-3 d-flex justify-content-end">
            {{ $products->links() }}
        </div>
    @endif

</div>
@endsection