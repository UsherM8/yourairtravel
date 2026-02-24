<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Blog;

class CreateBlog extends Component
{
    use WithFileUploads;

    public $title, $content, $image;

    // De geselecteerde tags (array)
    public $tags = [];

    // De vaste set tags (Identiek aan deals voor consistentie)
    public $availableTags = [
        // Werelddelen & Regio's
        'Europa', 'Azië', 'Afrika', 'Noord-Amerika', 'Zuid-Amerika', 'Oceanië', 'Midden-Oosten', 'Scandinavië', 'Middellandse Zee',
        // Type Reis
        'Zonvakantie', 'Stedentrip', 'Last Minute', 'All-Inclusive', 'Backpacken', 'Roadtrip', 'Wintersport', 'Cruises', 'Kamperen', 'Fly-Drive',
        // Doelgroep
        'Familie & Kinderen', 'Solo Reizen', 'Koppels', 'Groepsreizen', 'Digital Nomads',
        // Thema
        'Natuur', 'Cultuur', 'Eten & Drinken', 'Strand', 'Avontuur', 'Luxe', 'Budget', 'Duurzaam Reizen', 'Wellness', 'Fotografie',
        // Handig
        'Reistips', 'Inpaklijstjes', 'Vliegtips', 'Hotels', 'Autohuur', 'Visum & Documenten', 'Gezondheid op reis'
    ];

    public function saveBlog()
    {
        $this->validate([
            'title' => 'required|min:5',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $this->image ? $this->image->store('blogs', 'public') : null;

        Blog::create([
            'title' => $this->title,
            'content' => $this->content,
            'image_path' => $imagePath,
            'tags' => $this->tags, // Slaat de array op
            'user_id' => auth()->id(),
            'is_active' => true,
        ]);

        session()->flash('message', 'Blog succesvol geplaatst!');
        return redirect()->route('admin.blogs.index');
    }

    public function render()
    {
        return view('livewire.admin.create-blog')->layout('layouts.app');
    }
}
