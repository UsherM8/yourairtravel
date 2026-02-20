<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Deal;

class DealList extends Component
{
    // Hier slaan we de actieve filters in op
    public $filters = [
        'landen' => [],
        'steden' => [],
        'budgetten' => [],
        // Je kunt deze later verder uitbreiden voor reisduur, etc.
    ];

    // Deze functie wordt Aangeroepen zodra de Searchbar een signaal 'filters-updated' stuurt
    #[On('filters-updated')]
    public function updateFilters($nieuweFilters)
    {
        $this->filters = $nieuweFilters;
    }

    public function render()
    {
        // 1. Begin met een basis query (alleen actieve deals)
        $query = Deal::where('is_active', true);

        // 2. Filter op Landen of Steden
        if (!empty($this->filters['steden'])) {
            $query->whereIn('arrival_city', $this->filters['steden']);
        } elseif (!empty($this->filters['landen'])) {
            // Als er wel landen zijn gekozen, maar geen specifieke steden
            // Let op: dit werkt alleen als je 'arrival_country' ook netjes invult bij het aanmaken!
            $query->whereIn('arrival_country', $this->filters['landen']);
        }

        // 3. Filter op Budget (We pakken het hoogste aangevinkte budget)
        if (!empty($this->filters['budgetten'])) {
            $maxBudget = max($this->filters['budgetten']);
            // Als ze '501' (500+) niet hebben aangevinkt, filteren we op de max prijs
            if ($maxBudget <= 500) {
                $query->where('discounted_price', '<=', $maxBudget);
            }
        }

        // 4. Haal de resultaten op (nieuwste eerst)
        $deals = $query->latest()->get();

        return view('livewire.public.deal-list', [
            'deals' => $deals
        ]);
    }
}
