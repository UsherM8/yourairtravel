<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

    <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Top Aanbiedingen</h2>
            <p class="text-gray-500 mt-2 text-lg">De beste vluchten en prijzen van dit moment.</p>
        </div>
        <div class="text-sm font-medium text-gray-400 bg-gray-100 px-4 py-2 rounded-full">
            {{ count($deals) }} deals gevonden
        </div>
    </div>

    {{-- HET GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

        @forelse($deals as $deal)

            {{-- De Kaart (Container) --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group flex flex-col h-full relative block">

                {{-- DE TRUC: Onzichtbare link voor de hele kaart naar detailpagina --}}
                <a href="{{ route('public.deal.show', $deal->id) }}" class="absolute inset-0 z-10">
                    <span class="sr-only">Bekijk details van {{ $deal->title }}</span>
                </a>

                {{-- Korting Badge (Oranje!) --}}
                @if($deal->price > $deal->discounted_price)
                    <div class="absolute top-5 left-5 z-20 bg-[#e5764b] text-white text-sm font-black px-4 py-2 rounded-full shadow-lg transform -rotate-2 pointer-events-none">
                        -{{ round((($deal->price - $deal->discounted_price) / $deal->price) * 100) }}%
                    </div>
                @endif

                {{-- De Afbeelding --}}
                <div class="relative h-72 overflow-hidden bg-gray-200 pointer-events-none">
                    @if($deal->primaryImage)
                        <img src="{{ asset('storage/' . $deal->primaryImage->path) }}" alt="{{ $deal->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                    <div class="absolute bottom-5 left-5 right-5 text-white">
                        <div class="flex items-center text-sm font-semibold opacity-90 mb-2">
                            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $deal->arrival_city }}
                        </div>
                        <h3 class="text-2xl font-bold leading-tight line-clamp-2">{{ $deal->title }}</h3>
                    </div>
                </div>

                {{-- De Inhoud / Info --}}
                <div class="p-7 flex flex-col flex-grow">

                    <div class="flex justify-between items-center mb-4 text-sm text-gray-600 pointer-events-none">
                        <div class="flex items-center font-medium bg-gray-50 border border-gray-100 px-3 py-1.5 rounded-lg">
                            {{ $deal->departure_city }}
                            <svg class="w-3.5 h-3.5 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></path></svg>
                            {{ $deal->arrival_city }}
                        </div>
                        @if($deal->airline)
                            <div class="font-bold text-gray-400 uppercase tracking-wider text-xs">{{ $deal->airline }}</div>
                        @endif
                    </div>

                    {{-- Tags / Vakantietype (Mooi in het primaire blauw) --}}
                    @if(!empty($deal->tags) && is_array($deal->tags))
                        <div class="flex flex-wrap gap-1.5 mb-4 pointer-events-none">
                            @foreach(array_slice($deal->tags, 0, 2) as $tag) {{-- Laat er max 2 zien in het overzicht --}}
                                <span class="px-2 py-0.5 bg-[#2596be]/10 text-[#2596be] text-[10px] font-bold uppercase tracking-wider rounded border border-[#2596be]/20">
                                    {{ $tag }}
                                </span>
                            @endforeach
                            @if(count($deal->tags) > 2)
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-500 text-[10px] font-bold uppercase tracking-wider rounded border border-gray-200">
                                    +{{ count($deal->tags) - 2 }}
                                </span>
                            @endif
                        </div>
                    @endif

                    @if($deal->departure_date)
                        <div class="text-sm text-gray-500 mb-6 flex items-center font-medium pointer-events-none">
                            <svg class="w-4 h-4 mr-2 text-[#2596be]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Vertrek: {{ \Carbon\Carbon::parse($deal->departure_date)->format('d M Y') }}
                        </div>
                    @endif

                    <div class="mt-auto pt-5 border-t border-gray-100 flex items-center justify-between relative">
                        <div class="pointer-events-none">
                            <span class="text-xs text-gray-400 font-bold uppercase tracking-wider block mb-0.5">Vanaf</span>
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl font-black text-[#2596be]">€{{ $deal->discounted_price }}</span>
                                @if($deal->price > $deal->discounted_price)
                                    <span class="text-base text-gray-400 line-through font-semibold">€{{ $deal->price }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- De Call To Action knop (Oranje Actiekleur) --}}
                        <a href="{{ $deal->referral_url }}" target="_blank" rel="noopener noreferrer" class="relative z-20 px-6 py-3 bg-[#e5764b] text-white text-sm font-bold rounded-xl hover:bg-[#d4653a] transition-colors shadow-md hover:shadow-lg flex items-center">
                            Bekijk
                            <svg class="w-4 h-4 ml-1.5 transform group-hover:translate-x-1.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></path></svg>
                        </a>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-span-full py-24 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-[#2596be]/10 mb-5">
                    <svg class="w-10 h-10 text-[#2596be]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Geen deals gevonden</h3>
                <p class="text-gray-500 text-lg">Pas je filters aan of zoek op een andere bestemming.</p>
            </div>
        @endforelse
    </div>
</div>
