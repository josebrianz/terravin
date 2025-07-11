<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RetailerCatalogController extends Controller
{
    public function index()
    {
        // Sample wine data
        $wines = [
            (object)[
                'name' => 'Chateau Rouge',
                'price' => 45000,
                'description' => 'A bold red wine with notes of cherry and oak.',
                'image_url' => asset('images/chateau-rouge.jpg'),
            ],
            (object)[
                'name' => 'Blanc de Blancs',
                'price' => 38000,
                'description' => 'A crisp white wine, perfect for summer evenings.',
                'image_url' => 'https://images.unsplash.com/photo-1510626176961-4b57d4fbad04?auto=format&fit=crop&w=400&q=80', // White wine
            ],
            (object)[
                'name' => 'Rosé All Day',
                'price' => 42000,
                'description' => 'A refreshing rosé with hints of strawberry.',
                'image_url' => 'https://images.unsplash.com/photo-1464306076886-debca5e8a6b0?auto=format&fit=crop&w=400&q=80', // Rosé wine
            ],
            (object)[
                'name' => 'Pinot Noir Reserve',
                'price' => 52000,
                'description' => 'Elegant and smooth, with aromas of raspberry and spice.',
                'image_url' => 'https://images.unsplash.com/photo-1514361892635-cebb9b6c7ca5?auto=format&fit=crop&w=400&q=80', // Pinot Noir (red)
            ],
            (object)[
                'name' => 'Sauvignon Blanc',
                'price' => 36000,
                'description' => 'Zesty and vibrant, with citrus and tropical fruit notes.',
                'image_url' => 'https://images.unsplash.com/photo-1514361892635-cebb9b6c7ca5?auto=format&fit=crop&w=400&q=80', // White wine
            ],
            (object)[
                'name' => 'Merlot Classic',
                'price' => 47000,
                'description' => 'Soft tannins and flavors of plum and blackberry.',
                'image_url' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=400&q=80', // Merlot (red)
            ],
            (object)[
                'name' => 'Champagne Brut',
                'price' => 85000,
                'description' => 'A sparkling wine with fine bubbles and a dry finish.',
                'image_url' => 'https://images.unsplash.com/photo-1519864600265-abb23847ef2c?auto=format&fit=crop&w=400&q=80', // Champagne
            ],
            (object)[
                'name' => 'Cabernet Sauvignon',
                'price' => 56000,
                'description' => 'Full-bodied with dark fruit flavors and a hint of vanilla.',
                'image_url' => 'https://images.unsplash.com/photo-1502741338009-cac2772e18bc?auto=format&fit=crop&w=400&q=80', // Cabernet (red)
            ],
            (object)[
                'name' => 'Moscato d’Asti',
                'price' => 39000,
                'description' => 'Sweet and lightly sparkling, with peach and floral notes.',
                'image_url' => 'https://images.unsplash.com/photo-1519864600265-abb23847ef2c?auto=format&fit=crop&w=400&q=80', // Moscato (sparkling/sweet)
            ],
            (object)[
                'name' => 'Zinfandel',
                'price' => 53000,
                'description' => 'Rich and jammy, with flavors of blackberry and pepper.',
                'image_url' => 'https://images.unsplash.com/photo-1514361892635-cebb9b6c7ca5?auto=format&fit=crop&w=400&q=80', // Zinfandel (red)
            ],
            (object)[
                'name' => 'Chardonnay',
                'price' => 41000,
                'description' => 'Buttery and oaky, with notes of apple and vanilla.',
                'image_url' => 'https://images.unsplash.com/photo-1510626176961-4b57d4fbad04?auto=format&fit=crop&w=400&q=80', // Chardonnay (white)
            ],
            (object)[
                'name' => 'Prosecco',
                'price' => 48000,
                'description' => 'Italian sparkling wine, light and fruity.',
                'image_url' => 'https://images.unsplash.com/photo-1519864600265-abb23847ef2c?auto=format&fit=crop&w=400&q=80', // Prosecco (sparkling)
            ],
            (object)[
                'name' => 'Port',
                'price' => 60000,
                'description' => 'A rich, sweet fortified wine from Portugal.',
                'image_url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80', // Port (fortified, red)
            ],
            (object)[
                'name' => 'Sauternes',
                'price' => 75000,
                'description' => 'A luscious French dessert wine with honey and apricot notes.',
                'image_url' => 'https://images.unsplash.com/photo-1510626176961-4b57d4fbad04?auto=format&fit=crop&w=400&q=80', // Sauternes (dessert, golden)
            ],
            (object)[
                'name' => 'Orange Wine',
                'price' => 54000,
                'description' => 'A unique amber-hued wine with bold, nutty flavors.',
                'image_url' => 'https://images.unsplash.com/photo-1502741338009-cac2772e18bc?auto=format&fit=crop&w=400&q=80', // Orange wine (amber)
            ],
        ];
        return view('retailer.catalog', compact('wines'));
    }
} 