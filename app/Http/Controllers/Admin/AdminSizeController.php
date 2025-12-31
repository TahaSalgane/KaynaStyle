<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class AdminSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizes = Size::orderBy('sort_order')->get();
        return view('admin.sizes.index', compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sizes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        Size::create([
            'name_en' => $request->name_en,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.sizes.index')
            ->with('success', 'Size created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        return view('admin.sizes.show', compact('size'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        return view('admin.sizes.edit', compact('size'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Size $size)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        $size->update([
            'name_en' => $request->name_en,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.sizes.index')
            ->with('success', 'Size updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        $size->delete();
        return redirect()->route('admin.sizes.index')
            ->with('success', 'Size deleted successfully.');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(Size $size)
    {
        $size->update(['is_active' => !$size->is_active]);
        return redirect()->back()
            ->with('success', 'Size status updated successfully.');
    }
}
