<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">

    {{-- SECTIE 1: LAST MINUTES --}}
    @if($lastMinutes->count() > 0)
        <div>
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4 border-b border-gray-200 pb-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Last-Minutes ⚡</h2>
                    <p class="text-gray-500 mt-1">Pak je koffers, we vertrekken bijna!</p>
                </div>
                <a href="{{ route('search.results', ['vakantietypes' => ['lastminute']]) }}" class="text-[#2596be] font-bold hover:text-[#e5764b] transition-colors group">
                    Bekijk alles <span class="inline-block transform group-hover:translate-x-1 transition-transform">&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($lastMinutes->take(4) as $deal)
                    {{-- GEEF DE INDEX DOOR AAN HET KAARTJE! --}}
                    @include('components.deal-card', ['deal' => $deal, 'index' => $loop->index])
                @endforeach
            </div>
        </div>
    @endif

    {{-- SECTIE 2: ZONVAKANTIES --}}
    @if($zonvakanties->count() > 0)
        <div>
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4 border-b border-gray-200 pb-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Zonvakanties ☀️</h2>
                    <p class="text-gray-500 mt-1">Ontsnap naar de warmte met deze deals.</p>
                </div>
                <a href="{{ route('search.results', ['vakantietypes' => ['zon']]) }}" class="text-[#2596be] font-bold hover:text-[#e5764b] transition-colors group">
                    Bekijk alles <span class="inline-block transform group-hover:translate-x-1 transition-transform">&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($zonvakanties->take(4) as $deal)
                    {{-- GEEF DE INDEX DOOR AAN HET KAARTJE! --}}
                    @include('components.deal-card', ['deal' => $deal, 'index' => $loop->index])
                @endforeach
            </div>
        </div>
    @endif

</div>
