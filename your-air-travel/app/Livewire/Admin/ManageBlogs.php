<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Blog;
use App\Models\User;

class ManageBlogs extends Component
{
    use WithPagination;

    public $search = '';
    public $filter_author = '';
    public $filter_date = '';
    public $filter_status = 'all'; // Nieuw: filter voor status
    public $sort = 'newest';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterAuthor() { $this->resetPage(); }
    public function updatingFilterDate() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }
    public function updatingSort() { $this->resetPage(); }

    public function deleteBlog($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        session()->flash('message', 'Blog succesvol verwijderd!');
    }

    public function toggleArchive($id)
    {
        // FIX: Verwees eerst naar Deal, nu naar Blog
        $blog = Blog::findOrFail($id);
        $blog->is_active = !$blog->is_active;
        $blog->save();

        $status = $blog->is_active ? 'live gezet' : 'gearchiveerd';
        session()->flash('message', "Blog is succesvol $status!");
    }

    public function render()
    {
        $query = Blog::with('author');

        // 1. Zoeken
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('id', 'like', '%' . $this->search . '%');
            });
        }

        // 2. Auteur filter
        if (!empty($this->filter_author)) {
            $query->where('user_id', $this->filter_author);
        }

        // 3. Status filter (Archief vs Live)
        if ($this->filter_status !== 'all') {
            $query->where('is_active', $this->filter_status === 'active');
        }

        // 4. Datum filter
        if (!empty($this->filter_date)) {
            if (str_contains($this->filter_date, ' to ')) {
                $dates = explode(' to ', $this->filter_date);
                $query->whereBetween('created_at', [$dates[0] . ' 00:00:00', $dates[1] . ' 23:59:59']);
            } else {
                $query->whereDate('created_at', $this->filter_date);
            }
        }

        // 5. Sorteren
        $this->sort === 'oldest' ? $query->oldest() : $query->latest();

        return view('livewire.admin.manage-blogs', [
            'blogs' => $query->paginate(10),
            'authors' => User::all()
        ])->layout('layouts.app');
    }
}
