<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'author',
        'location',
        'product_id',
        'rating',
        'comment',
        'photo',
        'status',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Relationship: A review belongs to a Product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Accessor: Resolve photo URL cleanly.
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            if (Storage::disk('public')->exists($this->photo)) {
                return Storage::disk('public')->url($this->photo);
            }
            if (str_starts_with($this->photo, 'image/')) {
                return asset($this->photo);
            }
            return asset('storage/' . ltrim($this->photo, '/'));
        }

        // Default avatar with initials or fallback image
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->author) . '&background=061E43&color=D8BC8D&size=100';
    }
}
