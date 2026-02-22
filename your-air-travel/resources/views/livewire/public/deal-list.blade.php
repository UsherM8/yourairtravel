<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

    <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-gray-200 pb-4">
        <div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Gevonden Deals</h2>
            <p class="text-gray-500 mt-2 text-lg">Resultaten op basis van jouw filters.</p>
        </div>
        <div class="text-sm font-medium text-gray-400 bg-gray-100 px-4 py-2 rounded-full shadow-inner">
            {{ $totalDeals }} deals gevonden
        </div>
    </div>

    {{-- HET GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

        @forelse($deals as $deal)
            @include('components.deal-card', ['deal' => $deal, 'index' => $loop->index])
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

    {{-- DE LAAD MEER KNOP --}}
    <div class="mt-16 flex justify-center">
        @if(count($deals) < $totalDeals)
            <button
                wire:click="loadMore"
                class="px-10 py-4 bg-white border-2 border-[#2596be] text-[#2596be] font-black tracking-wide rounded-2xl hover:bg-[#2596be] hover:text-white transition-all duration-300 shadow-sm hover:shadow-lg flex items-center group"
            >
                {{-- Tekst als hij NIET aan het laden is --}}
                <span wire:loading.remove wire:target="loadMore" class="flex items-center">
                    Laad meer deals
                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-y-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                </span>

                {{-- Tekst (en spinner icoon) als hij WEL aan het laden is --}}
                <span wire:loading wire:target="loadMore" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Aan het inladen...
                </span>
            </button>
        @elseif($totalDeals > 0)
            <p class="text-gray-400 font-medium text-sm bg-gray-50 px-6 py-3 rounded-full">
                Je hebt alle {{ $totalDeals }} deals bekeken! ✈️
            </p>
        @endif
    </div>

</div>
