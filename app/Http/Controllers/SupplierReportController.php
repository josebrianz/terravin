<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierReportController extends Controller
{
    public function index()
    {
        $supplier = Auth::user();
        
        // Get real procurement orders for this supplier
        $procurements = \App\Models\Procurement::where('wholesaler_name', $supplier->name);
        
        // Calculate real supply stats
        $supplyStats = [
            'totalOrders' => $procurements->count(),
            'pendingOrders' => $procurements->where('status', 'pending')->count(),
            'deliveredOrders' => $procurements->where('status', 'received')->count(),
            'outOfStock' => \App\Models\SupplierRawMaterial::where('user_id', $supplier->id)
                ->whereRaw('CAST(SUBSTRING_INDEX(stock_level, " ", 1) AS UNSIGNED) <= 0')
                ->count(),
        ];
        
        // Get real raw materials for this supplier
        $rawMaterials = \App\Models\SupplierRawMaterial::where('user_id', $supplier->id)
            ->select('name', 'stock_level as stock', 'category as unit')
            ->get()
            ->map(function($material) {
                return [
                    'name' => $material->name,
                    'stock' => $material->stock,
                    'unit' => $material->unit
                ];
            });
        
        // Get recent orders for this supplier
        $recentOrders = $procurements->latest()->take(10)->get()->map(function($procurement) {
            return [
                'id' => $procurement->id,
                'items' => $procurement->item_name,
                'date' => $procurement->created_at->toDateString(),
                'status' => ucfirst($procurement->status),
            ];
        });
        
        return view('supplier.reports', compact('rawMaterials', 'recentOrders', 'supplyStats'));
    }

    public function apiIndex()
    {
        $supplier = Auth::user();
        
        // Get real procurement orders for this supplier
        $procurements = \App\Models\Procurement::where('wholesaler_name', $supplier->name);
        
        // Calculate real supply stats
        $supplyStats = [
            'totalOrders' => $procurements->count(),
            'pendingOrders' => $procurements->where('status', 'pending')->count(),
            'deliveredOrders' => $procurements->where('status', 'received')->count(),
            'outOfStock' => \App\Models\SupplierRawMaterial::where('user_id', $supplier->id)
                ->whereRaw('CAST(SUBSTRING_INDEX(stock_level, " ", 1) AS UNSIGNED) <= 0')
                ->count(),
        ];
        
        // Get real raw materials for this supplier
        $rawMaterials = \App\Models\SupplierRawMaterial::where('user_id', $supplier->id)
            ->select('name', 'stock_level as stock', 'category as unit')
            ->get()
            ->map(function($material) {
                return [
                    'name' => $material->name,
                    'stock' => $material->stock,
                    'unit' => $material->unit
                ];
            });
        
        // Get recent orders for this supplier
        $recentOrders = $procurements->latest()->take(10)->get()->map(function($procurement) {
            return [
                'id' => $procurement->id,
                'items' => $procurement->item_name,
                'date' => $procurement->created_at->toDateString(),
                'status' => ucfirst($procurement->status),
            ];
        });
        
        return response()->json([
            'rawMaterials' => $rawMaterials,
            'recentOrders' => $recentOrders,
            'supplyStats' => $supplyStats,
        ]);
    }
} 