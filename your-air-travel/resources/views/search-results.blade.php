@component('layouts.public')

    <div class="bg-gray-50 min-h-screen pt-12 pb-20">

        {{-- Pagina Header --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 text-center md:text-left">
            <h1 class="text-3xl md:text-4xl font-extrabold text-[#2596be] tracking-tight mb-2">Jouw Zoekresultaten</h1>
            <p class="text-gray-500 text-lg">Pas je filters aan om de perfecte deal te vinden.</p>
        </div>

        {{-- Zoekbalk (Bovenaan) --}}
        <div class="px-4 sm:px-6 lg:px-8 relative z-20 mb-8">
            <livewire:public.searchbar />
        </div>

        {{-- De gefilterde lijst met deals --}}
        <div class="relative z-10">
            <livewire:public.deal-list />
        </div>

    </div>

@endcomponent
