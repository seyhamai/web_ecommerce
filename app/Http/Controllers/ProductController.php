<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $allCategories = Category::query()->with('parent')->get()->sortBy('name');
        $colors = Color::query()->orderBy('name', 'asc')->get();
        $sizes = Size::query()->orderBy('name', 'asc')->get();

        return view('admin.products.create', compact('allCategories', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'name'             => 'required|string|max:255',
            'sku'              => 'required|string|unique:products,sku',
            'price'            => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'stock_quantity'   => 'required|numeric|min:0',
            'primary_image'    => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:2048',

            'variants'               => 'nullable|array',
            'variants.*.sku'         => 'required|string',
            'variants.*.color_id'    => 'nullable|integer',
            'variants.*.size_id'     => 'nullable|integer',
            'variants.*.price_offset' => 'nullable|numeric',
            'variants.*.stock'       => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // 1. SMART STOCK CALCULATION
            // Default to what they typed in the main box (for Simple Products)
            $finalStock = $request->stock_quantity;

            // If variants exist, override it with the sum of the variants (for Variable Products)
            if ($request->has('variants') && count($request->variants) > 0) {
                $finalStock = collect($request->variants)->sum('stock');
            }

            // 2. Handle Primary Image (Saving to public folder)
            $primaryImagePath = null;
            if ($request->hasFile('primary_image')) {
                $file = $request->file('primary_image');
                // Create a unique filename
                $filename = time() . '_primary_' . $file->getClientOriginalName();
                // Move it to your custom folder
                $file->move(public_path('admin_assets/assets/img/products'), $filename);
                // The exact path to store in the database
                $primaryImagePath = 'admin_assets/assets/img/products/' . $filename;
            }

            // 3. Create the Main Product
            $product = Product::create([
                'category_id'      => $request->category_id,
                'name'             => $request->name,
                'description'      => $request->description,
                'slug'             => Str::slug($request->name),
                'sku'              => $request->sku,
                'price'            => $request->price,
                'compare_at_price' => $request->compare_at_price,
                'stock_quantity'   => $finalStock,
                'primary_image'    => $primaryImagePath,
                'is_active'        => $request->has('is_active'),
                'is_featured'      => $request->has('is_featured'),
            ]);

            if ($request->hasFile('secondary_image')) {
                $file = $request->file('secondary_image');
                $filename = time() . '_secondary_' . $file->getClientOriginalName();
                $file->move(public_path('admin_assets/assets/img/products'), $filename);

                $product->images()->create([
                    'type'       => 'secondary_landscape',
                    'image_path' => 'admin_assets/assets/img/products/' . $filename
                ]);
            }

            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $file) {
                    $filename = time() . '_gallery_' . uniqid() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('admin_assets/assets/img/products'), $filename);

                    $product->images()->create([
                        'image_path' => 'admin_assets/assets/img/products/' . $filename,
                        'type'       => 'gallery'
                    ]);
                }
            }

            // 6. Save Variants (Only if they actually generated them)
            if ($request->has('variants') && count($request->variants) > 0) {
                foreach ($request->variants as $variant) {
                    $product->variants()->create([
                        'color_id'       => !empty($variant['color_id']) ? $variant['color_id'] : null,
                        'size_id'        => !empty($variant['size_id']) ? $variant['size_id'] : null,
                        'sku'            => $variant['sku'],
                        'stock_quantity' => $variant['stock'],
                        'price'          => $product->price + ($variant['price_offset'] ?? 0),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $product = Product::with(['images', 'variants'])->findOrFail($id);
        $allCategories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();

        return view('admin.products.pgUpdateProducts', compact('product', 'allCategories', 'colors', 'sizes'));
    }

    public function updateInfo(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'name'             => 'required|string|max:255',
            'sku'              => 'required|string|unique:products,sku,' . $id,
            'price'            => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'primary_image'    => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:5120',
        ]);

        try {
            DB::beginTransaction();
            $primaryImagePath = $product->primary_image;
            if ($request->hasFile('primary_image')) {
                // DELETE OLD FILE FROM FOLDER
                if ($primaryImagePath && File::exists(public_path($primaryImagePath))) {
                    File::delete(public_path($primaryImagePath));
                }

                $file = $request->file('primary_image');
                $filename = time() . '_primary_' . $file->getClientOriginalName();
                $file->move(public_path('admin_assets/assets/img/products'), $filename);
                $primaryImagePath = 'admin_assets/assets/img/products/' . $filename;
            }

            $product->update([
                'category_id'      => $request->category_id,
                'name'             => $request->name,
                'description'      => $request->description,
                'slug'             => Str::slug($request->name),
                'sku'              => $request->sku,
                'price'            => $request->price,
                'compare_at_price' => $request->compare_at_price,
                'primary_image'    => $primaryImagePath,
                'is_active'        => $request->has('is_active'),
                'is_featured'      => $request->has('is_featured'),
            ]);
            if ($request->hasFile('secondary_image')) {

                $oldSecondary = $product->images()->where('type', 'secondary_landscape')->first();
                if ($oldSecondary && File::exists(public_path($oldSecondary->image_path))) {
                    File::delete(public_path($oldSecondary->image_path));
                }

                $file = $request->file('secondary_image');
                $filename = time() . '_secondary_' . $file->getClientOriginalName();
                $file->move(public_path('admin_assets/assets/img/products'), $filename);

                $product->images()->updateOrCreate(
                    ['type' => 'secondary_landscape'],
                    ['image_path' => 'admin_assets/assets/img/products/' . $filename]
                );
            }
            if ($request->hasFile('gallery_images')) {
                // GET ALL OLD GALLERY IMAGES
                $oldGalleryImages = $product->images()->where('type', 'gallery')->get();

                // DELETE PHYSICAL FILES FROM FOLDER
                foreach ($oldGalleryImages as $oldImage) {
                    if (File::exists(public_path($oldImage->image_path))) {
                        File::delete(public_path($oldImage->image_path));
                    }
                }

                // DELETE ROWS FROM DATABASE
                $product->images()->where('type', 'gallery')->delete();

                // UPLOAD AND SAVE THE NEW ONES
                foreach ($request->file('gallery_images') as $file) {
                    $filename = time() . '_gallery_' . uniqid() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('admin_assets/assets/img/products'), $filename);

                    $product->images()->create([
                        'image_path' => 'admin_assets/assets/img/products/' . $filename,
                        'type'       => 'gallery'
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Product information updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function updateInventory(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'stock_quantity'   => 'nullable|numeric|min:0',
            'variants'         => 'nullable|array',
            'variants.*.sku'   => 'required|string',
            'variants.*.stock' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $finalStock = $request->stock_quantity ?? $product->stock_quantity;
            if ($request->has('variants') && count($request->variants) > 0) {
                $finalStock = collect($request->variants)->sum('stock');
            }

            $product->update([
                'stock_quantity' => $finalStock,
            ]);

            if ($request->has('variants') && count($request->variants) > 0) {
                $product->variants()->delete();

                foreach ($request->variants as $variant) {
                    $product->variants()->create([
                        'color_id'       => !empty($variant['color_id']) ? $variant['color_id'] : null,
                        'size_id'        => !empty($variant['size_id']) ? $variant['size_id'] : null,
                        'sku'            => $variant['sku'],
                        'stock_quantity' => $variant['stock'],
                        'price'          => $product->price + ($variant['price_offset'] ?? 0),
                    ]);
                }
            } elseif ($request->has('stock_quantity')) {
                $product->variants()->delete();
            }

            DB::commit();
            return back()->with('success', 'Inventory and variants updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product) {}
}
