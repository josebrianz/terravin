<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory;

class ImportWineImagesCommand extends Command
{
    protected $signature = 'import:wine-images';
    protected $description = 'Import wine inventory from CSV and match images, only adding new SKUs.';

    public function handle()
    {
        $csvPath = storage_path('MachineLearning/unique_image_rows_with_descriptions.csv');
        $imagesDir = public_path('wine_images');
        if (!file_exists($csvPath)) {
            $this->error('CSV file not found: ' . $csvPath);
            return 1;
        }
        if (!is_dir($imagesDir)) {
            $this->error('Images directory not found: ' . $imagesDir);
            return 1;
        }
        $imageFiles = array_map('strtolower', scandir($imagesDir));
        $imageMap = [];
        foreach ($imageFiles as $file) {
            if (preg_match('/^(img\d+)\.(jpe?g|png)$/', $file, $m)) {
                $imageMap[$m[1]] = $file;
            }
        }
        $handle = fopen($csvPath, 'r');
        if (!$handle) {
            $this->error('Failed to open CSV file.');
            return 1;
        }
        $header = fgetcsv($handle);
        $col = array_flip($header);
        $added = 0;
        while (($row = fgetcsv($handle)) !== false) {
            $imageBase = strtolower($row[$col['IMAGE']]);
            if (!isset($imageMap[$imageBase])) continue;
            $sku = $row[$col['ITEM CODE']];
            if (
                Inventory::where('sku', $sku)->exists() ||
                Inventory::where('item_code', $sku)->exists()
            ) continue;
            $inventory = new Inventory([
                'name' => $row[$col['WINE NAME']],
                'description' => $row[$col['DESCRIPTION']] ?? '',
                'sku' => $sku,
                'item_code' => $sku, // Add this line
                'quantity' => (int)($row[$col['QUANTITY']] ?? 0),
                'min_quantity' => 10,
                'unit_price' => (float)($row[$col['PRICE PER UNIT']] ?? 0),
                'category' => $row[$col['CATEGORY']] ?? null,
                'location' => null,
                'is_active' => true,
                'images' => [$imageMap[$imageBase]],
            ]);
            $inventory->save();
            $added++;
        }
        fclose($handle);
        $this->info("Imported $added new wine inventory items.");
        return 0;
    }
} 