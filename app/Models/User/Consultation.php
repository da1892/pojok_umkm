<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_id',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'attachment',
        'status',
        'response',
        'admin_id',
    ];

    /**
     * Get attachments as an array.
     * Supports both new JSON array and legacy single string.
     */
    public function getAttachmentsListAttribute(): array
    {
        if (empty($this->attachment)) {
            return [];
        }

        $decoded = json_decode($this->attachment, true);
        if (is_array($decoded)) {
            return $decoded;
        }

        return [$this->attachment];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
