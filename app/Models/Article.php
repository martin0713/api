<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'body',
        'records',
        'author_id',
        'image',
    ];

    protected $casts = [
        'records' => 'array',
    ];
}
