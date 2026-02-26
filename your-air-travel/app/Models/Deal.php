<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'departure_city',
        'arrival_city',
        'arrival_country',
        'arrival_continent', // Toegevoegd n.a.v. je migratie
        'price',
        'discounted_price',
        'airline',
        'departure_date',
        'duration_days',
        'tags',
        'referral_url',
        'instant_deal_slot',
        'is_active',
        'user_id'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
        'departure_date' => 'date',
    ];

    /**
     * De "Booted" methode voor Global Scopes
     */
    protected static function booted()
    {
        static::addGlobalScope('exclude_expired', function (Builder $builder) {
            // Pas de filter alleen toe als we NIET in het admin-gedeelte zijn
            if (!request()->is('admin*') && !request()->is('livewire/update*')) {
                $builder->where('is_active', true)
                        ->whereDate('departure_date', '>=', now()->startOfDay());
            }
        });
    }

    /**
     * Accessor: Bereken de terugkomstdatum live op basis van reisduur
     */
    public function getCalculatedReturnDateAttribute()
    {
        return $this->departure_date ? $this->departure_date->copy()->addDays($this->duration_days) : null;
    }

    // --- RELATIES ---

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
