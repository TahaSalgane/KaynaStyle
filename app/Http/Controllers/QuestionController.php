<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Product;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
            'product_id' => 'nullable|exists:products,id',
        ]);

        Question::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => app()->getLocale() === 'ar' ? 'شكراً لك! سنتواصل معك قريباً.' : 'Thank you! We will contact you soon.'
        ]);
    }
}
