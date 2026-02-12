<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\ManageDeals;
use App\Livewire\Admin\CreateDeal; // <--- 1. DEZE IMPORT IS CRUCIAAL!

Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::view('profile', 'profile')->name('profile');

    // --- ADMIN ROUTES ---

    // 1. Het overzicht (De lijst)
    Route::get('/admin/deals', ManageDeals::class)->name('admin.deals');

    // 2. De aanmaak pagina (Het formulier) <--- DEZE MISTE JE!
    Route::get('/admin/deals/create', CreateDeal::class)->name('admin.deals.create');
});

require __DIR__.'/auth.php';
