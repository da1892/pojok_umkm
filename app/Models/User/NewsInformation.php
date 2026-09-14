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
        'content',
        'category',
        'image_path',
        'author_id',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
