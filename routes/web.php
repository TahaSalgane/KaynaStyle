<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeroImageController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminColorController;
use App\Http\Controllers\Admin\AdminSizeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Admin\AdminQuestionController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\ContactController;

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Language switching
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en', 'fr', 'es'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// API Routes for color images
Route::get('/api/products/{product}/color-images/{color}', [ProductController::class, 'getColorImages'])->name('api.products.color-images');

// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::get('/cart/sidebar', [CartController::class, 'sidebar'])->name('cart.sidebar');

// Reviews
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Questions
Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');

// Wishlist
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::get('/wishlist/check', [WishlistController::class, 'check'])->name('wishlist.check');
Route::get('/wishlist/count', [WishlistController::class, 'count'])->name('wishlist.count');

// Orders
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{token}/thank-you', [OrderController::class, 'thankYou'])->name('orders.thank-you');

// Policy Pages
Route::get('/privacy-policy', [PolicyController::class, 'privacy'])->name('policies.privacy');
Route::get('/shipping-policy', [PolicyController::class, 'shipping'])->name('policies.shipping');

// FAQ
Route::get('/faq', [FAQController::class, 'index'])->name('faq.index');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Newsletter
Route::post('/newsletter/subscribe', [\App\Http\Controllers\NewsletterController::class, 'store'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{email}', [\App\Http\Controllers\NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth Routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware(['web', 'auth'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Hero Images Management
        Route::resource('hero-images', HeroImageController::class);
        Route::patch('/hero-images/{heroImage}/toggle', [HeroImageController::class, 'toggleActive'])->name('hero-images.toggle');

        // Products Management
        Route::resource('products', AdminProductController::class);
        Route::patch('/products/{product}/toggle-active', [AdminProductController::class, 'toggleActive'])->name('products.toggle-active');
        Route::patch('/products/{product}/toggle-featured', [AdminProductController::class, 'toggleFeatured'])->name('products.toggle-featured');

        // Categories Management
        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::patch('/categories/{category}/toggle-active', [AdminCategoryController::class, 'toggleActive'])->name('categories.toggle-active');

        // Orders Management
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'destroy']);
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

        // Users Management
        Route::resource('users', AdminUserController::class);

        // Colors Management
        Route::resource('colors', AdminColorController::class);
        Route::patch('/colors/{color}/toggle-active', [AdminColorController::class, 'toggleActive'])->name('colors.toggle-active');

        // Sizes Management
        Route::resource('sizes', AdminSizeController::class);
        Route::patch('/sizes/{size}/toggle-active', [AdminSizeController::class, 'toggleActive'])->name('sizes.toggle-active');

        // Reviews Management
        Route::resource('reviews', AdminReviewController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::patch('/reviews/{review}/toggle-approval', [AdminReviewController::class, 'toggleApproval'])->name('reviews.toggle-approval');

        // Questions Management
        Route::resource('questions', AdminQuestionController::class)->only(['index', 'show', 'destroy']);
        Route::patch('/questions/{question}/mark-read', [AdminQuestionController::class, 'markAsRead'])->name('questions.mark-read');
        Route::patch('/questions/{question}/mark-unread', [AdminQuestionController::class, 'markAsUnread'])->name('questions.mark-unread');

        // Contact Messages Management
        Route::resource('contact', \App\Http\Controllers\Admin\AdminContactController::class)->only(['index', 'show', 'destroy']);
        Route::patch('/contact/{contact}/mark-read', [\App\Http\Controllers\Admin\AdminContactController::class, 'markAsRead'])->name('contact.mark-read');
        Route::patch('/contact/{contact}/mark-unread', [\App\Http\Controllers\Admin\AdminContactController::class, 'markAsUnread'])->name('contact.mark-unread');
        Route::post('/contact/{contact}/respond', [\App\Http\Controllers\Admin\AdminContactController::class, 'respond'])->name('contact.respond');

        // Countdown Timer Management
        Route::resource('countdown', \App\Http\Controllers\Admin\AdminCountdownController::class)->only(['index', 'store', 'update', 'destroy']);
    });
});
