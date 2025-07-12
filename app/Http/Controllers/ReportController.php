<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Inventory;
use App\Models\Procurement;

class ReportController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalInventory = Inventory::count();
        $totalProcurements = class_exists(Procurement::class) ? Procurement::count() : null;
        return view('reports.index', compact('totalOrders', 'totalInventory', 'totalProcurements'));
    }
}

