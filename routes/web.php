<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\AnalyticsDashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleApprovalController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\VendorApplicationController;
use App\Http\Controllers\HelpController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

use App\Http\Controllers\SalesController;

use Illuminate\Http\Request;
use App\Models\Workforce;
use App\Models\SupplyCentre;
use App\Http\Controllers\VendorController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin-dashboard', function () {
    return view('admin-dashboard');
});

Route::get('/dashboard', function () {
    return view('admin-dashboard');
})->name('dashboard');

Route::get('/admin', function () {
    return view('admin-dashboard');
})->name('admin.dashboard');

Route::get('/application-status', [\App\Http\Controllers\Auth\ApplicationStatusController::class, 'index'])->name('application.status');

// Inventory Routes - Accessible by Admin, Vendor, Retailer
Route::middleware(['auth'])->group(function () {
    Route::resource('inventory', InventoryController::class);
});

// Procurement Routes - Accessible by Admin, Retailer, Vendor, Wholesaler
Route::middleware(['auth', 'role:Admin,Retailer,Vendor,Wholesaler'])->group(function () {
    Route::get('/procurement/dashboard', [ProcurementController::class, 'dashboard'])->name('procurement.dashboard');
    Route::resource('procurement', ProcurementController::class);
    
    // Procurement Status Management Routes
    Route::post('/procurement/{procurement}/approve', [ProcurementController::class, 'approve'])->name('procurement.approve');
    Route::post('/procurement/{procurement}/mark-as-ordered', [ProcurementController::class, 'markAsOrdered'])->name('procurement.markAsOrdered');
    Route::post('/procurement/{procurement}/mark-as-received', [ProcurementController::class, 'markAsReceived'])->name('procurement.markAsReceived');
});

// Order Management Routes - Accessible by Admin, Vendor, Retailer, Customer
Route::middleware(['auth', 'role:Admin,Vendor,Retailer,Customer'])->group(function () {
    Route::resource('orders', OrderController::class);
    Route::post('/orders/place', [OrderController::class, 'store'])->name('orders.place');
    // Route::get('/orders/pending', [OrderController::class, 'pending'])->name('orders.pending'); // moved out for debugging
    Route::get('/catalog', [OrderController::class, 'catalog'])->name('orders.catalog');
    Route::get('/orders/confirmation/{order}', [App\Http\Controllers\OrderController::class, 'confirmation'])->name('orders.confirmation');
});

// Debug: Make /orders/pending public for troubleshooting
Route::get('/orders/pending', [OrderController::class, 'pending'])->name('orders.pending');

// Profile Routes - Accessible by all authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Help Routes - Accessible by all authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/help', [HelpController::class, 'index'])->name('help.index');
});

// Admin Routes - Accessible only by Admin role
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/manage-roles', [RoleController::class, 'index'])->name('admin.manage-roles');
    Route::post('/admin/update-role/{id}', [RoleController::class, 'updateUserRole'])->name('admin.update-role');
    Route::post('/admin/add-user', [RoleController::class, 'createUser'])->name('admin.add-user');
    Route::get('/admin/edit-user/{id}', [RoleController::class, 'editUser'])->name('admin.edit-user');
    Route::post('/admin/edit-user/{id}', [RoleController::class, 'updateUser'])->name('admin.update-user');
    Route::delete('/admin/delete-user/{id}', [RoleController::class, 'deleteUser'])->name('admin.delete-user');
    Route::get('/admin/users-by-role/{role}', [RoleController::class, 'getUsersByRole'])->name('admin.users-by-role');
    Route::get('/admin/role-stats', [RoleController::class, 'getRoleStats'])->name('admin.role-stats');
    
    // Admin user creation routes
    Route::get('/admin/create-user', [RegisteredUserController::class, 'createAdmin'])->name('admin.create-user');
    Route::post('/admin/create-user', [RegisteredUserController::class, 'storeAdmin'])->name('admin.store-user');
    
    // Role approval routes
    Route::get('/admin/role-approvals', [RoleApprovalController::class, 'index'])->name('admin.role-approvals');
    Route::get('/admin/role-approvals/{roleApprovalRequest}', [RoleApprovalController::class, 'show'])->name('admin.role-approval.show');
    Route::post('/admin/role-approvals/{roleApprovalRequest}/approve', [RoleApprovalController::class, 'approve'])->name('admin.role-approval.approve');
    Route::post('/admin/role-approvals/{roleApprovalRequest}/reject', [RoleApprovalController::class, 'reject'])->name('admin.role-approval.reject');
    Route::get('/admin/role-approvals-stats', [RoleApprovalController::class, 'getStats'])->name('admin.role-approval.stats');
    Route::post('/admin/orders/bulk', [\App\Http\Controllers\AdminOrderController::class, 'bulk'])->name('admin.orders.bulk');
    Route::get('/admin/orders/export', [\App\Http\Controllers\AdminOrderController::class, 'export'])->name('admin.orders.export');
    Route::post('/admin/orders/{order}/admin-notes', [\App\Http\Controllers\AdminOrderController::class, 'updateAdminNotes'])->name('admin.orders.update-admin-notes');
    Route::get('/admin/orders/{order}/invoice', [\App\Http\Controllers\AdminOrderController::class, 'invoice'])->name('admin.orders.invoice');
    Route::post('/admin/orders/{order}/assign', [\App\Http\Controllers\AdminOrderController::class, 'updateAssignment'])->name('admin.orders.update-assignment');
});

