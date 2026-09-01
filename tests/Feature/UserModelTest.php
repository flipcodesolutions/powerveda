<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_table_has_expected_columns(): void
    {
        $columns = ['name', 'email', 'password', 'contactNo', 'role'];

        foreach ($columns as $column) {
            $this->assertTrue(
                Schema::hasColumn('users', $column),
                "Users table is missing column: {$column}"
            );
        }
    }

    public function test_user_can_be_created_with_default_role(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret123',
            'contactNo' => '+1234567890',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'contactNo' => '+1234567890',
            'role' => 'User',
        ]);

        $this->assertEquals('User', $user->role);
    }

    public function test_user_can_be_created_with_custom_role(): void
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'adminpassword',
            'contactNo' => '+9876543210',
            'role' => 'Admin',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'Admin',
        ]);

        $this->assertEquals('Admin', $user->role);
    }

    public function test_user_factory_generates_contact_no_and_default_role(): void
    {
        $user = User::factory()->create();

        $this->assertNotNull($user->name);
        $this->assertNotNull($user->email);
        $this->assertNotNull($user->contactNo);
        $this->assertEquals('User', $user->role);
    }
}
