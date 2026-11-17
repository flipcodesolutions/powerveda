<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected function createProduct(array $attributes = []): Product
    {
        return Product::create(array_merge([
            'name' => 'Yuvar Dhan Formulation',
            'price' => 1299.0,
            'stock' => 50,
            'detail' => 'Premium herbal wellness formulation.',
            'meta_title' => 'Herbal Product',
            'meta_detail' => 'Ayurvedic supplement',
            'badge' => 'AYURVEDIC',
        ], $attributes));
    }

    public function test_guest_cannot_access_cart_endpoints(): void
    {
        $this->getJson('/cart')->assertStatus(401);
        $this->postJson('/cart/add', ['product_id' => 1, 'qty' => 1])->assertStatus(401);
        $this->postJson('/cart/update', ['product_id' => 1, 'qty' => 2])->assertStatus(401);
        $this->postJson('/cart/remove', ['product_id' => 1])->assertStatus(401);
        $this->postJson('/cart/clear')->assertStatus(401);
        $this->postJson('/cart/sync', ['items' => []])->assertStatus(401);
    }

    public function test_logged_in_user_can_add_item_to_database_cart(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct([
            'name' => 'Ashwagandha Gold',
            'price' => 1499.0,
        ]);

        $response = $this->actingAs($user)->postJson('/cart/add', [
            'product_id' => $product->id,
            'qty' => 2,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('total_items', 2)
            ->assertJsonPath('subtotal', 2998);

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_name' => 'Ashwagandha Gold',
            'qty' => 2,
        ]);
    }

    public function test_adding_existing_product_increments_quantity(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct([
            'name' => 'Shilajit Resin',
            'price' => 2199.0,
        ]);

        // Add 1st time
        $this->actingAs($user)->postJson('/cart/add', [
            'product_id' => $product->id,
            'qty' => 1,
        ])->assertStatus(200);

        // Add 2nd time with qty 2
        $this->actingAs($user)->postJson('/cart/add', [
            'product_id' => $product->id,
            'qty' => 2,
        ])->assertStatus(200);

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'qty' => 3,
        ]);
        $this->assertEquals(1, $user->cartItems()->count());
    }

    public function test_logged_in_user_can_update_cart_quantity(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct(['price' => 1000.0]);

        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => $product->price,
            'qty' => 2,
        ]);

        $response = $this->actingAs($user)->postJson('/cart/update', [
            'product_id' => $product->id,
            'qty' => 5,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('total_items', 5)
            ->assertJsonPath('subtotal', 5000);

        $this->assertEquals(5, $cartItem->fresh()->qty);
    }

    public function test_updating_quantity_to_zero_removes_item(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct();

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => 500,
            'qty' => 1,
        ]);

        $response = $this->actingAs($user)->postJson('/cart/update', [
            'product_id' => $product->id,
            'qty' => 0,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonPath('total_items', 0);

        $this->assertEquals(0, $user->cartItems()->count());
    }

    public function test_logged_in_user_can_remove_item_from_cart(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct();

        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => 899,
            'qty' => 1,
        ]);

        $response = $this->actingAs($user)->postJson('/cart/remove', [
            'product_id' => $product->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('total_items', 0);

        $this->assertDatabaseMissing('cart_items', ['id' => $cartItem->id]);
    }

    public function test_logged_in_user_can_clear_cart(): void
    {
        $user = User::factory()->create();
        $p1 = $this->createProduct();
        $p2 = $this->createProduct();

        CartItem::create(['user_id' => $user->id, 'product_id' => $p1->id, 'product_name' => $p1->name, 'price' => 100, 'qty' => 1]);
        CartItem::create(['user_id' => $user->id, 'product_id' => $p2->id, 'product_name' => $p2->name, 'price' => 200, 'qty' => 2]);

        $response = $this->actingAs($user)->postJson('/cart/clear');

        $response
            ->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('total_items', 0)
            ->assertJsonPath('items', []);

        $this->assertEquals(0, $user->cartItems()->count());
    }

    public function test_guest_cart_moves_to_database_upon_user_login(): void
    {
        $user = User::factory()->create([
            'email' => 'customer@powerveda.com',
            'password' => 'Secret1234',
        ]);
        $product1 = $this->createProduct(['name' => 'Chyawanprash Special', 'price' => 799.0]);
        $product2 = $this->createProduct(['name' => 'Brahmi Brain Tonic', 'price' => 649.0]);

        $guestCart = [
            [
                'id' => $product1->id,
                'name' => $product1->name,
                'price' => 799.0,
                'image' => 'image/products/product-1.jpg',
                'qty' => 2,
            ],
            [
                'id' => $product2->id,
                'name' => $product2->name,
                'price' => 649.0,
                'image' => 'image/products/product-2.jpg',
                'qty' => 1,
            ]
        ];

        $response = $this->postJson('/login', [
            'login' => 'customer@powerveda.com',
            'password' => 'Secret1234',
            'guest_cart' => $guestCart,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonCount(2, 'cart');

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product1->id,
            'qty' => 2,
        ]);

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product2->id,
            'qty' => 1,
        ]);
    }

    public function test_guest_cart_moves_to_database_upon_user_registration(): void
    {
        $product = $this->createProduct(['name' => 'Saffron Glow Elixir', 'price' => 1899.0]);

        $guestCart = [
            [
                'id' => $product->id,
                'name' => $product->name,
                'price' => 1899.0,
                'qty' => 3,
            ]
        ];

        $response = $this->postJson('/register', [
            'name' => 'New Customer',
            'email' => 'newcustomer@powerveda.com',
            'contactNo' => '+919876543210',
            'password' => 'Password123',
            'guest_cart' => $guestCart,
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'cart')
            ->assertJsonPath('cart.0.qty', 3);

        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'product_name' => 'Saffron Glow Elixir',
            'qty' => 3,
        ]);
    }
}
