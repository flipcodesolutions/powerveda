<?php

namespace Tests\Feature;

use App\Models\CmsPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CmsPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed default CMS pages
        $this->seed(\Database\Seeders\CmsPageSeeder::class);
    }

    /**
     * Test guest cannot access admin CMS pages.
     */
    public function test_guest_cannot_access_admin_cms(): void
    {
        $this->get('/admin/cms')->assertRedirect(route('admin.login'));
        $this->post('/admin/cms', [
            'title' => 'Test Policy',
            'slug' => 'test-policy',
            'detail' => '<p>Test detail content</p>',
        ])->assertRedirect(route('admin.login'));
    }

    /**
     * Test admin can view CMS management page.
     */
    public function test_admin_can_view_cms_index_page(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->get('/admin/cms');
        $response->assertStatus(200);
        $response->assertSee('Policy Pages Content Manager');
        $response->assertSee('Privacy Policy');
        $response->assertSee('privacy-policy');
    }

    /**
     * Test admin can load specific policy by slug query parameter.
     */
    public function test_admin_can_load_specific_policy_slug(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->get('/admin/cms?slug=shipping-policy');
        $response->assertStatus(200);
        $response->assertSee('Shipping Policy');
        $response->assertSee('shipping-policy');
        $response->assertSee('Express Pan-India Delivery', false);
    }

    /**
     * Test admin can create or update a policy page via single createOrUpdate endpoint.
     */
    public function test_admin_can_create_or_update_policy(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        // Update existing privacy policy
        $response = $this->actingAs($admin)->post('/admin/cms', [
            'title' => 'Updated Privacy Policy Title',
            'slug' => 'privacy-policy',
            'detail' => '<h3>Updated Privacy Section</h3><p>We respect customer confidentiality.</p>',
        ]);

        $response->assertRedirect(route('admin.cms.index', ['slug' => 'privacy-policy']));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('cms_pages', [
            'slug' => 'privacy-policy',
            'title' => 'Updated Privacy Policy Title',
            'detail' => '<h3>Updated Privacy Section</h3><p>We respect customer confidentiality.</p>',
        ]);

        // Create a new policy page via the same createOrUpdate method
        $response = $this->actingAs($admin)->post('/admin/cms', [
            'title' => 'Wholesale Policy',
            'slug' => 'wholesale-policy',
            'detail' => '<p>Wholesale terms and Ayurvedic bulk supply guidelines.</p>',
        ]);

        $response->assertRedirect(route('admin.cms.index', ['slug' => 'wholesale-policy']));
        $this->assertDatabaseHas('cms_pages', [
            'slug' => 'wholesale-policy',
            'title' => 'Wholesale Policy',
        ]);
    }

    /**
     * Test validation rules on createOrUpdate.
     */
    public function test_cms_validation_rules(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->post('/admin/cms', [
            'title' => '',
            'slug' => '',
            'detail' => '',
        ]);

        $response->assertSessionHasErrors(['title', 'slug', 'detail']);
    }

    /**
     * Test visitor can view all 5 dynamic policy pages.
     */
    public function test_visitor_can_view_dynamic_policy_pages(): void
    {
        // 1. Privacy Policy
        $response = $this->get('/privacy-policy');
        $response->assertStatus(200);
        $response->assertSee('Privacy Policy');
        $response->assertSee('Vaidraj Disease Eradication Center');

        // 2. Refund Policy
        $response = $this->get('/refund-policy');
        $response->assertStatus(200);
        $response->assertSee('Refund Policy');
        $response->assertSee('30-Day');

        // 3. Return Policy
        $response = $this->get('/return-policy');
        $response->assertStatus(200);
        $response->assertSee('Return Policy');
        $response->assertSee('Free Reverse Pickup');

        // 4. Shipping Policy
        $response = $this->get('/shipping-policy');
        $response->assertStatus(200);
        $response->assertSee('Shipping Policy');
        $response->assertSee('BlueDart');

        // 5. Terms and Conditions
        $response = $this->get('/terms-and-conditions');
        $response->assertStatus(200);
        $response->assertSee('Terms and Conditions');
        $response->assertSee('AYUSH guidelines');
    }

    /**
     * Test dynamic /policies/{slug} route works for any CMS page.
     */
    public function test_visitor_can_view_policy_via_policies_slug_route(): void
    {
        $response = $this->get('/policies/privacy-policy');
        $response->assertStatus(200);
        $response->assertSee('Privacy Policy');

        $response = $this->get('/policies/shipping-policy');
        $response->assertStatus(200);
        $response->assertSee('Shipping Policy');
    }

    /**
     * Test 404 returned for invalid slug.
     */
    public function test_visitor_gets_404_for_non_existent_policy(): void
    {
        $response = $this->get('/policies/unknown-policy-slug-xyz');
        $response->assertStatus(404);
    }

    /**
     * Test redirects for shortcut URLs.
     */
    public function test_shortcut_redirects(): void
    {
        $this->get('/privacy')->assertRedirect('/privacy-policy');
        $this->get('/terms')->assertRedirect('/terms-and-conditions');
        $this->get('/refund')->assertRedirect('/refund-policy');
        $this->get('/return')->assertRedirect('/return-policy');
        $this->get('/shipping')->assertRedirect('/shipping-policy');
    }
}
