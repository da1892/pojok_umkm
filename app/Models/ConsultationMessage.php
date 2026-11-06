<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Support\ConsultationAttachment;

class ConsultationMessage extends Model
{
    use HasFactory;

    protected $table = 'consultation_messages';

    protected $fillable = [
        'consultation_id',
        'sender_type',
        'sender_name',
        'user_id',
        'message',
        'attachment',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get attachments as an array of ConsultationAttachment objects.
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

