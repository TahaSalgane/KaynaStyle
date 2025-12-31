<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\ProductColorImage;
use App\Models\ProductColorQuantity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'colorImages'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name_en')->get();
        $colors = Color::where('is_active', true)->orderBy('name_en')->get();
        $sizes = Size::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.products.create', compact('categories', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sale_end_date' => 'nullable|date|after:now',
            'is_countdown_sale' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'sizes' => 'nullable|array',
            'sizes.*' => 'exists:sizes,id',
            'color_images' => 'nullable|array',
            'color_images.*' => 'array',
            'color_images.*.color_id' => 'required|exists:colors,id',
            'color_images.*.images' => 'required|array',
            'color_images.*.images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:51200',
            'color_quantities' => 'nullable|array',
            'color_quantities.*' => 'array',
            'color_quantities.*.quantity' => 'nullable|integer|min:0',
            'main_images' => 'nullable|array',
            'main_images.*' => 'integer',
            'default_color_id' => 'nullable|exists:colors,id',
            'product_sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        $data = $request->except(['color_images', 'main_images', 'color_quantities', 'sizes']);

        // Handle product sort order field name mapping
        if ($request->has('product_sort_order')) {
            $data['sort_order'] = $request->product_sort_order;
        }
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        $data['is_countdown_sale'] = $request->has('is_countdown_sale');
        $data['sizes'] = $request->sizes ? json_encode($request->sizes) : null;

        // Handle empty SKU - convert to null
        if (empty($data['sku'])) {
            $data['sku'] = null;
        }

        // Generate slug from English name
        $data['slug'] = Str::slug($request->name_en);

        // Create the product
        $product = Product::create($data);

        // Handle color-based images and quantities
        if ($request->has('color_images')) {
            foreach ($request->color_images as $index => $colorData) {
                if (isset($colorData['color_id']) && isset($colorData['images'])) {
                    $colorId = $colorData['color_id'];
                    $images = $colorData['images'];

                    // Save color quantity
                    if (isset($request->color_quantities[$index]['quantity'])) {
                        \App\Models\ProductColorQuantity::create([
                            'product_id' => $product->id,
                            'color_id' => $colorId,
                            'quantity' => $request->color_quantities[$index]['quantity']
                        ]);
                    }

                    // Save color images using raw SQL to avoid constraint issues
                    foreach ($images as $imageIndex => $image) {
                        $imagePath = $image->store('products', 'public');
                        $isMain = isset($request->main_images[$index]) && $request->main_images[$index] == $imageIndex;

                        // Use raw SQL to insert the image
                        DB::statement("INSERT INTO product_color_images (product_id, color_id, image_path, is_main, sort_order, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())",
                            [$product->id, $colorId, $imagePath, $isMain ? 1 : 0, $imageIndex]);

                        Log::info("Created image for color {$colorId} with is_main: " . ($isMain ? 'true' : 'false'));
                    }
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'colorImages.color', 'defaultColor', 'colorQuantities.color']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('name_en')->get();
        $colors = Color::where('is_active', true)->orderBy('name_en')->get();
        $sizes = Size::where('is_active', true)->orderBy('sort_order')->get();

        // Load color images grouped by color
        $colorImages = $product->colorImages()->with('color')->get()->groupBy('color_id');

        return view('admin.products.edit', compact('product', 'categories', 'colors', 'sizes', 'colorImages'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sale_end_date' => 'nullable|date|after:now',
            'is_countdown_sale' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'sizes' => 'nullable|array',
            'sizes.*' => 'exists:sizes,id',
            'color_images' => 'nullable|array',
            'color_images.*' => 'array',
            'color_images.*.color_id' => 'required|exists:colors,id',
            'color_images.*.images' => 'required|array',
            'color_images.*.images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:51200',
            'color_quantities' => 'nullable|array',
            'color_quantities.*' => 'array',
            'color_quantities.*.quantity' => 'nullable|integer|min:0',
            'main_images' => 'nullable|array',
            'main_images.*' => 'integer',
            'new_color_images' => 'nullable|array',
            'new_color_images.*' => 'array',
            'new_color_images.*.images' => 'nullable|array',
            'new_color_images.*.images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:51200',
            'image_sort_order' => 'nullable|array',
            'image_sort_order.*' => 'string',
            'default_color_id' => 'nullable|exists:colors,id',
            'removed_color_images' => 'nullable|array',
            'removed_color_images.*' => 'integer',
            'product_sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        $data = $request->except(['color_images', 'main_images', 'removed_color_images', 'color_quantities', 'sizes', 'new_color_images', 'image_sort_order']);

        // Handle product sort order field name mapping
        if ($request->has('product_sort_order')) {
            $data['sort_order'] = $request->product_sort_order;
        }
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        $data['is_countdown_sale'] = $request->has('is_countdown_sale');
        $data['sizes'] = $request->sizes ? json_encode($request->sizes) : null;

        // Handle empty SKU - convert to null
        if (empty($data['sku'])) {
            $data['sku'] = null;
        }

        // Update slug if name changed
        if ($request->name_en !== $product->name_en) {
            $data['slug'] = Str::slug($request->name_en);
        }

        // Update the product
        $product->update($data);

        // Handle removed color images
        if ($request->has('removed_color_images')) {
            foreach ($request->removed_color_images as $imageId) {
                $colorImage = ProductColorImage::find($imageId);
                if ($colorImage) {
                    // Delete from storage
                    Storage::disk('public')->delete($colorImage->image_path);
                    // Delete from database
                    $colorImage->delete();
                }
            }
        }

        // Handle color quantities (update existing or create new)
        if ($request->has('color_quantities')) {
            foreach ($request->color_quantities as $key => $quantityData) {
                if (isset($quantityData['quantity'])) {
                    // Check if this is a new color (key starts with "new_")
                    if (strpos($key, 'new_') === 0) {
                        // Get the actual color_id from color_images array
                        $newColorKey = $key; // e.g., "new_0"
                        if (isset($request->color_images[$newColorKey]['color_id'])) {
                            $actualColorId = $request->color_images[$newColorKey]['color_id'];
                            // Only process if we have a valid integer color_id
                            if (is_numeric($actualColorId)) {
                                \App\Models\ProductColorQuantity::updateOrCreate(
                                    [
                                        'product_id' => $product->id,
                                        'color_id' => (int)$actualColorId
                                    ],
                                    [
                                        'quantity' => $quantityData['quantity']
                                    ]
                                );
                            }
                        }
                    } else {
                        // Existing color - key is the color_id
                        if (is_numeric($key)) {
                            \App\Models\ProductColorQuantity::updateOrCreate(
                                [
                                    'product_id' => $product->id,
                                    'color_id' => (int)$key
                                ],
                                [
                                    'quantity' => $quantityData['quantity']
                                ]
                            );
                        }
                    }
                }
            }
        }

        // Handle new color images (for new colors)
        if ($request->has('color_images')) {
            foreach ($request->color_images as $index => $colorData) {
                if (isset($colorData['color_id']) && isset($colorData['images'])) {
                    $colorId = $colorData['color_id'];
                    $images = $colorData['images'];

                    foreach ($images as $imageIndex => $image) {
                        $imagePath = $image->store('products', 'public');
                        $isMain = isset($request->main_images[$index]) && $request->main_images[$index] == $imageIndex;

                        // Use raw SQL to insert the image
                        DB::statement("INSERT INTO product_color_images (product_id, color_id, image_path, is_main, sort_order, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())",
                            [$product->id, $colorId, $imagePath, $isMain ? 1 : 0, $imageIndex]);

                        Log::info("Created new color image for color {$colorId} with is_main: " . ($isMain ? 'true' : 'false'));
                    }
                }
            }
        }

        // Handle new images for existing colors
        if ($request->has('new_color_images')) {
            foreach ($request->new_color_images as $colorId => $colorData) {
                if (isset($colorData['images']) && is_array($colorData['images'])) {
                    $images = $colorData['images'];

                    // Get the current highest sort order for this color
                    $maxSortOrder = ProductColorImage::where('product_id', $product->id)
                        ->where('color_id', $colorId)
                        ->max('sort_order') ?? -1;

                    foreach ($images as $imageIndex => $image) {
                        $imagePath = $image->store('products', 'public');

                        // Use raw SQL to insert the new image
                        DB::statement("INSERT INTO product_color_images (product_id, color_id, image_path, is_main, sort_order, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())",
                            [$product->id, $colorId, $imagePath, 0, $maxSortOrder + $imageIndex + 1]);

                        Log::info("Created new image for color {$colorId} with sort order " . ($maxSortOrder + $imageIndex + 1));
                    }
                }
            }
        }

        // Handle image sort order updates
        if ($request->has('image_sort_order')) {
            Log::info('Image sort order data:', $request->image_sort_order);

            foreach ($request->image_sort_order as $colorId => $imageOrder) {
                if (!empty($imageOrder)) {
                    $imageIds = explode(',', $imageOrder);
                    Log::info("Processing color {$colorId} with image order: " . implode(',', $imageIds));

                    // Use database transaction to ensure consistency
                    DB::transaction(function () use ($product, $colorId, $imageIds) {
                        // First, update all images to not be main (except the first one in our new order)
                        $firstImageId = trim($imageIds[0]);

                        // Get all images for this color
                        $allImages = ProductColorImage::where('product_id', $product->id)
                            ->where('color_id', $colorId)
                            ->get();

                        Log::info("Found {$allImages->count()} images for color {$colorId}, first image ID: {$firstImageId}");

                        // Validate that all image IDs in the sort order exist
                        $existingImageIds = $allImages->pluck('id')->toArray();
                        $imageIdsTrimmed = array_map('trim', $imageIds);
                        $invalidImageIds = array_diff($imageIdsTrimmed, $existingImageIds);
                        if (!empty($invalidImageIds)) {
                            Log::warning("Invalid image IDs in sort order: " . implode(',', $invalidImageIds));
                            return; // Skip processing if there are invalid IDs
                        }

                        // Find the current main image (if any)
                        $currentMainImage = $allImages->where('is_main', 1)->first();

                        // Update sort order and main status for each image in the new order
                        // We'll set the first image as main and all others as non-main
                        foreach ($imageIdsTrimmed as $index => $imageId) {
                            if (!empty($imageId) && in_array($imageId, $existingImageIds)) {
                                $isMain = $index === 0;
                                
                                // If this is the new main image and there's a current main image that's different
                                if ($isMain && $currentMainImage && $currentMainImage->id != $imageId) {
                                    // First, set the old main image to non-main
                                    DB::statement("UPDATE product_color_images SET is_main = 0 WHERE id = ?",
                                        [$currentMainImage->id]);
                                    Log::info("Set old main image {$currentMainImage->id} to not main");
                                }
                                
                                // Now update this image's sort order and main status
                                DB::statement("UPDATE product_color_images SET sort_order = ?, is_main = ? WHERE id = ? AND product_id = ? AND color_id = ?",
                                    [$index, $isMain ? 1 : 0, $imageId, $product->id, $colorId]);

                                Log::info("Updated image {$imageId} to sort order {$index}, is_main: " . ($isMain ? 'true' : 'false'));
                            }
                        }
                    });
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete all color images
        $colorImages = $product->colorImages;
        foreach ($colorImages as $colorImage) {
            Storage::disk('public')->delete($colorImage->image_path);
        }

        // Delete color image records
        $product->colorImages()->delete();

        // Delete color quantities
        $product->colorQuantities()->delete();

        // Delete legacy product images if they exist
        if ($product->images) {
            $images = is_array($product->images) ? $product->images : json_decode($product->getRawOriginal('images'), true);
            if (is_array($images)) {
                foreach ($images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function toggleActive(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        return back()->with('success', 'Product status updated.');
    }

    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);
        return back()->with('success', 'Product featured status updated.');
    }
}
