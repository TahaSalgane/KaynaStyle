<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\HeroImage;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->with(['category', 'colorImages'])
            ->limit(8)
            ->get();

        $newProducts = Product::where('is_active', true)
            ->with(['category', 'colorImages'])
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $heroImages = HeroImage::where('is_active', true)
            ->orderBy('order')
            ->get();

        // Static testimonials with product IDs (10 reviews)
        $staticTestimonials = [
            [
                'id' => 1,
                'customer_name' => 'Sarah Johnson',
                'rating' => 5,
                'review_text' => 'Beautiful craftsmanship! Exceeded expectations.',
                'product_id' => 1,
            ],
            [
                'id' => 2,
                'customer_name' => 'Michael Chen',
                'rating' => 5,
                'review_text' => 'Authentic Moroccan design. Highly recommend!',
                'product_id' => 2,
            ],
            [
                'id' => 3,
                'customer_name' => 'Emma Williams',
                'rating' => 5,
                'review_text' => 'So many compliments! Beautiful and durable.',
                'product_id' => 3,
            ],
            [
                'id' => 4,
                'customer_name' => 'David Martinez',
                'rating' => 5,
                'review_text' => 'Outstanding quality. Will order again!',
                'product_id' => 4,
            ],
            [
                'id' => 5,
                'customer_name' => 'Olivia Brown',
                'rating' => 5,
                'review_text' => 'Simply stunning! Excellent service.',
                'product_id' => 5,
            ],
            [
                'id' => 6,
                'customer_name' => 'James Taylor',
                'rating' => 5,
                'review_text' => 'Perfect gift! Great quality and value.',
                'product_id' => 6,
            ],
            [
                'id' => 7,
                'customer_name' => 'Sophia Anderson',
                'rating' => 5,
                'review_text' => 'Amazing craftsmanship! Fast delivery.',
                'product_id' => 7,
            ],
            [
                'id' => 8,
                'customer_name' => 'Robert Wilson',
                'rating' => 5,
                'review_text' => 'Authentic artistry. Highly satisfied!',
                'product_id' => 8,
            ],
            [
                'id' => 9,
                'customer_name' => 'Isabella Garcia',
                'rating' => 5,
                'review_text' => 'High-quality products! Will shop again.',
                'product_id' => 9,
            ],
            [
                'id' => 10,
                'customer_name' => 'William Lee',
                'rating' => 5,
                'review_text' => 'Exceptional quality. Great service!',
                'product_id' => 10,
            ],
        ];

        // Get product IDs from testimonials
        $productIds = array_column($staticTestimonials, 'product_id');

        // Fetch products by IDs (load colorImages for main_image accessor)
        $testimonialProducts = Product::whereIn('id', $productIds)
            ->with('colorImages')
            ->get()
            ->keyBy('id');

        // Map products to testimonials
        $testimonials = collect($staticTestimonials)->map(function($testimonial) use ($testimonialProducts) {
            $testimonial['product'] = $testimonialProducts->get($testimonial['product_id']);
            return $testimonial;
        });

        return view('home', compact('featuredProducts', 'newProducts', 'categories', 'heroImages', 'testimonials'));
    }
}
