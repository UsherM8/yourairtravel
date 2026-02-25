<?php

use Illuminate\Support\Facades\Route;
use App\Models\Deal; // Hiermee kan het dashboard deals ophalen
use Carbon\Carbon;   // Hiermee kunnen we rekenen met datums

use App\Livewire\Admin\ManageDeals;
use App\Livewire\Admin\CreateDeal;
use App\Livewire\Admin\EditDeal;
use App\Livewire\Admin\ManageBlogs;
use App\Livewire\Admin\CreateBlog;
use App\Livewire\Admin\InstantDealsManager;
use App\Livewire\Public\ShowDeal;
use App\Livewire\Public\ShowBlog;
use App\Livewire\Public\BlogList;

// --- PUBLIEKE ROUTES (Voor iedereen toegankelijk) ---
Route::view('/', 'welcome');

Route::get('/zoeken', function () {
    return view('search-results');
})->name('search.results');

Route::get('/deal/{deal}', ShowDeal::class)->name('public.deal.show');

// De publieke blog pagina's
Route::get('/blog', BlogList::class)->name('public.blogs');
Route::get('/blog/{id}', ShowBlog::class)->name('public.blog.show');
Route::view('/over-ons', 'over-ons')->name('over-ons');
Route::view('/contact', 'contact')->name('contact');
Route::view('/privacy-policy', 'privacy')->name('privacy');
Route::view('/algemene-voorwaarden', 'voorwaarden')->name('voorwaarden');

// --- ADMIN ROUTES (Alleen voor ingelogde beheerders) ---
Route::middleware(['auth'])->group(function () {

// --- HET NIEUWE SLIMME DASHBOARD ---
    Route::get('/admin/dashboard', function () {

        // We halen álle deals op zodat Laravel (Carbon) het rekenwerk kan doen,
        // in plaats van de SQLite database die datums niet goed begrijpt.
        $deals = Deal::all();

        $vandaag = now()->startOfDay();
        $volgendeWeek = now()->addDays(7)->endOfDay();

        $activeDealsCount = 0;
        $expiringSoonCount = 0;
        $expiredCount = 0;

        $expiringDealsList = collect();
        $expiredDealsList = collect();

        foreach($deals as $deal) {
            try {
                // We gebruiken nu de ECHTE kolomnaam: departure_date
                $dealDate = \Carbon\Carbon::parse($deal->departure_date)->startOfDay();
            } catch (\Exception $e) {
                continue;
            }

            if ($dealDate->gte($vandaag)) {
                $activeDealsCount++;
            }

            if ($dealDate->between($vandaag, $volgendeWeek)) {
                $expiringSoonCount++;
                $expiringDealsList->push($deal);
            }

            if ($dealDate->lt($vandaag)) {
                $expiredCount++;
                $expiredDealsList->push($deal);
            }
        }

        // En we sorteren nu ook op de juiste kolom!
        $expiringDeals = $expiringDealsList->sortBy('departure_date')->take(5);
        $expiredDeals = $expiredDealsList->sortByDesc('departure_date')->take(5);

        // Pak de top 5 voor de lijstjes in het dashboard en sorteer ze netjes
        $expiringDeals = $expiringDealsList->sortBy('start_date')->take(5);
        $expiredDeals = $expiredDealsList->sortByDesc('start_date')->take(5);

        $topClickedDeals = collect();

        return view('dashboard', compact(
            'activeDealsCount',
            'expiringSoonCount',
            'expiredCount',
            'expiringDeals',
            'expiredDeals',
            'topClickedDeals'
        ));
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::view('profile', 'profile')->name('profile');

    // Beheer Deals
    Route::get('/admin/deals', ManageDeals::class)->name('admin.deals');
    Route::get('/admin/deals/create', CreateDeal::class)->name('admin.deals.create');
    Route::get('/admin/deals/{deal}/edit', EditDeal::class)->name('admin.deals.edit');

    // Beheer de 8 Homepage Flash Deals
    Route::get('/admin/instant-deals', InstantDealsManager::class)->name('admin.instant-deals');

    // Beheer Blogs
    Route::get('/admin/blogs', ManageBlogs::class)->name('admin.blogs.index');
    Route::get('/admin/blogs/create', CreateBlog::class)->name('admin.blogs.create');
    Route::get('/admin/blogs/{id}/edit', ManageBlogs::class)->name('admin.blogs.edit');

});

require __DIR__.'/auth.php';
