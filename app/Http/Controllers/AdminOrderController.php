<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\AuditLog;
use App\Models\User;

class AdminOrderController extends Controller
{
    // List all orders
    public function index(Request $request)
    {
        $query = Order::query();

        // Filtering
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('customer_name')) {
            $query->where('customer_name', 'like', '%' . $request->customer_name . '%');
        }
        if ($request->filled('customer_email')) {
            $query->where('customer_email', 'like', '%' . $request->customer_email . '%');
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('min_amount')) {
            $query->where('total_amount', '>=', $request->min_amount);
        }
        if ($request->filled('max_amount')) {
            $query->where('total_amount', '<=', $request->max_amount);
        }

        $orders = $query->with('items')->latest()->paginate(20)->appends($request->all());
        return view('admin.orders.index', compact('orders'));
    }

    // Show order details
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        $shipment = $order->shipment;
        $auditLogs = \App\Models\AuditLog::where('resource_type', 'order')->where('resource_id', $order->id)->orderBy('created_at', 'desc')->get();
        return view('admin.orders.show', compact('order', 'shipment', 'auditLogs'));
    }

    // Update order status
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);
        $old = $order->only(['status']);
        $order->status = $request->status;
        $order->save();
        AuditLog::logOrderChange($order, $old, ['status' => $order->status], $request->user(), 'order_status_updated');
        return redirect()->back()->with('success', 'Order status updated.');
    }

    // Update admin notes
    public function updateAdminNotes(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'admin_notes' => 'nullable|string',
        ]);
        $old = $order->only(['admin_notes']);
        $order->admin_notes = $request->admin_notes;
        $order->save();
        AuditLog::logOrderChange($order, $old, ['admin_notes' => $order->admin_notes], $request->user(), 'order_admin_notes_updated');
        return redirect()->back()->with('success', 'Admin notes updated.');
    }

    // Update assignment
    public function updateAssignment(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        $old = $order->only(['assigned_to']);
        $order->assigned_to = $request->assigned_to;
        $order->save();
        \App\Models\AuditLog::logOrderChange($order, $old, ['assigned_to' => $order->assigned_to], $request->user(), 'order_assigned');
        return redirect()->back()->with('success', 'Order assignment updated.');
    }

    // Delete/cancel order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted.');
    }

    // Bulk actions for orders
    public function bulk(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'action' => 'required|string',
        ]);
        $orderIds = $request->order_ids;
        $action = $request->action;
        $count = 0;
        if ($action === 'update_status') {
            $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);
            $count = Order::whereIn('id', $orderIds)->update(['status' => $request->status]);
            return redirect()->back()->with('success', "$count orders updated to status '{$request->status}'.");
        } elseif ($action === 'delete') {
            $count = Order::whereIn('id', $orderIds)->delete();
            return redirect()->back()->with('success', "$count orders deleted.");
        }
        return redirect()->back()->with('error', 'Invalid bulk action.');
    }

    // Export orders as CSV or Excel
    public function export(Request $request)
    {
        $query = Order::query();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('customer_name')) {
            $query->where('customer_name', 'like', '%' . $request->customer_name . '%');
        }
        if ($request->filled('customer_email')) {
            $query->where('customer_email', 'like', '%' . $request->customer_email . '%');
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('min_amount')) {
            $query->where('total_amount', '>=', $request->min_amount);
        }
        if ($request->filled('max_amount')) {
            $query->where('total_amount', '<=', $request->max_amount);
        }
        $orders = $query->latest()->get();
        $format = $request->input('format', 'csv');
        $filename = 'orders_' . now()->format('Ymd_His');
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename.csv\"",
        ];
        $fields = ['id', 'customer_name', 'customer_email', 'status', 'total_amount', 'created_at'];
        if ($format === 'csv') {
            $callback = function() use ($orders, $fields) {
                $out = fopen('php://output', 'w');
                fputcsv($out, $fields);
                foreach ($orders as $order) {
                    fputcsv($out, [
                        $order->id,
                        $order->customer_name,
                        $order->customer_email,
                        $order->status,
                        $order->total_amount,
                        $order->created_at,
                    ]);
                }
                fclose($out);
            };
            return response()->stream($callback, 200, $headers);
        } elseif ($format === 'xlsx') {
            if (class_exists('PhpOffice\\PhpSpreadsheet\\Spreadsheet')) {
                $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->fromArray($fields, null, 'A1');
                $row = 2;
                foreach ($orders as $order) {
                    $sheet->fromArray([
                        $order->id,
                        $order->customer_name,
                        $order->customer_email,
                        $order->status,
                        $order->total_amount,
                        $order->created_at,
                    ], null, 'A'.$row);
                    $row++;
                }
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $tempFile = tempnam(sys_get_temp_dir(), 'orders_') . '.xlsx';
                $writer->save($tempFile);
                return response()->download($tempFile, "$filename.xlsx")->deleteFileAfterSend(true);
            } else {
                // Fallback to CSV if PhpSpreadsheet is not installed
                return redirect()->back()->with('error', 'Excel export not available. Please install phpoffice/phpspreadsheet.');
            }
        }
        return redirect()->back()->with('error', 'Invalid export format.');
    }

    public function invoice($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.orders.invoice', compact('order'));
    }
} 