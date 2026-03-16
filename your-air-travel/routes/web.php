<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Models\Deal;
use App\Models\Blog;
use App\Models\User;
use Carbon\Carbon;

use App\Livewire\Admin\ManageDeals;
use App\Livewire\Admin\CreateDeal;
use App\Livewire\Admin\EditDeal;
use App\Livewire\Admin\ManageBlogs;
use App\Livewire\Admin\CreateBlog;
use App\Livewire\Admin\EditBlog;
use App\Livewire\Admin\InstantDealsManager;
use App\Livewire\Admin\CreateUser;
use App\Livewire\Admin\ManageUsers;
use App\Livewire\Auth\SetPassword;

use App\Livewire\Public\ShowDeal;
use App\Livewire\Public\ShowBlog;
use App\Livewire\Public\BlogList;
use App\Livewire\Public\DealRoulette;
use App\Livewire\Public\BookConsultation;

// ==========================================
// 1. PUBLIEKE ROUTES (Voor elke bezoeker)
// ==========================================
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

Route::get('/blog', BlogList::class)->name(name: 'public.blogs');
Route::get('/blog/{id}', ShowBlog::class)->name('public.blog.show');
Route::get('/persoonlijk-reisadvies', BookConsultation::class)->name('consultation');

// Statische pagina's
Route::view('/over-ons', 'over-ons')->name('over-ons');
Route::view('/contact', 'contact')->name('contact');
Route::view('/privacy-policy', 'privacy')->name('privacy');
Route::view('/algemene-voorwaarden', 'voorwaarden')->name('voorwaarden');

// --- UITNODIGINGS-LINK (Signed URL) ---
Route::get('/uitnodiging/{user}', SetPassword::class)->name('invite.set-password');


// ==========================================
// 2. INGELOGDE GEBRUIKERS (Moeten ingelogd zijn)
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {

    // --- 2FA CHALLENGE (De enige plek waar je heen mag zonder 2FA-stempel) ---
    Route::get('/2fa-verificatie', \App\Livewire\Auth\TwoFactorChallenge::class)->name('2fa.challenge');

    // ==========================================
    // 2B. 2FA BEVEILIGDE ROUTES
    // ==========================================
    // Vanaf hier moet je écht de 2FA hebben gepasseerd.
    Route::middleware(['2fa'])->group(function () {

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
            $expiringDeals = Deal::where('is_active', true)
                        ->whereBetween('departure_date', [$vandaag, $volgendeWeek])
                        ->orderBy('departure_date', 'asc')
                        ->take(10)
                        ->get();

            $expiredDeals = Deal::where('is_active', true)
                                ->whereDate('departure_date', '<', $vandaag)
                                ->orderBy('departure_date', 'desc')
                                ->take(10)
                                ->get();

            // 3. TOP PERFORMANCE GRID (Met sortering & foto logica)
            $sort = request('sort', 'views');

            $query = Deal::with(['primaryImage', 'images']);

            if ($sort === 'boeks') {
                $query->orderBy('outbound_clicks', 'desc');
            } else {
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
        Route::post('/admin/deals/{deal}/archive', function (Deal $deal) {
            $deal->update(['is_active' => false]);
            return back()->with('message', 'Deal succesvol gearchiveerd.');
        })->name('admin.deals.archive');

        Route::post('/admin/blogs/{id}/archive', function ($id) {
            $blog = Blog::findOrFail($id);
            $blog->update(['is_active' => false]);
            return back()->with('message', 'Blog succesvol gearchiveerd.');
        })->name('admin.blogs.archive');

        // --- PROFIEL ---
        Route::view('profile', 'profile')->name('profile');

        // --- DEALS BEHEER ---
        Route::get('/admin/deals', ManageDeals::class)->name('admin.deals');
        Route::get('/admin/deals/create', CreateDeal::class)->name('admin.deals.create');
        Route::get('/admin/deals/{deal}/edit', EditDeal::class)->name('admin.deals.edit');
        Route::get('/admin/instant-deals', InstantDealsManager::class)->name('admin.instant-deals');

        // --- BLOGS BEHEER ---
        Route::get('/admin/blogs', ManageBlogs::class)->name('admin.blogs.index');
        Route::get('/admin/blogs/create', CreateBlog::class)->name('admin.blogs.create');
        Route::get('/admin/blogs/{id}/edit', EditBlog::class)->name('admin.blogs.edit');
    });
});


// ==========================================
// 3. SUPER ADMIN ROUTES (Gebruikersbeheer)
// ==========================================
// Let op de '2fa' in de middleware array! Super Admins moeten ook 2FA doen.
Route::middleware(['auth', 'verified', '2fa', 'admin'])->group(function () {

    Route::get('/admin/users', ManageUsers::class)->name('admin.users.index');
    Route::get('/admin/users/create', CreateUser::class)->name('admin.users.create');

});

require __DIR__.'/auth.php';
