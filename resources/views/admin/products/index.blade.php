@extends('layouts.admin')

@section('content')
<div class="container-fluid px-1 px-md-3 mb-5">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1 class="font-semibold fs-2 mb-0">Products</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-2"></i>Add New Product
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Product Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4" style="width: 180px; object-fit: cover;">Image</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock</th>
                            <th scope="col" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td class="ps-2">
                                @if($product->primary_image)
                                    <img src="{{ asset( $product->primary_image) }}" alt="{{ $product->name }}" class="img-thumbnail rounded" style="width: 90%; height: 80px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-semibold">
                                {{ $product->name }}
                                <div class="text-muted small fw-normal">SKU: {{ $product->sku }}</div>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $product->category->name ?? 'Uncategorized' }}</span>
                            </td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>
                                @if($product->stock_quantity > 10)
                                    <span class="text-success fw-semibold">{{ $product->stock_quantity }} in stock</span>
                                @elseif($product->stock_quantity > 0)
                                    <span class="text-warning fw-semibold">{{ $product->stock_quantity }} Low stock</span>
                                @else
                                    <span class="text-danger fw-semibold">Out of stock</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fs-1 mb-3 text-light"></i>
                                <h5>No products found</h5>
                                <p>You haven't added any products yet.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination Links -->
        @if($products->hasPages())
            <div class="card-footer bg-white py-3 border-top-0">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection