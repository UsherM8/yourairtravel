<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Blog;
use Illuminate\Support\Facades\File; // <-- Toegevoegd voor de copy fix

class EditBlog extends Component
{
    use WithFileUploads;

    public $blogId;
    public $title, $content, $image, $existingImage, $is_active;
    public $tags = [];

    public $availableTags = [
        'Europa', 'Azië', 'Afrika', 'Noord-Amerika', 'Zuid-Amerika', 'Oceanië', 'Midden-Oosten', 'Scandinavië', 'Middellandse Zee',
        'Zonvakantie', 'Stedentrip', 'Last Minute', 'All-Inclusive', 'Backpacken', 'Roadtrip', 'Wintersport', 'Cruises', 'Kamperen', 'Fly-Drive',
        'Familie & Kinderen', 'Solo Reizen', 'Koppels', 'Groepsreizen', 'Digital Nomads',
        'Natuur', 'Cultuur', 'Eten & Drinken', 'Strand', 'Avontuur', 'Luxe', 'Budget', 'Duurzaam Reizen', 'Wellness', 'Fotografie',
        'Reistips', 'Inpaklijstjes', 'Vliegtips', 'Hotels', 'Autohuur', 'Visum & Documenten', 'Gezondheid op reis'
    ];

    public function mount($id)
    {
        $blog = Blog::findOrFail($id);
        $this->blogId = $blog->id;
        $this->title = $blog->title;
        $this->content = $blog->content;
        $this->tags = $blog->tags ?? [];
        $this->existingImage = $blog->image_path;
        $this->is_active = $blog->is_active;
    }

    public function toggleArchive()
    {
        $this->is_active = !$this->is_active;
        Blog::where('id', $this->blogId)->update(['is_active' => $this->is_active]);

        $msg = $this->is_active ? 'Blog is nu weer live!' : 'Blog is gearchiveerd.';
        session()->flash('message', $msg);
    }

    public function updateBlog()
    {
        $this->validate([
            'title' => 'required|min:5',
            'content' => 'required',
            'image' => 'nullable|image|max:20480', // 20MB limiet
        ]);

        $blog = Blog::findOrFail($this->blogId);
        $imagePath = $blog->image_path;

        if ($this->image) {
            $destinationPath = public_path('uploads');

            // 1. Check of de map al bestaat. Zo niet? Maak hem dan aan!
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $filename = time() . '-' . $this->image->getClientOriginalName();

            // 2. Livewire-proof kopiëren (omzeilt de temp-file error)
            File::copy(
                $this->image->getRealPath(),
                $destinationPath . '/' . $filename
            );

            // 3. BONUS: Gooi de OUDE foto weg van de server als er een nieuwe is geüpload
            if ($blog->image_path && file_exists(public_path('uploads/' . $blog->image_path))) {
                unlink(public_path('uploads/' . $blog->image_path));
            }

            $imagePath = $filename;

            // Update ook direct het voorbeeldplaatje in het formulier
            $this->existingImage = $filename;
        }

        $blog->update([
            'title' => $this->title,
            'content' => $this->content,
            'image_path' => $imagePath,
            'tags' => $this->tags,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Blog succesvol bijgewerkt! ✨');
    }

    public function render()
    {
        return view('livewire.admin.edit-blog')->layout('layouts.app');
    }
}
