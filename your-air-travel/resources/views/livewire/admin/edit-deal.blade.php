<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">

            {{-- HEADER MET TERUG KNOP --}}
            <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Deal Bewerken: <span class="text-blue-600">{{ $title }}</span></h2>
                </div>
                <a href="{{ route('admin.deals') }}" class="flex items-center text-gray-500 hover:text-blue-600 transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Terug naar overzicht
                </a>
            </div>

            <form wire:submit.prevent="updateDeal" class="space-y-8">

                {{-- SECTIE 1: DE DEAL (PRIJS & TITEL) --}}
                <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                    <h3 class="text-lg font-semibold text-blue-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Marketing & Prijs
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Pakkende Titel</label>
                            <input type="text" wire:model="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Oorspronkelijke Prijs (€)</label>
                            <input type="number" step="0.01" wire:model="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-3">
                            @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deal Prijs (€)</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-green-600 font-bold">🔥</span>
                                </div>
                                <input type="number" step="0.01" wire:model="discounted_price" class="block w-full border-green-300 rounded-md focus:ring-green-500 focus:border-green-500 pl-10 bg-green-50">
                            </div>
                            @error('discounted_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- SECTIE 2: VLUCHT DETAILS (SLIM & CASCADING) --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Route, Vlucht & Data
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative">
                        {{-- Vertrek --}}
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-inner">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Vertrek (Van)</span>
                            <div class="mt-3 space-y-3">
                                <div>
                                    <label class="text-xs text-gray-500">Stad / Luchthaven</label>
                                    <select wire:model.live="departure_city" class="block w-full border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 font-medium">
                                        <option value="">Kies een vertrekplek...</option>
                                        @foreach($vertrekLocaties as $stad => $land)
                                            <option value="{{ $stad }}">{{ $stad }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500">Land</label>
                                    <input type="text" wire:model="departure_country" readonly class="block w-full border-gray-200 bg-gray-100 text-gray-500 rounded-md text-sm cursor-not-allowed">
                                </div>
                            </div>
                        </div>

                        {{-- Pijl --}}
                        <div class="hidden md:flex absolute inset-0 items-center justify-center pointer-events-none">
                            <div class="bg-white p-2 rounded-full shadow border border-gray-200">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>

                        {{-- Aankomst --}}
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-inner">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Bestemming (Naar)</span>
                            <div class="mt-3 space-y-3">
                                <div>
                                    <label class="text-xs text-gray-500">Land</label>
                                    <select wire:model.live="arrival_country" class="block w-full border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 font-medium">
                                        <option value="">Kies land...</option>
                                        @foreach(array_keys($beschikbareLanden) as $land)
                                            <option value="{{ $land }}">{{ $land }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500">Stad</label>
                                    <select wire:model="arrival_city" class="block w-full border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 font-medium disabled:bg-gray-100 disabled:text-gray-400" @if(!$arrival_country) disabled @endif>
                                        @if(!$arrival_country)
                                            <option value="">Kies eerst een land ☝️</option>
                                        @else
                                            <option value="">Kies een stad in {{ $arrival_country }}...</option>
                                            @foreach($beschikbareLanden[$arrival_country] as $stad)
                                                <option value="{{ $stad }}">{{ $stad }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Airline & Datums --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Luchtvaartmaatschappij</label>
                            <select wire:model="airline" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Kies maatschappij...</option>
                                <option value="KLM">KLM</option>
                                <option value="Transavia">Transavia</option>
                                <option value="Ryanair">Ryanair</option>
                                <option value="EasyJet">EasyJet</option>
                                <option value="Vueling">Vueling</option>
                                <option value="TUI fly">TUI fly</option>
                                <option value="Corendon">Corendon</option>
                                <option value="Wizz Air">Wizz Air</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Vertrekdatum</label>
                            <input type="date" wire:model="departure_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 text-blue-600">Terugkomstdatum</label>
                            <input type="date" wire:model="return_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                {{-- TAGS --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        Vakantietype (Tags)
                    </h3>
                    <div class="bg-white border border-gray-200 rounded-lg p-5 flex flex-wrap gap-4 shadow-inner">
                        @foreach(['Zonvakantie', 'Stedentrip', 'All-Inclusive', 'Last-Minute', 'Natuur', 'Verre Reis', 'Wintersport', 'Weekendje Weg'] as $tag)
                            <label class="inline-flex items-center cursor-pointer bg-gray-50 border border-gray-200 px-3 py-2 rounded-lg hover:bg-blue-50 transition-colors">
                                <input type="checkbox" wire:model="tags" value="{{ $tag }}" class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4 border-gray-300">
                                <span class="ml-2 text-sm text-gray-700 font-medium">{{ $tag }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- SECTIE 3: BESTAANDE & NIEUWE FOTO'S --}}
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Afbeeldingen Beheren
                    </h3>

                    @if(count($existing_images) > 0)
                        <div class="mb-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($existing_images as $img)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $img->path) }}" class="w-full h-32 object-cover rounded-lg shadow-sm border {{ $img->is_primary ? 'border-blue-500 border-2' : 'border-gray-200' }}">
                                    @if($img->is_primary)
                                        <div class="absolute top-0 right-0 bg-blue-600 text-white text-[10px] px-2 py-1 font-bold rounded-bl-lg">HOOFDFOTO</div>
                                    @endif
                                    <button type="button" wire:click="removeExistingImage({{ $img->id }})" wire:confirm="Foto definitief verwijderen?" class="absolute bottom-2 right-2 bg-red-600 text-white p-1.5 rounded-md hover:bg-red-700 shadow-md">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 mb-4 italic">Geen foto's gevonden voor deze deal.</p>
                    @endif

                    <div class="bg-gray-50 rounded-lg p-4 border border-dashed border-gray-300">
                        <label class="block text-sm font-medium text-gray-700 mb-2">+ Extra foto's toevoegen</label>
                        <input type="file" wire:model="new_images" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                        <p class="text-xs text-gray-500 mt-2">Max <strong class="text-gray-700">10MB</strong> per foto.</p>
                        @error('new_images.*') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- SECTIE 4: DETAILS --}}
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Omschrijving & Link</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Wervende Tekst</label>
                            <textarea wire:model="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Affiliate Link (URL)</label>
                            <input type="url" wire:model="referral_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-blue-600 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                {{-- FOOTER ACTIES --}}
                <div class="pt-6 flex items-center justify-end space-x-3">
                    <div wire:loading wire:target="new_images" class="mr-auto text-sm text-gray-500 italic">
                        <span class="inline-flex animate-pulse">Nieuwe foto's verwerken...</span>
                    </div>

                    <a href="{{ route('admin.deals') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Annuleren</a>
                    <button type="submit" wire:loading.attr="disabled" class="px-6 py-2 bg-blue-600 text-white rounded-md font-bold hover:bg-blue-700 shadow-md transition transform hover:scale-105">
                        Wijzigingen Opslaan 💾
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
