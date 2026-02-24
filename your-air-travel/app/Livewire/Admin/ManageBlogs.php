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
    public $sort = 'newest';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterAuthor() { $this->resetPage(); }
    public function updatingFilterDate() { $this->resetPage(); }
    public function updatingSort() { $this->resetPage(); }

    public function deleteBlog($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        session()->flash('message', 'Blog succesvol verwijderd!');
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

        // 3. Datum filter (Flatpickr range)
        if (!empty($this->filter_date)) {
            if (str_contains($this->filter_date, ' to ')) {
                $dates = explode(' to ', $this->filter_date);
                $query->whereBetween('created_at', [$dates[0] . ' 00:00:00', $dates[1] . ' 23:59:59']);
            } else {
                $query->whereDate('created_at', $this->filter_date);
            }
        }

        // 4. Sorteren
        if ($this->sort === 'oldest') { $query->oldest(); }
        else { $query->latest(); }

        return view('livewire.admin.manage-blogs', [
            'blogs' => $query->paginate(10),
            'authors' => User::all()
        ])->layout('layouts.app');
    }
}
