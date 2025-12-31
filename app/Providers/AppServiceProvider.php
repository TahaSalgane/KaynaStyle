<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share categories with all views (for footer)
        View::composer('layouts.app', function ($view) {
            $footerCategories = Category::where('is_active', true)
                ->orderBy('sort_order')
                ->limit(5)
                ->get();

            // Share active products for live sale notifications
            $activeProducts = \App\Models\Product::where('is_active', true)
                ->where('stock_quantity', '>', 0)
                ->with(['colorImages', 'defaultColor'])
                ->get()
                ->map(function ($product) {
                    // Get product main image using the model's method
                    $imagePath = $product->main_image;

                    return [
                        'id' => $product->id,
                        'name' => $product->name_en,
                        'slug' => $product->slug,
                        'image' => $imagePath ? asset('storage/' . $imagePath) : null,
                    ];
                })
                ->filter(function ($product) {
                    return $product['image'] !== null;
                })
                ->values();

            // Share active countdown timer
            $activeCountdown = \App\Models\CountdownTimer::where('is_active', true)
                ->where('end_date', '>', now())
                ->first();

            $view->with('footerCategories', $footerCategories);
            $view->with('activeProductsForNotifications', $activeProducts);
            $view->with('activeCountdown', $activeCountdown);
        });
    }
}
