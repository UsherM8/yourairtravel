<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'nullable|image|max:2048',
        ]);

        $blog = Blog::findOrFail($this->blogId);
        $imagePath = $this->existingImage;

        if ($this->image) {
            if ($this->existingImage) {
                Storage::disk('public')->delete($this->existingImage);
            }
            $imagePath = $this->image->store('blogs', 'public');
        }

        $blog->update([
            'title' => $this->title,
            'content' => $this->content,
            'image_path' => $imagePath,
            'tags' => $this->tags,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Blog succesvol bijgewerkt!');
        return redirect()->route('admin.blogs.index');
    }

    public function render()
    {
        return view('livewire.admin.edit-blog')->layout('layouts.app');
    }
}
