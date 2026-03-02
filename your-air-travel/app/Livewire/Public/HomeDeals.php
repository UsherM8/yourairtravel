<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Deal;
use App\Models\Blog; // We gebruiken je Blog model

class HomeDeals extends Component
{
    public function render()
    {
        // 1. Flash Deals (Slider)
        $instantDeals = Deal::whereNotNull('instant_deal_slot')
            ->where('is_active', true)
            ->with('primaryImage')
            ->orderBy('instant_deal_slot')
            ->get();
        // 2. Zonvakanties (Grid 4)
        $zonDeals = Deal::where('is_active', true)
            ->with('primaryImage')
            ->where(function($q) {
                $q->whereJsonContains('tags', 'Zonvakantie')
                  ->orWhere('tags', 'like', '%Zonvakantie%');
            })
            ->latest()->take(4)->get();
        // 3. Last Minutes (Grid 4)
        $lastMinuteDeals = Deal::where('is_active', true)
            ->with('primaryImage')
            ->where(function($q) {
                $q->whereJsonContains('tags', 'Last-Minute')
                  ->orWhere('tags', 'like', '%Last-Minute%');
            })
            ->latest()->take(4)->get();
        // 4. NIEUW: Laatste 3 Blogs (Grid 3)
        $latestBlogs = Blog::where('is_active', true) // Pas aan naar jouw status-veld (bijv. is_published)
            ->latest()
            ->take(3)
            ->get();
        return view('livewire.public.home-deals', [
            'zonDeals' => $zonDeals,
            'lastMinuteDeals' => $lastMinuteDeals,
            'instantDeals' => $instantDeals,
            'latestBlogs' => $latestBlogs
        ]);
    }
}
