<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Succes melding --}}
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('message') }}
            </div>
        @endif

        {{-- HEADER: Zoekbalk + Create Knop --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">

            {{-- Zoekbalk --}}
            <div class="w-full md:w-1/3 relative">
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Zoek op titel, stad of prijs..."
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm pl-10"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            {{-- De Create Knop --}}
            <a href="{{ route('admin.deals.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition ease-in-out duration-150">
                + Nieuwe Deal
            </a>
        </div>

        {{-- TABEL SECTIE --}}
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h3 class="text-xl font-bold mb-4 text-blue-800">Overzicht Deals</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prijs</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Traject</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($deals as $deal)
                            <tr class="hover:bg-gray-50 transition">

                                {{-- FOTO KOLOM (Aangepast naar de nieuwe tabel structuur) --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($deal->primaryImage)
                                        <img src="{{ asset('storage/' . $deal->primaryImage->path) }}" class="w-12 h-12 object-cover rounded-full border border-gray-200 shadow-sm">
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 text-xs border border-gray-200">
                                            Geen
                                        </div>
                                    @endif
                                </td>

                                {{-- TITEL (Nu ook klikbaar om te bewerken) --}}
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                    <a href="{{ route('admin.deals.edit', $deal->id) }}" class="hover:text-blue-600 hover:underline">
                                        {{ $deal->title }}
                                    </a>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-blue-600 font-bold">€ {{ $deal->price }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $deal->departure_city }} <span class="text-gray-400">→</span> {{ $deal->arrival_city }}
                                </td>

                                {{-- ACTIES (Bewerk & Verwijder) --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                                    <a href="{{ route('admin.deals.edit', $deal->id) }}" class="text-blue-600 hover:text-blue-900">
                                        Bewerk
                                    </a>

                                    <span class="text-gray-300">|</span>

                                    <button wire:click="deleteDeal({{ $deal->id }})" wire:confirm="Weet je zeker dat je '{{ $deal->title }}' wilt verwijderen?" class="text-red-600 hover:text-red-900">
                                        Verwijder
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    Geen deals gevonden die voldoen aan je zoekopdracht.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
