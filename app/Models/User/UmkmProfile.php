<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'owner_name',
        'nib',
        'pirt',
        'halal_cert',
        'address',
        'phone',
        'description',
        'map_link',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
