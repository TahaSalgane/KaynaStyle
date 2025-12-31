<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class AdminColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = Color::orderBy('name_en')->get();
        return view('admin.colors.index', compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.colors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'hex_code' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean'
        ]);

        Color::create([
            'name_en' => $request->name_en,
            'hex_code' => $request->hex_code,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.colors.index')
            ->with('success', 'Color created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        return view('admin.colors.show', compact('color'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Color $color)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'hex_code' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean'
        ]);

        $color->update([
            'name_en' => $request->name_en,
            'hex_code' => $request->hex_code,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.colors.index')
            ->with('success', 'Color updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        $color->delete();
        return redirect()->route('admin.colors.index')
            ->with('success', 'Color deleted successfully.');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(Color $color)
    {
        $color->update(['is_active' => !$color->is_active]);
        return redirect()->back()
            ->with('success', 'Color status updated successfully.');
    }
}
