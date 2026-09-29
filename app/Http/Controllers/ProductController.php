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
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category.parent', 'images'])->latest()->paginate(10);

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
        // 1. UPDATED VALIDATION
        $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'name'             => 'required|string|max:255',
            'sku'              => 'required|string|unique:products,sku',
            'price'            => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'stock_quantity'   => 'required|numeric|min:0',

            // New validation for the images array
            'images'           => 'required|array',
            'images.*'         => 'image|mimes:jpeg,png,jpg,webp,avif|max:2048',
            'primary_image_index'   => 'nullable|integer',
            // ... (keep the rest of your variants validation)
        ]);
        try {
            DB::beginTransaction();
            $finalStock = $request->stock_quantity;

            if ($request->has('variants') && count($request->variants) > 0) {
                $finalStock = collect($request->variants)->sum('stock');
            }

            // Create the Product 
            $product = Product::create([
                'category_id'      => $request->category_id,
                'name'             => $request->name,
                'description'      => $request->description,
                'slug'             => Str::slug($request->name),
                'sku'              => $request->sku,
                'price'            => $request->price,
                'compare_at_price' => $request->compare_at_price,
                'stock_quantity'   => $finalStock,
                'is_active'        => $request->has('is_active'),
                'is_featured'      => $request->has('is_featured'),
            ]);

            if ($request->hasFile('images')) {
                $primaryIndex = $request->input('primary_image_index', 0);
                $secondaryIndex = $request->input('secondary_image_index', 1);

                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('products', 'public');

                    // UPDATE THIS BLOCK TO MATCH YOUR MIGRATION EXACTLY:
                    if ($index == $primaryIndex) {
                        $type = 'primary_portrait';
                    } elseif ($index == $secondaryIndex) {
                        $type = 'secondary_landscape';
                    } else {
                        $type = 'gallery';
                    }

                    $product->images()->create([
                        'type'       => $type,
                        'image_path' => $path
                    ]);
                }
            }

            // Variants Logic... (Keep exactly as you had it)
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
            return redirect()->route('admin.products.index')->with('success', 'Product saved successfully!');
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
            'category_id'         => 'required|exists:categories,id',
            'name'                => 'required|string|max:255',
            'sku'                 => 'required|string|unique:products,sku,' . $id,
            'price'               => 'required|numeric|min:0',
            'compare_at_price'    => 'nullable|numeric|min:0',

            // Unified Image Validation
            'deleted_image_ids'   => 'nullable|array',
            'primary_selection'   => 'nullable|string',
            'secondary_selection' => 'nullable|string',
            'images'              => 'nullable|array',
            'images.*'            => 'image|mimes:jpeg,png,jpg,webp,avif|max:5120',
        ]);

        try {
            DB::beginTransaction();

            // 1. Update Product Details
            $product->update([
                'category_id'      => $request->category_id,
                'name'             => $request->name,
                'description'      => $request->description,
                'slug'             => Str::slug($request->name),
                'sku'              => $request->sku,
                'price'            => $request->price,
                'compare_at_price' => $request->compare_at_price,
                'is_active'        => $request->has('is_active'),
                'is_featured'      => $request->has('is_featured'),
            ]);

            // 2. Delete the images the user clicked 'X' on
            if ($request->has('deleted_image_ids')) {
                $imagesToDelete = $product->images()->whereIn('id', $request->deleted_image_ids)->get();
                foreach ($imagesToDelete as $delImg) {
                    if (Storage::disk('public')->exists($delImg->image_path)) {
                        Storage::disk('public')->delete($delImg->image_path);
                    }
                    $delImg->delete();
                }
            }

            // 3. Reset all remaining DB images to 'gallery' first (to clear old primary/secondary tags)
            $product->images()->update(['type' => 'gallery']);

            $primarySelection = $request->primary_selection;     // e.g., "existing_12" or "new_0"
            $secondarySelection = $request->secondary_selection; // e.g., "existing_14" or "new_1"

            // 4. Set Primary/Secondary for EXISTING images
            if (str_starts_with($primarySelection, 'existing_')) {
                $existingId = str_replace('existing_', '', $primarySelection);
                $product->images()->where('id', $existingId)->update(['type' => 'primary_portrait']);
            }
            if (str_starts_with($secondarySelection, 'existing_')) {
                $existingId = str_replace('existing_', '', $secondarySelection);
                $product->images()->where('id', $existingId)->update(['type' => 'secondary_landscape']);
            }

            // 5. Save and format NEWly uploaded images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('products', 'public');
                    $type = 'gallery';

                    // Check if this new image was selected as Primary or Secondary
                    if ($primarySelection === 'new_' . $index) {
                        $type = 'primary_portrait';
                    } elseif ($secondarySelection === 'new_' . $index) {
                        $type = 'secondary_landscape';
                    }

                    $product->images()->create([
                        'type'       => $type,
                        'image_path' => $path
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function updateInventory(Request $request, $id)
    {
        // No image changes in inventory
        $product = Product::findOrFail($id);

        $request->validate([
            'stock_quantity'             => 'required|numeric|min:0',
            'variants'                   => 'nullable|array',
            'variants.*.id'              => 'nullable|exists:product_variants,id',
            'variants.*.sku'             => 'required|string',
            'variants.*.color_id'        => 'nullable|integer',
            'variants.*.size_id'         => 'nullable|integer',
            'variants.*.price_offset'    => 'nullable|numeric',
            'variants.*.stock'           => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();
            $submittedVariantIds = [];

            if ($request->has('variants') && count($request->variants) > 0) {
                foreach ($request->variants as $variantData) {
                    $variantPrice = $product->price + ($variantData['price_offset'] ?? 0);

                    if (!empty($variantData['id'])) {
                        $variant = $product->variants()->find($variantData['id']);
                        if ($variant) {
                            $variant->update([
                                'sku'            => $variantData['sku'],
                                'price'          => $variantPrice,
                                'stock_quantity' => $variantData['stock'],
                            ]);
                            $submittedVariantIds[] = $variant->id;
                        }
                    } else {
                        $newVariant = $product->variants()->create([
                            'color_id'       => !empty($variantData['color_id']) ? $variantData['color_id'] : null,
                            'size_id'        => !empty($variantData['size_id']) ? $variantData['size_id'] : null,
                            'sku'            => $variantData['sku'],
                            'price'          => $variantPrice,
                            'stock_quantity' => $variantData['stock'],
                        ]);
                        $submittedVariantIds[] = $newVariant->id;
                    }
                }
                $product->variants()->whereNotIn('id', $submittedVariantIds)->delete();
                $finalStock = collect($request->variants)->sum('stock');
            } else {
                $product->variants()->delete();
                $finalStock = $request->stock_quantity;
            }

            $product->update(['stock_quantity' => $finalStock]);

            DB::commit();
            return back()->with('success', 'Inventory and variants updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating inventory: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $products = Product::onlyTrashed()->with(['category.parent'])->latest()->paginate(10);
        return view('admin.products.pgTrashProducts', compact('products'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return back()->with('success', 'Product moved to the trash successfully.');
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        return back()->with('success', 'Product restored successfully!');
    }

    public function forceDelete($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        // Because ALL images are now in the relation, this one loop handles primary, secondary, and gallery cleanup.
        $relatedImages = $product->images()->get();
        foreach ($relatedImages as $img) {
            if (Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
        }

        $product->forceDelete();
        return back()->with('success', 'Product and its images permanently deleted!');
    }
}
