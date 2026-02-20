<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

protected $fillable = [
    'title',
    'description',
    'price',
    'discounted_price',
    'departure_city',
    'departure_country',
    'arrival_city',
    'arrival_country',
    'airline',
    'departure_date',
    'return_date',
    'referral_url',
    'is_active',
    'click_count',
    'tags'
];

protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
    ];

    public function images()
    {
        return $this->hasMany(DealImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(DealImage::class)->where('is_primary', true);
    }

}