// Chat routes (only for wholesalers and customers)
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index')->middleware('role:Admin,Wholesaler,Customer');
    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show')->middleware('role:Admin,Wholesaler,Customer');
    Route::post('/chat/{user}', [ChatController::class, 'store'])->name('chat.store')->middleware('role:Admin,Wholesaler,Customer');
});

Route::delete('/chat/message/{id}', [\App\Http\Controllers\ChatController::class, 'deleteMessage'])->middleware('auth');
Route::patch('/chat/message/{id}', [\App\Http\Controllers\ChatController::class, 'editMessage'])->middleware('auth');

Route::get('/vendor/apply', [VendorApplicationController::class, 'create'])->name('vendor.apply');

Route::get('/vendor/apply',[VendorApplicationController::class,'create'])->name('vendor.apply');
Route::post('/vendor/submit',[VendorApplicationController::class,'submit'])->name('vendor.submit');
Route::get('/vendor/waiting',[VendorApplicationController::class,'waiting'])->name('vendor.waiting');
//Route::view('/vendor/apply', 'vendor.apply');
//Route::post('/vendor/submit', [VendorFormController::class, 'submit']);
Route::get('/vendor/apply', [VendorController::class, 'showApplicationForm'])->name('vendor.apply');
Route::post('/vendor/apply', [VendorController::class, 'submitVendorApplication'])->name('vendor.submit');
// Retailer Dashboard Route
Route::middleware(['auth', 'role:Retailer'])->group(function () {
    Route::get('/retailer/dashboard', [\App\Http\Controllers\RetailerDashboardController::class, 'index'])->name('retailer.dashboard');
    Route::get('/retailer/inventory', [\App\Http\Controllers\RetailerInventoryController::class, 'index'])->name('retailer.inventory');
});

  // Retailer Product Catalog Route
  Route::get('/retailer/catalog', function () {
      // Get all available products from vendors/wholesalers
      $products = \App\Models\Inventory::where('is_active', true)
          ->where('quantity', '>', 0)
          ->orderBy('name')
          ->get();
      
      // Get unique categories
      $categories = \App\Models\Inventory::where('is_active', true)
          ->where('quantity', '>', 0)
          ->distinct()
          ->pluck('category')
          ->filter()
          ->values();
      
          // Get vendors (users with Wholesaler role)
    $vendors = \App\Models\User::where('role', 'Wholesaler')->get();
      
      return view('retailer.catalog', compact('products', 'categories', 'vendors'));
  })->name('retailer.catalog')->middleware(['auth', 'role:Retailer']);

// Cart functionality for retailers
Route::post('/retailer/cart/add', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'wine_id' => 'required|exists:inventories,id',
        'quantity' => 'required|integer|min:1'
    ]);
    
    // Add to cart (you can implement this using session or database)
    $cart = session()->get('retailer_cart', []);
    $productId = $request->wine_id;
    
    if (isset($cart[$productId])) {
        $cart[$productId] += $request->quantity;
    } else {
        $cart[$productId] = $request->quantity;
    }
    
    session()->put('retailer_cart', $cart);
    
    return response()->json(['success' => true]);
})->middleware(['auth', 'role:Retailer']);

