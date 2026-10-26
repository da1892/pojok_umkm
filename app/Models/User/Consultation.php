<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Support\ConsultationAttachment;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
