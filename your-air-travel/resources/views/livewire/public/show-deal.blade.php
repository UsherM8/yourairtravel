@php
    // --- 1. PRIJS LOGICA FIX ---
    $normalePrijs = floatval($deal->price ?? 0);
    $kortingsPrijs = floatval($deal->discounted_price ?? 0);

    $hasDiscount = ($kortingsPrijs > 0 && $kortingsPrijs < $normalePrijs);
    $currentPrice = $hasDiscount ? $kortingsPrijs : $normalePrijs;

    // --- 2. AFBEELDINGEN VERZAMELEN (HOSTINGER FIX) ---
    $imageUrls = [];
    $rawPaths = [];

    // Verzamel eerst alle ruwe paden
    if (isset($deal->images) && count($deal->images) > 0) {
        foreach($deal->images as $img) {
            $rawPaths[] = $img->path ?? $img->image_path;
        }
    } elseif (isset($deal->primaryImage)) {
        $rawPaths[] = $deal->primaryImage->path;
    } elseif (!empty($deal->image_path)) {
        $rawPaths[] = $deal->image_path;
    }

    // Zet paden om naar kogelvrije URLs
    foreach($rawPaths as $path) {
        if ($path) {
            $imageUrls[] = file_exists(public_path('uploads/' . $path))
                ? asset('uploads/' . $path)
                : asset('storage/' . $path);
        }
    }
@endphp