Route::post('/retailer/cart/update', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'wine_id' => 'required|exists:inventories,id',
        'quantity' => 'required|integer|min:1'
    ]);
    $cart = session()->get('retailer_cart', []);
    $productId = $request->wine_id;
    if (isset($cart[$productId])) {
        $cart[$productId] = $request->quantity;
        session()->put('retailer_cart', $cart);

        // Calculate new subtotal and total
        $product = \App\Models\Inventory::find($productId);
        $subtotal = $product ? $product->unit_price * $cart[$productId] : 0;

        $total = 0;
        foreach ($cart as $pid => $qty) {
            $p = \App\Models\Inventory::find($pid);
            if ($p) $total += $p->unit_price * $qty;
        }

        return response()->json([
            'success' => true,
            'subtotal' => number_format($subtotal, 2),
            'total' => number_format($total, 2),
            'quantity' => $cart[$productId]
        ]);
    }
    return response()->json(['success' => false, 'message' => 'Item not found in cart']);
})->middleware(['auth', 'role:Retailer']);

Route::get('/retailer/cart', function () {
    $cart = session()->get('retailer_cart', []);
    $cartItems = [];
    $total = 0;
    
    foreach ($cart as $productId => $quantity) {
        $product = \App\Models\Inventory::find($productId);
        if ($product) {
            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $product->unit_price * $quantity
            ];
            $total += $product->unit_price * $quantity;
        }
    }
    
    return view('retailer.cart', compact('cartItems', 'total'));
})->name('retailer.cart')->middleware(['auth', 'role:Retailer']);

Route::post('/retailer/cart/remove', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'wine_id' => 'required|exists:inventories,id'
    ]);
    
    $cart = session()->get('retailer_cart', []);
    $productId = $request->wine_id;
    
    if (isset($cart[$productId])) {
        unset($cart[$productId]);
        session()->put('retailer_cart', $cart);
    }
    
    return response()->json(['success' => true]);
})->middleware(['auth', 'role:Retailer']);

Route::post('/retailer/cart/clear', function () {
    session()->forget('retailer_cart');
    return response()->json(['success' => true]);
})->middleware(['auth', 'role:Retailer']);

Route::post('/retailer/checkout', function (\Illuminate\Http\Request $request) {
    $cart = session()->get('retailer_cart', []);
    if (empty($cart)) {
        return redirect()->back()->with('error', 'Cart is empty');
    }
    try {
        \DB::beginTransaction();
        // Create the order
        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'customer_name' => auth()->user()->name,
            'customer_email' => auth()->user()->email,
            'customer_phone' => '',
            'status' => 'pending',
            'total_amount' => 0,
            'payment_method' => $request->input('payment_method', 'Cash on Delivery'),
            'shipping_address' => $request->input('shipping_address', ''),
            'notes' => $request->input('notes', null),
        ]);
        $totalAmount = 0;
        // Create order items
        foreach ($cart as $productId => $quantity) {
            $product = \App\Models\Inventory::find($productId);
            if ($product && $product->quantity >= $quantity) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'inventory_id' => $productId,
                    'item_name' => $product->name,
                    'quantity' => $quantity,
                    'unit_price' => $product->unit_price,
                    'total_price' => $product->unit_price * $quantity,
                    'subtotal' => $product->unit_price * $quantity,
                ]);
                $totalAmount += $product->unit_price * $quantity;
                // Update inventory quantity
                $product->decrement('quantity', $quantity);
            }
        }
        // Update order total
        $order->update(['total_amount' => $totalAmount]);
        // Clear the cart
        session()->forget('retailer_cart');
        \DB::commit();
        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    } catch (\Exception $e) {
        \DB::rollback();
        return redirect()->back()->with('error', 'Error placing order: ' . $e->getMessage());
    }
})->middleware(['auth', 'role:Retailer']);

Route::get('/retailer/checkout', function () {
    // You can customize this view as needed
    return view('retailer.checkout');
})->middleware(['auth', 'role:Retailer'])->name('retailer.checkout');

// Retailer Wine Catalog Route
Route::get('/retailer/catalog', [App\Http\Controllers\RetailerCatalogController::class, 'index'])->name('retailer.catalog');


// Reports Route - Accessible by authenticated users
// Route::middleware('auth')->group(function () {
//     Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
// });


