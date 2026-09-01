<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'price',
        'photo',
        'stock',
        'detail',
        'how_to_use',
        'how_to_use_steps',
        'meta_title',
        'meta_detail',
        'og_image',
        'badge',
        'original_price',
        'discount',
        'rating',
        'reviews_count',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->name);
            }
        });

        static::updating(function (Product $product) {
            if (empty($product->slug) || ($product->isDirty('name') && !$product->isDirty('slug'))) {
                $product->slug = static::generateUniqueSlug($product->name, $product->id);
            }
        });
    }

    /**
     * Generate a unique slug for the product.
     */
    public static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = \Illuminate\Support\Str::slug($name);
        if (empty($baseSlug)) {
            $baseSlug = 'product-' . time();
        }

        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    /**
     * The accessors to append to the model's array and JSON form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'photo_url',
        'how_to_use_steps_list',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'stock' => 'integer',
        'rating' => 'decimal:1',
        'reviews_count' => 'integer',
        'how_to_use_steps' => 'array',
    ];

    /**
     * Get the resolved URL for the product photo.
     */
    public function getPhotoUrlAttribute(): string
    {
        if (empty($this->photo)) {
            return asset('image/products/product-1.jpg');
        }

        // If path begins with http/https
        if (str_starts_with($this->photo, 'http://') || str_starts_with($this->photo, 'https://')) {
            return $this->photo;
        }

        // If stored in storage/
        if (str_starts_with($this->photo, 'products/') || str_starts_with($this->photo, 'photos/')) {
            return asset('storage/' . $this->photo);
        }

        return asset($this->photo);
    }

    /**
     * Get the resolved URL for the OG Image.
     */
    public function getOgImageUrlAttribute(): ?string
    {
        if (empty($this->og_image)) {
            return $this->photo_url;
        }

        if (str_starts_with($this->og_image, 'http://') || str_starts_with($this->og_image, 'https://')) {
            return $this->og_image;
        }

        if (str_starts_with($this->og_image, 'products/') || str_starts_with($this->og_image, 'og_images/')) {
            return asset('storage/' . $this->og_image);
        }

        return asset($this->og_image);
    }

    /**
     * Determine stock status label.
     */
    public function getStockStatusAttribute(): string
    {
        if ($this->stock <= 0) {
            return 'Out of Stock';
        }
        if ($this->stock <= 20) {
            return 'Low Stock';
        }
        return 'In Stock';
    }

    /**
     * Get structured list of steps for 'How to Use'.
     * Falls back to default steps if not explicitly configured.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getHowToUseStepsListAttribute(): array
    {
        if (!empty($this->how_to_use_steps) && is_array($this->how_to_use_steps) && count($this->how_to_use_steps) > 0) {
            return $this->how_to_use_steps;
        }

        // If general how_to_use text is provided, build a concise 3-4 step structure around it
        $generalUsage = $this->how_to_use ?: ($this->detail ?: 'Take as recommended by your Ayurvedic health practitioner.');

        return [
            [
                'step_number' => '01',
                'title'       => 'Dosage & Measure',
                'description' => $generalUsage,
                'timing'      => 'Daily Routine',
                'icon'        => 'bi-capsule',
            ],
            [
                'step_number' => '02',
                'title'       => 'Optimal Vehicle (Anupana)',
                'description' => 'Consume with warm water, organic milk, or honey 30 minutes after your meal for rapid bio-cellular assimilation.',
                'timing'      => 'Morning / Evening',
                'icon'        => 'bi-cup-hot',
            ],
            [
                'step_number' => '03',
                'title'       => 'Ritual Consistency',
                'description' => 'Maintain consistent daily consumption for 60 to 90 continuous days to allow sacred adaptogens to nourish deep tissues.',
                'timing'      => '60-90 Days',
                'icon'        => 'bi-calendar-check',
            ],
            [
                'step_number' => '04',
                'title'       => 'Holistic Synergy',
                'description' => 'Pair with balanced hydration, mindful breathing (Pranayama), and a clean whole-food Ayurvedic diet.',
                'timing'      => 'Daily Wellness',
                'icon'        => 'bi-heart-pulse',
            ],
        ];
    }

    /**
     * Relationship: A product has many FAQs.
     */
    public function faqs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductFaq::class)->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Relationship: Active FAQs for visitor storefront.
     */
    public function activeFaqs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductFaq::class)->where('is_active', true)->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Relationship: A product has many customer reviews.
     */
    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Relationship: A product has many order line items.
     */
    public function orderItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}

