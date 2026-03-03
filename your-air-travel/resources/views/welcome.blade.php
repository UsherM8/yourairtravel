@component('layouts.public')

    {{-- Hero sectie met Afbeelding Achtergrond --}}
    {{-- pt-40 zorgt dat de tekst perfect gecentreerd staat onder de fixed header, pb-32 voor de balans --}}
    <div class="relative pt-40 pb-32 px-4 sm:px-6 lg:px-8 text-center bg-cover bg-center bg-no-repeat"
         style="background-image: url('{{ asset('images/hero-bg.jpg') }}');">

        {{-- Donkere overlay voor leesbaarheid --}}
        <div class="absolute inset-0 bg-black/50"></div>

        <div class="relative z-10">
            <h1 class="text-3xl md:text-6xl font-black text-white mb-6 drop-shadow-2xl leading-tight italic uppercase tracking-tighter">
                Vind de goedkoopste vluchten, <br class="hidden md:block"/> zonder moeite.
            </h1>
            <p class="text-white/90 text-lg md:text-2xl max-w-2xl mx-auto mb-12 font-bold drop-shadow-lg">
                Wij speuren dagelijks het internet af voor de beste fouttarieven en last-minutes.
            </p>
        </div>
    </div>

    {{-- DE ZOEKBALK --}}
    {{-- De -mt-16 trekt de zoekbalk mooi half over de hero sectie heen --}}
    <div class="px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        <livewire:public.searchbar />
    </div>

    {{-- DE STATISCHE ETALAGE (Last-minutes, Zon, Vluchten) --}}
    <div class="relative z-10 bg-gray-50 pt-16 pb-24">
        <livewire:public.home-deals />
    </div>

@endcomponent