// Financial Reports Route - Accessible by all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/financial-reports', [App\Http\Controllers\FinancialReportController::class, 'index'])->name('financial-reports.index');
});

// Workforce Dashboard Route
Route::get('/workforce/dashboard', function () {
    $workforces = \App\Models\Workforce::with('supplyCentres')->get();
    $supplyCentres = \App\Models\SupplyCentre::with('workforces')->get();
    $total = $workforces->count();
    $assigned = $workforces->where('status', 'assigned')->count();
    $available = $workforces->where('status', 'available')->count();
    return view('workforce.dashboard', compact('workforces', 'supplyCentres', 'total', 'assigned', 'available'));
})->name('workforce.dashboard');

// Add Workforce
Route::post('/workforce', function(Request $request) {
    Workforce::create($request->only('name', 'role', 'status', 'contact'));
    return redirect()->back()->with('success', 'Workforce added!');
})->name('workforce.store');

// Add Supply Centre
Route::post('/supplycentre', function(Request $request) {
    SupplyCentre::create($request->only('name', 'location'));
    return redirect()->back()->with('success', 'Supply centre added!');
})->name('supplycentre.store');

// Assign Workforce to Supply Centre
Route::post('/workforce/assign', function(Request $request) {
    $workforce = Workforce::findOrFail($request->workforce_id);
    $workforce->supplyCentres()->syncWithoutDetaching([
        $request->supply_centre_id => ['assigned_at' => now()]
    ]);
    $workforce->supplyCentres()->updateExistingPivot($request->supply_centre_id, ['assigned_at' => now()]);
    $workforce->status = 'assigned';
    $workforce->save();
    return redirect()->back()->with('success', 'Workforce assigned!');
})->name('workforce.assign');

// Unassign Workforce from Supply Centre
Route::post('/workforce/unassign', function(Request $request) {
    $workforce = Workforce::findOrFail($request->workforce_id);
    $workforce->supplyCentres()->detach($request->supply_centre_id);
    // Optionally update status if no more assignments
    if ($workforce->supplyCentres()->count() == 0) {
        $workforce->status = 'available';
        $workforce->save();
    }
    return redirect()->back()->with('success', 'Workforce unassigned!');
})->name('workforce.unassign');

// Delete Workforce
Route::delete('/workforce/{id}', function($id) {
    Workforce::destroy($id);
    return redirect()->back()->with('success', 'Workforce deleted!');
})->name('workforce.delete');

// Delete Supply Centre
Route::delete('/supplycentre/{id}', function($id) {
    SupplyCentre::destroy($id);
    return redirect()->back()->with('success', 'Supply centre deleted!');
})->name('supplycentre.delete');

// Auto-Assign Workforce to Supply Centres with No Workers
Route::post('/workforce/auto-assign', function() {
    $availableWorkforce = \App\Models\Workforce::where('status', 'available')->get();
    $emptyCentres = \App\Models\SupplyCentre::doesntHave('workforces')->get();
    $assigned = 0;
    foreach ($emptyCentres as $centre) {
        $worker = $availableWorkforce->shift();
        if ($worker) {
            $worker->supplyCentres()->attach($centre->id, ['assigned_at' => now()]);
            $worker->status = 'assigned';
            $worker->save();
            $assigned++;
        } else {
            break;
        }
    }
    return redirect()->back()->with('success', $assigned . ' workforce assigned to empty supply centres.');
})->name('workforce.autoassign');


Route::get('/stakeholders', function (Request $request) {
    $view = $request->query('view', 'index');
    $id = $request->query('id');

    switch ($view) {
        case 'create':
            return view('stakeholders.create');
        case 'edit':
            if ($id) {
                $stakeholder = \App\Models\Stakeholder::findOrFail($id);
                return view('stakeholders.edit', compact('stakeholder'));
            }
            abort(404);
        case 'index':
        default:
            $stakeholders = \App\Models\Stakeholder::all();
            return view('stakeholders.index', compact('stakeholders'));
    }
})->name('stakeholders.unified');

// Store new stakeholder
Route::post('/stakeholders', function(Illuminate\Http\Request $request) {
    \App\Models\Stakeholder::create($request->only('name', 'email', 'role'));
    return redirect()->back()->with('success', 'Stakeholder added!');
})->name('stakeholders.store');

