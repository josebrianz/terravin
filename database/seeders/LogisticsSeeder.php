<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Inventory;

class LogisticsSeeder extends Seeder
{
    public function run()
    {
        // Create sample users
        $users = User::factory(10)->create();

        // Create sample wine inventory items
        $inventoryItems = [
            ['name' => 'Chardonnay 2022', 'sku' => 'WINE001', 'quantity' => 5, 'min_quantity' => 10, 'unit_price' => 45.99, 'category' => 'White Wine'],
            ['name' => 'Cabernet Sauvignon 2021', 'sku' => 'WINE002', 'quantity' => 15, 'min_quantity' => 20, 'unit_price' => 65.99, 'category' => 'Red Wine'],
            ['name' => 'Merlot 2023', 'sku' => 'WINE003', 'quantity' => 8, 'min_quantity' => 15, 'unit_price' => 52.99, 'category' => 'Red Wine'],
            ['name' => 'Pinot Grigio 2023', 'sku' => 'WINE004', 'quantity' => 0, 'min_quantity' => 5, 'unit_price' => 38.99, 'category' => 'White Wine'],
            ['name' => 'Sauvignon Blanc 2022', 'sku' => 'WINE005', 'quantity' => 25, 'min_quantity' => 30, 'unit_price' => 42.99, 'category' => 'White Wine'],
            ['name' => 'Malbec 2021', 'sku' => 'WINE006', 'quantity' => 3, 'min_quantity' => 10, 'unit_price' => 58.99, 'category' => 'Red Wine'],
            ['name' => 'Prosecco DOC', 'sku' => 'WINE007', 'quantity' => 50, 'min_quantity' => 100, 'unit_price' => 28.99, 'category' => 'Sparkling Wine'],
            ['name' => 'Pinot Noir 2022', 'sku' => 'WINE008', 'quantity' => 12, 'min_quantity' => 15, 'unit_price' => 72.99, 'category' => 'Red Wine'],
            ['name' => 'Riesling 2023', 'sku' => 'WINE009', 'quantity' => 7, 'min_quantity' => 12, 'unit_price' => 35.99, 'category' => 'White Wine'],
            ['name' => 'Syrah 2021', 'sku' => 'WINE010', 'quantity' => 4, 'min_quantity' => 8, 'unit_price' => 68.99, 'category' => 'Red Wine'],
            ['name' => 'Champagne Brut', 'sku' => 'WINE011', 'quantity' => 18, 'min_quantity' => 25, 'unit_price' => 89.99, 'category' => 'Sparkling Wine'],
            ['name' => 'Zinfandel 2022', 'sku' => 'WINE012', 'quantity' => 6, 'min_quantity' => 10, 'unit_price' => 48.99, 'category' => 'Red Wine'],
        ];

        foreach ($inventoryItems as $item) {
            Inventory::create($item);
        }
    }
} 