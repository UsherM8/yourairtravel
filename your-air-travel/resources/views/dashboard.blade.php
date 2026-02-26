<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-800 leading-tight italic">
                {{ __('Admin Overzicht') }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('admin.blogs.create') }}" class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-lg font-bold shadow-sm transition-colors text-sm hover:bg-gray-50">
                    + Nieuwe Blog
                </a>
                <a href="{{ route('admin.deals.create') }}" class="bg-[#2596be] hover:bg-[#1a7a9e] text-white px-4 py-2 rounded-lg font-bold shadow-sm transition-colors text-sm">
                    + Nieuwe Deal
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 1. KPI RIJ --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                {{-- Live --}}
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div class="w-10 h-10 bg-blue-100 text-[#2596be] rounded-xl flex items-center justify-center mr-3 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Live Deals</p>
                        <p class="text-xl font-black text-gray-900 leading-none">{{ $activeDealsCount ?? 0 }}</p>
                    </div>
                </div>
                {{-- Views --}}
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mr-3 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Deal Views</p>
                        <p class="text-xl font-black text-gray-900 leading-none">{{ $totalClicksThisWeek ?? 0 }}</p>
                    </div>
                </div>
                {{-- Boeks --}}
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mr-3 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Boeking link clicks</p>
                        <p class="text-xl font-black text-gray-900 leading-none">{{ $totalOutboundClicks ?? 0 }}</p>
                    </div>
                </div>
                {{-- Blogs --}}
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div class="w-10 h-10 bg-yellow-100 text-yellow-600 rounded-xl flex items-center justify-center mr-3 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Blog Views</p>
                        <p class="text-xl font-black text-gray-900 leading-none">{{ $totalBlogViews ?? 0 }}</p>
                    </div>
                </div>
                {{-- Offline --}}
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div class="w-10 h-10 bg-red-100 text-red-600 rounded-xl flex items-center justify-center mr-3 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Offline Deals</p>
                        <p class="text-xl font-black text-gray-900 leading-none">{{ $expiredCount ?? 0 }}</p>
                    </div>
                </div>
                {{-- Urgent --}}
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center mr-3 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Urgente Acties</p>
                        <p class="text-xl font-black text-gray-900">{{ $expiringSoonCount ?? 0 }}</p>
                    </div>
                </div>
            </div>

            {{-- 2. MIDDEN KOLOM: TABLES --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">

                    {{-- VERLOOPT BINNENKORT (10 items, klikbaar naar show) --}}
                    <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 bg-orange-50/50 flex justify-between items-center">
                            <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wider italic">⏱️ Verloopt Binnenkort (Top 10)</h3>
                        </div>
                        <div class="overflow-x-auto text-sm">
                            <table class="w-full text-left">
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($expiringDeals as $deal)
                                    <tr class="hover:bg-gray-50 transition-colors group">
                                        <td class="px-6 py-4 font-bold text-gray-800">
                                            <a href="{{ route('public.deal.show', $deal->id) }}" target="_blank" class="group-hover:text-[#2596be] transition-colors">
                                                {{ $deal->title }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-orange-600 font-black">Nog {{ (int) now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($deal->departure_date)->startOfDay()) }}d</td>
                                        <td class="px-6 py-4 text-right flex justify-end gap-3">
                                            <a href="{{ route('admin.deals.edit', $deal->id) }}" class="text-[#2596be] font-bold hover:underline">Edit</a>
                                            <form action="{{ route('admin.deals.archive', $deal->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-red-400 font-bold hover:text-red-600">Archiveer</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td class="px-6 py-10 text-center text-gray-400">Alles op orde.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- VERLOPEN DEALS (Geweest) --}}
                    <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 bg-red-50/50">
                            <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wider italic">🚨 Verlopen Deals</h3>
                        </div>
                        <div class="overflow-x-auto text-sm">
                            <table class="w-full text-left">
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($expiredDeals as $deal)
                                    <tr class="bg-red-50/5 group">
                                        <td class="px-6 py-4 font-medium text-gray-400 line-through">
                                             {{ $deal->title }}
                                        </td>
                                        <td class="px-6 py-4 text-red-500 font-bold">{{ \Carbon\Carbon::parse($deal->departure_date)->format('d M Y') }}</td>
                                        <td class="px-6 py-4 text-right flex justify-end gap-3">
                                            <a href="{{ route('admin.deals.edit', $deal->id) }}" class="text-[#2596be] font-bold hover:underline">Edit</a>
                                            <form action="{{ route('admin.deals.archive', $deal->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-red-500 font-black">Archiveer</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td class="px-6 py-10 text-center text-gray-400 italic">Geen verlopen deals.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- TOP BLOGS --}}
                <div class="space-y-8">
                    <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 bg-blue-50/30">
                            <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wider italic">📖 Top Blogs</h3>
                        </div>
                        <div class="p-4 space-y-1">
                            @foreach($topBlogs as $blog)
                            <a href="{{ route('public.blog.show', $blog->id) }}" target="_blank" class="flex items-center justify-between p-3 rounded-xl hover:bg-blue-50 transition-all group">
                                <span class="font-bold text-gray-800 text-xs truncate mr-2">{{ $blog->title }}</span>
                                <span class="shrink-0 bg-yellow-50 text-yellow-700 px-2 py-0.5 rounded text-[10px] font-black italic">🔥 {{ $blog->click_count }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. TOP PERFORMANCE GRID (3x5) --}}
            <div class="bg-white shadow-sm sm:rounded-[2.5rem] border border-gray-100 overflow-hidden">
                <div class="px-10 py-8 border-b border-gray-100 bg-gray-50/50 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <h3 class="font-black text-gray-900 text-xl italic uppercase tracking-widest">
                            <span class="text-yellow-500 mr-2">🏆</span> Performance Grid
                        </h3>
                    </div>

                    {{-- FILTER OPTIES --}}
                    <div class="flex flex-wrap items-center gap-3">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mr-2">Sorteer op:</p>
                        {{-- DEAFULT IS NU VIEWS --}}
                        <a href="?sort=views" class="bg-white border {{ request('sort') == 'views' || !request('sort') ? 'border-blue-500 text-blue-600 ring-2 ring-blue-100' : 'border-gray-200 text-gray-500' }} px-3 py-1.5 rounded-xl text-[9px] font-black uppercase transition-all shadow-sm">Views 👀</a>
                        <a href="?sort=boeks" class="bg-white border {{ request('sort') == 'boeks' ? 'border-purple-500 text-purple-600 ring-2 ring-purple-100' : 'border-gray-200 text-gray-500' }} px-3 py-1.5 rounded-xl text-[9px] font-black uppercase transition-all shadow-sm">Boeking link clicks ✈️</a>
                    </div>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                        @forelse($topClickedDeals as $deal)
                            @php
                                $rank = ($topClickedDeals->currentPage() - 1) * $topClickedDeals->perPage() + $loop->iteration;

                                $finalPath = null;
                                if(isset($deal->primaryImage)) {
                                    $finalPath = $deal->primaryImage->path;
                                } elseif(!empty($deal->image_path)) {
                                    $finalPath = $deal->image_path;
                                } elseif(isset($deal->images) && count($deal->images) > 0) {
                                    $finalPath = $deal->images[0]->path ?? $deal->images[0]->image_path;
                                }
                            @endphp

                            <div class="relative group h-full">
                                <div class="absolute -top-3 -left-3 w-10 h-10 bg-gray-900 text-white flex items-center justify-center rounded-2xl font-black italic shadow-xl z-20 group-hover:scale-110 transition-transform border-2 border-white">
                                    #{{ $rank }}
                                </div>

                                @if($deal->is_active)
                                    <a href="{{ route('public.deal.show', $deal->id) }}" target="_blank"
                                       class="block bg-white border border-gray-100 rounded-[2.5rem] overflow-hidden hover:shadow-2xl hover:border-[#2596be] transition-all relative h-full flex flex-col shadow-sm">

                                        <div class="h-32 w-full overflow-hidden bg-gray-100 relative shrink-0">
                                            @if($finalPath)
                                                <img src="{{ asset('storage/' . $finalPath) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-300 font-bold italic text-[10px]">
                                                    ✈️ YourAirTravel
                                                </div>
                                            @endif
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                        </div>

                                        <div class="p-5 flex-1 flex flex-col justify-between">
                                            <div class="min-w-0">
                                                <h4 class="font-black text-gray-900 text-[11px] leading-tight line-clamp-2 mb-1 uppercase tracking-tighter group-hover:text-[#2596be]">{{ $deal->title }}</h4>
                                                <p class="text-[9px] font-bold text-gray-400 uppercase italic truncate">{{ $deal->arrival_city }}</p>
                                            </div>

                                            <div class="mt-4 flex justify-between items-end border-t border-gray-50 pt-3">
                                                <div class="flex flex-col text-[10px] font-black">
                                                    <span class="text-purple-600">✈️ {{ $deal->outbound_clicks }}</span>
                                                </div>
                                                <div class="text-right text-[10px] font-black">
                                                    <span class="text-gray-800">👀 {{ $deal->click_count }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @else
                                    {{-- OFFLINE KAART --}}
                                    <div class="bg-gray-100 border border-gray-200 rounded-[2.5rem] overflow-hidden opacity-50 grayscale flex flex-col h-full relative">
                                        <div class="h-32 w-full bg-gray-200 flex items-center justify-center text-gray-400 italic font-black text-[10px]">OFFLINE</div>
                                        <div class="p-5 flex-1 flex flex-col justify-center">
                                            <h4 class="font-black text-gray-400 text-[10px] leading-tight line-through uppercase text-center">{{ $deal->title }}</h4>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="col-span-full py-20 text-center text-gray-300 font-black italic uppercase">Geen data gevonden.</div>
                        @endforelse
                    </div>

                    {{-- PAGINERING --}}
                    <div class="mt-12">
                        {{ $topClickedDeals->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
