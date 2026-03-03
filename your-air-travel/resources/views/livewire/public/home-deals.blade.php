<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24 py-12">

    {{-- CSS Fix voor de scrollbar en het 'snappen' van de kaarten --}}
    <style>
        .instant-slider-track::-webkit-scrollbar { display: none !important; }
        .instant-slider-track {
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
            scroll-snap-type: x mandatory; /* Zorgt dat de slider magnetisch is */
        }
        .instant-slider-track .deal-item {
            scroll-snap-align: center; /* Zorgt dat een kaart altijd in het midden vastklikt */
        }
    </style>

    {{-- SECTIE: INSTANT DEALS (INFINITY LOOP) --}}
    @if(isset($instantDeals) && $instantDeals->count() > 0)
    <section
        x-data="{
            interval: null,
            count: {{ $instantDeals->count() }},
            init() {
                this.$nextTick(() => {
                    let s = this.$refs.slider;
                    let items = s.querySelectorAll('.deal-item');
                    if (items.length < 2) return;

                    let step = this.getStep();
                    let itemWidth = items[0].offsetWidth || (s.clientWidth * 0.80);

                    // Bereken de exacte ruimte om de actieve kaart perfect in het midden te zetten
                    let centerOffset = (s.clientWidth - itemWidth) / 2;

                    s.scrollLeft = (step * this.count) - centerOffset;
                });
                this.startScroll();
            },
            startScroll() {
                this.interval = setInterval(() => { this.next(); }, 4000);
            },
            pauseScroll() { clearInterval(this.interval); },
            getStep() {
                let s = this.$refs.slider;
                let items = s.querySelectorAll('.deal-item');
                if (items.length < 2) return 0;
                return items[1].offsetLeft - items[0].offsetLeft;
            },
            next() {
                let s = this.$refs.slider;
                let step = this.getStep();
                let shift = step * this.count;
                s.scrollBy({ left: step, behavior: 'smooth' });

                setTimeout(() => {
                    if (s.scrollLeft >= (shift * 2)) {
                        s.classList.remove('scroll-smooth');
                        s.scrollLeft -= shift;
                        void s.offsetWidth;
                        s.classList.add('scroll-smooth');
                    }
                }, 600);
            },
            prev() {
                let s = this.$refs.slider;
                let step = this.getStep();
                let shift = step * this.count;
                s.scrollBy({ left: -step, behavior: 'smooth' });

                setTimeout(() => {
                    if (s.scrollLeft <= step) {
                        s.classList.remove('scroll-smooth');
                        s.scrollLeft += shift;
                        void s.offsetWidth;
                        s.classList.add('scroll-smooth');
                    }
                }, 600);
            }
        }"
        @mouseenter="pauseScroll()"
        @mouseleave="startScroll()"
        @touchstart="pauseScroll()"
        @touchend="startScroll()"
        class="bg-gradient-to-r from-orange-50 to-red-50 pt-8 pb-4 rounded-3xl border border-orange-100 shadow-sm mb-16 overflow-hidden"
    >
        <div class="px-8 md:px-12 mb-6">
            <h2 class="text-3xl md:text-4xl font-black text-orange-600 tracking-tight flex items-center">
                <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.381z"/></svg>
                Flash Deals
            </h2>
            <p class="text-orange-800/70 text-lg mt-1 font-medium">Direct boeken bij onze partners. Op = Op!</p>
        </div>

        <div class="relative w-full">
            {{-- Zijkant overlays (Fades) - Verborgen op mobiel met hidden md:block --}}
            <div class="hidden md:block absolute inset-y-0 left-0 w-24 md:w-56 bg-gradient-to-r from-orange-50 via-orange-50/80 to-transparent z-40 pointer-events-none"></div>
            <div class="hidden md:block absolute inset-y-0 right-0 w-24 md:w-56 bg-gradient-to-l from-red-50 via-red-50/80 to-transparent z-40 pointer-events-none"></div>

            {{-- Knoppen (verborgen op mobiel via hidden md:flex) --}}
            <button @click="prev()" class="hidden md:flex absolute left-4 md:left-8 top-1/2 -translate-y-1/2 z-50 bg-white/95 backdrop-blur-sm border border-orange-200 text-orange-600 p-3 rounded-full hover:bg-orange-600 hover:text-white transition-all shadow-xl group">
                <svg class="w-6 h-6 transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>

            <button @click="next()" class="hidden md:flex absolute right-4 md:right-8 top-1/2 -translate-y-1/2 z-50 bg-white/95 backdrop-blur-sm border border-orange-200 text-orange-600 p-3 rounded-full hover:bg-orange-600 hover:text-white transition-all shadow-xl group">
                <svg class="w-6 h-6 transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>

            <div
                x-ref="slider"
                class="flex overflow-x-auto gap-6 py-4 scroll-smooth instant-slider-track"
            >
                @foreach([1, 2, 3] as $loopIndex)
                    @foreach($instantDeals as $deal)
                        {{-- w-[80%] omdat we weten dat dit werkt --}}
                        <div class="deal-item flex-none w-[80%] sm:w-[45%] md:w-[32%] lg:w-[24%] px-1">
                            <div class="h-[320px] w-full">
                                @include('components.deal-card', [
                                    'deal' => $deal,
                                    'index' => 1,
                                    'isHomepage' => true,
                                    'urlOverride' => $deal->affiliate_url ?? $deal->url,
                                    'sliderMode' => true
                                ])
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- SECTIE: LAST MINUTES --}}
    @if(isset($lastMinuteDeals) && $lastMinuteDeals->count() > 0)
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
    @if(isset($zonDeals) && $zonDeals->count() > 0)
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

    {{-- SECTIE: BLOGS / INSPIRATIE --}}
    @if(isset($latestBlogs) && $latestBlogs->count() > 0)
    <section class="border-t border-gray-100 pt-24">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">Reisinspiratie & Tips 📝</h2>
                <p class="text-gray-500 text-lg mt-2">Haal alles uit je volgende vakantie met onze gidsen.</p>
            </div>
            <a href="{{ route('public.blogs') }}" class="mt-4 md:mt-0 inline-flex items-center text-[#2596be] font-bold hover:underline group">
                Bekijk alle artikelen
                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($latestBlogs as $blog)
                <x-blog-card :blog="$blog" />
            @endforeach
        </div>
    </section>
    @endif
</div>
