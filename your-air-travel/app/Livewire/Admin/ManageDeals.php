<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Deal;
use App\Models\User;

class ManageDeals extends Component
{
    use WithPagination;

    public $search = '';
    public $filter_author = '';
    public $filter_date = '';
    public $sort = 'newest';

    // NIEUW: De variabele voor het status filter
    public $filter_status = '';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterAuthor() { $this->resetPage(); }
    public function updatingFilterDate() { $this->resetPage(); }
    public function updatingSort() { $this->resetPage(); }

    // NIEUW: Reset de pagina als je wisselt tussen Actief / Archief
    public function updatingFilterStatus() { $this->resetPage(); }

    public function deleteDeal($id)
    {
        $deal = Deal::findOrFail($id);
        $deal->delete();
        session()->flash('message', 'Deal succesvol verwijderd!');
    }

    public function toggleArchive($id)
    {
        $deal = Deal::findOrFail($id);

        // Draait de status om: actief wordt inactief (archief), en andersom
        $deal->is_active = !$deal->is_active;
        $deal->save();

        session()->flash('message', 'De status van de deal is succesvol aangepast!');
    }

    public function render()
    {
        $query = Deal::with(['primaryImage', 'author']);

        // 1. Zoekbalk filter
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('arrival_city', 'like', '%' . $this->search . '%')
                  ->orWhere('id', 'like', '%' . $this->search . '%');
            });
        }

        // 2. Auteur filter
        if (!empty($this->filter_author)) {
            $query->where('user_id', $this->filter_author);
        }

        // 3. Datum filter (Met de Flatpickr kalender)
        if (!empty($this->filter_date)) {
            if (str_contains($this->filter_date, ' to ')) {
                $dates = explode(' to ', $this->filter_date);
                $query->whereBetween('created_at', [$dates[0] . ' 00:00:00', $dates[1] . ' 23:59:59']);
            } else {
                $query->whereDate('created_at', $this->filter_date);
            }
        }

        // 4. NIEUW: Status filter (Actief / Archief)
        if ($this->filter_status === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filter_status === 'archived') {
            $query->where('is_active', false);
        }

        // 5. DE GEPERFECTIONEERDE SORTERING (Stabiel & Bug-vrij)
        if ($this->sort === 'oldest') {
            $query->oldest()->orderBy('id');
        } elseif ($this->sort === 'price_asc') {
            $query->orderByRaw('(CASE WHEN discounted_price > 0 THEN discounted_price ELSE price END) ASC')->latest('id');
        } elseif ($this->sort === 'price_desc') {
            $query->orderByRaw('(CASE WHEN discounted_price > 0 THEN discounted_price ELSE price END) DESC')->latest('id');
        } elseif ($this->sort === 'clicks_desc') {
            $query->orderByRaw('COALESCE(click_count, 0) DESC')->latest('id');
        } elseif ($this->sort === 'clicks_asc') {
            $query->orderByRaw('COALESCE(click_count, 0) ASC')->latest('id');
        } elseif ($this->sort === 'conversions_desc') {
            $query->orderByRaw('COALESCE(outbound_clicks, 0) DESC')->latest('id');
        } elseif ($this->sort === 'conversions_asc') {
            $query->orderByRaw('COALESCE(outbound_clicks, 0) ASC')->latest('id');
        } else {
            // Standaard: Nieuwste eerst
            $query->latest()->orderByDesc('id');
        }

        $deals = $query->paginate(10);
        $authors = User::all();

        return view('livewire.admin.manage-deals', [
            'deals' => $deals,
            'authors' => $authors
        ])->layout('layouts.app');
    }
}
