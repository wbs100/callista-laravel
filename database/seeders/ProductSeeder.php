<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Modern Dining Table',
                'description' => 'Elegant modern dining table perfect for contemporary homes. Made from high-quality oak wood with a sleek finish.',
                'new_price' => 125000,
                'old_price' => 135000,
                'rating' => 4.5,
                'barcode' => 'CAL-DT-001',
                'color' => 'Oak Brown',
                'vendor' => 'Callista Furniture',
                'type' => 'Dining',
                'weight' => '45 kg',
                'size' => '180cm x 90cm x 75cm',
                'stock_status' => 'in_stock',
                'tags' => ['dining', 'table', 'oak', 'modern']
            ],
            [
                'name' => 'Luxury Leather Sofa',
                'description' => 'Premium leather sofa with exceptional comfort and style. Perfect for living rooms and lounges.',
                'new_price' => 275000,
                'old_price' => 295000,
                'rating' => 4.8,
                'vendor' => 'Callista Furniture',
                'type' => 'Living Room',
                'stock_status' => 'in_stock'
            ],
            [
                'name' => 'Ergonomic Office Chair',
                'description' => 'Professional office chair with lumbar support and adjustable height. Ideal for long working hours.',
                'new_price' => 45000,
                'old_price' => 50000,
                'rating' => 4.2,
                'vendor' => 'Callista Furniture',
                'type' => 'Office',
                'stock_status' => 'in_stock'
            ],
            [
                'name' => 'Complete Bedroom Set',
                'description' => 'Full bedroom furniture set including bed, nightstands, and dresser. Modern design with ample storage.',
                'new_price' => 350000,
                'old_price' => 380000,
                'rating' => 4.7,
                'vendor' => 'Callista Furniture',
                'type' => 'Bedroom',
                'stock_status' => 'in_stock'
            ],
            [
                'name' => 'Designer Coffee Table',
                'description' => 'Stylish glass-top coffee table with wooden legs. Perfect centerpiece for any living room.',
                'new_price' => 65000,
                'old_price' => 72000,
                'rating' => 4.3,
                'vendor' => 'Callista Furniture',
                'type' => 'Living Room',
                'stock_status' => 'in_stock'
            ],
            [
                'name' => 'Study Desk with Storage',
                'description' => 'Functional study desk with built-in drawers and shelving. Great for students and professionals.',
                'new_price' => 75000,
                'old_price' => 85000,
                'rating' => 4.4,
                'vendor' => 'Callista Furniture',
                'type' => 'Office',
                'stock_status' => 'in_stock'
            ],
            [
                'name' => 'Wardrobe with Mirror',
                'description' => 'Spacious wardrobe with full-length mirror and multiple compartments for organized storage.',
                'new_price' => 185000,
                'old_price' => 200000,
                'rating' => 4.6,
                'vendor' => 'Callista Furniture',
                'type' => 'Bedroom',
                'stock_status' => 'in_stock'
            ],
            [
                'name' => 'Wooden Bookshelf',
                'description' => 'Five-tier wooden bookshelf perfect for organizing books, decorative items, and storage boxes.',
                'new_price' => 55000,
                'old_price' => 60000,
                'rating' => 4.1,
                'vendor' => 'Callista Furniture',
                'type' => 'Storage',
                'stock_status' => 'in_stock'
            ],
            [
                'name' => 'Kitchen Cabinet Set',
                'description' => 'Complete kitchen cabinet solution with modern hardware and durable construction.',
                'new_price' => 225000,
                'old_price' => 250000,
                'rating' => 4.5,
                'vendor' => 'Callista Furniture',
                'type' => 'Kitchen',
                'stock_status' => 'low_stock'
            ],
            [
                'name' => 'TV Entertainment Unit',
                'description' => 'Modern TV stand with cable management and storage compartments for media devices.',
                'new_price' => 95000,
                'old_price' => 105000,
                'rating' => 4.3,
                'vendor' => 'Callista Furniture',
                'type' => 'Living Room',
                'stock_status' => 'in_stock'
            ],
            [
                'name' => 'Dining Chair Set',
                'description' => 'Set of 4 comfortable dining chairs with cushioned seats and ergonomic design.',
                'new_price' => 85000,
                'old_price' => 95000,
                'rating' => 4.4,
                'vendor' => 'Callista Furniture',
                'type' => 'Dining',
                'stock_status' => 'in_stock'
            ],
            [
                'name' => 'Bean Bag Chair',
                'description' => 'Comfortable bean bag chair filled with premium beans. Perfect for relaxation and casual seating.',
                'new_price' => 25000,
                'old_price' => 28000,
                'rating' => 3.9,
                'vendor' => 'Callista Furniture',
                'type' => 'Living Room',
                'stock_status' => 'in_stock'
            ],
            [
                'name' => 'Garden Patio Set',
                'description' => 'Weather-resistant outdoor furniture set including table and 4 chairs. Perfect for garden dining.',
                'new_price' => 165000,
                'old_price' => 180000,
                'rating' => 4.2,
                'vendor' => 'Callista Furniture',
                'type' => 'Outdoor',
                'stock_status' => 'low_stock'
            ],
            [
                'name' => 'Computer Gaming Desk',
                'description' => 'Spacious gaming desk with RGB lighting, cable management, and cup holder. Gamer approved!',
                'new_price' => 115000,
                'old_price' => 125000,
                'rating' => 4.6,
                'vendor' => 'Callista Furniture',
                'type' => 'Office',
                'stock_status' => 'in_stock'
            ],
            [
                'name' => 'Shoe Storage Cabinet',
                'description' => 'Multi-level shoe storage cabinet that can hold up to 20 pairs of shoes. Space-saving design.',
                'new_price' => 35000,
                'old_price' => 40000,
                'rating' => 4.0,
                'vendor' => 'Callista Furniture',
                'type' => 'Storage',
                'stock_status' => 'in_stock'
            ],
            [
                'name' => 'Antique Wooden Chest',
                'description' => 'Vintage-style wooden storage chest with intricate carvings. Limited edition piece.',
                'new_price' => 195000,
                'old_price' => 220000,
                'rating' => 4.8,
                'vendor' => 'Callista Furniture',
                'type' => 'Storage',
                'stock_status' => 'low_stock'
            ],
            [
                'name' => 'Executive Office Desk',
                'description' => 'Large executive desk made from premium mahogany wood. Perfect for corporate offices.',
                'new_price' => 285000,
                'old_price' => 320000,
                'rating' => 4.9,
                'vendor' => 'Callista Furniture',
                'type' => 'Office',
                'stock_status' => 'low_stock'
            ],
            [
                'name' => 'Vintage Armchair',
                'description' => 'Classic vintage armchair with velvet upholstery. Currently out of stock.',
                'new_price' => 145000,
                'old_price' => 160000,
                'rating' => 4.5,
                'vendor' => 'Callista Furniture',
                'type' => 'Living Room',
                'stock_status' => 'out_of_stock'
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('Product seeder completed successfully!');
    }
}