<div class="bg-gray-50 min-h-screen pb-12 pt-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- TERUG KNOP --}}
        <div class="mb-6">
            <a href="{{ route('search.results') }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-[#2596be] transition-colors bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100 hover:shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Terug naar alle deals
            </a>
        </div>

        {{-- HEADER / HOOFDFOTO SLIDER SECTIE (AIRBNB STYLE) --}}
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8 relative group"
             x-data="{
                activeSlide: 0,
                slides: {{ json_encode($imageUrls) }},
                timer: null,
                startLoop() {
                    if(this.slides.length > 1) {
                        this.timer = setInterval(() => { this.next() }, 5000);
                    }
                },
                stopLoop() { clearInterval(this.timer); },
                next() { this.activeSlide = this.activeSlide === this.slides.length - 1 ? 0 : this.activeSlide + 1; },
                prev() { this.activeSlide = this.activeSlide === 0 ? this.slides.length - 1 : this.activeSlide - 1; }
             }"
             x-init="startLoop()"
             @mouseenter="stopLoop()"
             @mouseleave="startLoop()">

            <div class="h-64 md:h-[500px] w-full bg-gray-200 relative">

                {{-- Fallback als er 0 foto's zijn --}}
                <template x-if="slides.length === 0">
                    <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold italic text-2xl">
                        ✈️ YourAirTravel
                    </div>
                </template>

                {{-- De Slides --}}
                <template x-for="(slide, index) in slides" :key="index">
                    <img x-show="activeSlide === index"
                         :src="slide"
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         class="absolute inset-0 w-full h-full object-cover">
                </template>

                {{-- Pijltjes Navigatie --}}
                <div x-show="slides.length > 1" class="absolute inset-0 flex items-center justify-between px-4 md:px-8 z-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                    <button @click.prevent="prev()" class="pointer-events-auto bg-black/40 hover:bg-black/70 text-white rounded-full p-3 backdrop-blur-sm transition-all shadow-md">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click.prevent="next()" class="pointer-events-auto bg-black/40 hover:bg-black/70 text-white rounded-full p-3 backdrop-blur-sm transition-all shadow-md">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>

                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none z-10"></div>

                {{-- Bolletjes Navigatie --}}
                <div x-show="slides.length > 1" class="absolute bottom-6 md:bottom-10 right-6 flex justify-end gap-2 z-30 pointer-events-none">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click.prevent="activeSlide = index"
                                class="h-1.5 md:h-2 rounded-full transition-all pointer-events-auto shadow-sm"
                                :class="activeSlide === index ? 'w-6 md:w-8 bg-white' : 'w-1.5 md:w-2 bg-white/50 hover:bg-white/90'"></button>
                    </template>
                </div>

                {{-- Titel op de foto --}}
                <div class="absolute bottom-6 left-6 md:bottom-10 md:left-10 text-white pr-6 z-20 pointer-events-none">
                    <span class="inline-block px-3 py-1 bg-[#2596be] text-xs font-bold rounded-full mb-3 uppercase tracking-wide shadow-sm">
                        {{ $deal->arrival_city }}, {{ $deal->arrival_country ?? 'Bestemming' }}
                    </span>
                    <h1 class="text-3xl md:text-6xl font-black leading-tight drop-shadow-lg max-w-3xl italic tracking-tighter">{{ $deal->title }}</h1>
                </div>
            </div>
        </div>

        {{-- CONTENT GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- LINKERKANT: Details --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                    @if(!empty($deal->tags) && is_array($deal->tags))
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($deal->tags as $tag)
                                <span class="px-3 py-1 bg-[#2596be]/10 text-[#2596be] text-xs font-bold rounded-lg border border-[#2596be]/20">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <h2 class="text-2xl font-bold text-gray-900 mb-4 uppercase tracking-tighter">Over deze deal</h2>
                    <p class="text-gray-600 leading-relaxed whitespace-pre-line text-lg font-medium">
                        {{ $deal->description }}
                    </p>
                </div>
            </div>

            {{-- RECHTERKANT: Boekingsbox --}}
            <div class="space-y-6">
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-6 md:p-8 sticky top-24">
                    <div class="mb-6">
                        <span class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] block mb-1">Jouw Prijs</span>
                        <div class="flex items-end gap-3">
                            <span class="text-5xl font-black text-[#2596be] tracking-tighter">€{{ $currentPrice }}</span>
                            @if($hasDiscount)
                                <span class="text-xl text-gray-300 line-through font-bold mb-1">€{{ $normalePrijs }}</span>
                            @endif
                        </div>
                        <p class="text-[10px] font-bold text-gray-400 mt-2 uppercase">* Prijzen kunnen snel wijzigen. Wacht niet te lang!</p>
                    </div>

                    <div class="space-y-4 mb-8 bg-gray-50 rounded-2xl p-5 border border-gray-100">
                        <div class="flex items-center text-gray-600">
                            <span class="w-8 flex justify-center text-xl">🛫</span>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase">Vertrek</p>
                                <p class="font-bold text-sm text-gray-800">{{ $deal->departure_city }} ({{ $deal->departure_country ?? '' }})</p>
                            </div>
                        </div>

                        <div class="flex items-center text-gray-600">
                            <span class="w-8 flex justify-center text-xl">🛬</span>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase">Aankomst</p>
                                <p class="font-bold text-sm text-gray-800">{{ $deal->arrival_city }} ({{ $deal->arrival_country ?? '' }})</p>
                            </div>
                        </div>

                        @if($deal->airline)
                            <div class="flex items-center text-gray-600">
                                <span class="w-8 flex justify-center text-xl">✈️</span>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase">Maatschappij</p>
                                    <p class="font-bold text-sm text-gray-800">{{ $deal->airline }}</p>
                                </div>
                            </div>
                        @endif

                        @if($deal->departure_date)
                            <div class="flex items-center text-gray-600">
                                <span class="w-8 flex justify-center text-xl">📅</span>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase">Indicatie vertrek</p>
                                    <p class="font-bold text-sm text-gray-800">{{ \Carbon\Carbon::parse($deal->departure_date)->translatedFormat('j M Y') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('public.deal.book', $deal->id) }}" target="_blank" rel="noopener noreferrer" class="w-full py-4 bg-[#e5764b] hover:bg-[#d4653a] text-white font-black text-lg rounded-2xl shadow-lg shadow-[#e5764b]/30 transition-all transform hover:-translate-y-1 flex items-center justify-center uppercase tracking-wider">
                        Bekijk & Boek Deal
                        <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
