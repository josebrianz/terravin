<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inventory;

class AssignMissingImagesCommand extends Command
{
    protected $signature = 'inventory:assign-missing-images';
    protected $description = 'Assign images to inventory items missing images, using fuzzy name matching within the same category.';

    public function handle()
    {
        $itemsWithoutImages = Inventory::where(function($q) {
            $q->whereNull('images')->orWhere('images', '[]')->orWhere('images', '')->orWhere('images', '[""]');
        })->get();

        $allWithImages = Inventory::whereNotNull('images')->where('images', '!=', '[]')->get();
        $assigned = 0;

        foreach ($itemsWithoutImages as $item) {
            $candidates = $allWithImages->where('category', $item->category);
            $bestMatch = null;
            $bestScore = 0;
            foreach ($candidates as $candidate) {
                similar_text(strtolower($item->name), strtolower($candidate->name), $percent);
                if ($percent > $bestScore) {
                    $bestScore = $percent;
                    $bestMatch = $candidate;
                }
            }
            if ($bestMatch && $bestScore > 60) { // 60% similarity threshold
                $item->images = $bestMatch->images;
                $item->save();
                $assigned++;
                $this->info("Assigned image(s) from '{$bestMatch->name}' to '{$item->name}' (category: {$item->category}, similarity: {$bestScore}%)");
            } elseif ($candidates->count() > 0) {
                // fallback: assign random image from same category
                $random = $candidates->random();
                $item->images = $random->images;
                $item->save();
                $assigned++;
                $this->info("Assigned random image from '{$random->name}' to '{$item->name}' (category: {$item->category})");
            } else {
                $this->warn("No image found for '{$item->name}' in category '{$item->category}'");
            }
        }
        $this->info("Assigned images to $assigned inventory items.");
        return 0;
    }
} 