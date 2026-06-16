<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()->with('parent')->latest()->get();
        $parentCategories = Category::query()->whereNull('parent_id')->get();

        return view('admin.categories.index', compact('categories', 'parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where(function ($query) use ($request) {
                    return $query->where('parent_id', $request->parent_id);
                })
            ],
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $slug = Str::slug($request->name);

        if ($request->filled('parent_id')) {
            $parent = Category::find($request->parent_id);
            $slug = $parent->slug . '-' . $slug;
        }

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'parent_id' => $request->parent_id,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Category created successfully.');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where(function ($query) use ($request) {
                    return $query->where('parent_id', $request->parent_id);
                })->ignore($category->id)
            ],
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $slug = Str::slug($request->name);

        if ($request->filled('parent_id')) {
            $parent = Category::find($request->parent_id);
            $slug = $parent->slug . '-' . $slug;
        }

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'parent_id' => $request->parent_id,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted successfully.');
    }
}
