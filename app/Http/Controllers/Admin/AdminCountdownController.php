<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CountdownTimer;
use Illuminate\Http\Request;

class AdminCountdownController extends Controller
{
    public function index()
    {
        $timer = CountdownTimer::where('is_active', true)->first();
        if (!$timer) {
            $timer = new CountdownTimer();
        }
        return view('admin.countdown.index', compact('timer'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:500',
            'end_date' => 'required|date|after:now',
            'background_color' => 'nullable|string|max:50',
            'text_color' => 'nullable|string|max:50',
        ]);

        // Deactivate all existing timers
        CountdownTimer::where('is_active', true)->update(['is_active' => false]);

        // Create new timer
        CountdownTimer::create([
            'title' => $request->filled('title') ? $request->title : null,
            'message' => $request->filled('message') ? $request->message : null,
            'end_date' => $request->end_date,
            'is_active' => true,
            'background_color' => $request->background_color ?? '#DC2626',
            'text_color' => $request->text_color ?? '#FFFFFF',
        ]);

        return redirect()->route('admin.countdown.index')
            ->with('success', 'Countdown timer created successfully.');
    }

    public function update(Request $request, CountdownTimer $countdown)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:500',
            'end_date' => 'required|date|after:now',
            'background_color' => 'nullable|string|max:50',
            'text_color' => 'nullable|string|max:50',
        ]);

        // Prepare update data
        $updateData = [
            'title' => $request->filled('title') ? $request->title : null,
            'message' => $request->filled('message') ? $request->message : null,
            'end_date' => $request->end_date,
            'background_color' => $request->background_color ?? '#DC2626',
            'text_color' => $request->text_color ?? '#FFFFFF',
        ];

        // Use fill() and save() to ensure changes are detected
        $countdown->fill($updateData);
        $countdown->save();

        return redirect()->route('admin.countdown.index')
            ->with('success', 'Countdown timer updated successfully.');
    }

    public function destroy(CountdownTimer $countdownTimer)
    {
        $countdownTimer->update(['is_active' => false]);
        return redirect()->route('admin.countdown.index')
            ->with('success', 'Countdown timer deactivated successfully.');
    }
}
