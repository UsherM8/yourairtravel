<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24">

        {{-- SECTIE: LAST MINUTES --}}
    @if($lastMinuteDeals->count() > 0)
    <section>
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">Last Minutes</h2>
                <p class="text-gray-500 text-lg mt-2">Snel en voordelig weg.</p>
            </div>
            <a href="/zoeken?tag=Last-Minute" class="hidden md:block text-[#2596be] font-bold hover:underline">Bekijk alles →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($lastMinuteDeals as $deal)
                @include('components.deal-card', [
                    'deal' => $deal,
                    'index' => $loop->index,
                    'isHomepage' => true
                ])
            @endforeach
        </div>
    </section>
    @endif

    {{-- SECTIE: ZONVAKANTIES --}}
    @if($zonDeals->count() > 0)
    <section>
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">Zonvakanties</h2>
                <p class="text-gray-500 text-lg mt-2">Heerlijk genieten van de zon.</p>
            </div>
            <a href="/zoeken?tag=Zonvakantie" class="hidden md:block text-[#2596be] font-bold hover:underline">Bekijk alles →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($zonDeals as $deal)
                @include('components.deal-card', [
                    'deal' => $deal,
                    'index' => $loop->index,
                    'isHomepage' => true
                ])
            @endforeach
        </div>
    </section>
    @endif
</div>
