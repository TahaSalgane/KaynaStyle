<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $query = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->with(['category', 'colorImages']);

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Color filter
        if ($request->filled('colors')) {
            $colors = explode(',', $request->colors);
            $query->where(function($q) use ($colors) {
                foreach ($colors as $color) {
                    $q->orWhereJsonContains('colors', $color);
                }
            });
        }

        // Size filter
        if ($request->filled('sizes')) {
            $sizes = explode(',', $request->sizes);
            $query->where(function($q) use ($sizes) {
                foreach ($sizes as $size) {
                    $q->orWhere('sizes', 'like', '%' . $size . '%');
                }
            });
        }

        // Sort filter
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name_' . app()->getLocale(), 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12);

        // Get available colors for this category
        $productsInCategory = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->get();

        $availableColorNames = collect();
        foreach ($productsInCategory as $product) {
            if ($product->colors) {
                $availableColorNames = $availableColorNames->merge($product->colors);
            }
        }

        $availableColors = \App\Models\Color::whereIn('name_en', $availableColorNames->unique())
            ->where('is_active', true)
            ->distinct()
            ->get();

        // Get all reviews for summary statistics (rating distribution, average, etc.)
        $allReviews = \App\Models\Review::where('category_id', $category->id)
            ->where('is_approved', true)
            ->get();

        $totalReviews = $allReviews->count();
        $averageRating = $totalReviews > 0 ? $allReviews->avg('rating') : 0;

        // Calculate rating distribution
        $ratingDistribution = [
            5 => $allReviews->where('rating', 5)->count(),
            4 => $allReviews->where('rating', 4)->count(),
            3 => $allReviews->where('rating', 3)->count(),
            2 => $allReviews->where('rating', 2)->count(),
            1 => $allReviews->where('rating', 1)->count(),
        ];

        // Get paginated reviews for display
        $reviews = \App\Models\Review::where('category_id', $category->id)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // If AJAX request for products, return JSON
        if ($request->ajax() && !$request->has('reviews_page')) {
            return response()->json([
                'html' => view('categories.partials.products-grid', compact('products'))->render(),
                'count' => $products->total()
            ]);
        }

        // If AJAX request for reviews pagination, return JSON
        if ($request->ajax() && $request->has('reviews_page')) {
            // Update reviews pagination with the requested page
            $reviews = \App\Models\Review::where('category_id', $category->id)
                ->where('is_approved', true)
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'page', $request->get('reviews_page'));

            $start = $reviews->firstItem() ?? 0;
            $end = $reviews->lastItem() ?? 0;
            $total = $reviews->total();

            return response()->json([
                'html' => view('categories.partials.reviews-list', compact('reviews'))->render(),
                'pagination' => view('categories.partials.reviews-pagination', compact('reviews'))->render(),
                'count_display' => view('categories.partials.reviews-count', [
                    'start' => $start,
                    'end' => $end,
                    'total' => $total
                ])->render()
            ]);
        }

        return view('categories.show', compact('category', 'products', 'availableColors', 'reviews', 'allReviews', 'totalReviews', 'averageRating', 'ratingDistribution'));
    }
}
