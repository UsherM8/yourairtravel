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
    public $sort = 'newest'; // NIEUW: Standaard sortering op nieuwste

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterAuthor() { $this->resetPage(); }
    public function updatingFilterDate() { $this->resetPage(); }
    public function updatingSort() { $this->resetPage(); } // Reset pagina bij sorteren

    public function deleteDeal($id)
    {
        $deal = Deal::findOrFail($id);
        $deal->delete();
        session()->flash('message', 'Deal succesvol verwijderd!');
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

        // 4. NIEUW: SORTERING
        if ($this->sort === 'oldest') {
            $query->oldest();
        } elseif ($this->sort === 'price_asc') {
            // Sorteer op prijs (Laag naar Hoog), houdt rekening met kortingen!
            $query->orderByRaw('(CASE WHEN discounted_price > 0 THEN discounted_price ELSE price END) ASC');
        } elseif ($this->sort === 'price_desc') {
            // Sorteer op prijs (Hoog naar Laag), houdt rekening met kortingen!
            $query->orderByRaw('(CASE WHEN discounted_price > 0 THEN discounted_price ELSE price END) DESC');
        } else {
            // Standaard: Nieuwste eerst
            $query->latest();
        }

        $deals = $query->paginate(10);
        $authors = User::all();

        return view('livewire.admin.manage-deals', [
            'deals' => $deals,
            'authors' => $authors
        ])->layout('layouts.app');
    }
}
