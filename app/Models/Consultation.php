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

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function messages()
    {
        return $this->hasMany(ConsultationMessage::class, 'consultation_id')->orderBy('id', 'asc');
    }

    /**
     * Memeriksa apakah pengguna (pengkonsultasi) diizinkan membalas:
     * - Pengguna TIDAK diizinkan membalas jika status konsultasi adalah 'selesai' atau 'ditolak'.
     * - Pengguna HANYA bisa menjawab jika tiket masih aktif dan pesan terakhir di thread berasal dari 'admin'.
     */
    public function canUserReply(): bool
    {
        if (in_array(strtolower((string)$this->status), ['selesai', 'ditolak'])) {
            return false;
        }

        $lastMessage = $this->hasMany(ConsultationMessage::class, 'consultation_id')
            ->reorder()
            ->orderByDesc('id')
            ->first();

        if ($lastMessage) {
            return $lastMessage->sender_type === 'admin';
        }

        // Fallback jika belum ada baris di consultation_messages:
        // Diizinkan hanya jika admin sudah pernah memberikan respon
        return !empty($this->response);
    }

    /**
     * Mengambil seluruh percakapan thread pesan secara urut.
     */
    public function getThreadMessagesAttribute()
    {
        $msgs = $this->messages()->with('user')->get();

        if ($msgs->isNotEmpty()) {
            return $msgs;
        }

        // Fallback kompatibilitas untuk data lama yang belum terisi di consultation_messages
        $fallback = collect();
        if (!empty($this->message)) {
            $fallback->push(new ConsultationMessage([
                'id' => 0,
                'consultation_id' => $this->id,
                'sender_type' => 'user',
                'sender_name' => $this->name ?: 'Pengguna',
                'user_id' => $this->user_id,
                'message' => $this->message,
                'attachment' => $this->attachment,
                'created_at' => $this->created_at ?: now(),
            ]));
        }

        if (!empty($this->response)) {
            $fallback->push(new ConsultationMessage([
                'id' => 0,
                'consultation_id' => $this->id,
                'sender_type' => 'admin',
                'sender_name' => 'Admin Dinas Perdagangan & KUKM',
                'user_id' => $this->admin_id,
                'message' => $this->response,
                'attachment' => null,
                'created_at' => $this->updated_at ?: now(),
            ]));
        }

        return $fallback;
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
