<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Models\Deal;
use App\Models\Blog;
use Carbon\Carbon;

use App\Livewire\Admin\ManageDeals;
use App\Livewire\Admin\CreateDeal;
use App\Livewire\Admin\EditDeal;
use App\Livewire\Admin\ManageBlogs;
use App\Livewire\Admin\CreateBlog;
use App\Livewire\Admin\EditBlog;
use App\Livewire\Admin\InstantDealsManager;
use App\Livewire\Public\ShowDeal;
use App\Livewire\Public\ShowBlog;
use App\Livewire\Public\BlogList;

// --- PUBLIEKE ROUTES ---
Route::view('/', 'welcome');

Route::get('/zoeken', function () {
    return view('search-results');
})->name('search.results');

Route::get('/deal/{deal}', ShowDeal::class)->name('public.deal.show');

// Conversie-tracking route
Route::get('/deal/{deal}/boek', function (Deal $deal) {
    $deal->increment('outbound_clicks');
    return redirect($deal->referral_url ?? '/');
})->name('public.deal.book');

Route::get('/blog', BlogList::class)->name('public.blogs');
Route::get('/blog/{id}', ShowBlog::class)->name('public.blog.show');

// Statische pagina's
Route::view('/over-ons', 'over-ons')->name('over-ons');
Route::view('/contact', 'contact')->name('contact');
Route::view('/privacy-policy', 'privacy')->name('privacy');
Route::view('/algemene-voorwaarden', 'voorwaarden')->name('voorwaarden');


// --- ADMIN ROUTES (Beveiligd) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // --- HET SLIMME DASHBOARD ---
    Route::get('/admin/dashboard', function () {
        $vandaag = now()->startOfDay();
        $volgendeWeek = now()->addDays(7)->endOfDay();

        // 1. KPI STATS (Basis tellers)
        $activeDealsCount  = Deal::where('is_active', true)->whereDate('departure_date', '>=', $vandaag)->count();
        $expiredCount      = Deal::where('is_active', true)->whereDate('departure_date', '<', $vandaag)->count();
        $expiringSoonCount = Deal::where('is_active', true)->whereBetween('departure_date', [$vandaag, $volgendeWeek])->count();

        $totalClicksThisWeek = Deal::sum('click_count');
        $totalOutboundClicks = Deal::sum('outbound_clicks');
        $totalBlogViews      = Blog::sum('click_count');

        // 2. ACTIE-LIJSTEN (Voor de tabellen bovenin)
        // In routes/web.php (Dashboard route)
$expiringDeals = Deal::where('is_active', true)
                    ->whereBetween('departure_date', [$vandaag, $volgendeWeek])
                    ->orderBy('departure_date', 'asc')
                    ->take(10) // Verhoogd naar 10
                    ->get();

// Verwijder 'price' uit de switch logica bij $topClickedDeals

        $expiredDeals = Deal::where('is_active', true)
                            ->whereDate('departure_date', '<', $vandaag)
                            ->orderBy('departure_date', 'desc')
                            ->take(10) // Verhoogd naar 10
                            ->get();

        // 3. TOP PERFORMANCE GRID (Met sortering & foto logica)
        // In routes/web.php (Dashboard route)
      $sort = request('sort', 'views'); // 'views' is hier de default waarde

      $query = Deal::with(['primaryImage', 'images']);

     if ($sort === 'boeks') {
    $query->orderBy('outbound_clicks', 'desc');
    } else {
    // Standaard sortering op Views
    $query->orderBy('click_count', 'desc');
   }

   $topClickedDeals = $query->paginate(15)->withQueryString();

        // 4. BLOGS
        $topBlogs = Blog::orderBy('click_count', 'desc')->take(5)->get();

        return view('dashboard', compact(
            'activeDealsCount', 'expiringSoonCount', 'expiredCount',
            'expiringDeals', 'expiredDeals', 'topClickedDeals',
            'totalClicksThisWeek', 'totalOutboundClicks', 'totalBlogViews', 'topBlogs'
        ));
    })->name('dashboard');

    // --- ARCHIVEER ROUTES ---
    // Archiveer Deal
    Route::post('/admin/deals/{deal}/archive', function (Deal $deal) {
        $deal->update(['is_active' => false]);
        return back()->with('message', 'Deal succesvol gearchiveerd.');
    })->name('admin.deals.archive');

    // Archiveer Blog
    Route::post('/admin/blogs/{id}/archive', function ($id) {
        $blog = Blog::findOrFail($id);
        $blog->update(['is_active' => false]);
        return back()->with('message', 'Blog succesvol gearchiveerd.');
    })->name('admin.blogs.archive');

    // --- RESOURCE BEHEER ---
    Route::view('profile', 'profile')->name('profile');

    // Deals Manager
    Route::get('/admin/deals', ManageDeals::class)->name('admin.deals');
    Route::get('/admin/deals/create', CreateDeal::class)->name('admin.deals.create');
    Route::get('/admin/deals/{deal}/edit', EditDeal::class)->name('admin.deals.edit');
    Route::get('/admin/instant-deals', InstantDealsManager::class)->name('admin.instant-deals');

    // Blogs Manager
    Route::get('/admin/blogs', ManageBlogs::class)->name('admin.blogs.index');
    Route::get('/admin/blogs/create', CreateBlog::class)->name('admin.blogs.create');
    Route::get('/admin/blogs/{id}/edit', EditBlog::class)->name('admin.blogs.edit');
});

require __DIR__.'/auth.php';
