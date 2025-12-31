<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('product')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->orderBy('name_en')->get();
        return view('admin.reviews.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|max:1000',
        ]);

        Review::create([
            'product_id' => $request->product_id,
            'customer_name' => $request->customer_name,
            'rating' => $request->rating,
            'review_text' => $request->review_text,
            'is_approved' => true,
        ]);

        return redirect()->route('admin.reviews.index')
            ->with('success', __('messages.review_created_successfully'));
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', __('messages.review_deleted_successfully'));
    }

    public function toggleApproval(Review $review)
    {
        $review->update(['is_approved' => !$review->is_approved]);

        return redirect()->route('admin.reviews.index')
            ->with('success', __('messages.review_status_updated'));
    }
}
