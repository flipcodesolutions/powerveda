<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Services\PhonePeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PhonePePaymentTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'customer@powerveda.com',
            'contactNo' => '9876543210',
        ]);

        $this->product = Product::create([
            'name' => 'Shilajit Pure Resin 20g',
            'price' => 1499.00,
            'stock' => 50,
            'detail' => 'Himalayan Shilajit Resin with 80%+ Fulvic Acid.',
        ]);
    }

    /**
     * Test PhonePeService generates OAuth Token successfully with mocked response.
     */
    public function test_phonepe_token_generation(): void
    {
        Http::fake([
            '*/oauth/token' => Http::response([
                'access_token' => 'mocked_phonepe_access_token_12345',
                'expires_in' => 3600,
                'token_type' => 'O-Bearer',
            ], 200),
        ]);

        $service = app(PhonePeService::class);
        $token = $service->getAccessToken();

        $this->assertEquals('mocked_phonepe_access_token_12345', $token);
    }

    /**
     * Test PhonePe Checkout initiation creates order and returns redirect URL.
     */
    public function test_phonepe_checkout_flow_returns_redirect_url(): void
    {
        Http::fake([
            '*/oauth/token' => Http::response([
                'access_token' => 'mocked_token_xyz',
                'expires_in' => 3600,
            ], 200),
            '*/checkout/v2/pay' => Http::response([
                'orderId' => 'PH_ORD_998877',
                'state' => 'PENDING',
                'redirectUrl' => 'https://mercury-uat.phonepe.com/transact/pg?token=simulated_token',
            ], 200),
        ]);

        $response = $this->actingAs($this->user)->postJson('/checkout/place-order', [
            'payment_method' => 'PhonePe',
            'recipient_name' => 'Aditya Sharma',
            'contactNo' => '9876543210',
            'address_line_1' => '108 Palm Enclave',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
            'cart_items' => [
                [
                    'product_id' => $this->product->id,
                    'qty' => 1,
                ]
            ],
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'redirect_url' => 'https://mercury-uat.phonepe.com/transact/pg?token=simulated_token',
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'payment_method' => 'PhonePe',
            'payment_status' => 'Pending',
        ]);
    }

    /**
     * Test PhonePe Callback verifies success state and marks order as Paid.
     */
    public function test_phonepe_callback_handles_success_payment(): void
    {
        $order = Order::create([
            'order_number' => 'PV-2026-TEST1',
            'user_id' => $this->user->id,
            'recipient_name' => 'Aditya Sharma',
            'contactNo' => '9876543210',
            'address_line_1' => '108 Palm Enclave',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
            'subtotal' => 1499.00,
            'shipping_fee' => 0.00,
            'total_amount' => 1499.00,
            'payment_method' => 'PhonePe',
            'payment_status' => 'Pending',
            'status' => 'Pending',
        ]);

        Http::fake([
            '*/oauth/token' => Http::response([
                'access_token' => 'mocked_token_xyz',
                'expires_in' => 3600,
            ], 200),
            '*/order/PV-2026-TEST1/status' => Http::response([
                'orderId' => 'PH_ORD_998877',
                'state' => 'COMPLETED',
                'amount' => 149900,
                'paymentDetails' => [
                    'transactionId' => 'TXN_PHONEPE_123456',
                    'paymentMode' => 'UPI',
                ],
            ], 200),
        ]);

        $response = $this->actingAs($this->user)->get('/payment/phonepe/callback?order_number=' . $order->order_number);

        $response->assertRedirect(route('account', ['tab' => 'orders']));
        $response->assertSessionHas('success');

        $order->refresh();
        $this->assertEquals('Paid', $order->payment_status);
        $this->assertEquals('Processing', $order->status);
        $this->assertEquals('TXN_PHONEPE_123456', $order->transaction_id);
    }

    /**
     * Test PhonePe Callback handles failed payment status.
     */
    public function test_phonepe_callback_handles_failed_payment(): void
    {
        $order = Order::create([
            'order_number' => 'PV-2026-FAIL1',
            'user_id' => $this->user->id,
            'recipient_name' => 'Aditya Sharma',
            'contactNo' => '9876543210',
            'address_line_1' => '108 Palm Enclave',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
            'subtotal' => 1499.00,
            'shipping_fee' => 0.00,
            'total_amount' => 1499.00,
            'payment_method' => 'PhonePe',
            'payment_status' => 'Pending',
            'status' => 'Pending',
        ]);

        Http::fake([
            '*/oauth/token' => Http::response([
                'access_token' => 'mocked_token_xyz',
                'expires_in' => 3600,
            ], 200),
            '*/order/PV-2026-FAIL1/status' => Http::response([
                'orderId' => 'PH_ORD_998877',
                'state' => 'FAILED',
                'responseCode' => 'PAYMENT_ERROR',
            ], 200),
        ]);

        $response = $this->actingAs($this->user)->get('/payment/phonepe/callback?order_number=' . $order->order_number);

        $response->assertRedirect(route('account', ['tab' => 'orders']));
        $response->assertSessionHas('error');

        $order->refresh();
        $this->assertEquals('Failed', $order->payment_status);
        $this->assertEquals('Cancelled', $order->status);
    }

    /**
     * Test PhonePe Server-to-Server Webhook updates order asynchronously.
     */
    public function test_phonepe_webhook_processing(): void
    {
        $order = Order::create([
            'order_number' => 'PV-2026-WEBHOOK1',
            'user_id' => $this->user->id,
            'recipient_name' => 'Aditya Sharma',
            'contactNo' => '9876543210',
            'address_line_1' => '108 Palm Enclave',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
            'subtotal' => 1499.00,
            'shipping_fee' => 0.00,
            'total_amount' => 1499.00,
            'payment_method' => 'PhonePe',
            'payment_status' => 'Pending',
            'status' => 'Pending',
        ]);

        Http::fake([
            '*/oauth/token' => Http::response([
                'access_token' => 'mocked_token_xyz',
                'expires_in' => 3600,
            ], 200),
            '*/order/PV-2026-WEBHOOK1/status' => Http::response([
                'orderId' => 'PH_ORD_WEBHOOK_1',
                'state' => 'COMPLETED',
                'paymentDetails' => [
                    'transactionId' => 'TXN_WEBHOOK_CONFIRMED',
                ],
            ], 200),
        ]);

        // Post without CSRF token (verifies CSRF exclusion as well)
        $response = $this->postJson('/payment/phonepe/webhook', [
            'merchantOrderId' => 'PV-2026-WEBHOOK1',
            'state' => 'COMPLETED',
            'data' => [
                'merchantOrderId' => 'PV-2026-WEBHOOK1',
                'transactionId' => 'TXN_WEBHOOK_CONFIRMED',
            ],
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'SUCCESS',
        ]);

        $order->refresh();
        $this->assertEquals('Paid', $order->payment_status);
        $this->assertEquals('Processing', $order->status);
        $this->assertEquals('TXN_WEBHOOK_CONFIRMED', $order->transaction_id);
    }
}
