<div class="bg-white rounded-2xl shadow-2xl p-4 md:p-6 w-full max-w-6xl mx-auto border border-gray-100">
    <form wire:submit.prevent="search" class="flex flex-col gap-4">

        {{-- HOOFD ZOEKVELDEN (Bovenste rij) --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            {{-- 1. Bestemming (Landen -> Steden Dropdown) --}}
            <div x-data="{ open: false }" class="relative z-50">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                {{-- De knop --}}
                <div @click="open = !open" class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl bg-white shadow-sm text-gray-700 font-medium cursor-pointer flex justify-between items-center h-full hover:border-[#2596be]/50 transition-colors">
                    <span class="truncate">
                        @if(count($geselecteerdeLanden) > 0 || count($geselecteerdeSteden) > 0)
                            {{ count($geselecteerdeLanden) + count($geselecteerdeSteden) }} locaties
                        @else
                            Waar wil je heen?
                        @endif
                    </span>
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
                {{-- Het uitklapmenu --}}
                <div x-show="open" @click.outside="open = false" style="display: none;" class="absolute w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl max-h-80 overflow-y-auto">
                    <div class="p-2">
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 px-2">Kies Landen & Steden</div>

                        @foreach($beschikbareBestemmingen as $land => $steden)
                            {{-- Het Land Checkbox --}}
                            <label class="flex items-center px-3 py-2 hover:bg-[#2596be]/10 rounded-lg cursor-pointer font-medium text-gray-800 transition-colors">
                                <input type="checkbox" wire:model.live="geselecteerdeLanden" value="{{ $land }}" class="rounded border-gray-300 text-[#2596be] focus:ring-[#2596be] w-4 h-4">
                                <span class="ml-3">{{ $land }}</span>
                            </label>

                            {{-- De Steden (Verschijnen pas als het land is aangevinkt!) --}}
                            @if(in_array($land, $geselecteerdeLanden))
                                <div class="ml-8 mb-2 border-l-2 border-[#2596be]/30 pl-2 space-y-1">
                                    @foreach($steden as $stad)
                                        <label class="flex items-center px-3 py-1.5 hover:bg-[#2596be]/10 rounded-lg cursor-pointer text-sm text-gray-600 transition-colors">
                                            <input type="checkbox" wire:model.live="geselecteerdeSteden" value="{{ $stad }}" class="rounded border-gray-300 text-[#2596be] focus:ring-[#2596be] w-3.5 h-3.5">
                                            <span class="ml-3">{{ $stad }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>

            {{-- 2. Reisperiode --}}
            <div x-data="{ open: false }" class="relative z-40">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div @click="open = !open" class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl bg-white shadow-sm text-gray-700 font-medium cursor-pointer flex justify-between items-center h-full hover:border-[#2596be]/50 transition-colors">
                    <span x-text="$wire.reisperiodes.length > 0 ? $wire.reisperiodes.length + ' gekozen' : 'Wanneer?'" class="truncate"></span>
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
                <div x-show="open" @click.outside="open = false" style="display: none;" class="absolute w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl max-h-60 overflow-y-auto">
                    <div class="p-2 space-y-1">
                        @foreach(['lente' => 'Lente (Mrt - Mei)', 'zomer' => 'Zomer (Jun - Aug)', 'herfst' => 'Herfst (Sep - Nov)', 'winter' => 'Winter (Dec - Feb)', 'lastminute' => 'Last-minute ⚡'] as $val => $label)
                        <label class="flex items-center px-3 py-2 hover:bg-[#2596be]/10 rounded-lg cursor-pointer transition-colors">
                            <input type="checkbox" wire:model.live="reisperiodes" value="{{ $val }}" class="rounded border-gray-300 text-[#2596be] focus:ring-[#2596be] w-4 h-4">
                            <span class="ml-3 text-sm text-gray-700">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- 3. Vertrekluchthaven --}}
            <div x-data="{ open: false }" class="relative z-40">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div @click="open = !open" class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl bg-white shadow-sm text-gray-700 font-medium cursor-pointer flex justify-between items-center h-full hover:border-[#2596be]/50 transition-colors">
                    <span x-text="$wire.vertrekluchthavens.length > 0 ? $wire.vertrekluchthavens.length + ' gekozen' : 'Vertrek vanaf'" class="truncate"></span>
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
                <div x-show="open" @click.outside="open = false" style="display: none;" class="absolute w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl max-h-60 overflow-y-auto">
                    <div class="p-2 space-y-1">
                        @foreach(['AMS' => 'Amsterdam (Schiphol)', 'EIN' => 'Eindhoven', 'RTM' => 'Rotterdam / Den Haag', 'BRU' => 'Brussel', 'DUS' => 'Düsseldorf'] as $val => $label)
                        <label class="flex items-center px-3 py-2 hover:bg-[#2596be]/10 rounded-lg cursor-pointer transition-colors">
                            <input type="checkbox" wire:model.live="vertrekluchthavens" value="{{ $val }}" class="rounded border-gray-300 text-[#2596be] focus:ring-[#2596be] w-4 h-4">
                            <span class="ml-3 text-sm text-gray-700">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- 4. Zoekknop (Oranje Actiekleur) --}}
            <button type="submit" class="w-full py-3 px-6 bg-[#e5764b] hover:bg-[#d4653a] text-white font-bold rounded-xl shadow-lg shadow-[#e5764b]/30 transition-all transform hover:-translate-y-0.5 flex items-center justify-center z-10">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Vind Deals
            </button>
        </div>

        {{-- EXTRA FILTERS (Onderste rij) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-gray-100 pt-4 mt-2">

            {{-- 5. Budget --}}
            <div class="flex items-center space-x-2">
                <span class="text-sm font-semibold text-gray-500 w-24">Budget:</span>
                <div x-data="{ open: false }" class="relative w-full z-30">
                    <div @click="open = !open" class="w-full py-2 px-3 border border-gray-200 rounded-lg text-sm text-gray-600 bg-white cursor-pointer flex justify-between items-center hover:border-[#2596be]/50 transition-colors">
                        <span x-text="$wire.budgetten.length > 0 ? $wire.budgetten.length + ' gekozen' : 'Alle prijzen'" class="truncate"></span>
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                    <div x-show="open" @click.outside="open = false" style="display: none;" class="absolute w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl">
                        <div class="p-1">
                            @foreach(['50' => 'Onder de €50', '100' => 'Tot €100', '250' => 'Tot €250', '500' => 'Tot €500'] as $val => $label)
                            <label class="flex items-center px-3 py-2 hover:bg-[#2596be]/10 rounded cursor-pointer transition-colors">
                                <input type="checkbox" wire:model.live="budgetten" value="{{ $val }}" class="rounded border-gray-300 text-[#2596be] focus:ring-[#2596be] w-4 h-4">
                                <span class="ml-3 text-sm text-gray-700">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- 6. Vakantietype --}}
            <div class="flex items-center space-x-2">
                <span class="text-sm font-semibold text-gray-500 w-24">Type:</span>
                <div x-data="{ open: false }" class="relative w-full z-30">
                    <div @click="open = !open" class="w-full py-2 px-3 border border-gray-200 rounded-lg text-sm text-gray-600 bg-white cursor-pointer flex justify-between items-center hover:border-[#2596be]/50 transition-colors">
                        <span x-text="$wire.vakantietypes.length > 0 ? $wire.vakantietypes.length + ' gekozen' : 'Alle types'" class="truncate"></span>
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                    <div x-show="open" @click.outside="open = false" style="display: none;" class="absolute w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl">
                        <div class="p-1">
                            @foreach(['zon' => 'Zonvakantie ☀️', 'stad' => 'Stedentrip 🏛️', 'natuur' => 'Natuur & Actief 🌲', 'ver' => 'Verre Reizen 🌍'] as $val => $label)
                            <label class="flex items-center px-3 py-2 hover:bg-[#2596be]/10 rounded cursor-pointer transition-colors">
                                <input type="checkbox" wire:model.live="vakantietypes" value="{{ $val }}" class="rounded border-gray-300 text-[#2596be] focus:ring-[#2596be] w-4 h-4">
                                <span class="ml-3 text-sm text-gray-700">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- 7. Reisduur --}}
            <div class="flex items-center space-x-2">
                <span class="text-sm font-semibold text-gray-500 w-24">Duur:</span>
                <div x-data="{ open: false }" class="relative w-full z-30">
                    <div @click="open = !open" class="w-full py-2 px-3 border border-gray-200 rounded-lg text-sm text-gray-600 bg-white cursor-pointer flex justify-between items-center hover:border-[#2596be]/50 transition-colors">
                        <span x-text="$wire.reisduren.length > 0 ? $wire.reisduren.length + ' gekozen' : 'Maakt niet uit'" class="truncate"></span>
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                    <div x-show="open" @click.outside="open = false" style="display: none;" class="absolute w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl">
                        <div class="p-1">
                            @foreach(['weekend' => '1-3 Dagen (Weekendje)', 'week' => '1 Week', '2weken' => '10-14 Dagen'] as $val => $label)
                            <label class="flex items-center px-3 py-2 hover:bg-[#2596be]/10 rounded cursor-pointer transition-colors">
                                <input type="checkbox" wire:model.live="reisduren" value="{{ $val }}" class="rounded border-gray-300 text-[#2596be] focus:ring-[#2596be] w-4 h-4">
                                <span class="ml-3 text-sm text-gray-700">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- POPULAIRE BESTEMMINGEN PILLS --}}
        <div class="border-t border-gray-100 pt-4 flex flex-col sm:flex-row sm:items-center gap-3">
            <span class="text-sm font-semibold text-gray-500">Populaire bestemmingen:</span>

            <div class="flex flex-wrap gap-2">
                @foreach(['Spanje' => '🇪🇸 Spanje', 'Italië' => '🇮🇹 Italië', 'Griekenland' => '🇬🇷 Griekenland', 'Indonesië' => '🌴 Bali (Indonesië)', 'Verenigd Koninkrijk' => '🎡 Londen (VK)'] as $val => $label)
                    {{-- Pills in jouw blauw --}}
                    <button type="button" wire:click="setBestemming('{{ $val }}')" class="px-3 py-1.5 bg-[#2596be]/10 text-[#2596be] rounded-full text-xs font-bold hover:bg-[#2596be]/20 transition-colors border border-[#2596be]/20">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            {{-- Laad indicator (Oranje text) --}}
            <span wire:loading class="ml-auto text-sm text-[#e5764b] font-medium animate-pulse">
                Zoeken... ✈️
            </span>
        </div>

    </form>
</div>
