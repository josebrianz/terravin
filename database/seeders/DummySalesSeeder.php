<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DummySalesSeeder extends Seeder
{
    public function run()
    {
        // Get 1 item_code per category (beer, wine, liquor, dunnage, kegs)
        $categories = ['beer', 'wine', 'liquor', 'dunnage', 'kegs'];
        $items = collect();
        foreach ($categories as $category) {
            $item = DB::table('inventories')
                ->where('category', $category)
                ->select('id', 'item_name', 'category')
                ->first();
            if ($item) {
                $items->push($item);
            }
        }

        $customerNames = ['John Doe', 'Jane Smith', 'Alice Brown', 'Bob White', 'Charlie Black'];
        $now = Carbon::now();
        $userId = DB::table('users')->value('id'); // Get the first user ID

        foreach ($categories as $catIdx => $category) {
            $item = $items->firstWhere('category', $category);
            if (!$item) continue;
            for ($i = 0; $i < 12; $i++) {
                $orderDate = $now->copy()->subMonths(11 - $i)->startOfMonth()->addDays(rand(0, 27));
                $orderId = DB::table('orders')->insertGetId([
                    'customer_name' => $customerNames[$i % count($customerNames)],
                    'user_id' => $userId, // Add user_id
                    'customer_email' => Str::slug($customerNames[$i % count($customerNames)], '.') . '@example.com',
                    'customer_phone' => '555-000' . rand(1000, 9999),
                    'shipping_address' => '123 Main St',
                    'notes' => null,
                    'total_amount' => rand(100, 500),
                    'status' => 'completed',
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'inventory_id' => $item->id,
                    'item_name' => $item->item_name,
                    'item_image' => null,
                    'unit_price' => rand(10, 50),
                    'quantity' => rand(1, 10),
                    'subtotal' => rand(100, 500),
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);
            }
        }
    }
} 