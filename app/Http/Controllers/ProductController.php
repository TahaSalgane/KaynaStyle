<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->with(['category', 'colorImages']);

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Category filter
        if ($request->filled('categories')) {
            $categories = explode(',', $request->categories);
            $query->whereHas('category', function($q) use ($categories) {
                $q->whereIn('slug', $categories);
            });
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
                    $q->orWhereJsonContains('sizes', $size);
                }
            });
        }

        // Featured filter
        if ($request->filled('featured') && $request->featured === 'true') {
            $query->where('is_featured', true);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name_en', 'like', "%{$search}%");
        }

        // Sort filter
        // If "new" filter is set, default to newest sort
        $sort = $request->get('sort', $request->filled('new') && $request->new === 'true' ? 'newest' : 'newest');
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
        $categories = Category::where('is_active', true)->get();

        // Get available colors for all products
        $allProducts = Product::where('is_active', true)->get();
        $availableColorNames = collect();
        foreach ($allProducts as $product) {
            if ($product->colors) {
                $availableColorNames = $availableColorNames->merge($product->colors);
            }
        }

        $availableColors = \App\Models\Color::whereIn('name_en', $availableColorNames->unique())
            ->where('is_active', true)
            ->get();

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'html' => view('categories.partials.products-grid', compact('products'))->render(),
                'count' => $products->total()
            ]);
        }

        return view('products.index', compact('products', 'categories', 'availableColors'));
    }

    public function show(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'colorImages.color', 'defaultColor', 'approvedReviews'])
            ->firstOrFail();

        // Get available colors for this product (only those with quantity > 0)
        $availableColors = $product->getAvailableColors()->filter(function ($color) use ($product) {
            return $product->isColorAvailable($color->id);
        });

        // Get default color (product's default color or first available color)
        $defaultColor = $product->defaultColor && $product->isColorAvailable($product->default_color_id)
            ? $product->defaultColor
            : $availableColors->first();
        $selectedColorId = request('color', $defaultColor?->id);

        // Get images for selected color
        $colorImages = $product->getImagesForColor($selectedColorId);
        $mainImage = $product->getMainImageForColor($selectedColorId);

        // Get actual size names from size IDs
        $sizeNames = [];
        if ($product->sizes && is_array($product->sizes)) {
            $sizes = \App\Models\Size::whereIn('id', $product->sizes)->get();
            $sizeNames = $sizes->pluck('name', 'id')->toArray();
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->with(['category', 'colorImages'])
            ->limit(4)
            ->get();

        // Share active countdown timer
        $activeCountdown = \App\Models\CountdownTimer::where('is_active', true)
            ->where('end_date', '>', now())
            ->first();

        // Moroccan cities data
        $moroccanCities = [
            ['en' => 'Casablanca', 'ar' => 'الدار البيضاء'],
            ['en' => 'Rabat', 'ar' => 'الرباط'],
            ['en' => 'Fes', 'ar' => 'فاس'],
            ['en' => 'Marrakech', 'ar' => 'مراكش'],
            ['en' => 'Agadir', 'ar' => 'أكادير'],
            ['en' => 'Tangier', 'ar' => 'طنجة'],
            ['en' => 'Meknes', 'ar' => 'مكناس'],
            ['en' => 'Oujda', 'ar' => 'وجدة'],
            ['en' => 'Kenitra', 'ar' => 'القنيطرة'],
            ['en' => 'Tetouan', 'ar' => 'تطوان'],
            ['en' => 'Safi', 'ar' => 'آسفي'],
            ['en' => 'Mohammedia', 'ar' => 'المحمدية'],
            ['en' => 'Khouribga', 'ar' => 'خريبكة'],
            ['en' => 'Beni Mellal', 'ar' => 'بني ملال'],
            ['en' => 'El Jadida', 'ar' => 'الجديدة'],
            ['en' => 'Taza', 'ar' => 'تازة'],
            ['en' => 'Nador', 'ar' => 'الناظور'],
            ['en' => 'Settat', 'ar' => 'سطات'],
            ['en' => 'Larache', 'ar' => 'العرائش'],
            ['en' => 'Ksar El Kebir', 'ar' => 'القصر الكبير'],
            ['en' => 'Khemisset', 'ar' => 'الخميسات'],
            ['en' => 'Guelmim', 'ar' => 'كلميم'],
            ['en' => 'Berrechid', 'ar' => 'برشيد'],
            ['en' => 'Ouarzazate', 'ar' => 'ورزازات'],
            ['en' => 'Errachidia', 'ar' => 'الرشيدية'],
            ['en' => 'Tiznit', 'ar' => 'تيزنيت'],
            ['en' => 'Chefchaouen', 'ar' => 'شفشاون'],
            ['en' => 'Dakhla', 'ar' => 'الداخلة'],
            ['en' => 'Laayoune', 'ar' => 'العيون'],
            ['en' => 'Essaouira', 'ar' => 'الصويرة'],
            ['en' => 'Ifrane', 'ar' => 'إفران'],
            ['en' => 'Azrou', 'ar' => 'أزرو'],
            ['en' => 'Midelt', 'ar' => 'ميدلت'],
            ['en' => 'Zagora', 'ar' => 'زاكورة'],
            ['en' => 'Tinghir', 'ar' => 'تنغير'],
            ['en' => 'Taroudant', 'ar' => 'تارودانت'],
            ['en' => 'Sidi Ifni', 'ar' => 'سيدي إفني'],
            ['en' => 'Tan-Tan', 'ar' => 'طانطان'],
            ['en' => 'Smara', 'ar' => 'السمارة']
        ];

        // Get all reviews for the product's category (for summary statistics)
        $allReviews = \App\Models\Review::where('category_id', $product->category_id)
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
        $reviews = \App\Models\Review::where('category_id', $product->category_id)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // If AJAX request for reviews pagination, return JSON
        if ($request->ajax() && $request->has('reviews_page')) {
            $reviews = \App\Models\Review::where('category_id', $product->category_id)
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

        return view('products.show', compact('product', 'relatedProducts', 'moroccanCities', 'availableColors', 'selectedColorId', 'colorImages', 'mainImage', 'sizeNames', 'reviews', 'allReviews', 'totalReviews', 'averageRating', 'ratingDistribution', 'activeCountdown'));
    }

    public function getColorImages($productId, $colorId)
    {
        $product = Product::findOrFail($productId);

        // Check if color is available (has quantity > 0)
        if (!$product->isColorAvailable($colorId)) {
            return response()->json([
                'success' => false,
                'message' => 'Color not available'
            ], 404);
        }

        $images = $product->getImagesForColor($colorId);

        return response()->json([
            'success' => true,
            'images' => $images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'image_path' => $image->image_path,
                    'image_url' => $image->image_url,
                    'is_main' => $image->is_main,
                    'sort_order' => $image->sort_order
                ];
            })
        ]);
    }
}
