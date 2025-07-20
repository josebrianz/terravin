<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory;
use App\Models\Procurement;

class AnalyticsDashboardController extends Controller
{
    /**
     * Display the analytics dashboard with KPIs and charts.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            // Get year filter from request, default to current year
            $selectedYear = $request->get('year', now()->year);

            // Fetch KPIs with error handling
            $kpis = $this->getKPIs($selectedYear);
            
            // Fetch chart data
            $chartData = $this->getChartData($selectedYear);

            return view('analytics.dashboard', array_merge($kpis, $chartData));

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Analytics Dashboard Error: ' . $e->getMessage());
            
            // Return view with error message
            return view('analytics.dashboard', [
                'error' => 'Unable to load analytics data. Please try again later.',
                'totalSales' => 0,
                'totalCustomers' => 0,
                'totalRevenue' => 0,
                'topProduct' => 'N/A',
                'salesRevenueData' => ['labels' => [], 'sales' => [], 'revenue' => []],
                'customerSegmentsData' => ['labels' => [], 'data' => []],
                'topProductsData' => ['labels' => [], 'data' => []],
                'monthlyOrdersData' => ['labels' => [], 'data' => []],
            ]);
        }
    }

    /**
     * Get Key Performance Indicators.
     *
     * @param int $year
     * @return array
     */
    private function getKPIs(int $year): array
    {
        // Total sales (orders) for the selected year
        $totalSales = Order::whereYear('created_at', $year)->count();
        
        // Total customers (users with Customer role)
        $totalCustomers = User::where('role', 'Customer')->count();
        
        // Total revenue for the selected year
        $totalRevenue = Order::whereYear('created_at', $year)->sum('total_amount');
        
        // Top selling product for the selected year
        $topProduct = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereYear('orders.created_at', $year)
            ->select('order_items.item_name')
            ->groupBy('order_items.item_name')
            ->orderByRaw('SUM(order_items.quantity) DESC')
            ->limit(1)
            ->value('item_name') ?? 'N/A';

        return [
            'totalSales' => $totalSales,
            'totalCustomers' => $totalCustomers,
            'totalRevenue' => $totalRevenue,
            'topProduct' => $topProduct,
        ];
    }

