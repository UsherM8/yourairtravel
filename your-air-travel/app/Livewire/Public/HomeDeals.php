<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Deal;

class HomeDeals extends Component
{
    public function render()
    {
        // Haal max 5 Last-minutes op
        $lastMinutes = Deal::where('is_active', true)
            ->whereJsonContains('tags', 'Last-Minute')
            ->latest()->take(5)->get();

        // Haal max 5 Zonvakanties op
        $zonvakanties = Deal::where('is_active', true)
            ->whereJsonContains('tags', 'Zonvakantie')
            ->latest()->take(5)->get();

        // Haal max 5 willekeurige 'Vluchten' (deals met een specifieke airline) op
        $vluchten = Deal::where('is_active', true)
            ->whereNotNull('airline')
            ->latest()->take(5)->get();

        return view('livewire.public.home-deals', [
            'lastMinutes' => $lastMinutes,
            'zonvakanties' => $zonvakanties,
            'vluchten' => $vluchten,
        ]);
    }
}
