<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateInventoryCategories extends Command
{
    protected $signature = 'inventory:update-categories {csv_path=storage/MachineLearning/newest_sales.csv}';
    protected $description = 'Update the category column in inventories table based on a CSV file';

    public function handle()
    {
        $csvPath = $this->argument('csv_path');
        if (!file_exists($csvPath)) {
            $this->error("CSV file not found: $csvPath");
            return 1;
        }

        $handle = fopen($csvPath, 'r');
        if (!$handle) {
            $this->error('Could not open CSV file.');
            return 1;
        }

        $header = fgetcsv($handle); // Read header
        $categoryIndex = array_search('CATEGORY', $header);
        $itemCodeIndex = array_search('ITEM CODE', $header);
        if ($categoryIndex === false || $itemCodeIndex === false) {
            $this->error('CSV must have CATEGORY and ITEM CODE columns.');
            fclose($handle);
            return 1;
        }

        $updates = [];
        while (($row = fgetcsv($handle)) !== false) {
            $category = strtolower(trim($row[$categoryIndex]));
            $itemCode = trim($row[$itemCodeIndex]);
            if ($category && $itemCode) {
                $updates[$itemCode] = $category;
            }
        }
        fclose($handle);

        $updated = 0;
        foreach ($updates as $itemCode => $category) {
            $affected = DB::table('inventories')
                ->where('item_code', (string)$itemCode)
                ->update(['category' => $category]);
            $updated += $affected;
        }

        $this->info("Updated $updated inventory records with category.");
        return 0;
    }
} 