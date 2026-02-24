<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Deal;

class HomeDeals extends Component
{
    public function render()
    {
        // We zoeken op beide varianten (met en zonder streepje) voor de zekerheid
        $zonDeals = Deal::where('is_active', true)
            ->where(function($q) {
                $q->whereJsonContains('tags', 'Zonvakantie')
                  ->orWhere('tags', 'like', '%Zonvakantie%');
            })
            ->latest()->take(4)->get();

        $lastMinuteDeals = Deal::where('is_active', true)
            ->where(function($q) {
                $q->whereJsonContains('tags', 'Last-Minute') // Met streepje
                  ->orWhereJsonContains('tags', 'Last Minute') // Met spatie
                  ->orWhere('tags', 'like', '%Last-Minute%')
                  ->orWhere('tags', 'like', '%Last Minute%');
            })
            ->latest()->take(4)->get();

        return view('livewire.public.home-deals', [
            'zonDeals' => $zonDeals,
            'lastMinuteDeals' => $lastMinuteDeals,
        ]);
    }
}
