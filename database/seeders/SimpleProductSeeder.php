<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class SimpleProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create products with all required fields
        for ($i = 1; $i <= 18; $i++) {
            Product::create([
                'name' => "Product {$i}",
                'description' => "Description for product {$i}. This is a high-quality furniture item.",
                'new_price' => rand(25000, 500000),
                'old_price' => rand(30000, 550000),
                'rating' => rand(35, 50) / 10, // 3.5 to 5.0
                'barcode' => 'CAL-PROD-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'color' => ['Brown', 'Black', 'White', 'Natural', 'Grey'][rand(0, 4)],
                'vendor' => 'Callista Furniture',
                'type' => ['Living Room', 'Bedroom', 'Dining', 'Office', 'Storage'][rand(0, 4)],
                'weight' => rand(5, 100) . ' kg',
                'size' => rand(50, 200) . 'cm x ' . rand(50, 150) . 'cm x ' . rand(30, 100) . 'cm',
                'stock_status' => ['in_stock', 'low_stock', 'out_of_stock'][rand(0, 2)],
                'tags' => ['furniture', 'modern', 'quality'],
            ]);
        }

        $this->command->info('Simple Product seeder completed successfully!');
    }
}