// Update stakeholder
Route::put('/stakeholders/{id}', function(Illuminate\Http\Request $request, $id) {
    $stakeholder = \App\Models\Stakeholder::findOrFail($id);
    $stakeholder->update($request->only('name', 'email', 'role'));
    return redirect()->back()->with('success', 'Stakeholder updated!');
})->name('stakeholders.update');

// Delete stakeholder
Route::delete('/stakeholders/{id}', function($id) {
    \App\Models\Stakeholder::destroy($id);
    return redirect()->back()->with('success', 'Stakeholder deleted!');
})->name('stakeholders.destroy');

// Save preferences
Route::post('/stakeholders/preferences', function(Illuminate\Http\Request $request) {
    // Save preferences logic here (customize as needed)
    // Example: \App\Models\Preference::updateOrCreate([...], [...]);
    return redirect()->back()->with('success', 'Preferences saved!');
})->name('stakeholders.preferences');

Route::post('/stakeholders/{id}/preferences', [App\Http\Controllers\StakeholderController::class, 'updatePreferences'])->name('stakeholders.preferences.update');

Route::get('/stakeholders/dashboard', [App\Http\Controllers\StakeholderController::class, 'dashboard'])->name('stakeholders.dashboard');

Route::middleware(['auth', 'role:Vendor,Supplier,Admin'])->group(function () {
    Route::get('/my-report', [App\Http\Controllers\StakeholderController::class, 'showReports'])->name('my.report');
});


require __DIR__.'/auth.php';

// Analytics Dashboard Routes - Accessible by Admin (add more roles/permissions as needed)
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/analytics/dashboard', [AnalyticsDashboardController::class, 'index'])->name('analytics.dashboard');
    Route::post('/predict-sales', [AnalyticsDashboardController::class, 'predictSales'])->name('predict.sales');
});

// Vendor Dashboard Route - Accessible only by Vendor role
Route::middleware(['auth', 'role:Vendor'])->group(function () {
    Route::get('/vendor/dashboard', [App\Http\Controllers\VendorDashboardController::class, 'index'])->name('vendor.dashboard');
});

// Vendor Orders Resource Routes - Accessible only by Vendor role
Route::middleware(['auth', 'role:Vendor'])->group(function () {
    Route::resource('vendor/orders', App\Http\Controllers\VendorOrderController::class)->names('vendor.orders');
});

// Vendor Order Management Routes - Accessible by Vendor only
Route::middleware(['auth', 'role:Vendor'])->group(function () {
    Route::get('/vendor/orders', [\App\Http\Controllers\VendorOrderController::class, 'index'])->name('vendor.orders.index');
});

// Vendor Finance Route - Accessible only by Vendor role
Route::middleware(['auth', 'role:Vendor'])->group(function () {
    Route::get('/vendor/finance', [App\Http\Controllers\VendorFinanceController::class, 'index'])->name('vendor.finance');
});

// Vendor Reports Route - Accessible only by Vendor role
Route::middleware(['auth', 'role:Vendor'])->group(function () {
    Route::get('/vendor/reports', [App\Http\Controllers\VendorReportController::class, 'index'])->name('vendor.reports');
});

// Vendor Messages Route - Accessible only by Vendor role
Route::middleware(['auth', 'role:Vendor'])->group(function () {
    Route::get('/vendor/messages', [App\Http\Controllers\VendorMessageController::class, 'index'])->name('vendor.messages');
});

// Vendor Contracts Route - Accessible only by Vendor role
Route::middleware(['auth', 'role:Vendor'])->group(function () {
    Route::get('/vendor/contracts', [App\Http\Controllers\VendorContractController::class, 'index'])->name('vendor.contracts');
});

// Wholesaler Dashboard Route - Accessible only by Wholesaler role
// Route::middleware(['auth', 'role:Wholesaler'])->group(function () {
//     Route::get('/wholesaler/dashboard', [App\Http\Controllers\WholesalerDashboardController::class, 'index'])->name('wholesaler.dashboard');
// });

// Batch Management Routes - Accessible by all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::resource('batches', App\Http\Controllers\BatchController::class);
});

// Pricing Management Route - Accessible by all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/pricing', [App\Http\Controllers\PricingController::class, 'index'])->name('pricing.index');
});

// Compliance Document Management Routes - Accessible by all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::resource('compliance-documents', App\Http\Controllers\ComplianceDocumentController::class);
});

