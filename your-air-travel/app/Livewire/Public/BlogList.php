<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Blog;

class BlogList extends Component
{
    public $limit = 9;
    public $totalBlogs;

    // --- NIEUWE FILTER VARIABELEN ---
    public $search = '';
    public $selectedTag = '';
    public $sort = 'desc'; // Standaard 'desc' (Nieuw naar Oud)

    // Als iemand zoekt of filtert, resetten we het aantal getoonde blogs terug naar 9
    public function updatedSearch() { $this->limit = 9; }
    public function updatedSelectedTag() { $this->limit = 9; }
    public function updatedSort() { $this->limit = 9; }

    public function loadMore()
    {
        $this->limit += 9;
    }

    public function render()
    {
        // Haal automatisch alle unieke tags op uit de actieve blogs om de dropdown te vullen
        $availableTags = Blog::where('is_active', true)
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        // Begin de zoekopdracht
        $query = Blog::where('is_active', true)
            ->when($this->search, function ($q) {
                // Zoek op titel
                $q->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedTag, function ($q) {
                // Filter op de geselecteerde tag (JSON array doorzoeken)
                $q->whereJsonContains('tags', $this->selectedTag);
            });

        // Tel hoeveel blogs er zijn na het filteren (voor de "Laad meer" knop)
        $this->totalBlogs = $query->count();

        // Haal de uiteindelijke blogs op, gesorteerd op datum
        $blogs = $query->orderBy('created_at', $this->sort)
            ->take($this->limit)
            ->get();

        return view('livewire.public.blog-list', [
            'blogs' => $blogs,
            'availableTags' => $availableTags // Geef de tags mee naar de view
        ])->layout('layouts.public');
    }
}
