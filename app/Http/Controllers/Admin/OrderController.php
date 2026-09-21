<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display the Admin Customer Orders management page.
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = Order::with(['user', 'items'])->latest();

        // 1. Order Status Filter
        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        // 2. Payment Status Filter
        if ($request->filled('payment_status') && $request->input('payment_status') !== 'all') {
            $query->where('payment_status', $request->input('payment_status'));
        }

        // 3. Payment Method Filter
        if ($request->filled('payment_method') && $request->input('payment_method') !== 'all') {
            $query->where('payment_method', $request->input('payment_method'));
        }

        // 4. Date Range Filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        // 5. Search Filter
        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('recipient_name', 'like', "%{$search}%")
                    ->orWhere('contactNo', 'like', "%{$search}%")
                    ->orWhere('transaction_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        // Calculate summary metrics
        $stats = [
            'total_orders' => Order::count(),
            'paid_orders' => Order::where('payment_status', 'Paid')->count(),
            'pending_payment' => Order::where('payment_status', 'Pending')->count(),
            'failed_payment' => Order::where('payment_status', 'Failed')->count(),
        ];

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'orders' => $orders,
                'stats' => $stats,
            ]);
        }

        return view('admin.pages.orders', compact('orders', 'stats'));
    }

    /**
     * Display the specified order details as JSON.
     */
    public function show(Order $order): JsonResponse
    {
        $order->load(['user', 'items']);

        return response()->json([
            'success' => true,
            'order' => $order,
        ]);
    }

    /**
     * Update the status of an order.
     */
    public function updateStatus(Request $request, Order $order): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:Processing,In Transit,Delivered,Cancelled',
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Order #{$order->order_number} status updated to {$order->status}!",
                'order' => $order,
            ]);
        }

        return redirect()->back()->with('success', "Order #{$order->order_number} status updated to {$order->status}!");
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(Request $request, Order $order): JsonResponse|RedirectResponse
    {
        $orderNumber = $order->order_number;
        $order->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Order #{$orderNumber} deleted successfully!",
            ]);
        }

        return redirect()->route('admin.orders')->with('success', "Order #{$orderNumber} deleted successfully!");
    }
}
