<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Deal;
use Carbon\Carbon;

class Searchbar extends Component
{
    public $geselecteerdeLanden = [];
    public $geselecteerdeSteden = [];
    public $geselecteerdeContinenten = [];
    public $geselecteerdeTags = [];
    public $vertrekluchthavens = [];

    public $min_budget = 0;
    public $max_budget = 2000;

    public $vakantietypes = [];
    public $reisduren = [];
    public $datum_van;
    public $datum_tot;

    public $resultCount = 0;

    public function mount()
    {
        $this->geselecteerdeLanden = (array) request()->query('landen', []);
        $this->geselecteerdeSteden = (array) request()->query('steden', []);
        $this->geselecteerdeContinenten = (array) request()->query('continenten', []);
        $this->geselecteerdeTags = (array) request()->query('tags', []);
        $this->vertrekluchthavens = (array) request()->query('vertrekluchthavens', []);

        $this->min_budget = floatval(request()->query('min_budget', 0));
        $this->max_budget = floatval(request()->query('max_budget', 2000));

        $this->vakantietypes = (array) request()->query('vakantietypes', []);
        $this->reisduren = (array) request()->query('reisduren', []);

        $this->datum_van = request()->query('datum_van');
        $this->datum_tot = request()->query('datum_tot');

        $this->calculateCount();
    }

    public function updatedMinBudget($value)
    {
        if ($value > $this->max_budget) $this->max_budget = $value;
        $this->calculateCount();
    }

    public function updatedMaxBudget($value)
    {
        if ($value < $this->min_budget) $this->min_budget = $value;
        $this->calculateCount();
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'geselecteerdeLanden' || $propertyName === 'geselecteerdeSteden') {
            $alleBestemmingen = $this->getBestemmingenLijst();
            if (!empty($this->geselecteerdeLanden)) {
                $this->geselecteerdeSteden = array_filter($this->geselecteerdeSteden, function($stad) use ($alleBestemmingen) {
                    foreach ($this->geselecteerdeLanden as $land) {
                        if (isset($alleBestemmingen[$land]) && in_array($stad, $alleBestemmingen[$land])) return true;
                    }
                    return false;
                });
            }
        }

