<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReviewCrudTest extends TestCase
{
    use RefreshDatabase;

    protected \App\Models\User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = \App\Models\User::factory()->create(['role' => 'Admin']);
        $this->actingAs($this->admin);
    }

    /**
     * 1. Test listing reviews on index page.
     */
    public function test_can_list_reviews(): void
    {
        $review = Review::create([
            'author'   => 'Dr. Anjali Sen',
            'location' => 'Kolkata, West Bengal',
            'rating'   => 5,
            'comment'  => 'Remarkable purity and authentic formulation. Highly recommended.',
            'status'   => 'Approved',
        ]);

        $response = $this->get('/admin/reviews');
        $response->assertStatus(200);
        $response->assertSee('Dr. Anjali Sen');
        $response->assertSee('Remarkable purity');
    }

    /**
     * 2. Test create form view renders successfully with products dropdown.
     */
    public function test_can_view_create_page(): void
    {
        $product = Product::create([
            'name'  => 'Power Veda Shilajit Gold',
            'price' => 2499.00,
            'stock' => 50,
        ]);

        $response = $this->get('/admin/reviews/create');
        $response->assertStatus(200);
        $response->assertSee('Add Customer Review');
        $response->assertSee('Power Veda Shilajit Gold');
    }

    /**
     * 3. Test saving review with reviewer photo upload via standard form POST.
     */
    public function test_can_store_review_with_photo(): void
    {
        Storage::fake('public');

        $product = Product::create([
            'name'  => 'Power Veda Ashwagandha KSM-66',
            'price' => 1499.00,
            'stock' => 100,
        ]);

        $photoFile = UploadedFile::fake()->image('customer_avatar.jpg', 300, 300);

        $payload = [
            'author'     => 'Kavita Iyer',
            'location'   => 'Chennai, Tamil Nadu',
            'product_id' => $product->id,
            'rating'     => 5,
            'comment'    => 'Great results within two weeks of regular consumption.',
            'status'     => 'Approved',
            'photo'      => $photoFile,
        ];

        $response = $this->post('/admin/reviews', $payload);

        $response->assertRedirect(route('admin.reviews.index'));
        $response->assertSessionHas('success', 'Customer review added successfully!');

        $review = Review::where('author', 'Kavita Iyer')->first();
        $this->assertNotNull($review);
        $this->assertEquals(5, $review->rating);
        $this->assertEquals($product->id, $review->product_id);
        $this->assertNotNull($review->photo);

        // Assert file exists on storage disk
        Storage::disk('public')->assertExists($review->photo);
    }

    /**
     * 4. Test edit form view renders successfully with review data.
     */
    public function test_can_view_edit_page(): void
    {
        $review = Review::create([
            'author'   => 'Rohan Varma',
            'location' => 'Pune',
            'rating'   => 4,
            'comment'  => 'Good product packaging and timely dispatch.',
            'status'   => 'Pending',
        ]);

        $response = $this->get("/admin/reviews/{$review->id}/edit");
        $response->assertStatus(200);
        $response->assertSee('Edit Review: Rohan Varma');
        $response->assertSee('Good product packaging');
    }

    /**
     * 5. Test updating review and replacing photo via standard form PUT.
     */
    public function test_can_update_review_and_replace_photo(): void
    {
        Storage::fake('public');

        $initialPhoto = UploadedFile::fake()->image('old_avatar.jpg');
        $review = Review::create([
            'author'   => 'Old Reviewer',
            'location' => 'Delhi',
            'rating'   => 3,
            'comment'  => 'Old comment text',
            'photo'    => $initialPhoto->store('reviews/photos', 'public'),
            'status'   => 'Pending',
        ]);

        $newPhoto = UploadedFile::fake()->image('new_avatar.jpg');

        $response = $this->put("/admin/reviews/{$review->id}", [
            'author'   => 'Updated Reviewer Name',
            'location' => 'New Delhi',
            'rating'   => 5,
            'comment'  => 'Updated energetic feedback after longer usage.',
            'status'   => 'Approved',
            'photo'    => $newPhoto,
        ]);

        $response->assertRedirect(route('admin.reviews.index'));
        $response->assertSessionHas('success', 'Customer review updated successfully!');

        $review->refresh();
        $this->assertEquals('Updated Reviewer Name', $review->author);
        $this->assertEquals('Approved', $review->status);
        $this->assertEquals(5, $review->rating);

        Storage::disk('public')->assertExists($review->photo);
    }

    /**
     * 6. Test deleting a review via standard form DELETE.
     */
    public function test_can_delete_review(): void
    {
        Storage::fake('public');

        $photo = UploadedFile::fake()->image('review_to_delete.jpg');
        $photoPath = $photo->store('reviews/photos', 'public');

        $review = Review::create([
            'author'  => 'Reviewer to Delete',
            'rating'  => 2,
            'comment' => 'Comment to be removed',
            'photo'   => $photoPath,
            'status'  => 'Hidden',
        ]);

        $response = $this->delete("/admin/reviews/{$review->id}");
        $response->assertRedirect(route('admin.reviews.index'));
        $response->assertSessionHas('success', 'Customer review deleted successfully!');

        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
        Storage::disk('public')->assertMissing($photoPath);
    }

    /**
     * 7. Test form validation on invalid review inputs.
     */
    public function test_review_validation(): void
    {
        $response = $this->post('/admin/reviews', [
            'author'  => '', // Required
            'rating'  => 10, // Must be 1 to 5
            'comment' => '', // Required
            'status'  => 'InvalidStatus', // Must be in Approved, Pending, Hidden
        ]);

        $response->assertSessionHasErrors(['author', 'rating', 'comment', 'status']);
    }
}
