<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            ['name_en' => 'Pink', 'name_ar' => 'وردي', 'hex_code' => '#FFC0CB', 'is_active' => true],
            ['name_en' => 'Purple', 'name_ar' => 'بنفسجي', 'hex_code' => '#800080', 'is_active' => true],
            ['name_en' => 'Blue', 'name_ar' => 'أزرق', 'hex_code' => '#0000FF', 'is_active' => true],
            ['name_en' => 'Red', 'name_ar' => 'أحمر', 'hex_code' => '#FF0000', 'is_active' => true],
            ['name_en' => 'White', 'name_ar' => 'أبيض', 'hex_code' => '#FFFFFF', 'is_active' => true],
            ['name_en' => 'Black', 'name_ar' => 'أسود', 'hex_code' => '#000000', 'is_active' => true],
            ['name_en' => 'Yellow', 'name_ar' => 'أصفر', 'hex_code' => '#FFFF00', 'is_active' => true],
            ['name_en' => 'Green', 'name_ar' => 'أخضر', 'hex_code' => '#008000', 'is_active' => true],
        ];

        foreach ($colors as $color) {
            Color::create($color);
        }
    }
}
