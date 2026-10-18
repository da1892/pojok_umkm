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
        'images',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function getAllImagesAttribute(): array
    {
        if (!empty($this->images) && is_array($this->images)) {
            return $this->images;
        }
        return $this->image_path ? [$this->image_path] : [];
    }

    public function umkmProfile()
    {
        return $this->belongsTo(UmkmProfile::class);
    }
}