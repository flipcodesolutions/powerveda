<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the Dedicated Shopping Cart page or return JSON for AJAX API.
     */
    public function index(Request $request): View|JsonResponse
    {
        // If AJAX / JSON request from frontend scripts
        if ($request->expectsJson() || $request->ajax()) {
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated.',
                    'items' => [],
                    'total_items' => 0,
                    'subtotal' => 0,
                ], 401);
            }

            $items = $this->getUserCartFormatted(auth()->user());

            return response()->json([
                'success' => true,
                'items' => $items,
                'total_items' => array_sum(array_column($items, 'qty')),
                'subtotal' => array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $items)),
            ]);
        }

        // Web Browser Page Request: Render Dedicated Cart View
        $recommendedProducts = Product::inRandomOrder()->take(4)->get();

        return view('visitor.pages.cart', compact('recommendedProducts'));
    }

    /**
     * Add an item to the user's database cart.
     */
    public function add(Request $request): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $validated = $request->validate([
            'product_id'   => ['nullable', 'integer'],
            'id'           => ['nullable', 'integer'],
            'qty'          => ['nullable', 'integer', 'min:1'],
            'name'         => ['nullable', 'string'],
            'product_name' => ['nullable', 'string'],
            'price'        => ['nullable', 'numeric'],
            'image'        => ['nullable', 'string'],
        ]);

        $productId = $validated['product_id'] ?? $validated['id'] ?? null;
        $qty = $validated['qty'] ?? 1;
        $name = $validated['name'] ?? $validated['product_name'] ?? null;
        $price = $validated['price'] ?? 0;
        $image = $validated['image'] ?? null;

        // If product_id exists in database, fetch reliable product details
        if ($productId) {
            $product = Product::find($productId);
            if ($product) {
                $name = $product->name;
                $price = $product->price;
                $image = $product->photo ? asset($product->photo) : ($image ?: asset('image/products/product-1.jpg'));
            }
        }

        $name = $name ?: 'Power Veda Wellness Formulation';

        $user = auth()->user();

        // Check if item already exists in user's cart
        $existing = $user->cartItems()
            ->where(function ($query) use ($productId, $name) {
                if ($productId) {
                    $query->where('product_id', $productId);
                } else {
                    $query->where('product_name', $name);
                }
            })
            ->first();

        if ($existing) {
            $existing->increment('qty', $qty);
        } else {
            $user->cartItems()->create([
                'product_id'   => $productId,
                'product_name' => $name,
                'price'        => $price,
                'image'        => $image,
                'qty'          => $qty,
            ]);
        }

        $items = $this->getUserCartFormatted($user);

        return response()->json([
            'success' => true,
            'message' => "{$name} added to cart!",
            'items' => $items,
            'total_items' => array_sum(array_column($items, 'qty')),
            'subtotal' => array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $items)),
        ]);
    }

    /**
     * Update item quantity in the user's database cart.
     */
    public function update(Request $request): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'product_id' => ['nullable', 'integer'],
            'id'         => ['nullable', 'integer'],
            'qty'        => ['required', 'integer'],
        ]);

        $productId = $validated['product_id'] ?? $validated['id'] ?? null;
        $qty = $validated['qty'];
        $user = auth()->user();

        $item = $user->cartItems()
            ->where(function ($query) use ($productId) {
                $query->where('product_id', $productId)
                    ->orWhere('id', $productId);
            })
            ->first();

        if ($item) {
            if ($qty <= 0) {
                $item->delete();
            } else {
                $item->update(['qty' => $qty]);
            }
        }

        $items = $this->getUserCartFormatted($user);

        return response()->json([
            'success' => true,
            'items' => $items,
            'total_items' => array_sum(array_column($items, 'qty')),
            'subtotal' => array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $items)),
        ]);
    }

    /**
     * Remove an item from the user's database cart.
     */
    public function remove(Request $request): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'product_id' => ['nullable', 'integer'],
            'id'         => ['nullable', 'integer'],
        ]);

        $productId = $validated['product_id'] ?? $validated['id'] ?? null;
        $user = auth()->user();

        $user->cartItems()
            ->where(function ($query) use ($productId) {
                $query->where('product_id', $productId)
                    ->orWhere('id', $productId);
            })
            ->delete();

        $items = $this->getUserCartFormatted($user);

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart.',
            'items' => $items,
            'total_items' => array_sum(array_column($items, 'qty')),
            'subtotal' => array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $items)),
        ]);
    }

    /**
     * Clear all items from the user's database cart.
     */
    public function clear(Request $request): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $user = auth()->user();
        $user->cartItems()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared.',
            'items' => [],
            'total_items' => 0,
            'subtotal' => 0,
        ]);
    }

    /**
     * Synchronize guest localStorage cart into database cart on login/registration.
     */
    public function sync(Request $request): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $guestItems = $request->input('items', $request->input('guest_cart', []));
        $user = auth()->user();

        if (is_array($guestItems) && !empty($guestItems)) {
            static::mergeGuestCartItems($user, $guestItems);
        }

        $items = $this->getUserCartFormatted($user);

        return response()->json([
            'success' => true,
            'message' => 'Cart synchronized successfully!',
            'items' => $items,
            'total_items' => array_sum(array_column($items, 'qty')),
            'subtotal' => array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $items)),
        ]);
    }

    /**
     * Helper to merge guest cart items array into a user's DB cart.
     */
    public static function mergeGuestCartItems($user, array $guestItems): void
    {
        foreach ($guestItems as $item) {
            $productId = $item['id'] ?? $item['product_id'] ?? null;
            $qty = max(1, (int) ($item['qty'] ?? 1));
            $name = $item['name'] ?? $item['product_name'] ?? 'Power Veda Formulation';
            $price = (float) ($item['price'] ?? 0);
            $image = $item['image'] ?? null;

            if ($productId) {
                $product = Product::find($productId);
                if ($product) {
                    $name = $product->name;
                    $price = (float) $product->price;
                    $image = $product->photo ? asset($product->photo) : ($image ?: asset('image/products/product-1.jpg'));
                }
            }

            $existing = $user->cartItems()
                ->where(function ($query) use ($productId, $name) {
                    if ($productId) {
                        $query->where('product_id', $productId);
                    } else {
                        $query->where('product_name', $name);
                    }
                })
                ->first();

            if ($existing) {
                // If existing in database, add the guest quantity
                $existing->increment('qty', $qty);
            } else {
                $user->cartItems()->create([
                    'product_id'   => $productId,
                    'product_name' => $name,
                    'price'        => $price,
                    'image'        => $image,
                    'qty'          => $qty,
                ]);
            }
        }
    }

    /**
     * Helper to format DB cart items into matching frontend state array.
     */
    protected function getUserCartFormatted($user): array
    {
        return $user->cartItems()
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id'    => $item->product_id ?: $item->id,
                    'db_id' => $item->id,
                    'name'  => $item->product_name,
                    'price' => (float) $item->price,
                    'image' => $item->image ?: asset('image/products/product-1.jpg'),
                    'qty'   => (int) $item->qty,
                ];
            })
            ->toArray();
    }
}
