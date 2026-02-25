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
    'departure_city',
    'arrival_city',
    'arrival_country',
    'price',
    'discounted_price',
    'airline',
    'departure_date',
    'return_date',
    'duration_days',
    'tags',
    'referral_url',
    'instant_deal_slot',
    'is_active'
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
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
