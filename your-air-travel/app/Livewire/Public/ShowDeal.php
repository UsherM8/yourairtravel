<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Deal;

class ShowDeal extends Component
{
    public Deal $deal;

    public function mount(Deal $deal)
    {
        // 1. Controleer of de deal actief is! Zo niet, gooi direct een mooie 404-foutpagina.
        if (!$deal->is_active) {
            abort(404);
        }

        $this->deal = $deal;

        // 2. Verhoog de teller voor paginaweergaven (alleen als hij actief is dus!)
        $this->deal->increment('click_count');
    }

    public function render()
    {
        return view('livewire.public.show-deal')->layout('layouts.public');
    }
}
