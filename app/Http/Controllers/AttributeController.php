<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    public function index()
    {
        $colors = Color::orderBy('created_at', 'desc')->get();
        $sizes = Size::all()->sortByDesc('name', SORT_NATURAL | SORT_FLAG_CASE);

        return view('admin.attributes.index', compact('colors', 'sizes'));
    }

    public function storeColor(Request $request)
    {
        $request->validate([
            'color_name' => 'required|string|unique:colors,name',
            'hex_code' => 'required|string|max:7',
        ]);

        Color::create([
            'name'     => $request->color_name,
            'hex_code' => $request->hex_code,
        ]);

        return back()->with('success', 'Color added successfully!');
    }

    public function storeSize(Request $request)
    {
        $request->validate([
            'size_name' => 'required|string|unique:sizes,name',
        ]);

        Size::create([
            'name' => $request->size_name,
        ]);

        return back()->with('success', 'Size added successfully!')->with('active_tab', 'sizes');
    }

    // --- COLOR EDIT & DELETE ---
    public function updateColor(Request $request, $id)
    {
        $color = Color::findOrFail($id);
        $isUsed = DB::table('product_variants')->where('color_id', $id)->exists();

        // 🌟 Updated to check $request->color_name
        if ($isUsed && $color->name !== $request->color_name) {
            $typoDistance = levenshtein(strtolower($color->name), strtolower($request->color_name));

            if ($typoDistance > 2) {
                return back()->with('error', 'Cannot make major name changes to an active color. You can only fix minor typos (up to 2 letters) or adjust the Hex Code.');
            }
        }

        // 🌟 Updated validation key to color_name
        $request->validate([
            'color_name' => 'required|string|max:255|unique:colors,name,' . $id,
            'hex_code' => 'required|string|max:7',
        ]);

        // 🌟 Updated mapping to DB
        $color->update([
            'name' => $request->color_name,
            'hex_code' => $request->hex_code,
        ]);

        return back()->with('success', 'Color updated successfully!');
    }

    public function updateSize(Request $request, $id)
    {
        $size = Size::findOrFail($id);
        $isUsed = DB::table('product_variants')->where('size_id', $id)->exists();

        // 🌟 Updated to check $request->size_name
        if ($isUsed && $size->name !== $request->size_name) {
            return back()->with('error', 'Cannot edit this size because products are already using it. Please create a new size instead.');
        }

        // 🌟 Updated validation key to size_name
        $request->validate([
            'size_name' => 'required|string|max:255|unique:sizes,name,' . $id,
        ]);

        // 🌟 Updated mapping to DB
        $size->update([
            'name' => $request->size_name,
        ]);

        return back()->with('success', 'Size updated successfully!')->with('active_tab', 'sizes');
    }

    public function destroyColor($id)
    {
        $isUsed = DB::table('product_variants')->where('color_id', $id)->exists();

        if ($isUsed) {
            return back()->with('error', 'Cannot delete this color because it is currently used by one or more product variants.');
        }

        $color = Color::findOrFail($id);
        $color->delete();

        return back()->with('success', 'Color deleted successfully!');
    }

    public function destroySize($id)
    {
        $isUsed = DB::table('product_variants')->where('size_id', $id)->exists();

        if ($isUsed) {
            return back()->with('error', 'Cannot delete this size because it is currently used by one or more product variants.');
        }

        $size = Size::findOrFail($id);
        $size->delete();

        return back()->with('success', 'Size deleted successfully!')->with('active_tab', 'sizes');
    }
}
