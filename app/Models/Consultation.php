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
        'status',
        'response',
        'admin_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
