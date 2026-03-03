<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Blog;
use Illuminate\Support\Facades\File; // <-- Toegevoegd voor de copy fix

class CreateBlog extends Component
{
    use WithFileUploads;

    public $title, $content, $image;
    public $is_active = true; // Standaard staat een nieuwe blog op 'Live'
    public $tags = [];

    public $availableTags = [
        'Europa', 'Azië', 'Afrika', 'Noord-Amerika', 'Zuid-Amerika', 'Oceanië', 'Midden-Oosten', 'Scandinavië', 'Middellandse Zee',
        'Zonvakantie', 'Stedentrip', 'Last Minute', 'All-Inclusive', 'Backpacken', 'Roadtrip', 'Wintersport', 'Cruises', 'Kamperen', 'Fly-Drive',
        'Familie & Kinderen', 'Solo Reizen', 'Koppels', 'Groepsreizen', 'Digital Nomads',
        'Natuur', 'Cultuur', 'Eten & Drinken', 'Strand', 'Avontuur', 'Luxe', 'Budget', 'Duurzaam Reizen', 'Wellness', 'Fotografie',
        'Reistips', 'Inpaklijstjes', 'Vliegtips', 'Hotels', 'Autohuur', 'Visum & Documenten', 'Gezondheid op reis'
    ];

    public function toggleStatus()
    {
        $this->is_active = !$this->is_active;
    }

    public function saveBlog()
    {
        // 1. Validatie (max 5MB is perfect)
        $this->validate([
            'title' => 'required|min:5',
            'content' => 'required',
            'image' => 'required|image|max:5120',
        ]);

        $imagePath = null;

        // 2. Afbeelding verwerken (Livewire-Proof)
        if ($this->image) {
            $destinationPath = public_path('uploads');

            // Check of de map al bestaat. Zo niet? Maak hem dan aan!
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Maak een unieke bestandsnaam
            $filename = time() . '-' . $this->image->getClientOriginalName();

            // Kopiëer de foto uit de Livewire-temp map naar public/uploads
            File::copy(
                $this->image->getRealPath(),
                $destinationPath . '/' . $filename
            );

            // Sla alleen de naam op in de DB
            $imagePath = $filename;
        }

        // 3. Blog opslaan in de database
        Blog::create([
            'title' => $this->title,
            'content' => $this->content,
            'image_path' => $imagePath,
            'tags' => $this->tags,
            'is_active' => $this->is_active,
            'author_id' => auth()->id(),
        ]);

        session()->flash('message', 'Blog succesvol aangemaakt! ✨');
        return redirect()->route('admin.blogs.index');
    }

    public function render()
    {
        return view('livewire.admin.create-blog')->layout('layouts.app');
    }
}
