<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\ConsultationAttachment;

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
     * Get attachments as an array of ConsultationAttachment objects.
     * Supports both new JSON array, hybrid payload with Base64, and legacy strings.
     *
     * @return ConsultationAttachment[]
     */
    public function getAttachmentsListAttribute(): array
    {
        if (empty($this->attachment)) {
            return [];
        }

        $decoded = json_decode($this->attachment, true);
        $items = is_array($decoded) ? $decoded : [$this->attachment];

        $list = [];
        foreach ($items as $item) {
            if (is_array($item)) {
                $list[] = new ConsultationAttachment($item);
            } elseif (is_string($item) && trim($item) !== '') {
                $list[] = new ConsultationAttachment(['path' => $item]);
            }
        }

        return $list;
    }
}
