<div class="bg-white p-6 rounded-xl shadow-lg text-center max-w-2xl mx-auto">
    <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Weet je niet waarheen? 🌍</h2>
    <p class="text-gray-600 mb-6">Kies een datum en wij zoeken een willekeurige topdeal voor je uit!</p>

    <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2">Vanaf wanneer wil je vliegen?</label>
        <input type="date" wire:model="departureDate" class="border border-gray-300 rounded-lg p-3 w-full max-w-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <button wire:click="getRandomDeal" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-full hover:bg-blue-700 transition transform hover:scale-105 shadow-md">
        Verras mij met een bestemming! ✈️
    </button>

    @if($selectedDeal)
        <div class="mt-8 p-6 border-2 border-blue-200 bg-blue-50 rounded-xl animate-fade-in-up">
            <p class="text-sm font-bold text-blue-500 uppercase tracking-wide mb-1">Jouw bestemming is geworden...</p>
            <h3 class="text-3xl font-black text-blue-900 mb-2">{{ $selectedDeal->arrival_city }}, {{ $selectedDeal->arrival_country }}!</h3>
            <p class="text-gray-700 font-medium">{{ $selectedDeal->title }}</p>

            <div class="mt-6">
                <a href="{{ route('deals.show', $selectedDeal->id) }}" class="inline-block bg-orange-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-orange-600 transition shadow">
                    Bekijk deze deal
                </a>
            </div>
        </div>
    @elseif($noDealsFound)
        <div class="mt-8 p-4 bg-red-50 text-red-600 rounded-lg border border-red-200">
            Oeps! We konden helaas geen deals vinden vanaf deze datum. Probeer een andere datum of laat het veld leeg.
        </div>
    @endif
</div>
