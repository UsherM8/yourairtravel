<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Succes melding --}}
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('message') }}
            </div>
        @endif

        {{-- HEADER: Zoekbalk + Filters + Create Knop --}}
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">

            {{-- Linker kant: Zoeken & Filters (Nu netjes in een grid!) --}}
            <div class="w-full lg:w-5/6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">

                {{-- Zoekbalk --}}
                <div class="relative">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Zoek op ID, titel of stad..."
                        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm pl-10"
                    >
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                {{-- Filter: Auteur --}}
                <div>
                    <select wire:model.live="filter_author" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-600">
                        <option value="">Alle Auteurs</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter: Datum (Kalender) --}}
                <div wire:ignore class="relative flex flex-col">
                    <div class="relative w-full">
                        <input
                            type="text"
                            x-data
                            x-init="
                                flatpickr($el, {
                                    mode: 'range',
                                    dateFormat: 'Y-m-d',
                                    altInput: true,
                                    altFormat: 'j M Y',
                                    locale: 'nl',
                                    placeholder: 'Aanmaakdatum...',
                                    onChange: function(selectedDates, dateStr, instance) {
                                        $wire.set('filter_date', dateStr);
                                    }
                                });
                            "
                            class="w-full border-gray-300 text-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm pl-10 bg-white cursor-pointer"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    {{-- Wis knopje (past zich mooi aan als er een datum gekozen is) --}}
                    @if($filter_date)
                        <button wire:click="$set('filter_date', '')" onclick="document.querySelector('.flatpickr-input')._flatpickr.clear()" class="text-[10px] text-red-500 hover:text-red-700 font-bold uppercase tracking-wider mt-1 text-left px-1">
                            Wis datum ×
                        </button>
                    @endif
                </div>

                {{-- NIEUW Sorteer dropdown --}}
                <div>
                    <select wire:model.live="sort" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-600 font-medium">
                        <option value="newest">Nieuwste eerst</option>
                        <option value="oldest">Oudste eerst</option>
                        <option value="price_asc">Prijs: Laag - Hoog</option>
                        <option value="price_desc">Prijs: Hoog - Laag</option>
                    </select>
                </div>

            </div>

            {{-- De Create Knop --}}
            <a href="{{ route('admin.deals.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition ease-in-out duration-150 whitespace-nowrap ml-auto lg:ml-0 mt-2 lg:mt-0">
                + Nieuwe Deal
            </a>
        </div>

        {{-- TABEL SECTIE --}}
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-blue-800">Overzicht Deals</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">#ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auteur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aangemaakt</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prijs</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($deals as $deal)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-bold">
                                    {{ $deal->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($deal->primaryImage)
                                        <img src="{{ asset('storage/' . $deal->primaryImage->path) }}" class="w-12 h-12 object-cover rounded-md border border-gray-200 shadow-sm">
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded-md flex items-center justify-center text-gray-400 text-xs border border-gray-200">
                                            Geen
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                    <a href="{{ route('admin.deals.edit', $deal->id) }}" class="hover:text-blue-600 hover:underline block truncate w-48">
                                        {{ $deal->title }}
                                    </a>
                                    <span class="text-xs text-gray-400">{{ $deal->departure_city }} → {{ $deal->arrival_city }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <div class="h-6 w-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold mr-2">
                                            {{ substr($deal->author->name ?? '?', 0, 1) }}
                                        </div>
                                        {{ $deal->author->name ?? 'Systeem' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $deal->created_at->format('d-m-Y') }}
                                    <div class="text-xs text-gray-400">{{ $deal->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-blue-600 font-bold">€ {{ $deal->discounted_price > 0 ? $deal->discounted_price : $deal->price }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                                    <a href="{{ route('admin.deals.edit', $deal->id) }}" class="text-blue-600 hover:text-blue-900">Bewerk</a>
                                    <span class="text-gray-300">|</span>
                                    <button wire:click="deleteDeal({{ $deal->id }})" wire:confirm="Weet je zeker dat je '{{ $deal->title }}' wilt verwijderen?" class="text-red-600 hover:text-red-900">
                                        Verwijder
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                    Geen deals gevonden die voldoen aan je zoekopdracht.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINERING LINKS --}}
            @if($deals->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $deals->links() }}
                </div>
            @endif

        </div>

    </div>
</div>
