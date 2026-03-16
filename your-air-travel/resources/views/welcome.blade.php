@component('layouts.public')

    {{-- Hero sectie met Afbeelding Achtergrond --}}
    <div class="relative py-28 px-4 sm:px-6 lg:px-8 text-center bg-cover bg-center bg-no-repeat"
         style="background-image: url('{{ asset('images/Background image.jpg') }}');">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 drop-shadow-lg">
                Vind de goedkoopste vluchten, <br class="hidden md:block"/> zonder moeite.
            </h1>
            <p class="text-white/90 text-lg md:text-xl max-w-2xl mx-auto mb-10 font-medium drop-shadow-md">
                Wij speuren dagelijks het internet af voor de beste fouttarieven en last-minutes.
            </p>
        </div>
    </div>

    {{-- DE ZOEKBALK (Telt nu alleen, en stuurt je door!) --}}
    <div class="px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        <livewire:public.searchbar />
    </div>

    {{-- DE STATISCHE ETALAGE (Last-minutes, Zon, Vluchten) --}}
    <div class="relative z-10 bg-gray-50 pt-12 pb-12">
        <livewire:public.home-deals />
    </div>

    {{-- 🎲 BESTEMMING ROULETTE (Nieuw!) --}}
    <div class="relative z-10 bg-white py-16 px-4 sm:px-6 lg:px-8 border-t border-gray-100">
        <livewire:public.deal-roulette />
    </div>

@endcomponent
