<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        // Order by sort_order so you can control which banner shows first
        $sliders = Slider::orderBy('sort_order', 'asc')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        // Updated to use the shared form view
        return view('admin.sliders.pgUpdateSlider');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'link_url' => 'nullable|url|max:255',
        ]);

        // Upload the image to storage/app/public/sliders
        $imagePath = $request->file('image')->store('sliders', 'public');

        Slider::create([
            'image' => $imagePath,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'link_url' => $request->link_url,
            'sort_order' => Slider::max('sort_order') + 1, // Put new slider at the end
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider added successfully!');
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.sliders.pgUpdateSlider', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 1. Handle New Image Upload
        if ($request->hasFile('image')) {
            if ($slider->image && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }
            $slider->image = $request->file('image')->store('sliders', 'public');
        }
        // 2. Handle Image Removal via Component Flag
        elseif ($request->input('remove_image') == '1') {
            if ($slider->image && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }
            $slider->image = null;
        }

        $slider->title = $request->title;
        $slider->subtitle = $request->subtitle;
        $slider->link_url = $request->link_url;
        $slider->is_active = $request->has('is_active') ? true : false;
        $slider->save();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully!');
    }

    public function toggle($id)
    {
        $slider = Slider::findOrFail($id);

        // Flips the boolean value
        $slider->is_active = !$slider->is_active;
        $slider->save();

        return back()->with('success', 'Slider visibility updated successfully!');
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        // Delete the physical image file from the server
        if ($slider->image && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return back()->with('success', 'Slider deleted successfully!');
    }
}
