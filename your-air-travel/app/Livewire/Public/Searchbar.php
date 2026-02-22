<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Deal;

class Searchbar extends Component
{
    public $geselecteerdeLanden = [];
    public $geselecteerdeSteden = [];
    public $vertrekluchthavens = [];

    public $min_budget = 0;
    public $max_budget = 2000;

    public $vakantietypes = [];
    public $reisduren = [];
    public $datum_van;
    public $datum_tot;

    public $resultCount = 0;

    // We hebben hier een aparte functie van gemaakt. Veel sneller voor de laadtijd!
    public function getBestemmingenLijst()
    {
        return [
            'Spanje' => ['Barcelona', 'Madrid', 'Valencia', 'Ibiza', 'Mallorca', 'Malaga', 'Canarische Eilanden'],
            'Italië' => ['Rome', 'Milaan', 'Venetië', 'Napels', 'Sicilië'],
            'Griekenland' => ['Athene', 'Kreta', 'Santorini', 'Rhodos', 'Kos'],
            'Portugal' => ['Lissabon', 'Porto', 'Faro (Algarve)', 'Madeira'],
            'Turkije' => ['Istanbul', 'Antalya', 'Bodrum', 'Alanya'],
            'Nederland' => ['Amsterdam', 'Rotterdam', 'Maastricht', 'Texel'],
            'ABC-Eilanden' => ['Aruba', 'Bonaire', 'Curaçao'],
            'Egypte' => ['Hurghada', 'Sharm el-Sheikh', 'Caïro'],
            'Marokko' => ['Marrakech', 'Agadir', 'Casablanca'],
            'Kaapverdië' => ['Sal', 'Boa Vista', 'São Vicente'],
            'Senegal' => ['Dakar'],
            'Kenia' => ['Nairobi', 'Mombasa'],
            'Zuid-Afrika' => ['Kaapstad', 'Johannesburg', 'Krugerpark'],
            'Ver. Arabische Emiraten' => ['Dubai', 'Abu Dhabi'],
            'Indonesië' => ['Bali', 'Jakarta', 'Lombok'],
            'Thailand' => ['Bangkok', 'Phuket', 'Koh Samui'],
            'Vietnam' => ['Hanoi', 'Ho Chi Minhstad'],
            'Japan' => ['Tokio', 'Kyoto', 'Osaka'],
            'China' => ['Beijing', 'Shanghai']
        ];
    }

    public function mount()
    {
        $this->geselecteerdeLanden = (array) request()->query('landen', []);
        $this->geselecteerdeSteden = (array) request()->query('steden', []);
        $this->vertrekluchthavens = (array) request()->query('vertrekluchthavens', []);

        $this->min_budget = request()->query('min_budget', 0);
        $this->max_budget = request()->query('max_budget', 2000);

        $this->vakantietypes = (array) request()->query('vakantietypes', []);
        $this->reisduren = (array) request()->query('reisduren', []);

        $this->datum_van = request()->query('datum_van');
        $this->datum_tot = request()->query('datum_tot');

        $this->calculateCount();
    }

    public function updatedMinBudget($value)
    {
        if ($value > $this->max_budget) {
            $this->max_budget = $value;
        }
        $this->calculateCount();
    }

    public function updatedMaxBudget($value)
    {
        if ($value < $this->min_budget) {
            $this->min_budget = $value;
        }
        $this->calculateCount();
    }

    public function setBestemming($land)
    {
        if (in_array($land, $this->geselecteerdeLanden)) {
            $this->geselecteerdeLanden = array_diff($this->geselecteerdeLanden, [$land]);
        } else {
            $this->geselecteerdeLanden[] = $land;
        }
        $this->calculateCount();
    }

    public function updated()
    {
        $alleBestemmingen = $this->getBestemmingenLijst();

        foreach ($this->geselecteerdeSteden as $key => $stad) {
            $hoortBijGeselecteerdLand = false;
            foreach ($this->geselecteerdeLanden as $land) {
                if (isset($alleBestemmingen[$land]) && in_array($stad, $alleBestemmingen[$land])) {
                    $hoortBijGeselecteerdLand = true;
                    break;
                }
            }
            if (!$hoortBijGeselecteerdLand) {
                unset($this->geselecteerdeSteden[$key]);
            }
        }

        $this->calculateCount();
    }

    public function calculateCount()
    {
        $query = Deal::where('is_active', true);

        if (!empty($this->geselecteerdeSteden)) $query->whereIn('arrival_city', $this->geselecteerdeSteden);
        elseif (!empty($this->geselecteerdeLanden)) $query->whereIn('arrival_country', $this->geselecteerdeLanden);

        if ($this->min_budget > 0) {
            $query->where('discounted_price', '>=', $this->min_budget);
        }
        if ($this->max_budget < 2000) {
            $query->where('discounted_price', '<=', $this->max_budget);
        }

        if (!empty($this->vakantietypes)) {
            $query->where(function($q) {
                foreach($this->vakantietypes as $type) {
                    if ($type === 'zon') $q->orWhereJsonContains('tags', 'Zonvakantie');
                    if ($type === 'stad') $q->orWhereJsonContains('tags', 'Stedentrip');
                    if ($type === 'natuur') $q->orWhereJsonContains('tags', 'Natuur');
                    if ($type === 'ver') $q->orWhereJsonContains('tags', 'Verre Reis');
                    if ($type === 'lastminute') $q->orWhereJsonContains('tags', 'Last-Minute');
                }
            });
        }

        if (!empty($this->vertrekluchthavens)) {
            $airports = [];
            foreach($this->vertrekluchthavens as $code) {
                if ($code === 'AMS') $airports[] = 'Amsterdam (Schiphol)';
                if ($code === 'EIN') $airports[] = 'Eindhoven';
                if ($code === 'RTM') $airports[] = 'Rotterdam / Den Haag';
                if ($code === 'BRU') { $airports[] = 'Brussel (Zaventem)'; $airports[] = 'Brussel (Charleroi)'; }
                if ($code === 'DUS') { $airports[] = 'Düsseldorf (Intl)'; $airports[] = 'Düsseldorf (Weeze)'; }
            }
            $query->whereIn('departure_city', $airports);
        }

        if (!empty($this->datum_van)) $query->whereDate('departure_date', '>=', $this->datum_van);
        if (!empty($this->datum_tot)) $query->whereDate('departure_date', '<=', $this->datum_tot);

        $this->resultCount = $query->count();
    }

    public function search()
    {
        $params = array_filter([
            'landen' => $this->geselecteerdeLanden,
            'steden' => $this->geselecteerdeSteden,
            'min_budget' => $this->min_budget > 0 ? $this->min_budget : null,
            'max_budget' => $this->max_budget < 2000 ? $this->max_budget : null,
            'vakantietypes' => $this->vakantietypes,
            'reisduren' => $this->reisduren,
            'datum_van' => $this->datum_van,
            'datum_tot' => $this->datum_tot,
            'vertrekluchthavens' => $this->vertrekluchthavens,
        ]);

        return redirect()->route('search.results', $params);
    }

    public function render()
    {
        return view('livewire.public.searchbar', [
            // Dit geeft de lijst feilloos door aan je HTML, zonder de Error!
            'beschikbareBestemmingen' => $this->getBestemmingenLijst()
        ]);
    }
}
