<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Get the authenticated user's order history as JSON.
     */
    public function index(Request $request): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please log in to view your orders.',
            ], 401);
        }

        $orders = auth()->user()->orders()
            ->with('items')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'orders' => $orders,
        ]);
    }

    /**
     * Place a new order for the authenticated user.
     */
    public function store(Request $request): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please log in to place your order.',
            ], 401);
        }

        $user = auth()->user();

        // 1. Gather Cart Items (from database cart or request payload)
        $dbCartItems = $user->cartItems()->get();
        $itemsToOrder = [];

        if ($dbCartItems->isNotEmpty()) {
            foreach ($dbCartItems as $cItem) {
                $itemsToOrder[] = [
                    'product_id' => $cItem->product_id,
                    'product_name' => $cItem->product_name,
                    'price' => (float) $cItem->price,
                    'qty' => (int) $cItem->qty,
                    'image' => $cItem->image,
                ];
            }
        } elseif ($request->has('cart_items') && is_array($request->input('cart_items')) && count($request->input('cart_items')) > 0) {
            foreach ($request->input('cart_items') as $cItem) {
                $itemsToOrder[] = [
                    'product_id' => $cItem['id'] ?? $cItem['product_id'] ?? null,
                    'product_name' => $cItem['name'] ?? $cItem['product_name'] ?? 'Ayurvedic Formulation',
                    'price' => (float) ($cItem['price'] ?? 0),
                    'qty' => max(1, (int) ($cItem['qty'] ?? 1)),
                    'image' => $cItem['image'] ?? null,
                ];
            }
        }

        if (empty($itemsToOrder)) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty. Please add products before placing an order.',
            ], 422);
        }

        // 2. Validate Address
        $recipientName = '';
        $contactNo = '';
        $address1 = '';
        $address2 = null;
        $city = '';
        $state = '';
        $pincode = '';

        if ($request->filled('address_id')) {
            $address = $user->addresses()->find($request->input('address_id'));
            if (!$address) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected delivery address not found.',
                ], 404);
            }

            $recipientName = $address->recipient_name;
            $contactNo = $address->contactNo;
            $address1 = $address->address_line_1;
            $address2 = $address->address_line_2;
            $city = $address->city;
            $state = $address->state;
            $pincode = $address->pincode;
        } else {
            $validated = $request->validate([
                'recipient_name' => 'required|string|max:255',
                'contactNo' => 'required|string|max:20',
                'address_line_1' => 'required|string|max:255',
                'address_line_2' => 'nullable|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'pincode' => 'required|string|max:15',
                'save_address' => 'nullable|boolean',
            ]);

            $recipientName = $validated['recipient_name'];
            $contactNo = $validated['contactNo'];
            $address1 = $validated['address_line_1'];
            $address2 = $validated['address_line_2'] ?? null;
            $city = $validated['city'];
            $state = $validated['state'];
            $pincode = $validated['pincode'];

            if ($request->boolean('save_address')) {
                $user->addresses()->create([
                    'recipient_name' => $recipientName,
                    'contactNo' => $contactNo,
                    'address_line_1' => $address1,
                    'address_line_2' => $address2,
                    'city' => $city,
                    'state' => $state,
                    'pincode' => $pincode,
                    'type' => 'Home',
                    'is_default' => $user->addresses()->count() === 0,
                ]);
            }
        }

        // 3. Payment Method & Status
        $paymentMethod = $request->input('payment_method', 'Cash on Delivery');
        $pmLower = strtolower((string) $paymentMethod);
        if (str_contains($pmLower, 'upi') || str_contains($pmLower, 'online') || str_contains($pmLower, 'card') || str_contains($pmLower, 'prepaid')) {
            $paymentMethod = 'Prepaid UPI / Online';
            $paymentStatus = 'Paid';
        } else {
            $paymentMethod = 'Cash on Delivery';
            $paymentStatus = 'Pending';
        }

        // 4. Calculate Subtotal, Shipping, and Total
        $subtotal = 0.0;
        foreach ($itemsToOrder as $item) {
            $subtotal += ($item['price'] * $item['qty']);
        }

        $shippingFee = ($subtotal >= 999 || $subtotal == 0) ? 0.00 : 99.00;
        $totalAmount = $subtotal + $shippingFee;

        // 5. Generate Unique Order Number
        $orderNumber = 'PV-' . date('Y') . '-' . strtoupper(Str::random(5));

        // 6. DB Transaction to Create Order and OrderItems & Clear Cart
        $order = DB::transaction(function () use (
            $user,
            $orderNumber,
            $recipientName,
            $contactNo,
            $address1,
            $address2,
            $city,
            $state,
            $pincode,
            $subtotal,
            $shippingFee,
            $totalAmount,
            $paymentMethod,
            $paymentStatus,
            $itemsToOrder,
            $request
        ) {
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $user->id,
                'recipient_name' => $recipientName,
                'contactNo' => $contactNo,
                'address_line_1' => $address1,
                'address_line_2' => $address2,
                'city' => $city,
                'state' => $state,
                'pincode' => $pincode,
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'total_amount' => $totalAmount,
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentStatus,
                'status' => 'Processing',
                'notes' => $request->input('notes'),
            ]);

            foreach ($itemsToOrder as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'image' => $item['image'],
                ]);
            }

            // Clear User's Database Cart
            $user->cartItems()->delete();

            return $order;
        });

        $order->load('items');

        return response()->json([
            'success' => true,
            'message' => "Order #{$order->order_number} placed successfully!",
            'order' => $order,
        ], 201);
    }
}
