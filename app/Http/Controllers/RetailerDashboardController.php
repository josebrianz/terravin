<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\Promotion;

class RetailerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders();

        $pendingOrders = $orders->where('status', 'pending')->count();
        $shippedOrders = $orders->where('status', 'shipped')->count();
        $deliveredOrders = $orders->where('status', 'delivered')->count();
        $totalOrders = $orders->count();

        $recentOrders = $orders->latest()->take(5)->get();

        // Fetch notifications from the database for the logged-in retailer
        $notifications = Notification::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Monthly sales data for the current year
        $monthlySales = array_fill(1, 12, 0);
        $ordersThisYear = $user->orders()->whereYear('created_at', now()->year)->get();
        foreach ($ordersThisYear as $order) {
            $month = (int) $order->created_at->format('n');
            $monthlySales[$month] += $order->total_amount;
        }
        $salesLabels = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];
        $salesData = array_values($monthlySales);
        // Only pass up to the current month for a cleaner chart
        $currentMonth = (int) now()->format('n');
        $salesLabels = array_slice($salesLabels, 0, $currentMonth);
        $salesData = array_slice($salesData, 0, $currentMonth);

        // Fetch the current active promotion
        $promotion = Promotion::where('is_active', true)
            ->where(function($query) {
                $today = now()->toDateString();
                $query->whereNull('start_date')->orWhere('start_date', '<=', $today);
            })
            ->where(function($query) {
                $today = now()->toDateString();
                $query->whereNull('end_date')->orWhere('end_date', '>=', $today);
            })
            ->orderByDesc('created_at')
            ->first();

        return view('retailer-dashboard', compact(
            'pendingOrders',
            'shippedOrders',
            'deliveredOrders',
            'totalOrders',
            'recentOrders',
            'notifications',
            'salesLabels',
            'salesData',
            'promotion'
        ));
    }

    public function orders()
    {
        $user = auth()->user();
        $query = $user->orders()->latest();
        if (request('status')) {
            $query->where('status', request('status'));
        }
        $orders = $query->paginate(10);
        return view('retailer.orders', compact('orders'));
    }

    public function showOrder($id)
    {
        $user = auth()->user();
        $order = $user->orders()->where('id', $id)->firstOrFail();
        return view('retailer.order-details', compact('order'));
    }

    public function invoices()
    {
        $user = auth()->user();
        $invoices = Invoice::where('user_id', $user->id)->latest()->paginate(10);
        return view('retailer.invoices', compact('invoices'));
    }

    public function markNotificationRead($id)
    {
        $user = auth()->user();
        $notification = \App\Models\Notification::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        $notification->read_at = now();
        $notification->save();
        return back()->with('success', 'Notification marked as read.');
    }

    public function allNotifications()
    {
        $user = auth()->user();
        $notifications = \App\Models\Notification::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('retailer.all-notifications', compact('notifications'));
    }
} 