<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\ManageDeals;
use App\Livewire\Admin\CreateDeal;
use App\Livewire\Admin\EditDeal;
use App\Livewire\Public\ShowDeal;
use App\Livewire\Admin\ManageBlogs;
use App\Livewire\Admin\CreateBlog;
use App\Livewire\Public\ShowBlog;
use App\Livewire\Public\BlogList;

// --- PUBLIEKE ROUTES (Voor iedereen toegankelijk) ---
Route::view('/', 'welcome');

Route::get('/zoeken', function () {
    return view('search-results');
})->name('search.results');

Route::get('/deal/{deal}', ShowDeal::class)->name('public.deal.show');

// De publieke blog pagina (Moet BUITEN de auth groep staan)


// --- ADMIN ROUTES (Alleen voor ingelogde beheerders) ---
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::view('profile', 'profile')->name('profile');

    // Beheer Deals
    Route::get('/admin/deals', ManageDeals::class)->name('admin.deals');
    Route::get('/admin/deals/create', CreateDeal::class)->name('admin.deals.create');
    Route::get('/admin/deals/{deal}/edit', EditDeal::class)->name('admin.deals.edit');

    // Beheer Blogs
    Route::get('/admin/blogs', ManageBlogs::class)->name('admin.blogs.index');
    Route::get('/admin/blogs/create', CreateBlog::class)->name('admin.blogs.create');
    Route::get('/admin/blogs/{id}/edit', ManageBlogs::class)->name('admin.blogs.edit'); // Hier maken we later de EditBlog voor
    Route::get('/blog/{id}', ShowBlog::class)->name('public.blog.show');
    Route::get('/blog', BlogList::class)->name('public.blogs');
});

require __DIR__.'/auth.php';
