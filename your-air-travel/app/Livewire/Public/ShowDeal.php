<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Deal;

class ShowDeal extends Component
{
    public Deal $deal;

    public function mount(Deal $deal)
    {
        $this->deal = $deal;

        // Verhoog de klikteller elke keer als iemand de pagina opent
        $this->deal->increment('click_count');
    }

public function render()
    {
        // VERANDERD: ->layout('layouts.public') in plaats van guest
        return view('livewire.public.show-deal')->layout('layouts.public');
    }
}
