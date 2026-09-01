<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class VisitorAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user can register with name, email, contactNo, password.
     */
    public function test_user_can_register_via_api(): void
    {
        $payload = [
            'name'      => 'Aarohi Sharma',
            'email'     => 'aarohi.sharma@example.com',
            'contactNo' => '+91 9876543210',
            'password'  => 'SecurePass123!',
        ];

        $response = $this->postJson('/register', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'user'    => [
                    'name'      => 'Aarohi Sharma',
                    'email'     => 'aarohi.sharma@example.com',
                    'contactNo' => '+91 9876543210',
                    'role'      => 'User',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'email'     => 'aarohi.sharma@example.com',
            'name'      => 'Aarohi Sharma',
            'contactNo' => '+91 9876543210',
            'role'      => 'User',
        ]);

        $this->assertTrue(Auth::check());
        $this->assertEquals('aarohi.sharma@example.com', Auth::user()->email);
    }

    /**
     * Test registration validation errors.
     */
    public function test_registration_validation(): void
    {
        User::create([
            'name'      => 'Existing User',
            'email'     => 'existing@example.com',
            'contactNo' => '+91 1111111111',
            'password'  => Hash::make('password123'),
            'role'      => 'User',
        ]);

        // Duplicate email & short password
        $response = $this->postJson('/register', [
            'name'      => '',
            'email'     => 'existing@example.com',
            'contactNo' => '',
            'password'  => '123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'contactNo', 'password']);
    }

    /**
     * Test user can log in with email and password.
     */
    public function test_user_can_login_with_email(): void
    {
        $user = User::create([
            'name'      => 'Rahul Verma',
            'email'     => 'rahul@example.com',
            'contactNo' => '+91 9898989898',
            'password'  => Hash::make('MyPassword123'),
            'role'      => 'User',
        ]);

        $response = $this->postJson('/login', [
            'login'    => 'rahul@example.com',
            'password' => 'MyPassword123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'user'    => [
                    'id'    => $user->id,
                    'name'  => 'Rahul Verma',
                    'email' => 'rahul@example.com',
                    'role'  => 'User',
                ],
            ]);

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test user can log in with contact number (phone) and password.
     */
    public function test_user_can_login_with_contact_number(): void
    {
        $user = User::create([
            'name'      => 'Priya Patel',
            'email'     => 'priya@example.com',
            'contactNo' => '+919876500000',
            'password'  => Hash::make('PriyaPass2026'),
            'role'      => 'User',
        ]);

        $response = $this->postJson('/login', [
            'login'    => '+919876500000',
            'password' => 'PriyaPass2026',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'user'    => [
                    'id'    => $user->id,
                    'name'  => 'Priya Patel',
                    'email' => 'priya@example.com',
                ],
            ]);

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test login fails with wrong password.
     */
    public function test_login_fails_with_invalid_credentials(): void
    {
        User::create([
            'name'      => 'Vikram',
            'email'     => 'vikram@example.com',
            'contactNo' => '+91 9999988888',
            'password'  => Hash::make('Secret123'),
            'role'      => 'User',
        ]);

        $response = $this->postJson('/login', [
            'login'    => 'vikram@example.com',
            'password' => 'WrongPassword',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ]);

        $this->assertGuest();
    }

    /**
     * Test user can log out via API.
     */
    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/logout');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertGuest();
    }

    /**
     * Test /user/me returns authenticated status and user data.
     */
    public function test_user_me_endpoint(): void
    {
        // Unauthenticated
        $this->getJson('/user/me')
            ->assertStatus(200)
            ->assertJson([
                'authenticated' => false,
                'user'          => null,
            ]);

        // Authenticated
        $user = User::factory()->create([
            'name'      => 'Sneha Roy',
            'email'     => 'sneha@example.com',
            'contactNo' => '+91 7777766666',
            'role'      => 'User',
        ]);

        $this->actingAs($user)->getJson('/user/me')
            ->assertStatus(200)
            ->assertJson([
                'authenticated' => true,
                'user'          => [
                    'id'        => $user->id,
                    'name'      => 'Sneha Roy',
                    'email'     => 'sneha@example.com',
                    'contactNo' => '+91 7777766666',
                    'role'      => 'User',
                    'is_admin'  => false,
                ],
            ]);
    }

    /**
     * Test guest cannot access /account page and is redirected.
     */
    public function test_guest_cannot_access_account_page(): void
    {
        $response = $this->get('/account');
        $response->assertRedirect(route('home'));
    }

    /**
     * Test /account page is accessible when logged in.
     */
    public function test_account_page_is_accessible(): void
    {
        $user = User::factory()->create([
            'name'      => 'Sarah Jenkins',
            'email'     => 'sarah.jenkins@example.com',
            'contactNo' => '+1 (555) 123-4567',
        ]);

        $response = $this->actingAs($user)->get('/account');
        $response->assertStatus(200)
            ->assertSee('My Account')
            ->assertSee('Sarah Jenkins')
            ->assertSee('Recent Order')
            ->assertSee('Profile Details');
    }

    /**
     * Test user can update their profile information.
     */
    public function test_user_can_update_profile(): void
    {
        $user = User::factory()->create([
            'name'      => 'Original Name',
            'email'     => 'original@example.com',
            'contactNo' => '+91 1111122222',
        ]);

        $response = $this->actingAs($user)->postJson('/user/profile', [
            'name'      => 'Updated Name',
            'email'     => 'updated@example.com',
            'contactNo' => '+91 9999988888',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'user'    => [
                    'name'      => 'Updated Name',
                    'email'     => 'updated@example.com',
                    'contactNo' => '+91 9999988888',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'id'        => $user->id,
            'name'      => 'Updated Name',
            'email'     => 'updated@example.com',
            'contactNo' => '+91 9999988888',
        ]);
    }

    /**
     * Test /orders route redirects to /account?tab=orders.
     */
    public function test_orders_route_redirects_to_account_orders(): void
    {
        $response = $this->get('/orders');
        $response->assertRedirect('/account?tab=orders');
    }
}