// Customer Products Page - All products for customers
Route::middleware(['auth', 'role:Customer'])->group(function () {
    Route::get('/customer/products', [App\Http\Controllers\OrderController::class, 'catalog'])->name('customer.products');
});

// Customer Dashboard Route - Accessible only by Customer role
Route::middleware(['auth', 'role:Customer'])->group(function () {
    Route::get('/customer/dashboard', function () {
        return view('customer-dashboard');
    })->name('customer.dashboard');
});

// Customer Order History Page - Only customer's own orders
Route::middleware(['auth', 'role:Customer'])->group(function () {
    Route::get('/customer/orders', [App\Http\Controllers\OrderController::class, 'customerOrders'])->name('customer.orders');
});

// Customer Favorites Placeholder Page
Route::middleware(['auth', 'role:Customer'])->group(function () {
    Route::get('/customer/favorites', function () {
        return view('customer.favorites');
    })->name('customer.favorites');
});

// Blade test route
Route::get('/test-blade', function () {
    return view('test');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/orders/history', [App\Http\Controllers\OrderController::class, 'history'])->name('orders.history');
});

// Cart Routes - Authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
});

Route::get('/workforce/assignments', [App\Http\Controllers\WorkforceDashboardController::class, 'assignments'])->name('workforce.assignments');

// Forecast Routes
Route::get('/forecast', [SalesController::class, 'dashboard'])->name('forecast.dashboard');
Route::post('/forecast/predict', [SalesController::class, 'predictCategory'])->name('forecast.predict');
Route::get('/forecast/download', [SalesController::class, 'downloadForecastCsv'])->name('forecast.download');

// Logistics Module - Admin Only
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/logistics/dashboard', [\App\Http\Controllers\LogisticsDashboardController::class, 'index'])->name('logistics.dashboard');
    Route::get('/shipments', [\App\Http\Controllers\LogisticsDashboardController::class, 'shipmentsIndex'])->name('shipments.index');
    Route::resource('shipments', \App\Http\Controllers\LogisticsDashboardController::class)->except(['index']); // index handled by dashboard
}); 

Route::get('/retailer/help', function () {
    return view('help.retailer');
})->name('help.retailer'); 

// Vendor Inventory Management Route - Accessible by Vendor only
Route::middleware(['auth', 'role:Vendor'])->group(function () {
    Route::get('/vendor/inventory', [\App\Http\Controllers\VendorInventoryController::class, 'index'])->name('vendor.inventory.index');
}); 

// Supplier Dashboard Route - Accessible only by Supplier role
Route::middleware(['auth', 'role:Supplier'])->group(function () {
    Route::get('/supplier/dashboard', function () {
        return view('supplier.dashboard');
    })->name('supplier.dashboard');
}); 

// Supplier Raw Materials Route - Accessible only by Supplier role
Route::middleware(['auth', 'role:Supplier'])->group(function () {
    Route::get('/supplier/raw-materials', function () {
        return view('supplier.raw-materials');
    })->name('supplier.raw-materials');
}); 

// Supplier Orders Route - Accessible only by Supplier role
Route::middleware(['auth', 'role:Supplier'])->group(function () {
    Route::get('/supplier/orders', function () {
        return view('supplier.orders');
    })->name('supplier.orders');
}); 

// Supplier Order Details Route - Accessible only by Supplier role
Route::middleware(['auth', 'role:Supplier'])->group(function () {
    Route::get('/supplier/orders/{order}', function ($order) {
        return view('supplier.orders-show', ['orderId' => $order]);
    })->name('supplier.orders.show');
}); 

// Supplier Reports Route - Accessible only by Supplier role
use App\Http\Controllers\SupplierReportController;
Route::middleware(['auth', 'role:Supplier'])->group(function () {
    Route::get('/supplier/reports', [SupplierReportController::class, 'index'])->name('supplier.reports');
}); 

// Supplier Reports API Route - returns live data as JSON for AJAX polling
Route::middleware(['auth:sanctum', 'role:Supplier'])->get('/api/supplier/reports', [App\Http\Controllers\SupplierReportController::class, 'apiIndex']);

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/stakeholders/{id}/reports', [App\Http\Controllers\StakeholderController::class, 'showReportsForStakeholder'])->name('stakeholders.reports');
});

