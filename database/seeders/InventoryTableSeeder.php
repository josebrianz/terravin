<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class InventoryTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        $items = [
            [
                'name' => 'Chardonnay 2022',
                'description' => null,
                'sku' => 'WINE001',
                'item_code' => 'WINE001',
                'quantity' => 5,
                'min_quantity' => 10,
                'unit_price' => 45.99,
                'category' => 'White Wine',
                'location' => null,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Cabernet Sauvignon 2021',
                'description' => null,
                'sku' => 'WINE002',
                'item_code' => 'WINE002',
                'quantity' => 15,
                'min_quantity' => 20,
                'unit_price' => 65.99,
                'category' => 'Red Wine',
                'location' => null,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Merlot 2023',
                'description' => null,
                'sku' => 'WINE003',
                'item_code' => 'WINE003',
                'quantity' => 8,
                'min_quantity' => 15,
                'unit_price' => 52.99,
                'category' => 'Red Wine',
                'location' => null,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Pinot Grigio 2023',
                'description' => null,
                'sku' => 'WINE004',
                'item_code' => 'WINE004',
                'quantity' => 0,
                'min_quantity' => 5,
                'unit_price' => 38.99,
                'category' => 'White Wine',
                'location' => null,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Sauvignon Blanc 2022',
                'description' => null,
                'sku' => 'WINE005',
                'item_code' => 'WINE005',
                'quantity' => 25,
                'min_quantity' => 30,
                'unit_price' => 42.99,
                'category' => 'White Wine',
                'location' => null,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Malbec 2021',
                'description' => null,
                'sku' => 'WINE006',
                'item_code' => 'WINE006',
                'quantity' => 3,
                'min_quantity' => 10,
                'unit_price' => 58.99,
                'category' => 'Red Wine',
                'location' => null,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Prosecco DOC',
                'description' => null,
                'sku' => 'WINE007',
                'item_code' => 'WINE007',
                'quantity' => 50,
                'min_quantity' => 100,
                'unit_price' => 28.99,
                'category' => 'Sparkling Wine',
                'location' => null,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Pinot Noir 2022',
                'description' => null,
                'sku' => 'WINE008',
                'item_code' => 'WINE008',
                'quantity' => 12,
                'min_quantity' => 15,
                'unit_price' => 72.99,
                'category' => 'Red Wine',
                'location' => null,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Riesling 2023',
                'description' => null,
                'sku' => 'WINE009',
                'item_code' => 'WINE009',
                'quantity' => 7,
                'min_quantity' => 12,
                'unit_price' => 35.99,
                'category' => 'White Wine',
                'location' => null,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Syrah 2021',
                'description' => null,
                'sku' => 'WINE010',
                'item_code' => 'WINE010',
                'quantity' => 4,
                'min_quantity' => 8,
                'unit_price' => 68.99,
                'category' => 'Red Wine',
                'location' => null,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Champagne Brut',
                'description' => null,
                'sku' => 'WINE011',
                'item_code' => 'WINE011',
                'quantity' => 18,
                'min_quantity' => 25,
                'unit_price' => 89.99,
                'category' => 'Sparkling Wine',
                'location' => null,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Zinfandel 2022',
                'description' => null,
                'sku' => 'WINE012',
                'item_code' => 'WINE012',
                'quantity' => 6,
                'min_quantity' => 10,
                'unit_price' => 48.99,
                'category' => 'Red Wine',
                'location' => null,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($items as $item) {
            // Only insert if SKU does not already exist
            if (!DB::table('inventories')->where('sku', $item['sku'])->exists()) {
                DB::table('inventories')->insert($item);
            }
        }

        // List of classic white wine names
        $whiteWines = [
            'Sauvignon Blanc',
            'Chardonnay',
            'Riesling',
            'Pinot Grigio',
            'Chenin Blanc',
            'Moscato',
            'Gewürztraminer',
            'Semillon',
            'Viognier',
            'Grüner Veltliner',
        ];

        // Get all inventory items where category is 'beer'
        $beerItems = DB::table('inventories')->where('category', 'beer')->get();
        $usedNames = [];
        foreach ($beerItems as $item) {
            // Pick a random white wine name that hasn't been used yet
            $availableWines = array_diff($whiteWines, $usedNames);
            if (empty($availableWines)) {
                $usedNames = [];
                $availableWines = $whiteWines;
            }
            $wineName = $availableWines[array_rand($availableWines)];
            $usedNames[] = $wineName;
            DB::table('inventories')->where('id', $item->id)->update([
                'name' => $wineName,
                'category' => 'White Wine',
            ]);
        }

        // List of classic red wine names
        $redWines = [
            'Cabernet Sauvignon',
            'Merlot',
            'Pinot Noir',
            'Syrah',
            'Malbec',
            'Zinfandel',
            'Sangiovese',
            'Tempranillo',
            'Grenache',
            'Nebbiolo',
        ];

        // Get all inventory items where category is 'dunnage' or 'kegs'
        $redItems = DB::table('inventories')->whereIn('category', ['dunnage', 'kegs'])->get();
        $usedRedNames = [];
        foreach ($redItems as $item) {
            // Pick a random red wine name that hasn't been used yet
            $availableReds = array_diff($redWines, $usedRedNames);
            if (empty($availableReds)) {
                $usedRedNames = [];
                $availableReds = $redWines;
            }
            $wineName = $availableReds[array_rand($availableReds)];
            $usedRedNames[] = $wineName;
            DB::table('inventories')->where('id', $item->id)->update([
                'name' => $wineName,
                'category' => 'Red Wine',
            ]);
        }

        // List of classic sparkling wine names
        $sparklingWines = [
            'Champagne',
            'Prosecco',
            'Cava',
            'Franciacorta',
            'Crémant',
            'Sekt',
            'Asti Spumante',
            'Brut Rosé',
            'Lambrusco',
            'Schramsberg',
        ];

        // Get all inventory items where category is 'liquor'
        $liquorItems = DB::table('inventories')->where('category', 'liquor')->get();
        $usedSparklingNames = [];
        foreach ($liquorItems as $item) {
            // Pick a random sparkling wine name that hasn't been used yet
            $availableSparkling = array_diff($sparklingWines, $usedSparklingNames);
            if (empty($availableSparkling)) {
                $usedSparklingNames = [];
                $availableSparkling = $sparklingWines;
            }
            $wineName = $availableSparkling[array_rand($availableSparkling)];
            $usedSparklingNames[] = $wineName;
            DB::table('inventories')->where('id', $item->id)->update([
                'name' => $wineName,
                'category' => 'Sparkling Wine',
            ]);
        }

        // Get all inventory items where category is 'wine'
        $wineItems = DB::table('inventories')->where('category', 'wine')->get();
        $usedWhiteNamesForWine = [];
        foreach ($wineItems as $item) {
            // Pick a random white wine name that hasn't been used yet
            $availableWines = array_diff($whiteWines, $usedWhiteNamesForWine);
            if (empty($availableWines)) {
                $usedWhiteNamesForWine = [];
                $availableWines = $whiteWines;
            }
            $wineName = $availableWines[array_rand($availableWines)];
            $usedWhiteNamesForWine[] = $wineName;
            DB::table('inventories')->where('id', $item->id)->update([
                'name' => $wineName,
                'category' => 'White Wine',
            ]);
        }
    }
}
