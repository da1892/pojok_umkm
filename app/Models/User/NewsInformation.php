<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsInformation extends Model
{
    use HasFactory;
    
    protected $table = 'news_informations';

    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'category',
        'image_path',
        'images',
        'is_published',
        'author_id',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'images' => 'array',
    ];

    public function author()
    {
        return $this->belongsTo(\App\Models\User\User::class, 'author_id');
    }

    /**
     * Get all images as array, fallback to image_path if images is empty.
     */
    public function getAllImagesAttribute()
    {
        if (!empty($this->images) && is_array($this->images)) {
            return $this->images;
        }

        if (!empty($this->image_path)) {
            return [$this->image_path];
        }

        return [];
    }
}
