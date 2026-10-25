<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
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
        'admin_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
}
