<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'published_at',
        'description',
        'image_url',
    ];


    protected $casts = [
        'published_at' => 'datetime'
    ];
}
