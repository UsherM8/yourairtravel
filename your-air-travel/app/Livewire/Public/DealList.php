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
        $this->filters['landen'] = (array) request()->query('landen', []);
        $this->filters['steden'] = (array) request()->query('steden', []);
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
        // Reset de limiet terug naar 12 als iemand een filter aanklikt!
        $this->limit = 12;
    }

    public function loadMore()
    {
        $this->limit += 12;
    }

    public function render()
    {
        $query = Deal::where('is_active', true);

        // 1. Filter op Landen / Steden
        if (!empty($this->filters['steden'])) {
            $query->whereIn('arrival_city', $this->filters['steden']);
        } elseif (!empty($this->filters['landen'])) {
            $query->whereIn('arrival_country', $this->filters['landen']);
        }

        // 2. Filter op Budget
        if (isset($this->filters['min_budget']) && $this->filters['min_budget'] > 0) {
            $query->where('discounted_price', '>=', $this->filters['min_budget']);
        }
        if (isset($this->filters['max_budget']) && $this->filters['max_budget'] < 2000) {
            $query->where('discounted_price', '<=', $this->filters['max_budget']);
        }

        // 3. Filter op Vertrekluchthavens
        if (!empty($this->filters['vertrekluchthavens'])) {
            $airports = [];
            foreach($this->filters['vertrekluchthavens'] as $code) {
                if ($code === 'AMS') $airports[] = 'Amsterdam (Schiphol)';
                if ($code === 'EIN') $airports[] = 'Eindhoven';
                if ($code === 'RTM') $airports[] = 'Rotterdam / Den Haag';
                if ($code === 'BRU') { $airports[] = 'Brussel (Zaventem)'; $airports[] = 'Brussel (Charleroi)'; }
                if ($code === 'DUS') { $airports[] = 'Düsseldorf (Intl)'; $airports[] = 'Düsseldorf (Weeze)'; }
            }
            $query->whereIn('departure_city', $airports);
        }

        // 4. Filter op Vakantietypes
        if (!empty($this->filters['vakantietypes'])) {
            $query->where(function($q) {
                foreach($this->filters['vakantietypes'] as $type) {
                    if ($type === 'zon') $q->orWhereJsonContains('tags', 'Zonvakantie');
                    if ($type === 'stad') $q->orWhereJsonContains('tags', 'Stedentrip');
                    if ($type === 'natuur') $q->orWhereJsonContains('tags', 'Natuur');
                    if ($type === 'ver') $q->orWhereJsonContains('tags', 'Verre Reis');
                    if ($type === 'lastminute') $q->orWhereJsonContains('tags', 'Last-Minute');
                }
            });
        }

        // 5. Kalender Datum Filtering
        if (!empty($this->filters['datum_van'])) {
            $query->whereDate('departure_date', '>=', $this->filters['datum_van']);
        }
        if (!empty($this->filters['datum_tot'])) {
            $query->whereDate('departure_date', '<=', $this->filters['datum_tot']);
        }

        // 6. Filter op Reisduur (Via de nieuwe database kolom!)
        if (!empty($this->filters['reisduren'])) {
            $query->whereIn('duration_days', $this->filters['reisduren']);
        }

        // Bereken het totaal voor de HTML (Hier kwam je foutmelding vandaan!)
        $totalDeals = $query->count();

        // Haal de deals op, en laad direct de foto in (met `with()`) zodat de website sneller is
        $deals = $query->with('primaryImage')->latest()->take($this->limit)->get();

        return view('livewire.public.deal-list', [
            'deals' => $deals,
            'totalDeals' => $totalDeals
        ]);
    }
}
