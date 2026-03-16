<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Deal;

class DealRoulette extends Component
{
    public $departureDate = null;
    public $deals = []; // Hier slaan we precies 8 vakjes in op
    public $hasDeals = false;

    public function mount()
    {
        $this->loadDeals();
    }

    // Deze functie vuurt automatisch af als de datum wordt aangepast!
    public function updatedDepartureDate()
    {
        $this->loadDeals();
    }

    public function loadDeals()
    {
        $query = Deal::where('is_active', true);

        // Filter op datum (vanaf de gekozen datum)
        if ($this->departureDate) {
            $query->whereDate('departure_date', '>=', $this->departureDate);
        }

        // Haal maximaal 8 willekeurige deals op
        $fetchedDeals = $query->inRandomOrder()->take(8)->get(['id', 'title', 'arrival_city', 'arrival_country']);

        $paddedDeals = collect();

        // We hebben precies 8 partjes nodig voor het wiel.
        // Als we bijv. maar 3 deals vinden, herhalen we ze tot de 8 vol is.
        if ($fetchedDeals->count() > 0) {
            $this->hasDeals = true;
            while ($paddedDeals->count() < 8) {
                foreach ($fetchedDeals as $d) {
                    if ($paddedDeals->count() < 8) {
                        $paddedDeals->push([
                            'id' => $d->id,
                            'title' => $d->title,
                            'city' => $d->arrival_city,
                            'country' => $d->arrival_country,
                        ]);
                    }
                }
            }
        } else {
            $this->hasDeals = false;
            // Nood-opvulling als er écht nul deals zijn voor deze datum
            for ($i = 0; $i < 8; $i++) {
                $paddedDeals->push(['id' => null, 'title' => 'Geen', 'city' => 'Helaas', 'country' => '']);
            }
        }

        $this->deals = $paddedDeals->toArray();
    }

    public function spinWheel()
    {
        if (!$this->hasDeals) {
            return null; // Stop als er niks is
        }

        // Kies het winnende vakje (0 tot 7)
        $winningIndex = rand(0, 7);
        $winner = $this->deals[$winningIndex];

        return [
            'index' => $winningIndex,
            'id' => $winner['id'],
            'location' => $winner['city'] . ', ' . $winner['country'],
        ];
    }

    public function render()
    {
        return view('livewire.public.deal-roulette');
    }
}
