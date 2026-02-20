<?php

namespace App\Livewire\Public;

use Livewire\Component;

class Searchbar extends Component
{
    //Llijst met landen en hun steden
    public $beschikbareBestemmingen = [
        'Spanje' => ['Barcelona', 'Madrid', 'Valencia', 'Ibiza', 'Mallorca', 'Malaga'],
        'Italië' => ['Rome', 'Milaan', 'Venetië', 'Napels', 'Sicilië'],
        'Griekenland' => ['Athene', 'Kreta', 'Santorini', 'Rhodos', 'Kos'],
        'Turkije' => ['Istanbul', 'Antalya', 'Bodrum'],
        'Frankrijk' => ['Parijs', 'Nice', 'Lyon', 'Marseille'],
        'Portugal' => ['Lissabon', 'Porto', 'Faro (Algarve)'],
        'Verenigd Koninkrijk' => ['Londen', 'Edinburgh', 'Manchester'],
        'Indonesië' => ['Bali', 'Jakarta'],
    ];

    //multi-select arrays
    public $geselecteerdeLanden = [];
    public $geselecteerdeSteden = [];

    //filters
    public $reisperiodes = [];
    public $vertrekluchthavens = [];
    public $budgetten = [];
    public $vakantietypes = [];
    public $reisduren = [];

    public function setBestemming($land)
    {
        // Als het land nog niet is aangevinkt, vinken we hem aan
        if (!in_array($land, $this->geselecteerdeLanden)) {
            $this->geselecteerdeLanden[] = $land;
        }
        $this->search();
    }

    // Automatisch search
    public function updated()
    {
        // Zorg dat steden van afgevinkte landen ook netjes worden afgevinkt
        foreach ($this->geselecteerdeSteden as $key => $stad) {
            $hoortBijGeselecteerdLand = false;
            foreach ($this->geselecteerdeLanden as $land) {
                if (in_array($stad, $this->beschikbareBestemmingen[$land])) {
                    $hoortBijGeselecteerdLand = true;
                    break;
                }
            }
            if (!$hoortBijGeselecteerdLand) {
                unset($this->geselecteerdeSteden[$key]);
            }
        }

        $this->search();
    }

    public function search()
    {
        $this->dispatch('filters-updated', [
            'landen' => $this->geselecteerdeLanden,
            'steden' => $this->geselecteerdeSteden,
            'reisperiodes' => $this->reisperiodes,
            'vertrekluchthavens' => $this->vertrekluchthavens,
            'budgetten' => $this->budgetten,
            'vakantietypes' => $this->vakantietypes,
            'reisduren' => $this->reisduren,
        ]);
    }

    public function render()
    {
        return view('livewire.public.searchbar');
    }
}