    /**
     * Get chart data for analytics dashboard.
     *
     * @param int $year
     * @return array
     */
    private function getChartData(int $year): array
    {
        // Sales & Revenue by Month
        $monthlyData = Order::whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue, COUNT(*) as sales')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];

        $salesRevenueData = [
            'labels' => array_values($months),
            'sales' => array_map(fn($i) => $monthlyData[$i + 1]->sales ?? 0, array_keys($months)),
            'revenue' => array_map(fn($i) => $monthlyData[$i + 1]->revenue ?? 0, array_keys($months)),
        ];

        // Customer Segments (real data from users table)
        $customerSegments = User::select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->get();
        $customerSegmentsData = [
            'labels' => $customerSegments->pluck('role')->toArray(),
            'data' => $customerSegments->pluck('count')->toArray(),
        ];

        // Top 5 Products Sold
        $topProducts = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereYear('orders.created_at', $year)
            ->select('order_items.item_name')
            ->selectRaw('SUM(order_items.quantity) as total_sold')
            ->groupBy('order_items.item_name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        $topProductsData = [
            'labels' => $topProducts->pluck('item_name')->toArray(),
            'data' => $topProducts->pluck('total_sold')->toArray(),
        ];

        // Monthly Orders
        $monthlyOrders = Order::whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $monthlyOrdersData = [
            'labels' => array_values($months),
            'data' => array_map(fn($i) => $monthlyOrders[$i + 1]->count ?? 0, array_keys($months)),
        ];

        // Inventory by Category
        $inventoryByCategory = DB::table('inventories')
            ->select('category', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('category')
            ->orderByDesc('total_quantity')
            ->get();
        $inventoryCategoryData = [
            'labels' => $inventoryByCategory->pluck('category')->toArray(),
            'data' => $inventoryByCategory->pluck('total_quantity')->toArray(),
        ];

        // Inventory by Stock
        $inventoryStockData = [
            'labels' => Inventory::pluck('name')->toArray(),
            'data' => Inventory::pluck('quantity')->toArray(),
        ];

        // Inventory by Category
        $inventoryByCategory = Inventory::select('category', DB::raw('SUM(quantity) as total'))
            ->groupBy('category')
            ->get();
        $inventoryCategoryData = [
            'labels' => $inventoryByCategory->pluck('category')->toArray(),
            'data' => $inventoryByCategory->pluck('total')->toArray(),
        ];

        // Orders per Month
        $orders = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();
        $orderLabels = [];
        $orderData = [];
        foreach (range(1, 12) as $m) {
            $orderLabels[] = date('F', mktime(0, 0, 0, $m, 1));
            $orderData[] = $orders->firstWhere('month', $m)->count ?? 0;
        }
        $ordersData = [
            'labels' => $orderLabels,
            'data' => $orderData,
        ];

        // Procurement per Month
        $procurements = Procurement::select(
                DB::raw('MONTH(order_date) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('order_date', $year)
            ->groupBy(DB::raw('MONTH(order_date)'))
            ->orderBy('month')
            ->get();
        $procurementLabels = [];
        $procurementData = [];
        foreach (range(1, 12) as $m) {
            $procurementLabels[] = date('F', mktime(0, 0, 0, $m, 1));
            $procurementData[] = $procurements->firstWhere('month', $m)->count ?? 0;
        }
        $procurementChartData = [
            'labels' => $procurementLabels,
            'data' => $procurementData,
        ];

        return [
            'salesRevenueData' => $salesRevenueData,
            'customerSegmentsData' => $customerSegmentsData,
            'topProductsData' => $topProductsData,
            'monthlyOrdersData' => $monthlyOrdersData,
            'inventoryCategoryData' => $inventoryCategoryData,
            'inventoryStockData' => $inventoryStockData,
            'ordersData' => $ordersData,
            'procurementData' => $procurementChartData,
        ];
    }

    /**
     * Predict sales using the Flask API.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function predictSales(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'year'              => 'required|integer|min:2020|max:2030',
            'month'             => 'required|integer|min:1|max:12',
            'supplier'          => 'required|string|max:255',
            'item_description'  => 'required|string|max:255',
            'item_type'         => 'required|string|max:100',
            'retail_transfers'  => 'required|numeric|min:0',
            'warehouse_sales'   => 'required|numeric|min:0',
        ], [
            'year.min' => 'Year must be 2020 or later.',
            'year.max' => 'Year cannot be later than 2030.',
            'month.min' => 'Month must be between 1 and 12.',
            'month.max' => 'Month must be between 1 and 12.',
            'retail_transfers.min' => 'Retail transfers cannot be negative.',
            'warehouse_sales.min' => 'Warehouse sales cannot be negative.',
        ]);

        try {
            // Prepare data for Flask API
            $apiData = [
                'year'              => $validatedData['year'],
                'month'             => $validatedData['month'],
                'supplier'          => $validatedData['supplier'],
                'item_description'  => $validatedData['item_description'],
                'item_type'         => $validatedData['item_type'],
                'retail_transfers'  => (float)$validatedData['retail_transfers'],
                'warehouse_sales'   => (float)$validatedData['warehouse_sales']
            ];

            // Send request to Flask API with timeout
            $response = Http::timeout(30)->post('http://127.0.0.1:5000/predict', $apiData);

            if ($response->successful()) {
                $predictedSales = $response->json()['predicted_sales'] ?? null;

                if ($predictedSales !== null && is_numeric($predictedSales)) {
                    // Get fresh dashboard data for the view
                    $dashboardData = array_merge(
                        $this->getKPIs(now()->year),
                        $this->getChartData(now()->year)
                    );
                    
                    return view('analytics.dashboard', array_merge($dashboardData, [
                        'predicted_sales' => $predictedSales,
                        'success' => 'Sales prediction generated successfully!'
                    ]));
                } else {
                    return back()->with('error', 'Invalid prediction response from the service.');
                }
            } else {
                $errorMessage = $response->json()['error'] ?? 'Unknown error from prediction service.';
                return back()->with('error', 'Prediction failed: ' . $errorMessage);
            }

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return back()->with('error', 'Could not connect to the prediction service. Please ensure your Python Flask API is running at http://127.0.0.1:5000.');
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return back()->with('error', 'Request to prediction service failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            \Log::error('Sales Prediction Error: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    /**
     * Generate datasets for the new analytics dashboard charts.
     *
     * @return array
     */
    public function dashboard()
    {
        // Inventory by Stock
        $inventoryStockData = [
            'labels' => Inventory::pluck('name')->toArray(),
            'data' => Inventory::pluck('quantity')->toArray(),
        ];

        // Inventory by Category
        $inventoryByCategory = Inventory::select('category', DB::raw('SUM(quantity) as total'))
            ->groupBy('category')
            ->get();
        $inventoryCategoryData = [
            'labels' => $inventoryByCategory->pluck('category')->toArray(),
            'data' => $inventoryByCategory->pluck('total')->toArray(),
        ];

        // Orders per Month (current year)
        $orders = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();
        $orderLabels = [];
        $orderData = [];
        foreach (range(1, 12) as $m) {
            $orderLabels[] = date('F', mktime(0, 0, 0, $m, 1));
            $orderData[] = $orders->firstWhere('month', $m)->count ?? 0;
        }
        $ordersData = [
            'labels' => $orderLabels,
            'data' => $orderData,
        ];

        // Procurement per Month (current year)
        $procurements = Procurement::select(
                DB::raw('MONTH(order_date) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('order_date', now()->year)
            ->groupBy(DB::raw('MONTH(order_date)'))
            ->orderBy('month')
            ->get();
        $procurementLabels = [];
        $procurementData = [];
        foreach (range(1, 12) as $m) {
            $procurementLabels[] = date('F', mktime(0, 0, 0, $m, 1));
            $procurementData[] = $procurements->firstWhere('month', $m)->count ?? 0;
        }
        $procurementChartData = [
            'labels' => $procurementLabels,
            'data' => $procurementData,
        ];

        // Pass to view
        return view('analytics.dashboard', [
            // ...other data...
            'inventoryStockData' => $inventoryStockData,
            'inventoryCategoryData' => $inventoryCategoryData,
            'ordersData' => $ordersData,
            'procurementData' => $procurementChartData,
        ]);
    }
} 