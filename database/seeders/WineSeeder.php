<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inventory;

class WineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wines = [
            // Red Wines
            [
                'name' => 'Château Margaux 2015',
                'description' => 'Premium French Bordeaux red wine with rich flavors of blackberry, plum, and oak.',
                'sku' => 'RED-001',
                'quantity' => 25,
                'min_quantity' => 5,
                'unit_price' => 850000,
                'category' => 'Red Wine',
                'location' => 'Cellar A',
                'is_active' => true
            ],
            [
                'name' => 'Barolo Riserva 2018',
                'description' => 'Italian Nebbiolo wine with notes of cherry, rose, and truffle.',
                'sku' => 'RED-002',
                'quantity' => 30,
                'min_quantity' => 8,
                'unit_price' => 120000,
                'category' => 'Red Wine',
                'location' => 'Cellar A',
                'is_active' => true
            ],
            [
                'name' => 'Napa Valley Cabernet Sauvignon 2020',
                'description' => 'California Cabernet with bold flavors of black cherry, vanilla, and cedar.',
                'sku' => 'RED-003',
                'quantity' => 45,
                'min_quantity' => 10,
                'unit_price' => 75000,
                'category' => 'Red Wine',
                'location' => 'Cellar B',
                'is_active' => true
            ],
            [
                'name' => 'Rioja Gran Reserva 2016',
                'description' => 'Spanish Tempranillo with complex notes of leather, tobacco, and dark fruit.',
                'sku' => 'RED-004',
                'quantity' => 35,
                'min_quantity' => 8,
                'unit_price' => 65000,
                'category' => 'Red Wine',
                'location' => 'Cellar A',
                'is_active' => true
            ],
            [
                'name' => 'Pinot Noir Reserve 2021',
                'description' => 'Oregon Pinot Noir with elegant flavors of raspberry, earth, and spice.',
                'sku' => 'RED-005',
                'quantity' => 40,
                'min_quantity' => 10,
                'unit_price' => 55000,
                'category' => 'Red Wine',
                'location' => 'Cellar B',
                'is_active' => true
            ],

            // White Wines
            [
                'name' => 'Chardonnay Grand Cru 2019',
                'description' => 'French Chardonnay with notes of apple, butter, and oak.',
                'sku' => 'WHITE-001',
                'quantity' => 30,
                'min_quantity' => 8,
                'unit_price' => 95000,
                'category' => 'White Wine',
                'location' => 'Cellar C',
                'is_active' => true
            ],
            [
                'name' => 'Sauvignon Blanc 2022',
                'description' => 'New Zealand Sauvignon Blanc with crisp citrus and herbaceous notes.',
                'sku' => 'WHITE-002',
                'quantity' => 50,
                'min_quantity' => 12,
                'unit_price' => 35000,
                'category' => 'White Wine',
                'location' => 'Cellar C',
                'is_active' => true
            ],
            [
                'name' => 'Riesling Spätlese 2020',
                'description' => 'German Riesling with sweet notes of peach, honey, and petrol.',
                'sku' => 'WHITE-003',
                'quantity' => 25,
                'min_quantity' => 6,
                'unit_price' => 45000,
                'category' => 'White Wine',
                'location' => 'Cellar C',
                'is_active' => true
            ],
            [
                'name' => 'Pinot Grigio 2022',
                'description' => 'Italian Pinot Grigio with light, crisp flavors of pear and citrus.',
                'sku' => 'WHITE-004',
                'quantity' => 60,
                'min_quantity' => 15,
                'unit_price' => 28000,
                'category' => 'White Wine',
                'location' => 'Cellar C',
                'is_active' => true
            ],

            // Sparkling Wines
            [
                'name' => 'Champagne Brut 2018',
                'description' => 'French Champagne with fine bubbles and notes of green apple and toast.',
                'sku' => 'SPARK-001',
                'quantity' => 20,
                'min_quantity' => 5,
                'unit_price' => 180000,
                'category' => 'Sparkling Wine',
                'location' => 'Cellar D',
                'is_active' => true
            ],
            [
                'name' => 'Prosecco Superiore 2022',
                'description' => 'Italian Prosecco with fresh, fruity flavors and lively bubbles.',
                'sku' => 'SPARK-002',
                'quantity' => 40,
                'min_quantity' => 10,
                'unit_price' => 42000,
                'category' => 'Sparkling Wine',
                'location' => 'Cellar D',
                'is_active' => true
            ],
            [
                'name' => 'Cava Reserva 2019',
                'description' => 'Spanish Cava with complex flavors of almond, citrus, and yeast.',
                'sku' => 'SPARK-003',
                'quantity' => 30,
                'min_quantity' => 8,
                'unit_price' => 38000,
                'category' => 'Sparkling Wine',
                'location' => 'Cellar D',
                'is_active' => true
            ],

            // Rosé Wines
            [
                'name' => 'Provence Rosé 2022',
                'description' => 'French Rosé with delicate notes of strawberry, peach, and herbs.',
                'sku' => 'ROSE-001',
                'quantity' => 35,
                'min_quantity' => 10,
                'unit_price' => 32000,
                'category' => 'Rosé Wine',
                'location' => 'Cellar A',
                'is_active' => true
            ],
            [
                'name' => 'Tuscany Rosé 2022',
                'description' => 'Italian Rosé with flavors of cherry, watermelon, and citrus.',
                'sku' => 'ROSE-002',
                'quantity' => 30,
                'min_quantity' => 8,
                'unit_price' => 28000,
                'category' => 'Rosé Wine',
                'location' => 'Cellar A',
                'is_active' => true
            ],

            // Dessert Wines
            [
                'name' => 'Sauternes 2017',
                'description' => 'French dessert wine with rich flavors of apricot, honey, and vanilla.',
                'sku' => 'DESSERT-001',
                'quantity' => 15,
                'min_quantity' => 3,
                'unit_price' => 120000,
                'category' => 'Dessert Wine',
                'location' => 'Cellar E',
                'is_active' => true
            ],
            [
                'name' => 'Port Vintage 2018',
                'description' => 'Portuguese Port with intense flavors of blackberry, chocolate, and spice.',
                'sku' => 'DESSERT-002',
                'quantity' => 20,
                'min_quantity' => 5,
                'unit_price' => 85000,
                'category' => 'Dessert Wine',
                'location' => 'Cellar E',
                'is_active' => true
            ]
        ];

        foreach ($wines as $wine) {
            Inventory::create($wine);
        }
    }
}
