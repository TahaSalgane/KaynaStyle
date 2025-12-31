<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $pajamasCategory = Category::where('slug', 'pajamas')->first();
        $pantsCategory = Category::where('slug', 'pants')->first();
        $dressesCategory = Category::where('slug', 'dresses')->first();

        // Pajamas
        $pajamas = [
            [
                'category_id' => $pajamasCategory->id,
                'name_en' => 'Cotton Pajama Set',
                'name_ar' => 'طقم بيجاما قطني',
                'slug' => 'cotton-pajama-set',
                'description_en' => 'Soft and comfortable cotton pajama set perfect for bedtime',
                'description_ar' => 'طقم بيجاما قطني ناعم ومريح مثالي للنوم',
                'price' => 45.00,
                'sale_price' => 35.00,
                'sku' => 'PJ001',
                'images' => [
                    'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                    'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'
                ],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'colors' => ['Pink', 'Purple', 'Blue'],
                'color' => 'Pink',
                'stock_quantity' => 50,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => $pajamasCategory->id,
                'name_en' => 'Silk Pajama Set',
                'name_ar' => 'طقم بيجاما حريري',
                'slug' => 'silk-pajama-set',
                'description_en' => 'Luxurious silk pajama set for a comfortable sleep',
                'description_ar' => 'طقم بيجاما حريري فاخر لنوم مريح',
                'price' => 65.00,
                'sku' => 'PJ002',
                'images' => [
                    'https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                    'https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'
                ],
                'sizes' => ['S', 'M', 'L'],
                'colors' => ['White', 'Pink', 'Purple'],
                'stock_quantity' => 30,
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        // Pants
        $pants = [
            [
                'category_id' => $pantsCategory->id,
                'name_en' => 'Denim Jeans',
                'name_ar' => 'جينز',
                'slug' => 'denim-jeans',
                'description_en' => 'Classic denim jeans perfect for everyday wear',
                'description_ar' => 'جينز كلاسيكي مثالي للارتداء اليومي',
                'price' => 55.00,
                'sale_price' => 45.00,
                'sku' => 'PT001',
                'images' => [
                    'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                    'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'
                ],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'colors' => ['Blue', 'Black'],
                'stock_quantity' => 40,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => $pantsCategory->id,
                'name_en' => 'Cotton Trousers',
                'name_ar' => 'بنطلون قطني',
                'slug' => 'cotton-trousers',
                'description_en' => 'Comfortable cotton trousers for casual wear',
                'description_ar' => 'بنطلون قطني مريح للارتداء العادي',
                'price' => 40.00,
                'sku' => 'PT002',
                'images' => [
                    'https://images.unsplash.com/photo-1591195853828-11db59a44f6b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                    'https://images.unsplash.com/photo-1591195853828-11db59a44f6b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'
                ],
                'sizes' => ['S', 'M', 'L'],
                'colors' => ['Black', 'White', 'Pink'],
                'stock_quantity' => 35,
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        // Dresses
        $dresses = [
            [
                'category_id' => $dressesCategory->id,
                'name_en' => 'Evening Dress',
                'name_ar' => 'فستان مسائي',
                'slug' => 'evening-dress',
                'description_en' => 'Elegant evening dress for special occasions',
                'description_ar' => 'فستان مسائي أنيق للمناسبات الخاصة',
                'price' => 120.00,
                'sale_price' => 100.00,
                'sku' => 'DR001',
                'images' => [
                    'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                    'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'
                ],
                'sizes' => ['S', 'M', 'L'],
                'colors' => ['Red', 'Black', 'Purple'],
                'stock_quantity' => 25,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => $dressesCategory->id,
                'name_en' => 'Summer Dress',
                'name_ar' => 'فستان صيفي',
                'slug' => 'summer-dress',
                'description_en' => 'Light and comfortable summer dress',
                'description_ar' => 'فستان صيفي خفيف ومريح',
                'price' => 60.00,
                'sku' => 'DR002',
                'images' => [
                    'https://images.unsplash.com/photo-1445205170230-053b83016050?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                    'https://images.unsplash.com/photo-1445205170230-053b83016050?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'
                ],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'colors' => ['Yellow', 'Pink', 'Green'],
                'stock_quantity' => 45,
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        $allProducts = array_merge($pajamas, $pants, $dresses);

        foreach ($allProducts as $productData) {
            // Add color field based on the first color in the colors array
            if (isset($productData['colors']) && is_array($productData['colors']) && count($productData['colors']) > 0) {
                $productData['color'] = $productData['colors'][0];
            }

            $product = Product::where('slug', $productData['slug'])->first();
            if ($product) {
                $product->update($productData);
            } else {
                Product::create($productData);
            }
        }
    }
}
