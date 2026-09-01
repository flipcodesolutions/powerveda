<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_addresses_api(): void
    {
        $response = $this->getJson('/user/addresses');
        $response->assertStatus(401);
    }

    public function test_user_can_view_their_saved_addresses(): void
    {
        $user = User::factory()->create();
        Address::create([
            'user_id' => $user->id,
            'recipient_name' => 'Gohil Ravirajsinh',
            'contactNo' => '+919979404044',
            'address_line_1' => 'Flat 402, Lotus Residency',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
            'type' => 'Home',
            'is_default' => true,
        ]);

        $response = $this->actingAs($user)->getJson('/user/addresses');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'addresses')
            ->assertJsonPath('addresses.0.recipient_name', 'Gohil Ravirajsinh');
    }

    public function test_user_can_create_new_address_and_it_becomes_default_if_first(): void
    {
        $user = User::factory()->create();

        $payload = [
            'recipient_name' => 'Gohil Ravirajsinh',
            'contactNo' => '+919979404044',
            'address_line_1' => 'Flat 402, Lotus Residency',
            'address_line_2' => 'Near Green Park',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
            'type' => 'Home',
            'is_default' => false, // Will become default because it's first
        ];

        $response = $this->actingAs($user)->postJson('/user/addresses', $payload);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('address.recipient_name', 'Gohil Ravirajsinh')
            ->assertJsonPath('address.is_default', true);

        $this->assertDatabaseHas('addresses', [
            'user_id' => $user->id,
            'recipient_name' => 'Gohil Ravirajsinh',
            'city' => 'Mumbai',
            'is_default' => 1,
        ]);
    }

    public function test_user_can_store_multiple_addresses(): void
    {
        $user = User::factory()->create();

        // 1st Address (Default)
        $this->actingAs($user)->postJson('/user/addresses', [
            'recipient_name' => 'Gohil Ravirajsinh',
            'contactNo' => '+919979404044',
            'address_line_1' => 'Flat 402, Lotus Residency',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
            'type' => 'Home',
            'is_default' => true,
        ])->assertStatus(201);

        // 2nd Address (Work)
        $this->actingAs($user)->postJson('/user/addresses', [
            'recipient_name' => 'Gohil Office',
            'contactNo' => '+919979404044',
            'address_line_1' => 'Tower B, Cyber Hub',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400051',
            'type' => 'Work',
            'is_default' => false,
        ])->assertStatus(201);

        $this->assertEquals(2, $user->addresses()->count());
        $this->assertTrue($user->addresses()->where('type', 'Home')->first()->is_default);
        $this->assertFalse($user->addresses()->where('type', 'Work')->first()->is_default);
    }

    public function test_user_can_update_address(): void
    {
        $user = User::factory()->create();
        $address = Address::create([
            'user_id' => $user->id,
            'recipient_name' => 'Old Name',
            'contactNo' => '+919979404044',
            'address_line_1' => 'Old Street',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
            'type' => 'Home',
            'is_default' => true,
        ]);

        $response = $this->actingAs($user)->putJson("/user/addresses/{$address->id}", [
            'recipient_name' => 'Updated Ravirajsinh',
            'contactNo' => '+919979404044',
            'address_line_1' => 'Flat 402, Lotus Residency',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
            'type' => 'Home',
            'is_default' => true,
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('address.recipient_name', 'Updated Ravirajsinh');

        $this->assertDatabaseHas('addresses', [
            'id' => $address->id,
            'recipient_name' => 'Updated Ravirajsinh',
        ]);
    }

    public function test_user_can_set_address_as_default(): void
    {
        $user = User::factory()->create();
        $addr1 = Address::create([
            'user_id' => $user->id,
            'recipient_name' => 'Address 1',
            'contactNo' => '1111111111',
            'address_line_1' => 'Street 1',
            'city' => 'City 1',
            'state' => 'State 1',
            'pincode' => '111111',
            'is_default' => true,
        ]);

        $addr2 = Address::create([
            'user_id' => $user->id,
            'recipient_name' => 'Address 2',
            'contactNo' => '2222222222',
            'address_line_1' => 'Street 2',
            'city' => 'City 2',
            'state' => 'State 2',
            'pincode' => '222222',
            'is_default' => false,
        ]);

        $response = $this->actingAs($user)->postJson("/user/addresses/{$addr2->id}/default");

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertFalse($addr1->fresh()->is_default);
        $this->assertTrue($addr2->fresh()->is_default);
    }

    public function test_user_can_delete_address(): void
    {
        $user = User::factory()->create();
        $address = Address::create([
            'user_id' => $user->id,
            'recipient_name' => 'To Delete',
            'contactNo' => '1111111111',
            'address_line_1' => 'Street',
            'city' => 'City',
            'state' => 'State',
            'pincode' => '111111',
            'is_default' => true,
        ]);

        $response = $this->actingAs($user)->deleteJson("/user/addresses/{$address->id}");

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertDatabaseMissing('addresses', ['id' => $address->id]);
    }

    public function test_user_cannot_update_or_delete_another_users_address(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $address = Address::create([
            'user_id' => $user1->id,
            'recipient_name' => 'User1 Address',
            'contactNo' => '1111111111',
            'address_line_1' => 'Street 1',
            'city' => 'City 1',
            'state' => 'State 1',
            'pincode' => '111111',
            'is_default' => true,
        ]);

        // User 2 attempts to update User 1's address
        $response = $this->actingAs($user2)->putJson("/user/addresses/{$address->id}", [
            'recipient_name' => 'Hacked Name',
            'contactNo' => '1111111111',
            'address_line_1' => 'Street 1',
            'city' => 'City 1',
            'state' => 'State 1',
            'pincode' => '111111',
        ]);
        $response->assertStatus(403);

        // User 2 attempts to delete User 1's address
        $delResponse = $this->actingAs($user2)->deleteJson("/user/addresses/{$address->id}");
        $delResponse->assertStatus(403);

        $this->assertDatabaseHas('addresses', ['id' => $address->id]);
    }
}
