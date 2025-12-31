<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'customer_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|max:2000',
            'review_title' => 'nullable|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'display_name_format' => 'nullable|in:full,first_name_only,last_initial,all_initials,anonymous',
            'media' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,mov,mp4,m4v|max:10240', // 10MB max
        ]);

        $mediaPath = null;
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('reviews/media', 'public');
        }

        // Use display_name as customer_name if customer_name is not provided
        $customerName = $request->customer_name ?: $request->display_name;

        // Ensure we have a customer name (use email prefix as last resort)
        if (!$customerName) {
            $customerName = explode('@', $request->email)[0];
        }

        $review = Review::create([
            'category_id' => $request->category_id,
            'customer_name' => $customerName,
            'email' => $request->email,
            'review_title' => $request->review_title,
            'rating' => $request->rating,
            'review_text' => $request->review_text,
            'media' => $mediaPath,
            'display_name' => $request->display_name ?: $customerName,
            'display_name_format' => $request->display_name_format ?: 'first_name_only',
            'is_approved' => true, // Auto-approve user reviews, admin can change later
        ]);

        return response()->json([
            'success' => true,
            'message' => __('messages.review_added_successfully'),
            'review' => $review
        ]);
    }
}
