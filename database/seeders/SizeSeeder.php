<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Size;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = [
            ['name_en' => 'XS', 'name_ar' => 'صغير جداً', 'sort_order' => 1, 'is_active' => true],
            ['name_en' => 'S', 'name_ar' => 'صغير', 'sort_order' => 2, 'is_active' => true],
            ['name_en' => 'M', 'name_ar' => 'متوسط', 'sort_order' => 3, 'is_active' => true],
            ['name_en' => 'L', 'name_ar' => 'كبير', 'sort_order' => 4, 'is_active' => true],
            ['name_en' => 'XL', 'name_ar' => 'كبير جداً', 'sort_order' => 5, 'is_active' => true],
            ['name_en' => 'XXL', 'name_ar' => 'كبير جداً جداً', 'sort_order' => 6, 'is_active' => true],
            ['name_en' => '28', 'name_ar' => '28', 'sort_order' => 7, 'is_active' => true],
            ['name_en' => '30', 'name_ar' => '30', 'sort_order' => 8, 'is_active' => true],
            ['name_en' => '32', 'name_ar' => '32', 'sort_order' => 9, 'is_active' => true],
            ['name_en' => '34', 'name_ar' => '34', 'sort_order' => 10, 'is_active' => true],
            ['name_en' => '36', 'name_ar' => '36', 'sort_order' => 11, 'is_active' => true],
            ['name_en' => '38', 'name_ar' => '38', 'sort_order' => 12, 'is_active' => true],
            ['name_en' => '40', 'name_ar' => '40', 'sort_order' => 13, 'is_active' => true],
            ['name_en' => '42', 'name_ar' => '42', 'sort_order' => 14, 'is_active' => true],
            ['name_en' => '44', 'name_ar' => '44', 'sort_order' => 15, 'is_active' => true],
        ];

        foreach ($sizes as $size) {
            Size::create($size);
        }
    }
}
