<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test successful contact form submission by visitor.
     */
    public function test_visitor_can_submit_contact_form(): void
    {
        $payload = [
            'name'      => 'Rajesh Khanna',
            'email'     => 'rajesh.khanna@example.com',
            'contactno' => '+91 9876543210',
            'subject'   => 'Product Dosage & Consultation',
            'messages'  => 'I would like guidance on using Ashwagandha Gold KSM-66 capsules for post-workout stamina.',
        ];

        $response = $this->postJson('/contact', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'contact' => [
                    'name'    => 'Rajesh Khanna',
                    'email'   => 'rajesh.khanna@example.com',
                    'subject' => 'Product Dosage & Consultation',
                ],
            ]);

        $this->assertDatabaseHas('contacts', [
            'name'      => 'Rajesh Khanna',
            'email'     => 'rajesh.khanna@example.com',
            'contactno' => '+91 9876543210',
            'subject'   => 'Product Dosage & Consultation',
            'status'    => 'Unread',
        ]);
    }

    /**
     * Test all fields are strictly required for contact submission.
     */
    public function test_contact_form_validation_requires_all_fields(): void
    {
        $response = $this->postJson('/contact', [
            'name'      => '',
            'email'     => 'invalid-email',
            'contactno' => '',
            'subject'   => '',
            'messages'  => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'contactno', 'subject', 'messages']);
    }

    /**
     * Test guest cannot access admin contact inbox.
     */
    public function test_guest_cannot_access_admin_contacts(): void
    {
        $response = $this->get('/admin/contacts');
        $response->assertRedirect('/admin/login');
    }

    /**
     * Test non-admin regular user gets 403 forbidden for admin contact inbox.
     */
    public function test_non_admin_cannot_access_admin_contacts(): void
    {
        $user = User::factory()->create(['role' => 'User']);

        $response = $this->actingAs($user)->get('/admin/contacts');
        $response->assertStatus(403);
    }

    /**
     * Test admin can view, search, and filter contact messages.
     */
    public function test_admin_can_view_contact_messages(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $contact = Contact::factory()->create([
            'name'    => 'Sneha Kapoor',
            'subject' => 'Custom Bulk Order',
            'status'  => 'Unread',
        ]);

        $response = $this->actingAs($admin)->get('/admin/contacts');
        $response->assertStatus(200)
            ->assertSee('Sneha Kapoor')
            ->assertSee('Custom Bulk Order');
    }

    /**
     * Test admin can update contact message status.
     */
    public function test_admin_can_update_contact_status(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $contact = Contact::factory()->create(['status' => 'Unread']);

        $response = $this->actingAs($admin)->patchJson("/admin/contacts/{$contact->id}/status", [
            'status' => 'Read',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'status'  => 'Read',
            ]);

        $this->assertDatabaseHas('contacts', [
            'id'     => $contact->id,
            'status' => 'Read',
        ]);
    }

    /**
     * Test admin can delete contact message.
     */
    public function test_admin_can_delete_contact_message(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $contact = Contact::factory()->create();

        $response = $this->actingAs($admin)->deleteJson("/admin/contacts/{$contact->id}");

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);
    }
}
