<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function createProduct(array $attributes = []): Product
    {
        return Product::create(array_merge([
            'name' => 'Power Veda Formulation',
            'price' => 1299.00,
            'stock' => 50,
            'detail' => 'Premium herbal wellness formulation.',
            'meta_title' => 'Herbal Product',
            'meta_detail' => 'Ayurvedic supplement',
            'badge' => 'AYURVEDIC',
        ], $attributes));
    }

    public function test_guest_cannot_place_order(): void
    {
        $response = $this->postJson(route('checkout.place_order'), [
            'payment_method' => 'Cash on Delivery',
            'cart_items' => [
                ['id' => 1, 'name' => 'Ashwagandha Gold', 'price' => 1499, 'qty' => 1],
            ],
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Please log in to place your order.',
            ]);
    }

    public function test_logged_in_user_can_place_order_with_saved_address(): void
    {
        $user = User::factory()->create(['role' => 'User']);
        $product = $this->createProduct(['price' => 1299]);

        $address = Address::create([
            'user_id' => $user->id,
            'recipient_name' => 'Aarav Patel',
            'contactNo' => '9876543210',
            'address_line_1' => 'Flat 402, Lotus Tower',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
            'type' => 'Home',
            'is_default' => true,
        ]);

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => $product->price,
            'qty' => 2,
            'image' => $product->og_image,
        ]);

        $response = $this->actingAs($user)->postJson(route('checkout.place_order'), [
            'address_id' => $address->id,
            'payment_method' => 'Cash on Delivery',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'recipient_name' => 'Aarav Patel',
            'contactNo' => '9876543210',
            'city' => 'Mumbai',
            'status' => 'Processing',
            'payment_method' => 'Cash on Delivery',
        ]);

        $order = Order::where('user_id', $user->id)->first();
        $this->assertNotNull($order);
        $this->assertCount(1, $order->items);
        $this->assertEquals(2, $order->items->first()->qty);

        // Cart should be cleared
        $this->assertDatabaseMissing('cart_items', [
            'user_id' => $user->id,
        ]);
    }

    public function test_logged_in_user_can_place_order_with_new_address(): void
    {
        $user = User::factory()->create(['role' => 'User']);
        $product = $this->createProduct(['price' => 899]);

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => 899,
            'qty' => 1,
        ]);

        $response = $this->actingAs($user)->postJson(route('checkout.place_order'), [
            'recipient_name' => 'Priya Sharma',
            'contactNo' => '9123456789',
            'address_line_1' => 'Plot 12, Green Avenue',
            'address_line_2' => 'Near City Mall',
            'city' => 'Bengaluru',
            'state' => 'Karnataka',
            'pincode' => '560001',
            'save_address' => true,
            'payment_method' => 'Prepaid UPI',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'recipient_name' => 'Priya Sharma',
            'payment_method' => 'Prepaid UPI / Online',
            'payment_status' => 'Paid',
            'city' => 'Bengaluru',
        ]);

        // Address should also be saved in addresses table
        $this->assertDatabaseHas('addresses', [
            'user_id' => $user->id,
            'recipient_name' => 'Priya Sharma',
            'city' => 'Bengaluru',
        ]);
    }

    public function test_user_can_view_orders_on_account_page_and_api(): void
    {
        $user = User::factory()->create(['role' => 'User']);

        $order = Order::create([
            'order_number' => 'PV-2026-TEST1',
            'user_id' => $user->id,
            'recipient_name' => 'Test User',
            'contactNo' => '9999999999',
            'address_line_1' => '123 Main St',
            'city' => 'Delhi',
            'state' => 'Delhi',
            'pincode' => '110001',
            'subtotal' => 1499.00,
            'shipping_fee' => 0.00,
            'total_amount' => 1499.00,
            'status' => 'Processing',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_name' => 'Ashwagandha Gold',
            'price' => 1499.00,
            'qty' => 1,
        ]);

        // 1. Account page renders order
        $pageResponse = $this->actingAs($user)->get(route('account'));
        $pageResponse->assertStatus(200)
            ->assertSee('#PV-2026-TEST1')
            ->assertSee('Ashwagandha Gold');

        // 2. API returns order
        $apiResponse = $this->actingAs($user)->getJson(route('user.orders.list'));
        $apiResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'order_number' => 'PV-2026-TEST1',
            ]);
    }

    public function test_admin_can_view_and_update_orders(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $customer = User::factory()->create(['role' => 'User']);

        $order = Order::create([
            'order_number' => 'PV-2026-ADM1',
            'user_id' => $customer->id,
            'recipient_name' => 'Rohan Varma',
            'contactNo' => '9888877777',
            'address_line_1' => '456 Hill Rd',
            'city' => 'Pune',
            'state' => 'Maharashtra',
            'pincode' => '411001',
            'subtotal' => 2499.00,
            'shipping_fee' => 0.00,
            'total_amount' => 2499.00,
            'status' => 'Processing',
        ]);

        // Admin can view orders
        $response = $this->actingAs($admin)->get(route('admin.orders'));
        $response->assertStatus(200)
            ->assertSee('PV-2026-ADM1')
            ->assertSee('Rohan Varma');

        // Admin can update status
        $updateResponse = $this->actingAs($admin)->patchJson(route('admin.orders.status', $order), [
            'status' => 'In Transit',
        ]);

        $updateResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'In Transit',
        ]);
    }

    public function test_non_admin_cannot_access_admin_orders(): void
    {
        $customer = User::factory()->create(['role' => 'User']);

        $response = $this->actingAs($customer)->get(route('admin.orders'));
        $response->assertStatus(403);
    }
}
