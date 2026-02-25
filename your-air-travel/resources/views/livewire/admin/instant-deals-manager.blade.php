<div class="max-w-7xl mx-auto p-6">
    <div class="mb-8">
        <h2 class="text-3xl font-black text-gray-900">Homepage Instant Deals (Flash Deals)</h2>
        <p class="text-gray-500 mt-2">Beheer hier de 8 deals die direct boekbaar zijn op de homepage.</p>
    </div>

    {{-- DE 8 BLOKKEN (GRID) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($slots as $slot)
            @php
                $dealInSlot = $slottedDeals->get($slot);
            @endphp

            <div class="border-2 {{ $dealInSlot ? 'border-transparent shadow-md' : 'border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 cursor-pointer' }} rounded-2xl flex flex-col justify-center items-center h-48 relative transition-all overflow-hidden"
                 @if(!$dealInSlot) wire:click="openSelector({{ $slot }})" @endif>

                @if($dealInSlot)
                    {{-- ER ZIT AL EEN DEAL IN DIT BLOK --}}

                    {{-- De Afbeelding als Achtergrond --}}
                    <div class="absolute inset-0 w-full h-full">
                        <img src="{{ asset('storage/' . $dealInSlot->image_path) }}" alt="{{ $dealInSlot->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/30"></div>
                    </div>

                    {{-- Badges en Knoppen --}}
                    <span class="absolute top-2 left-2 bg-[#2596be] text-white text-xs font-bold px-2 py-1 rounded-md z-10 shadow-sm">Slot {{ $slot }}</span>

                    <button wire:click="clearSlot({{ $slot }})" class="absolute top-2 right-2 text-red-500 hover:text-white hover:bg-red-500 bg-white rounded-full p-1.5 shadow-md z-10 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    {{-- Titel & Prijs --}}
                    <div class="absolute bottom-3 left-0 w-full px-3 z-10">
                        <div class="bg-white/95 backdrop-blur-sm p-2 rounded-xl shadow-sm text-center">
                            <p class="font-bold text-gray-900 truncate px-1" title="{{ $dealInSlot->title }}">{{ $dealInSlot->title }}</p>
                            <p class="text-[#2596be] font-black text-sm mt-0.5 flex justify-center items-center gap-1.5">
                                @if($dealInSlot->discounted_price > 0 && $dealInSlot->discounted_price < $dealInSlot->price)
                                    <span class="text-gray-400 line-through text-xs font-semibold">€{{ $dealInSlot->price }}</span>
                                    <span>€{{ $dealInSlot->discounted_price }}</span>
                                @else
                                    <span>€{{ $dealInSlot->price }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                @else
                    {{-- LEEG BLOK --}}
                    <span class="absolute top-2 left-2 bg-gray-200 text-gray-600 text-xs font-bold px-2 py-1 rounded-md">Slot {{ $slot }}</span>
                    <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    <span class="text-gray-500 font-medium text-sm">Klik om deal toe te voegen</span>
                @endif
            </div>
        @endforeach
    </div>

    {{-- DE DEAL KIEZER (MODAL / OVERLAY) --}}
    @if($activeSlot !== null)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[80vh] flex flex-col overflow-hidden">

                {{-- Header van de modal --}}
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="text-xl font-bold text-gray-900">Kies een deal voor Slot {{ $activeSlot }}</h3>
                    <button wire:click="closeSelector" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                {{-- Zoekbalk --}}
                <div class="p-4 border-b border-gray-100">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Zoek op titel of bestemming..." class="w-full border-gray-300 rounded-xl shadow-sm focus:border-[#2596be] focus:ring-[#2596be]">
                </div>

                {{-- Lijst met deals --}}
                <div class="overflow-y-auto p-2 flex-1">
                    @forelse($availableDeals as $deal)
                        <div class="flex items-center justify-between p-4 hover:bg-gray-50 border-b border-gray-50 last:border-0 rounded-xl transition-colors">
                            <div class="flex items-center truncate mr-4">
                                <div class="w-12 h-12 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0 mr-4 shadow-sm">
                                    <img src="{{ asset('storage/' . $deal->image_path) }}" class="w-full h-full object-cover">
                                </div>
                                <div class="truncate">
                                    <p class="font-bold text-gray-900 truncate">{{ $deal->title }}</p>
                                    <p class="text-sm text-gray-500 flex items-center gap-1.5 mt-0.5">
                                        {{ $deal->destination }} &bull;
                                        @if($deal->discounted_price > 0 && $deal->discounted_price < $deal->price)
                                            <span class="text-gray-400 line-through text-xs">€{{ $deal->price }}</span>
                                            <span class="text-[#2596be] font-bold">€{{ $deal->discounted_price }}</span>
                                        @else
                                            <span class="text-[#2596be] font-bold">€{{ $deal->price }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <button wire:click="assignDeal({{ $deal->id }})" class="bg-[#2596be] hover:bg-[#1a7a9e] text-white px-4 py-2 rounded-lg font-bold text-sm flex-shrink-0 transition-colors shadow-sm">
                                Kies deze
                            </button>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            Geen deals beschikbaar. Al je actieve deals staan wellicht al op de homepage, of probeer een andere zoekterm.
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    @endif
</div>
