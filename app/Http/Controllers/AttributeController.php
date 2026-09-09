<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Size;

class AttributeController extends Controller
{
    public function index()
    {
        $colors = Color::orderBy('created_at', 'desc')->get();
        $sizes = Size::orderBy('created_at', 'desc')->get();
        $sizes = Size::all()->sortByDesc('name', SORT_NATURAL | SORT_FLAG_CASE);
        return view('admin.attributes.index', compact('colors', 'sizes'));
    }

    public function storeColor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'hex_code' => 'required|string|max:7',
        ]);

        Color::create([
            'name' => $request->name,
            'hex_code' => $request->hex_code,
        ]);

        return back()->with('success', 'Color added successfully!');
    }

    public function storeSize(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Size::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Size added successfully!');
    }
}
