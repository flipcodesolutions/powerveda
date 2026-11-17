<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductCrudTest extends TestCase
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
     * 1. Test listing products on index page.
     */
    public function test_can_list_products(): void
    {
        Product::create([
            'name' => 'Test Ashwagandha Tonic',
            'price' => 1299.0,
            'stock' => 50,
            'detail' => 'Test formulation detail',
            'meta_title' => 'Test SEO Title',
            'meta_detail' => 'Test SEO Description',
            'badge' => 'NATURAL',
        ]);

        $response = $this->get('/admin/products');
        $response->assertStatus(200);
        $response->assertSee('Test Ashwagandha Tonic');
    }

    /**
     * 2. Test create form view renders successfully.
     */
    public function test_can_view_create_page(): void
    {
        $response = $this->get('/admin/products/create');
        $response->assertStatus(200);
        $response->assertSee('Create New Product');
    }

    /**
     * 3. Test saving product with photo and og_image upload via standard form POST.
     */
    public function test_can_store_product_with_file_uploads(): void
    {
        Storage::fake('public');

        $photoFile = UploadedFile::fake()->image('ashwagandha.jpg', 600, 600);
        $ogImageFile = UploadedFile::fake()->image('ashwagandha_og.jpg', 1200, 630);

        $payload = [
            'name' => 'Yuvar Dhan Shilajit Gold Resin',
            'price' => 2499.0,
            'stock' => 30,
            'photo' => $photoFile,
            'detail' => 'Pure Himalayan mountain-harvested Shilajit resin with 84+ ionic minerals.',
            'meta_title' => 'Buy Authentic Shilajit Gold Resin | Yuvar Dhan',
            'meta_detail' => 'Pure Himalayan Shilajit resin for peak stamina.',
            'og_image' => $ogImageFile,
        ];

        $response = $this->post('/admin/products', $payload);

        // Standard Laravel form post redirects to index with success
        $response->assertRedirect(route('admin.products.index'));
        $response->assertSessionHas('success', 'Product created successfully with usage steps & FAQs!');

        $product = Product::where('name', 'Yuvar Dhan Shilajit Gold Resin')->first();
        $this->assertNotNull($product);
        $this->assertNotNull($product->photo);
        $this->assertNotNull($product->og_image);

        // Assert files exist on storage disk
        Storage::disk('public')->assertExists($product->photo);
        Storage::disk('public')->assertExists($product->og_image);
    }

    /**
     * 3b. Test that meta_title, meta_detail, and og_image auto-fill from name, detail, and photo when left empty.
     */
    public function test_store_product_auto_fills_meta_and_og_from_name_detail_and_photo_when_empty(): void
    {
        Storage::fake('public');

        $photoFile = UploadedFile::fake()->image('neem_wash.jpg', 600, 600);

        $payload = [
            'name' => 'Yuvar Dhan Neem Cleanser',
            'price' => 699.0,
            'stock' => 50,
            'photo' => $photoFile,
            'detail' => 'Organic clarifying wash with active neem and tulsi extract.',
            'meta_title' => '',  // Left empty
            'meta_detail' => '',  // Left empty
            'og_image' => null,  // Left empty
        ];

        $response = $this->post('/admin/products', $payload);

        $response->assertRedirect(route('admin.products.index'));

        $product = Product::where('name', 'Yuvar Dhan Neem Cleanser')->first();
        $this->assertNotNull($product);

        // Verify meta_title was auto-filled from name
        $this->assertEquals('Yuvar Dhan Neem Cleanser', $product->meta_title);

        // Verify meta_detail was auto-filled from detail
        $this->assertEquals('Organic clarifying wash with active neem and tulsi extract.', $product->meta_detail);

        // Verify og_image was auto-filled from product photo
        $this->assertEquals($product->photo, $product->og_image);
    }

    /**
     * 4. Test edit form view renders successfully with product data.
     */
    public function test_can_view_edit_page(): void
    {
        $product = Product::create([
            'name' => 'Brahmi Brain Booster',
            'price' => 899.0,
            'stock' => 40,
            'detail' => 'Formulation for focus',
            'meta_title' => 'Brahmi Brain Focus',
            'meta_detail' => 'Focus and memory support',
        ]);

        $response = $this->get(route('admin.products.edit', $product));
        $response->assertStatus(200);
        $response->assertSee('Edit Product: Brahmi Brain Booster');
        $response->assertSee('899');
    }

    /**
     * 5. Test updating product and replacing files via standard form PUT.
     */
    public function test_can_update_product_and_replace_files(): void
    {
        Storage::fake('public');

        $initialPhoto = UploadedFile::fake()->image('old_photo.jpg');
        $product = Product::create([
            'name' => 'Old Product Name',
            'price' => 500.0,
            'stock' => 10,
            'photo' => $initialPhoto->store('products/photos', 'public'),
            'detail' => 'Old detail',
            'meta_title' => 'Old Meta Title',
            'meta_detail' => 'Old Meta Detail',
        ]);

        $newPhoto = UploadedFile::fake()->image('new_photo.jpg');
        $newOgImage = UploadedFile::fake()->image('new_og.jpg');

        $response = $this->put(route('admin.products.update', $product), [
            'name' => 'Updated Product Name',
            'price' => 799.0,
            'stock' => 25,
            'detail' => 'Updated detail',
            'meta_title' => 'Updated Meta Title',
            'meta_detail' => 'Updated Meta Detail',
            'photo' => $newPhoto,
            'og_image' => $newOgImage,
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $response->assertSessionHas('success', 'Product updated successfully with usage steps & FAQs!');

        $product->refresh();
        $this->assertEquals('Updated Product Name', $product->name);
        $this->assertEquals('799.00', $product->price);
        $this->assertEquals(25, $product->stock);

        Storage::disk('public')->assertExists($product->photo);
        Storage::disk('public')->assertExists($product->og_image);
    }

    /**
     * 6. Test deleting a product via standard form DELETE.
     */
    public function test_can_delete_product(): void
    {
        Storage::fake('public');

        $photo = UploadedFile::fake()->image('to_delete.jpg');
        $og = UploadedFile::fake()->image('og_to_delete.jpg');

        $photoPath = $photo->store('products/photos', 'public');
        $ogPath = $og->store('products/og_images', 'public');

        $product = Product::create([
            'name' => 'Product to Delete',
            'price' => 399.0,
            'stock' => 5,
            'photo' => $photoPath,
            'og_image' => $ogPath,
        ]);

        $response = $this->delete(route('admin.products.destroy', $product));
        $response->assertRedirect(route('admin.products.index'));
        $response->assertSessionHas('success', 'Product deleted successfully!');

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        Storage::disk('public')->assertMissing($photoPath);
        Storage::disk('public')->assertMissing($ogPath);
    }

    /**
     * 7. Test form validation on invalid input.
     */
    public function test_product_validation(): void
    {
        $response = $this->post('/admin/products', [
            'name' => '',  // Required
            'price' => -10,  // Must be >= 0
            'stock' => -5,  // Must be >= 0
        ]);

        $response->assertSessionHasErrors(['name', 'price', 'stock']);
    }
}
