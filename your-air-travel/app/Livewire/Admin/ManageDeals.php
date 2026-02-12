<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Deal;

class ManageDeals extends Component
{
    // We hebben hier geen 'WithFileUploads' meer nodig, want we uploaden hier niet.

    // 1. De variabele voor de zoekbalk (gekoppeld aan wire:model in je view)
    public $search = '';

    // 2. De functie om een deal te verwijderen
    public function deleteDeal($id)
    {
        $deal = Deal::find($id);

        if ($deal) {
            $deal->delete();
            session()->flash('message', 'Deal succesvol verwijderd uit de database.');
        }
    }

    // 3. De render functie die de lijst filtert op basis van je zoekopdracht
    public function render()
    {
        $deals = Deal::query()
            ->where('title', 'like', '%' . $this->search . '%')
            ->orWhere('departure_city', 'like', '%' . $this->search . '%')
            ->orWhere('arrival_city', 'like', '%' . $this->search . '%')
            ->orWhere('price', 'like', '%' . $this->search . '%')
            ->latest()
            ->get();

        return view('livewire.admin.manage-deals', [
            'deals' => $deals
        ])->layout('layouts.app');
    }
}
