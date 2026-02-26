<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Deal;

class DealList extends Component
{
    public $filters = [
        'landen' => [],
        'steden' => [],
        'continenten' => [],
        'tags' => [],
        'min_budget' => 0,
        'max_budget' => 2000,
        'datum_van' => null,
        'datum_tot' => null,
        'vertrekluchthavens' => [],
        'vakantietypes' => [],
        'reisduren' => [],
    ];

    public $limit = 12;

    public function mount()
    {
        // Haal alle filters op uit de URL parameters
        $this->filters['landen'] = (array) request()->query('landen', []);
        $this->filters['steden'] = (array) request()->query('steden', []);
        $this->filters['continenten'] = (array) request()->query('continenten', []);
        $this->filters['tags'] = (array) request()->query('tags', []);
        $this->filters['min_budget'] = request()->query('min_budget', 0);
        $this->filters['max_budget'] = request()->query('max_budget', 2000);
        $this->filters['vakantietypes'] = (array) request()->query('vakantietypes', []);
        $this->filters['reisduren'] = (array) request()->query('reisduren', []);
        $this->filters['datum_van'] = request()->query('datum_van');
        $this->filters['datum_tot'] = request()->query('datum_tot');
        $this->filters['vertrekluchthavens'] = (array) request()->query('vertrekluchthavens', []);
    }

    #[On('filters-updated')]
    public function updateFilters($nieuweFilters)
    {
        $this->filters = array_merge($this->filters, $nieuweFilters);
        $this->limit = 12; // Reset pagination bij nieuwe filter actie
    }

    public function loadMore()
    {
        $this->limit += 12;
    }

    public function render()
    {
        // Basis query (Global Scope 'exclude_expired' uit Deal model wordt automatisch toegepast)
        $query = Deal::query();

        // 1. Filter op Continenten (Nieuwe database kolom)
        if (!empty($this->filters['continenten'])) {
            $query->whereIn('arrival_continent', $this->filters['continenten']);
        }

        // 2. Filter op specifieke Tags (JSON kolom)
        if (!empty($this->filters['tags'])) {
            $query->where(function($q) {
                foreach($this->filters['tags'] as $tag) {
                    $q->orWhereJsonContains('tags', $tag);
                }
            });
        }

        // 3. Filter op Landen / Steden
        if (!empty($this->filters['steden'])) {
            $query->whereIn('arrival_city', $this->filters['steden']);
        } elseif (!empty($this->filters['landen'])) {
            $query->whereIn('arrival_country', $this->filters['landen']);
        }

        // 4. Budget Filtering (Scenario korting vs normale prijs)
        $min = (float)($this->filters['min_budget'] ?? 0);
        $max = (float)($this->filters['max_budget'] ?? 2000);

        $query->where(function($q) use ($min, $max) {
            $q->where(function($sub) use ($min, $max) {
                // Scenario A: Deal heeft een actieve kortingsprijs
                $sub->where('discounted_price', '>', 0)
                    ->whereBetween('discounted_price', [$min, $max]);
            })->orWhere(function($sub) use ($min, $max) {
                // Scenario B: Deal heeft geen kortingsprijs
                $sub->where(function($p) {
                        $p->whereNull('discounted_price')->orWhere('discounted_price', 0);
                    })
                    ->whereBetween('price', [$min, $max]);
            });
        });

        // 5. Filter op Vertrekluchthavens
        if (!empty($this->filters['vertrekluchthavens'])) {
            $airportMapping = [
                'AMS' => ['Amsterdam (Schiphol)'],
                'EIN' => ['Eindhoven'],
                'RTM' => ['Rotterdam / Den Haag'],
                'BRU' => ['Brussel (Zaventem)', 'Brussel (Charleroi)'],
                'DUS' => ['Düsseldorf (Intl)', 'Düsseldorf (Weeze)']
            ];

            $allowedAirports = [];
            foreach($this->filters['vertrekluchthavens'] as $code) {
                if (isset($airportMapping[$code])) {
                    $allowedAirports = array_merge($allowedAirports, $airportMapping[$code]);
                }
            }
            $query->whereIn('departure_city', $allowedAirports);
        }

        // 6. Filter op Vakantietypes (ROBUUSTE FILTER VOOR LAST-MINUTE & ALL-INCLUSIVE)
        if (!empty($this->filters['vakantietypes'])) {
            $query->where(function($q) {
                foreach($this->filters['vakantietypes'] as $type) {
                    $tagMap = [
                        'zon'           => 'Zonvakantie',
                        'stad'          => 'Stedentrip',
                        'natuur'        => 'Natuur',
                        'ver'           => 'Verre Reis',
                        'lastminute'    => 'Last-Minute',
                        'all-inclusive' => 'All-inclusive'
                    ];

                    if (isset($tagMap[$type])) {
                        // Zoek op de standaard waarde uit de map
                        $q->orWhere(function($sub) use ($type, $tagMap) {
                            $sub->whereJsonContains('tags', $tagMap[$type]);

                            // Extra checks voor Last-Minute (spatie variaties)
                            if ($type === 'lastminute') {
                                $sub->orWhereJsonContains('tags', 'Last Minute')
                                    ->orWhereJsonContains('tags', 'last minute');
                            }

                            // Extra checks voor All-inclusive (hoofdletter variaties)
                            if ($type === 'all-inclusive') {
                                $sub->orWhereJsonContains('tags', 'All-Inclusive')
                                    ->orWhereJsonContains('tags', 'All inclusive')
                                    ->orWhereJsonContains('tags', 'All Inclusive');
                            }
                        });
                    }
                }
            });
        }

        // 7. Datum Filtering
        if (!empty($this->filters['datum_van'])) {
            $query->whereDate('departure_date', '>=', $this->filters['datum_van']);
        }
        if (!empty($this->filters['datum_tot'])) {
            $query->whereDate('departure_date', '<=', $this->filters['datum_tot']);
        }

        // 8. Filter op Reisduur
        if (!empty($this->filters['reisduren'])) {
            $query->whereIn('duration_days', $this->filters['reisduren']);
        }

        $totalDeals = $query->count();
        $deals = $query->with('primaryImage')->latest()->take($this->limit)->get();

        return view('livewire.public.deal-list', [
            'deals' => $deals,
            'totalDeals' => $totalDeals
        ]);
    }
}
