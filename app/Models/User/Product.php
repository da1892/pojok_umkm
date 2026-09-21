<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'umkm_profile_id',
        'name',
        'description',
        'category',
        'price',
        'image_path',
        'status',
    ];

    public function umkmProfile()
    {
        return $this->belongsTo(UmkmProfile::class);
    }
}