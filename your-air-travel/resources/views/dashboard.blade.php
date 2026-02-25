<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-800 leading-tight">
                {{ __('Admin Overzicht') }}
            </h2>
            <a href="{{ route('admin.deals.create') }}" class="bg-[#2596be] hover:bg-[#1a7a9e] text-white px-4 py-2 rounded-lg font-bold shadow-sm transition-colors text-sm">
                + Nieuwe Deal Toevoegen
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- TOP RIJ: STATISTIEKEN (KPI's) --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                {{-- Stat: Actieve Deals --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div class="w-12 h-12 bg-blue-100 text-[#2596be] rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Actieve Deals</p>
                        <p class="text-2xl font-black text-gray-900">{{ $activeDealsCount ?? 0 }}</p>
                    </div>
                </div>

                {{-- Stat: Verloopt Binnenkort --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Verloopt < 7 dgn</p>
                        <p class="text-2xl font-black text-gray-900">{{ $expiringSoonCount ?? 0 }}</p>
                    </div>
                </div>

                {{-- Stat: Verlopen Actie Vereist --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Verlopen (Offline)</p>
                        <p class="text-2xl font-black text-gray-900">{{ $expiredCount ?? 0 }}</p>
                    </div>
                </div>

                {{-- Stat: Totaal Kliks --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Kliks (Deze week)</p>
                        <p class="text-2xl font-black text-gray-900">{{ $totalClicksThisWeek ?? 0 }}</p>
                    </div>
                </div>

            </div>

            {{-- MAIN CONTENT GRID --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- LINKER KOLOM (Actie vereist) --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- 1. VERLOOPT BINNENKORT --}}
                    <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 bg-orange-50/50 flex justify-between items-center">
                            <h3 class="font-bold text-gray-900 flex items-center">
                                <span class="text-orange-500 mr-2">⏱️</span> Verloopt Binnenkort (Actie Vereist)
                            </h3>
                        </div>
                        <div class="p-0">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3">Titel</th>
                                        <th class="px-6 py-3">Bestemming</th>
                                        <th class="px-6 py-3">Startdatum</th>
                                        <th class="px-6 py-3">Actie</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($expiringDeals ?? [] as $deal)
                                    <tr class="border-b hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-gray-900">{{ $deal->title }}</td>
                                        <td class="px-6 py-4">{{ $deal->destination }}</td>
                                        <td class="px-6 py-4 text-orange-600 font-bold">Nog {{ (int) abs(now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($deal->departure_date)->startOfDay())) }} dagen</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('admin.deals.edit', $deal->id) }}" class="text-[#2596be] hover:underline">Bewerken</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-400">Geen deals die binnenkort verlopen. Mooi zo!</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- 2. VERLOPEN DEALS --}}
                    <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 bg-red-50/50 flex justify-between items-center">
                            <h3 class="font-bold text-gray-900 flex items-center">
                                <span class="text-red-500 mr-2">🚨</span> Verlopen Deals (Staan offline)
                            </h3>
                        </div>
                        <div class="p-0">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3">Titel</th>
                                        <th class="px-6 py-3">Verlopen op (Startdatum)</th>
                                        <th class="px-6 py-3">Actie</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($expiredDeals ?? [] as $deal)
                                    <tr class="border-b bg-red-50/10">
                                        <td class="px-6 py-4 font-bold text-gray-400 line-through">{{ $deal->title }}</td>
                                        <td class="px-6 py-4 text-red-500 font-medium">{{ \Carbon\Carbon::parse($deal->start_date)->format('d-m-Y') }}</td>
                                        <td class="px-6 py-4 flex gap-3">
                                            <a href="{{ route('admin.deals.edit', $deal->id) }}" class="text-[#2596be] hover:underline">Verlengen</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-gray-400">Je hebt momenteel geen verlopen deals.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                {{-- RECHTER KOLOM (Prestaties) --}}
                <div class="space-y-8">

                    {{-- 3. MEEST GEKLIKT (Top Performers) --}}
                    <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-gray-900 flex items-center">
                                <span class="text-yellow-500 mr-2">🏆</span> Top Performers (Kliks)
                            </h3>
                        </div>
                        <div class="p-6">
                            <ul class="space-y-4">
                                @forelse($topClickedDeals ?? [] as $deal)
                                <li class="flex items-center justify-between pb-4 border-b border-gray-50 last:border-0 last:pb-0">
                                    <div>
                                        <p class="font-bold text-gray-900 text-sm">{{ $deal->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $deal->partner ?? 'Aanbieder' }}</p>
                                    </div>
                                    <div class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                        {{ $deal->clicks ?? 0 }} kliks
                                    </div>
                                </li>
                                @empty
                                <div class="text-center py-4 text-gray-400 text-sm">
                                    Nog onvoldoende data beschikbaar.
                                </div>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
