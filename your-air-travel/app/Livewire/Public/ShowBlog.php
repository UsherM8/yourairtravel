<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Blog;

class ShowBlog extends Component
{
    public Blog $blog;

    public function mount($id)
    {
        // Haal de blog op op basis van ID, en check of hij actief is
        $this->blog = Blog::where('is_active', true)->findOrFail($id);
    }

    public function render()
    {
        // Gebruik jouw Mega-Menu layout!
        return view('livewire.public.show-blog')->layout('layouts.public');
    }
}
