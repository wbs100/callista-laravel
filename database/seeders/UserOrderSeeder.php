<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserOrder;

class UserOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users with role 'user'
        $users = User::where('role', 'user')->get();
        
        if ($users->isEmpty()) {
            $this->command->info('No regular users found. Creating some users first...');
            
            // Create some regular users if none exist
            for ($i = 1; $i <= 5; $i++) {
                User::create([
                    'name' => "Customer {$i}",
                    'email' => "customer{$i}@example.com",
                    'password' => bcrypt('password'),
                    'role' => 'user',
                    'email_verified_at' => now(),
                ]);
            }
            
            $users = User::where('role', 'user')->get();
        }

        // Sample product details for orders
        $productOptions = [
            'Modern Dining Table Set',
            'Luxury Sofa Collection',
            'Ergonomic Office Chair',
            'Complete Bedroom Set',
            'Designer Coffee Table',
            'Study Desk with Storage',
            'Wardrobe with Mirror',
            'Bookshelf Unit',
            'Kitchen Cabinet Set',
            'Living Room TV Stand',
            'Dining Chair Set (4 pieces)',
            'Bean Bag Collection',
            'Garden Furniture Set',
            'Computer Desk',
            'Shoe Storage Cabinet'
        ];

        $statusOptions = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

        // Create 25 orders for pagination testing
        foreach ($users as $user) {
            // Create 3-7 orders per user
            $orderCount = rand(3, 7);
            
            for ($i = 0; $i < $orderCount; $i++) {
                UserOrder::create([
                    'user_id' => $user->id,
                    'contact_info' => $user->email,
                    'billing_data' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'address' => 'Sample Address ' . rand(1, 100),
                        'city' => 'Colombo',
                        'postal_code' => '00' . rand(100, 999)
                    ],
                    'order_notes' => 'Sample order for ' . $productOptions[array_rand($productOptions)],
                    'cart_data' => [
                        [
                            'name' => $productOptions[array_rand($productOptions)],
                            'price' => rand(15000, 450000),
                            'quantity' => rand(1, 3)
                        ]
                    ],
                    'payment_mode' => ['cash', 'card', 'online'][array_rand(['cash', 'card', 'online'])],
                    'payment_data' => [
                        'method' => 'sample',
                        'reference' => 'REF-' . rand(1000, 9999)
                    ],
                    'status' => $statusOptions[array_rand($statusOptions)],
                    'created_at' => now()->subDays(rand(1, 90)), // Orders from last 90 days
                    'updated_at' => now()->subDays(rand(0, 30)),
                ]);
            }
        }

        $this->command->info('UserOrder seeder completed successfully!');
    }
}
