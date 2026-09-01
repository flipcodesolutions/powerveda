<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'email',
    'contactno',
    'subject',
    'messages',
    'status',
])]
class Contact extends Model
{
    use HasFactory;

    /**
     * Default model attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => 'Unread',
    ];

    /**
     * Check if inquiry is unread.
     */
    public function isUnread(): bool
    {
        return $this->status === 'Unread';
    }

    /**
     * Mark inquiry as read.
     */
    public function markAsRead(): void
    {
        if ($this->status === 'Unread') {
            $this->update(['status' => 'Read']);
        }
    }
}