        if ($this->datum_van && $this->datum_tot) {
            try {
                if (Carbon::parse($this->datum_tot)->lt(Carbon::parse($this->datum_van))) {
                    $this->datum_tot = $this->datum_van;
                }
            } catch (\Exception $e) {
                // Ignore parse errors
            }
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

    public function calculateCount()
    {
        $query = Deal::query();

        // 1. Filter op Continenten (Nieuwe kolom)
        if (!empty($this->geselecteerdeContinenten)) {
            $query->whereIn('arrival_continent', $this->geselecteerdeContinenten);
        }

        // 2. Filter op handmatige Tags
        if (!empty($this->geselecteerdeTags)) {
            $query->where(function($q) {
                foreach($this->geselecteerdeTags as $tag) {
                    $q->orWhereJsonContains('tags', $tag);
                }
            });
        }

        // 3. Locatie filters
        if (!empty($this->geselecteerdeSteden)) {
            $query->whereIn('arrival_city', $this->geselecteerdeSteden);
        } elseif (!empty($this->geselecteerdeLanden)) {
            $query->whereIn('arrival_country', $this->geselecteerdeLanden);
        }

        // 4. Budget logic
        $min = (float)$this->min_budget;
        $max = (float)$this->max_budget;
        $query->where(function($q) use ($min, $max) {
            $q->where(function($sub) use ($min, $max) {
                $sub->where('discounted_price', '>', 0)->whereBetween('discounted_price', [$min, $max]);
            })->orWhere(function($sub) use ($min, $max) {
                $sub->where(function($p) {
                    $p->whereNull('discounted_price')->orWhere('discounted_price', 0);
                })->whereBetween('price', [$min, $max]);
            });
        });

        // 5. Vakantietypes (VERBETERDE FILTERING)
        if (!empty($this->vakantietypes)) {
            $query->where(function($q) {
                foreach($this->vakantietypes as $type) {
                    if ($type === 'lastminute') {
                        $q->orWhereJsonContains('tags', 'Last-Minute')
                          ->orWhereJsonContains('tags', 'Last Minute');
                    } elseif ($type === 'all-inclusive') {
                        $q->orWhereJsonContains('tags', 'All-inclusive')
                          ->orWhereJsonContains('tags', 'All-Inclusive')
                          ->orWhereJsonContains('tags', 'All inclusive')
                          ->orWhereJsonContains('tags', 'All Inclusive');
                    } else {
                        $tagMap = [
                            'zon' => 'Zonvakantie',
                            'stad' => 'Stedentrip',
                            'natuur' => 'Natuur',
                            'ver' => 'Verre Reis'
                        ];
                        if (isset($tagMap[$type])) {
                            $q->orWhereJsonContains('tags', $tagMap[$type]);
                        }
                    }
                }
            });
        }

        // 6. Luchthavens
        if (!empty($this->vertrekluchthavens)) {
            $airportMapping = [
                'AMS' => ['Amsterdam (Schiphol)'], 'EIN' => ['Eindhoven'], 'RTM' => ['Rotterdam / Den Haag'],
                'BRU' => ['Brussel (Zaventem)', 'Brussel (Charleroi)'], 'DUS' => ['Düsseldorf (Intl)', 'Düsseldorf (Weeze)']
            ];
            $allowedAirports = [];
            foreach($this->vertrekluchthavens as $code) {
                if (isset($airportMapping[$code])) $allowedAirports = array_merge($allowedAirports, $airportMapping[$code]);
            }
            $query->whereIn('departure_city', $allowedAirports);
        }

        if ($this->datum_van) $query->whereDate('departure_date', '>=', $this->datum_van);
        if ($this->datum_tot) $query->whereDate('departure_date', '<=', $this->datum_tot);
        if (!empty($this->reisduren)) $query->whereIn('duration_days', $this->reisduren);

        $this->resultCount = $query->count();
    }

    public function search()
    {
        $params = [
            'landen' => $this->geselecteerdeLanden,
            'steden' => $this->geselecteerdeSteden,
            'continenten' => $this->geselecteerdeContinenten,
            'tags' => $this->geselecteerdeTags,
            'min_budget' => $this->min_budget,
            'max_budget' => $this->max_budget,
            'vakantietypes' => $this->vakantietypes,
            'reisduren' => $this->reisduren,
            'datum_van' => $this->datum_van,
            'datum_tot' => $this->datum_tot,
            'vertrekluchthavens' => $this->vertrekluchthavens,
        ];

        return redirect()->route('search.results', array_filter($params));
    }

    public function getBestemmingenLijst()
    {
        return [
            'Spanje' => ['Barcelona', 'Madrid', 'Valencia', 'Ibiza', 'Mallorca', 'Malaga', 'Canarische Eilanden', 'Sevilla', 'Alicante', 'Girona'],
            'Italië' => ['Rome', 'Milaan', 'Venetië', 'Napels', 'Sicilië', 'Sardinië', 'Florence', 'Pisa', 'Bologna', 'Verona'],
            'Griekenland' => ['Athene', 'Kreta', 'Santorini', 'Rhodos', 'Kos', 'Corfu', 'Zakynthos', 'Mykonos', 'Thessaloniki'],
            'Portugal' => ['Lissabon', 'Porto', 'Faro (Algarve)', 'Madeira', 'Azoren'],
            'Turkije' => ['Istanbul', 'Antalya', 'Bodrum', 'Alanya', 'Dalaman', 'Izmir', 'Cappadocië'],
            'Frankrijk' => ['Parijs', 'Nice', 'Lyon', 'Marseille', 'Bordeaux', 'Toulouse', 'Corsica'],
            'Kroatië' => ['Split', 'Dubrovnik', 'Zagreb', 'Zadar', 'Pula'],
            'Verenigd Koninkrijk' => ['Londen', 'Edinburgh', 'Manchester', 'Birmingham', 'Glasgow', 'Belfast'],
            'Duitsland' => ['Berlijn', 'München', 'Hamburg', 'Frankfurt', 'Keulen', 'Düsseldorf'],
            'Verenigde Staten' => ['New York', 'Los Angeles', 'Miami', 'Las Vegas', 'San Francisco', 'Orlando', 'Chicago', 'Hawaii'],
            'Canada' => ['Toronto', 'Vancouver', 'Montreal', 'Calgary', 'Ottawa'],
            'Mexico' => ['Cancún', 'Mexico-Stad', 'Playa del Carmen', 'Tulum'],
            'Indonesië' => ['Bali', 'Jakarta', 'Lombok'],
            'Thailand' => ['Bangkok', 'Phuket', 'Koh Samui', 'Chiang Mai'],
            'Japan' => ['Tokio', 'Kyoto', 'Osaka'],
            'Marokko' => ['Marrakech', 'Agadir', 'Casablanca'],
            'Egypte' => ['Hurghada', 'Sharm el-Sheikh', 'Caïro'],
        ];
    }

    public function render()
    {
        return view('livewire.public.searchbar', [
            'beschikbareBestemmingen' => $this->getBestemmingenLijst()
        ]);
    }
}
