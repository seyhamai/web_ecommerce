<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()->with(['category', 'images', 'variants'])->latest()->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $allCategories = Category::query()->with('parent')->get()->sortBy('name');
        $colors = Color::query()->orderBy('name', 'asc')->get();
        $sizes = Size::query()->orderBy('name', 'asc')->get();

        return view('admin.products.create', compact('allCategories', 'colors', 'sizes'));
    }

    public function store(Request $request) {}

    public function edit(Product $product) {}

    public function update(Request $request, Product $product) {}

    public function destroy(Product $product) {}
}
