<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Blog;

class ShowBlog extends Component
{
    public Blog $blog;

    public function mount($id)
{
    $this->blog = \App\Models\Blog::findOrFail($id);

    // TEL EEN WEERGAVE OP
    // We gebruiken increment, dat is supersnel en veilig
    $this->blog->increment('click_count');
}

    public function render()
    {
        // Gebruik jouw Mega-Menu layout!
        return view('livewire.public.show-blog')->layout('layouts.public');
    }
}
