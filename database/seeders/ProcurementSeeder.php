<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Procurement;
use App\Models\User;

class ProcurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default user if none exists
        $user = User::firstOrCreate(
            ['email' => 'admin@terravin.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('Admin@123'),
            ]
        );

        $wholesalers = [
            'Premium Cork Wholesalers',
            'Glass Bottle Wholesalers',
            'Wine Label Printing Wholesalers',
            'Vineyard Equipment Wholesalers',
            'Wine Storage Solutions Wholesalers',
            'Fermentation Equipment Wholesalers',
            'Wine Packaging International Wholesalers',
            'Oak Barrel Traders Wholesalers',
            'Wine Machinery Corp. Wholesalers',
        ];

        $items = [
            'French Oak Barrels (225L)',
            'Premium Wine Corks',
            'Wine Bottles (750ml)',
            'Custom Wine Labels',
            'Fermentation Tanks',
            'Wine Storage Racks',
            'Bottling Equipment',
            'Wine Capsules',
            'Wine Filtration Systems',
            'Temperature Control Units',
            'Wine Pumps',
            'Grape Crushers',
            'Wine Presses',
            'Wine Testing Equipment',
            'Wine Bottle Caps',
            'Wine Racking Equipment',
            'Wine Transfer Pumps',
            'Wine Bottle Fillers',
            'Wine Corking Machines',
            'Wine Label Applicators',
        ];

        $statuses = ['pending', 'approved', 'ordered', 'received', 'cancelled'];
        $statusWeights = [3, 2, 2, 1, 1]; // More pending and approved items

        for ($i = 1; $i <= 30; $i++) {
            $status = $statuses[array_rand($statusWeights)];
            $quantity = rand(1, 100);
            $unitPrice = rand(50, 5000);
            $totalAmount = $quantity * $unitPrice;

            $procurement = Procurement::create([
                'po_number' => 'PO-' . date('Y') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'item_name' => $items[array_rand($items)],
                'description' => 'Wine production and packaging supplies for Terravin winery operations.',
                'wholesaler_name' => $wholesalers[array_rand($wholesalers)],
                'wholesaler_email' => 'contact@' . strtolower(str_replace([' ', '&', '.', '(', ')', 'Ltd.', 'Co.', 'Corp.', 'International'], ['', 'and', '', '', '', 'ltd', 'co', 'corp', 'int'], $wholesalers[array_rand($wholesalers)])) . '.com',
                'wholesaler_phone' => '+1-' . rand(200, 999) . '-' . rand(200, 999) . '-' . rand(1000, 9999),
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_amount' => $totalAmount,
                'status' => $status,
                'requested_by' => $user->id,
                'approved_by' => $status !== 'pending' ? $user->id : null,
                'order_date' => $status === 'ordered' || $status === 'received' ? now()->subDays(rand(1, 30)) : null,
                'expected_delivery' => now()->addDays(rand(1, 60)),
                'actual_delivery' => $status === 'received' ? now()->subDays(rand(1, 15)) : null,
                'notes' => 'Essential supplies for Terravin wine production and bottling operations.',
                'created_at' => now()->subDays(rand(1, 90)),
                'updated_at' => now()->subDays(rand(1, 90)),
            ]);
        }

        $this->command->info('Wine supply procurement data seeded successfully!');
    }
}
