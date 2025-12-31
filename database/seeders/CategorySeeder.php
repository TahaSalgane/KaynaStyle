<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name_en' => 'Pajamas',
                'name_ar' => 'بيجاما',
                'slug' => 'pajamas',
                'description_en' => 'Comfortable and stylish pajamas for girls',
                'description_ar' => 'بيجاما مريحة وأنيقة للبنات',
                'image' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name_en' => 'Pants',
                'name_ar' => 'سراويل',
                'slug' => 'pants',
                'description_en' => 'Trendy pants and trousers for girls',
                'description_ar' => 'سراويل وتنورات عصرية للبنات',
                'image' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name_en' => 'Dresses',
                'name_ar' => 'قبية',
                'slug' => 'dresses',
                'description_en' => 'Beautiful dresses for special occasions',
                'description_ar' => 'فساتين جميلة للمناسبات الخاصة',
                'image' => 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::where('slug', $categoryData['slug'])->first();
            if ($category) {
                $category->update($categoryData);
            } else {
                Category::create($categoryData);
            }
        }
    }
}
