<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\PhonePeService;
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
     * Place a new order with multiple items from modal or direct cart, optionally initiating PhonePe PG.
     */
    public function store(Request $request, PhonePeService $phonePeService): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please log in to place your order.',
            ], 401);
        }

        $user = auth()->user();

        // 1. Validate Input
        $request->validate([
            'address_id' => 'nullable|integer',
            'recipient_name' => 'nullable|string|max:100',
            'contactNo' => 'nullable|string|max:20',
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:15',
            'payment_method' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
            'cart_items' => 'nullable|array',
            'save_address' => 'nullable|boolean',
        ]);

        // 2. Resolve Items to Order (check DB cart first, then request payload)
        $dbCartItems = $user->cartItems()->get();
        $itemsToOrder = [];

        if ($dbCartItems->isNotEmpty()) {
            foreach ($dbCartItems as $cItem) {
                $itemsToOrder[] = [
                    'product_id' => $cItem->product_id,
                    'product_name' => $cItem->product_name ?? 'Ayurvedic Formulation',
                    'price' => (float) $cItem->price,
                    'qty' => (int) $cItem->qty,
                    'image' => $cItem->image,
                ];
            }
        } elseif ($request->has('cart_items') && is_array($request->input('cart_items')) && count($request->input('cart_items')) > 0) {
            foreach ($request->input('cart_items') as $cItem) {
                $prodId = $cItem['id'] ?? $cItem['product_id'] ?? null;
                $prod = $prodId ? Product::find($prodId) : null;
                $itemsToOrder[] = [
                    'product_id' => $prodId,
                    'product_name' => $cItem['name'] ?? $cItem['product_name'] ?? ($prod ? $prod->name : 'Ayurvedic Formulation'),
                    'price' => (float) ($cItem['price'] ?? ($prod ? $prod->price : 0)),
                    'qty' => max(1, (int) ($cItem['qty'] ?? 1)),
                    'image' => $cItem['image'] ?? ($prod ? $prod->photo_url : null),
                ];
            }
        }

        if (empty($itemsToOrder)) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty. Please add formulations before placing an order.',
            ], 422);
        }

        // 3. Resolve Address
        $recipientName = '';
        $contactNo = '';
        $address1 = '';
        $address2 = null;
        $city = '';
        $state = '';
        $pincode = '';

        if ($request->filled('address_id')) {
            $address = Address::where('id', $request->input('address_id'))
                ->where('user_id', $user->id)
                ->first();

            if (!$address) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected delivery address could not be found.',
                ], 422);
            }

            $recipientName = $address->recipient_name;
            $contactNo = $address->contactNo;
            $address1 = $address->address_line_1;
            $address2 = $address->address_line_2;
            $city = $address->city;
            $state = $address->state;
            $pincode = $address->pincode;
        } else {
            // Validate required inline fields
            $recipientName = (string) $request->input('recipient_name', $user->name);
            $contactNo = (string) $request->input('contactNo', $user->contactNo ?? '');
            $address1 = (string) $request->input('address_line_1');
            $address2 = $request->input('address_line_2');
            $city = (string) $request->input('city');
            $state = (string) $request->input('state');
            $pincode = (string) $request->input('pincode');

            if (empty($recipientName) || empty($contactNo) || empty($address1) || empty($city) || empty($state) || empty($pincode)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please provide complete delivery address details.',
                ], 422);
            }

            // Save new address if requested
            if ($request->boolean('save_address', true)) {
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

        // 4. Payment Method & Status
        $rawPaymentMethod = $request->input('payment_method', 'Cash on Delivery');
        $pmLower = strtolower((string) $rawPaymentMethod);
        $isPhonePe = str_contains($pmLower, 'phonepe');

        if ($isPhonePe) {
            $paymentMethod = 'PhonePe';
            $paymentStatus = 'Pending';
            $orderStatus = 'Pending';
        } elseif (str_contains($pmLower, 'upi') || str_contains($pmLower, 'online') || str_contains($pmLower, 'card') || str_contains($pmLower, 'prepaid')) {
            $paymentMethod = 'Prepaid UPI / Online';
            $paymentStatus = 'Paid';
            $orderStatus = 'Processing';
        } else {
            $paymentMethod = 'Cash on Delivery';
            $paymentStatus = 'Pending';
            $orderStatus = 'Processing';
        }

        // 5. Calculate Subtotal, Shipping, and Total
        $subtotal = 0.0;
        foreach ($itemsToOrder as $item) {
            $subtotal += ($item['price'] * $item['qty']);
        }

        $shippingFee = ($subtotal >= 999 || $subtotal == 0) ? 0.00 : 99.00;
        $totalAmount = $subtotal + $shippingFee;

        // 6. Generate Unique Order Number
        $orderNumber = 'PV-' . date('Y') . '-' . strtoupper(Str::random(5));

        // 7. DB Transaction to Create Order and OrderItems & Clear Cart
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
            $orderStatus,
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
                'status' => $orderStatus,
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

        // 8. If PhonePe payment, initiate PG session and return redirect URL
        if ($isPhonePe) {
            $callbackUrl = route('payment.phonepe.callback', ['order_number' => $order->order_number]);
            $phonePeResult = $phonePeService->initiatePayment($order, $callbackUrl);

            if ($phonePeResult['success'] && !empty($phonePeResult['redirect_url'])) {
                return response()->json([
                    'success' => true,
                    'message' => "Order #{$order->order_number} initiated. Redirecting to PhonePe...",
                    'redirect_url' => $phonePeResult['redirect_url'],
                    'order' => $order,
                ], 201);
            }

            // If Sandbox/API communication error, return informative fallback
            return response()->json([
                'success' => false,
                'message' => $phonePeResult['message'] ?? 'Unable to connect to PhonePe Gateway. Please try again or select Cash on Delivery.',
                'order' => $order,
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => "Order #{$order->order_number} placed successfully!",
            'order' => $order,
        ], 201);
    }
}
