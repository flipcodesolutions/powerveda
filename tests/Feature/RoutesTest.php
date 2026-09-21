<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\CmsPageSeeder::class);
    }

    /**
     * Test all Visitor routes return 200 OK.
     */
    public function test_visitor_routes(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/privacy-policy');
        $response->assertStatus(200);

        $response = $this->get('/terms-and-conditions');
        $response->assertStatus(200);

        $response = $this->get('/refund-policy');
        $response->assertStatus(200);

        $response = $this->get('/return-policy');
        $response->assertStatus(200);

        $response = $this->get('/shipping-policy');
        $response->assertStatus(200);
    }

    /**
     * Test that shop buttons and shop section are hidden when only 1 product exists.
     */
    public function test_hides_shop_section_and_buttons_when_only_one_product_exists(): void
    {
        Product::create([
            'name' => 'Single Exclusive Product',
            'price' => 1999.00,
            'stock' => 20,
            'detail' => 'Single formulation only.',
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        // Should see the single product
        $response->assertSee('Single Exclusive Product');

        // Should NOT see Shop Nav Link
        $response->assertDontSee('#shop"');

        // Should NOT see the Shop catalog section
        $response->assertDontSee('id="shop"');
        $response->assertDontSee('SHOP NOW');
    }

    /**
     * Test that shop buttons and shop section are shown when multiple products exist.
     */
    public function test_shows_shop_section_and_buttons_when_multiple_products_exist(): void
    {
        Product::create([
            'name' => 'Product 1',
            'price' => 1000.00,
            'stock' => 10,
        ]);
        Product::create([
            'name' => 'Product 2',
            'price' => 2000.00,
            'stock' => 20,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        // Should see Shop Nav Link and Shop Section
        $response->assertSee('#shop');
        $response->assertSee('id="shop"', false);
        $response->assertSee('SHOP NOW');
    }

    /**
     * Test all Admin routes return 200 OK when authenticated as Admin.
     */
    public function test_admin_routes(): void
    {
        $admin = \App\Models\User::factory()->create([
            'role' => 'Admin',
        ]);

        $this->actingAs($admin)->get('/admin')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/dashboard')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/products')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/orders')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/reviews')->assertStatus(200);
    }

    /**
     * Test guest is redirected to admin login when accessing admin routes.
     */
    public function test_guest_is_redirected_to_admin_login(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
        $this->get('/admin/dashboard')->assertRedirect(route('admin.login'));
        $this->get('/admin/products')->assertRedirect(route('admin.login'));
        $this->get('/admin/orders')->assertRedirect(route('admin.login'));
        $this->get('/admin/reviews')->assertRedirect(route('admin.login'));
    }

    /**
     * Test alias redirects work as expected.
     */
    public function test_alias_redirects(): void
    {
        $this->get('/privacy')->assertRedirect('/privacy-policy');
        $this->get('/terms')->assertRedirect('/terms-and-conditions');
        $this->get('/refund')->assertRedirect('/refund-policy');
    }
}
