<div class="bg-gray-50 min-h-screen pb-20">

    {{-- Hero Sectie (Net als je Algemene Voorwaarden) --}}
    <div class="relative py-20 bg-gradient-to-r from-[#2596be] to-[#1a7a9e] overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4">Persoonlijk Reisadvies</h1>
            <p class="text-lg text-blue-50 max-w-2xl mx-auto">Bespaar uren aan stressvol zoekwerk. Wij pluizen het internet voor je uit en vinden de perfecte vakantie voor slechts €10,-.</p>
        </div>
        {{-- Decoratieve cirkel --}}
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
    </div>

    {{-- Content Sectie --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-start">

            {{-- LINKER KANT: De Waarde & Uitleg --}}
            <div class="bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-gray-100">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Hoe werkt het?</h3>

                <ul class="space-y-8">
                    <li class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-[#2596be]/10 text-[#2596be] font-black text-xl">1</div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-bold text-gray-900">Vertel ons je wensen</h4>
                            <p class="mt-1 text-gray-500 font-medium">Vul het formulier in met je budget, reisdata en droombestemming (of laat je verrassen!).</p>
                        </div>
                    </li>
                    <li class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-[#2596be]/10 text-[#2596be] font-black text-xl">2</div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-bold text-gray-900">Wij gaan op jacht</h4>
                            <p class="mt-1 text-gray-500 font-medium">Ons team duikt in de verborgen systemen, vergelijkt fouttarieven en combineert losse tickets voor de absolute bodemprijs.</p>
                        </div>
                    </li>
                    <li class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-[#2596be]/10 text-[#2596be] font-black text-xl">3</div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-bold text-gray-900">Jij krijgt de beste opties</h4>
                            <p class="mt-1 text-gray-500 font-medium">We sturen je een overzicht met de 3 beste deals die we hebben gevonden. Jij hoeft alleen nog maar te boeken.</p>
                        </div>
                    </li>
                </ul>

                <div class="mt-10 bg-blue-50 p-6 rounded-2xl border border-blue-100">
                    <p class="text-sm text-blue-800 font-bold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Waarom €10?
                    </p>
                    <p class="mt-2 text-sm text-blue-700 font-medium">
                        Omdat we écht handwerk leveren. We gebruiken geen standaard vergelijkingssites, maar zoeken handmatig naar combinaties die normale zoekmachines missen. Die €10 verdien je dubbel en dwars terug in je besparing!
                    </p>
                </div>
            </div>

            {{-- RECHTER KANT: Het Formulier --}}
            <div class="bg-white p-8 md:p-10 rounded-3xl shadow-xl border border-gray-100 relative overflow-hidden">

                @if($isSubmitted)
                    {{-- Succes Scherm --}}
                    <div class="text-center py-12">
                        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                            <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 mb-2">Aanvraag ontvangen!</h3>
                        <p class="text-gray-500 font-medium mb-6">We hebben je wensen in goede orde ontvangen. We nemen zo snel mogelijk contact met je op om de start van onze zoektocht en de betaling af te stemmen.</p>
                        <button wire:click="$set('isSubmitted', false)" class="text-[#2596be] font-bold hover:underline">
                            Nieuwe aanvraag doen
                        </button>
                    </div>
                @else
                    {{-- Het Formulier --}}
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Start jouw zoektocht</h3>

                    <form wire:submit.prevent="submitRequest" class="space-y-5">

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Jouw Naam</label>
                            <input type="text" wire:model="name" class="w-full border-gray-300 rounded-xl shadow-sm focus:border-[#2596be] focus:ring-[#2596be] p-3" placeholder="Bijv. Sarah de Jong">
                            @error('name') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">E-mailadres</label>
                                <input type="email" wire:model="email" class="w-full border-gray-300 rounded-xl shadow-sm focus:border-[#2596be] focus:ring-[#2596be] p-3" placeholder="jouw@email.nl">
                                @error('email') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Telefoon (Optioneel)</label>
                                <input type="text" wire:model="phone" class="w-full border-gray-300 rounded-xl shadow-sm focus:border-[#2596be] focus:ring-[#2596be] p-3" placeholder="06 12345678">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Gewenste vertrekdatum / periode</label>
                            <input type="text"
                                   x-data
                                   x-init="flatpickr($el, {dateFormat: 'd-m-Y', minDate: 'today'})"
                                   wire:model="preferred_date"
                                   class="w-full border-gray-300 rounded-xl shadow-sm focus:border-[#2596be] focus:ring-[#2596be] p-3"
                                   placeholder="Kies een datum...">
                            @error('preferred_date') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Wat zoek je ongeveer?</label>
                            <textarea wire:model="destination_wishes" rows="4" class="w-full border-gray-300 rounded-xl shadow-sm focus:border-[#2596be] focus:ring-[#2596be] p-3" placeholder="Bijv: 2 weken naar de zon in oktober, budget is max €600 per persoon. Mag ook buiten Europa zijn!"></textarea>
                            @error('destination_wishes') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full bg-[#2596be] hover:bg-[#1a7a9e] text-white font-black text-lg px-8 py-4 rounded-xl shadow-lg transition-all transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                            Aanvragen voor €10,-
                            <svg wire:loading wire:target="submitRequest" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>

                        <p class="text-xs text-center text-gray-400 font-medium mt-4">
                            Je zit nergens aan vast. Na de aanvraag sturen we je een betaalverzoek (Tikkie/iDEAL) om de zoektocht te starten.
                        </p>
                    </form>
                @endif

            </div>
        </div>
    </div>
</div>
