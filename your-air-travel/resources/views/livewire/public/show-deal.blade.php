<div class="bg-gray-50 min-h-screen pb-12 pt-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- TERUG KNOP --}}
        <div class="mb-6">
            <a href="/" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-[#2596be] transition-colors bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100 hover:shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Terug naar alle deals
            </a>
        </div>

        {{-- HEADER / HOOFDFOTO SECTIE --}}
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8 relative">

            {{-- Grote Hoofdfoto --}}
            <div class="h-64 md:h-96 w-full bg-gray-200 relative">
                @if($deal->primaryImage)
                    <img src="{{ asset('storage/' . $deal->primaryImage->path) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">Geen afbeelding</div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

                {{-- Titel op de foto --}}
                <div class="absolute bottom-6 left-6 md:bottom-10 md:left-10 text-white pr-6">
                    <span class="inline-block px-3 py-1 bg-[#2596be] text-xs font-bold rounded-full mb-3 uppercase tracking-wide shadow-sm">
                        {{ $deal->arrival_city }}, {{ $deal->arrival_country ?? 'Bestemming' }}
                    </span>
                    <h1 class="text-3xl md:text-5xl font-extrabold leading-tight drop-shadow-lg">{{ $deal->title }}</h1>
                </div>
            </div>
        </div>

        {{-- CONTENT GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- LINKERKANT: Details & Galerij (2/3 breedte) --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Omschrijving & NIEUWE TAGS --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">

                    {{-- Laat de tags (vakantietypes) zien als ze zijn ingevuld --}}
                    @if(!empty($deal->tags) && is_array($deal->tags))
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($deal->tags as $tag)
                                <span class="px-3 py-1 bg-[#2596be]/10 text-[#2596be] text-xs font-bold rounded-lg border border-[#2596be]/20">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Over deze deal</h2>
                    <p class="text-gray-600 leading-relaxed whitespace-pre-line text-lg">
                        {{ $deal->description }}
                    </p>
                </div>

                {{-- Fotogalerij (Alleen laten zien als er meer dan 1 foto is) --}}
                @if($deal->images->count() > 1)
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Meer foto's</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach($deal->images as $img)
                                @if(!$img->is_primary)
                                    <img src="{{ asset('storage/' . $img->path) }}" class="w-full h-32 md:h-40 object-cover rounded-xl shadow-sm hover:scale-105 transition-transform cursor-pointer">
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- RECHTERKANT: Boekingsbox (1/3 breedte) --}}
            <div class="space-y-6">

                {{-- Boeking / Prijs Box --}}
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-6 md:p-8 sticky top-24">
                    <div class="mb-6">
                        <span class="text-sm font-semibold text-gray-400 uppercase tracking-wide block mb-1">Jouw Prijs</span>
                        <div class="flex items-end gap-3">
                            {{-- Prijs is nu blauw --}}
                            <span class="text-5xl font-black text-[#2596be]">€{{ $deal->discounted_price }}</span>
                            @if($deal->price > $deal->discounted_price)
                                <span class="text-xl text-gray-400 line-through font-medium mb-1">€{{ $deal->price }}</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-2">* Prijzen kunnen snel wijzigen. Wacht niet te lang!</p>
                    </div>

                    <div class="space-y-4 mb-8 bg-gray-50 rounded-2xl p-4 border border-gray-100">
                        <div class="flex items-center text-gray-600">
                            <span class="w-8 flex justify-center text-xl">🛫</span>
                            <div>
                                <p class="text-xs text-gray-400">Vertrek</p>
                                <p class="font-semibold">{{ $deal->departure_city }} ({{ $deal->departure_country ?? '' }})</p>
                            </div>
                        </div>

                        <div class="flex items-center text-gray-600">
                            <span class="w-8 flex justify-center text-xl">🛬</span>
                            <div>
                                <p class="text-xs text-gray-400">Aankomst</p>
                                <p class="font-semibold">{{ $deal->arrival_city }} ({{ $deal->arrival_country ?? '' }})</p>
                            </div>
                        </div>

                        @if($deal->airline)
                            <div class="flex items-center text-gray-600">
                                <span class="w-8 flex justify-center text-xl">✈️</span>
                                <div>
                                    <p class="text-xs text-gray-400">Maatschappij</p>
                                    <p class="font-semibold">{{ $deal->airline }}</p>
                                </div>
                            </div>
                        @endif

                        @if($deal->departure_date)
                            <div class="flex items-center text-gray-600">
                                <span class="w-8 flex justify-center text-xl">📅</span>
                                <div>
                                    <p class="text-xs text-gray-400">Vertrekdatum</p>
                                    <p class="font-semibold">{{ \Carbon\Carbon::parse($deal->departure_date)->format('d M Y') }}</p>
                                </div>
                            </div>
                        @endif

                        {{-- NIEUW: Terugkomstdatum --}}
                        @if($deal->return_date)
                            <div class="flex items-center text-gray-600">
                                <span class="w-8 flex justify-center text-xl">🔙</span>
                                <div>
                                    <p class="text-xs text-gray-400">Terugkomst</p>
                                    <p class="font-semibold">{{ \Carbon\Carbon::parse($deal->return_date)->format('d M Y') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- De ultieme klik-knop in jouw ORANJE kleur! --}}
                    <a href="{{ $deal->referral_url }}" target="_blank" rel="noopener noreferrer" class="w-full py-4 bg-[#e5764b] hover:bg-[#d4653a] text-white font-black text-lg rounded-xl shadow-lg shadow-[#e5764b]/30 transition-all transform hover:-translate-y-1 flex items-center justify-center">
                        Bekijk & Boek Deal
                        <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
