<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inventory;

class NormalizeInventoryCategoriesCommand extends Command
{
    protected $signature = 'inventory:normalize-categories';
    protected $description = 'Normalize inventory category names (Red Wine, White Wine, Sparkling Wine)';

    public function handle()
    {
        $map = [
            'red wine' => 'Red Wine',
            'white wine' => 'White Wine',
            'sparkling wine' => 'Sparkling Wine',
        ];
        $fixed = 0;
        $all = Inventory::all();
        foreach ($all as $item) {
            $cat = strtolower(trim($item->category));
            if (isset($map[$cat]) && $item->category !== $map[$cat]) {
                $old = $item->category;
                $item->category = $map[$cat];
                $item->save();
                $fixed++;
                $this->info("Changed category from '$old' to '{$item->category}' for inventory ID {$item->id} ({$item->name})");
            }
        }
        $this->info("Normalized $fixed inventory categories.");
        return 0;
    }
} 