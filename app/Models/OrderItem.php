<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'price',
        'qty',
        'image',
    ];

    /**
     * The accessors to append to the model's array and JSON form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'item_total',
        'photo_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'qty' => 'integer',
    ];

    /**
     * Get the order that owns this item.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the referenced product if still in catalog.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the line total for this item.
     */
    public function getItemTotalAttribute(): float
    {
        return (float) ($this->price * $this->qty);
    }

    /**
     * Get resolved image URL for display.
     */
    public function getPhotoUrlAttribute(): string
    {
        if (empty($this->image)) {
            return asset('image/products/product-1.jpg');
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        if (str_starts_with($this->image, 'products/') || str_starts_with($this->image, 'photos/')) {
            return asset('storage/' . $this->image);
        }

        if (str_starts_with($this->image, '/')) {
            return asset(ltrim($this->image, '/'));
        }

        return asset($this->image);
    }
}
