<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inventory;

class FixInventoryImagesCommand extends Command
{
    protected $signature = 'inventory:fix-images';
    protected $description = 'Fix the images field in the inventories table to ensure it is a valid JSON array and matches files in public/wine_images.';

    public function handle()
    {
        $imagesDir = public_path('wine_images');
        $imageFiles = array_map('strtolower', scandir($imagesDir));
        $fixed = 0;
        $skipped = 0;
        $all = Inventory::all();
        foreach (
            $all as $item
        ) {
            $original = $item->images;
            $changed = false;
            $images = $original;
            // If images is a string, try to convert to array
            if (is_string($images)) {
                $decoded = json_decode($images, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $images = $decoded;
                } elseif (trim($images) !== '') {
                    $images = [trim($images)];
                } else {
                    $images = [];
                }
                $changed = true;
            }
            // Remove empty/invalid values
            $images = array_filter((array)$images, function($img) {
                return is_string($img) && trim($img) !== '';
            });
            // Check that the file exists in public/wine_images
            $images = array_values(array_filter($images, function($img) use ($imageFiles) {
                return in_array(strtolower($img), $imageFiles);
            }));

            // If images is still empty, assign a random image from same category or from wine_images
            if (empty($images)) {
                // Try to find another inventory item in the same category with images
                $categoryMatch = $all->where('category', $item->category)->filter(function($inv) use ($item) {
                    return $inv->id !== $item->id && !empty($inv->images) && is_array($inv->images) && count($inv->images) > 0;
                });
                if ($categoryMatch->count() > 0) {
                    $randomItem = $categoryMatch->random();
                    $images = is_array($randomItem->images) ? [$randomItem->images[0]] : [$randomItem->images];
                    $this->info("Assigned random image from same category to inventory ID {$item->id} ({$item->name})");
                } elseif (count($imageFiles) > 2) { // Exclude . and ..
                    $validImages = array_filter($imageFiles, function($img) {
                        return preg_match('/\.(jpe?g|png)$/i', $img);
                    });
                    if (!empty($validImages)) {
                        $images = [array_values($validImages)[array_rand($validImages)]];
                        $this->info("Assigned random image from wine_images folder to inventory ID {$item->id} ({$item->name})");
                    }
                }
            }

            if ($images !== $original) {
                $item->images = $images;
                $item->save();
                $fixed++;
                $this->info("Fixed images for inventory ID {$item->id} ({$item->name})");
            } else {
                $skipped++;
            }
        }
        $this->info("Fixed $fixed inventory records. Skipped $skipped records (already valid).");
        return 0;
    }
} 