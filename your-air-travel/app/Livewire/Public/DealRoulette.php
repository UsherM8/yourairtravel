<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Deal;

class DealRoulette extends Component
{
    public $departureDate = null;
    public $selectedDeal = null; 
    public $noDealsFound = false;

    public function getRandomDeal()
    {
        $query = Deal::where('is_active', true);

        if ($this->departureDate) {
            $query->whereDate('departure_date', '>=', $this->departureDate);
        }

        $deal = $query->inRandomOrder()->first();

        if ($deal) {
            $this->selectedDeal = $deal;
            $this->noDealsFound = false;
        } else {
            $this->selectedDeal = null;
            $this->noDealsFound = true;
        }
    }

    public function render()
    {
        return view('livewire.public.deal-roulette');
    }
}
