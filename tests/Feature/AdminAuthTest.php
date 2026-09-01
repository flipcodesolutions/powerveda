<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin user seeder creates the administrator account.
     */
    public function test_admin_user_seeder_creates_admin_account(): void
    {
        $this->seed(AdminUserSeeder::class);

        $this->assertDatabaseHas('users', [
            'email' => 'admin@powerveda.com',
            'role' => 'Admin',
        ]);

        $admin = User::where('email', 'admin@powerveda.com')->first();
        $this->assertNotNull($admin);
        $this->assertTrue(Hash::check('Admin@12345', $admin->password));
        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isUser());
    }

    /**
     * Test guest can view the admin login page.
     */
    public function test_guest_can_view_admin_login_page(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('Admin Console');
        $response->assertSee('Access Admin Console');
    }

    /**
     * Test already logged-in admin is redirected to dashboard when visiting login page.
     */
    public function test_authenticated_admin_redirected_to_dashboard_from_login_page(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->get('/admin/login');

        $response->assertRedirect(route('admin.dashboard'));
    }

    /**
     * Test admin can log in successfully with valid credentials.
     */
    public function test_admin_can_login_with_valid_credentials(): void
    {
        $admin = User::factory()->create([
            'email' => 'customadmin@powerveda.com',
            'password' => Hash::make('SecretAdmin123!'),
            'role' => 'Admin',
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'customadmin@powerveda.com',
            'password' => 'SecretAdmin123!',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    /**
     * Test login fails with invalid password.
     */
    public function test_admin_cannot_login_with_invalid_password(): void
    {
        User::factory()->create([
            'email' => 'admin@powerveda.com',
            'password' => Hash::make('CorrectPassword'),
            'role' => 'Admin',
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@powerveda.com',
            'password' => 'WrongPassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test regular user cannot log in via admin login.
     */
    public function test_regular_user_cannot_login_via_admin_login(): void
    {
        $user = User::factory()->create([
            'email' => 'customer@example.com',
            'password' => Hash::make('UserPassword123'),
            'role' => 'User',
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'customer@example.com',
            'password' => 'UserPassword123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test regular user is blocked (403 Forbidden) from accessing admin routes.
     */
    public function test_regular_user_blocked_from_admin_panel(): void
    {
        $regularUser = User::factory()->create([
            'role' => 'User',
        ]);

        $response = $this->actingAs($regularUser)->get('/admin');
        $response->assertStatus(403);

        $response = $this->actingAs($regularUser)->get('/admin/products');
        $response->assertStatus(403);

        $response = $this->actingAs($regularUser)->get('/admin/orders');
        $response->assertStatus(403);

        $response = $this->actingAs($regularUser)->get('/admin/reviews');
        $response->assertStatus(403);
    }

    /**
     * Test guest is redirected to login when trying to access admin routes.
     */
    public function test_guest_is_redirected_to_login_from_admin_routes(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect(route('admin.login'));
    }

    /**
     * Test admin can log out successfully.
     */
    public function test_admin_can_logout(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $response = $this->actingAs($admin)->post('/admin/logout');

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }
}
