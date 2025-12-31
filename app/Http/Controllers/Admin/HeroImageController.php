<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroImageController extends Controller
{
    public function index()
    {
        $heroImages = HeroImage::orderBy('order')->get();
        return view('admin.hero-images.index', compact('heroImages'));
    }

    public function create()
    {
        return view('admin.hero-images.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        $imagePath = $request->file('image')->store('hero-images', 'public');

        HeroImage::create([
            'image_path' => $imagePath,
            'is_active' => $request->has('is_active'),
            'order' => $request->order ?? 0
        ]);

        return redirect()->route('admin.hero-images.index')
            ->with('success', 'Hero image created successfully.');
    }

    public function edit(HeroImage $heroImage)
    {
        return view('admin.hero-images.edit', compact('heroImage'));
    }

    public function update(Request $request, HeroImage $heroImage)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        $data = [
            'is_active' => $request->has('is_active'),
            'order' => $request->order ?? 0
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($heroImage->image_path);
            $data['image_path'] = $request->file('image')->store('hero-images', 'public');
        }

        $heroImage->update($data);

        return redirect()->route('admin.hero-images.index')
            ->with('success', 'Hero image updated successfully.');
    }

    public function destroy(HeroImage $heroImage)
    {
        Storage::disk('public')->delete($heroImage->image_path);
        $heroImage->delete();

        return redirect()->route('admin.hero-images.index')
            ->with('success', 'Hero image deleted successfully.');
    }

    public function toggleActive(HeroImage $heroImage)
    {
        $heroImage->update(['is_active' => !$heroImage->is_active]);
        return back()->with('success', 'Hero image status updated.');
    }
}









