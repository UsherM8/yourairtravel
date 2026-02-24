<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'arrival_country',
        'arrival_city',
        'image_path',
        'tags',
        'is_active',
        'user_id'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
    ];

    // Connectie naar de beheerder die de blog schreef
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
