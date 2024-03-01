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
        'user_id',
        'image',
    ];

    protected $casts = [
        'records' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
