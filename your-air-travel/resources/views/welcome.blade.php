@component('layouts.public')

    {{-- Hero sectie (De grote header banner in jouw knallende oranje actiekleur!) --}}
    <div class="bg-[#e5764b] py-20 px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 shadow-sm">
            Vind de goedkoopste vluchten, <br class="hidden md:block"/> zonder moeite.
        </h1>
        <p class="text-white/90 text-lg md:text-xl max-w-2xl mx-auto mb-10 font-medium">
            Wij speuren dagelijks het internet af voor de beste fouttarieven en last-minutes.
        </p>
    </div>

    {{-- HIER ROEPEN WE DE ZOEKBALK AAN! --}}
    <div class="px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        <livewire:public.searchbar />
    </div>

    {{-- DE LIJST MET DEALS! --}}
    <div class="relative z-10 bg-gray-50 pt-8 pb-20">
        <livewire:public.deal-list />
    </div>

@endcomponent
