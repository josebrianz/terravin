<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ShipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add 3 sample shipments
        Shipment::create([
            'order_id' => 1,
            'tracking_number' => 'TRACK1001',
            'status' => 'pending',
            'carrier' => 'DHL',
            'shipping_cost' => 25.50,
            'estimated_delivery_date' => now()->addDays(3),
            'shipping_address' => '123 Wine St, Napa Valley, CA',
            'notes' => 'Fragile',
            'created_by' => 1,
        ]);
        Shipment::create([
            'order_id' => 1,
            'tracking_number' => 'TRACK1002',
            'status' => 'in_transit',
            'carrier' => 'FedEx',
            'shipping_cost' => 30.00,
            'estimated_delivery_date' => now()->addDays(5),
            'shipping_address' => '456 Vineyard Rd, Sonoma, CA',
            'notes' => 'Deliver before noon',
            'created_by' => 1,
        ]);
        Shipment::create([
            'order_id' => 1,
            'tracking_number' => 'TRACK1003',
            'status' => 'delivered',
            'carrier' => 'UPS',
            'shipping_cost' => 20.00,
            'estimated_delivery_date' => now()->subDays(2),
            'shipping_address' => '789 Cellar Ave, Paso Robles, CA',
            'notes' => 'Leave at front desk',
            'created_by' => 1,
        ]);
    }
}
