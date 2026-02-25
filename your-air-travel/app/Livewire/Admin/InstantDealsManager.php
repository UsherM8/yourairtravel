<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Deal;

class InstantDealsManager extends Component
{
    public $activeSlot = null; // Houdt bij op welk van de 8 blokken je hebt geklikt
    public $search = ''; // Voor als je veel deals hebt en er eentje zoekt

    // Open de deal-kiezer voor een specifiek blok
    public function openSelector($slotNumber)
    {
        $this->activeSlot = $slotNumber;
        $this->search = '';
    }

    // Sluit de kiezer
    public function closeSelector()
    {
        $this->activeSlot = null;
    }

    // Koppel een deal aan het gekozen blok
    public function assignDeal($dealId)
    {
        // 1. Haal een eventuele oude deal uit dit blok
        Deal::where('instant_deal_slot', $this->activeSlot)->update(['instant_deal_slot' => null]);

        // 2. Zet de nieuwe deal in dit blok
        $deal = Deal::find($dealId);
        if ($deal) {
            $deal->update(['instant_deal_slot' => $this->activeSlot]);
        }

        // 3. Sluit de kiezer
        $this->closeSelector();
    }

    // Haal een deal uit een blok (blok weer leegmaken)
    public function clearSlot($slotNumber)
    {
        Deal::where('instant_deal_slot', $slotNumber)->update(['instant_deal_slot' => null]);
    }

    public function render()
    {
        // Haal de huidige deals op die aan een slot zijn gekoppeld (1 t/m 8)
        $slottedDeals = Deal::whereNotNull('instant_deal_slot')->get()->keyBy('instant_deal_slot');

        // Haal beschikbare deals op voor in de zoeklijst
        $availableDeals = collect();
        if ($this->activeSlot !== null) {
            $availableDeals = Deal::where('is_active', true)
                ->whereNull('instant_deal_slot') // <-- DEZE REGEL ZORGT DAT GEKOZEN DEALS VERDWIJNEN
                ->where(function($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('destination', 'like', '%' . $this->search . '%');
                })
                ->take(15)
                ->get();
        }

        return view('livewire.admin.instant-deals-manager', [
            'slots' => range(1, 8), // Genereert een array [1, 2, 3, 4, 5, 6, 7, 8]
            'slottedDeals' => $slottedDeals,
            'availableDeals' => $availableDeals,
        ])->layout('layouts.app'); // <-- HIER IS DE FIX TOEGEVOEGD
    }
}
