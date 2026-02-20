<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\ManageDeals;
use App\Livewire\Admin\CreateDeal;
use App\Livewire\Admin\EditDeal;
use App\Livewire\Public\ShowDeal;

Route::view('/', 'welcome');

Route::get('/deal/{deal}', ShowDeal::class)->name('public.deal.show');

Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::view('profile', 'profile')->name('profile');

    //ADMIN ROUTES
    Route::get('/admin/deals', ManageDeals::class)->name('admin.deals');
    Route::get('/admin/deals/create', CreateDeal::class)->name('admin.deals.create');
    Route::get('/admin/deals/{deal}/edit', EditDeal::class)->name('admin.deals.edit');

});

require __DIR__.'/auth.php';
